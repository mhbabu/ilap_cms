<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function inbox(Request $request)
    {
        $userId = auth()->id();

        $conversations = Message::query()
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->with(['sender', 'receiver'])
            ->latest('sent_at')
            ->get()
            ->groupBy(function ($msg) use ($userId) {
                return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(function ($msgs) {
                return $msgs->first();
            })
            ->sortByDesc('sent_at')
            ->values();

        $activeConversation = null;
        $activeMessages = collect();

        if ($request->filled('with')) {
            $otherId = (int) $request->get('with');
            $activeConversation = User::find($otherId);

            $activeMessages = Message::query()
                ->where(function ($q) use ($userId, $otherId) {
                    $q->where(function ($q2) use ($userId, $otherId) {
                        $q2->where('sender_id', $userId)->where('receiver_id', $otherId);
                    })->orWhere(function ($q2) use ($userId, $otherId) {
                        $q2->where('sender_id', $otherId)->where('receiver_id', $userId);
                    });
                })
                ->with(['sender', 'receiver'])
                ->orderBy('sent_at', 'asc')
                ->get();

            foreach ($activeMessages as $msg) {
                if ($msg->receiver_id === $userId && !$msg->is_read) {
                    $msg->update(['is_read' => true]);
                }
            }
        }

        return $this->withOrg('messages.inbox', [
            'conversations'     => $conversations,
            'activeConversation'=> $activeConversation,
            'activeMessages'    => $activeMessages,
            'users'             => User::where('id', '!=', $userId)->orderBy('name')->get(),
        ]);
    }

    public function sent(Request $request)
    {
        $q = Message::query()->where('sender_id',auth()->id())
            ->with('receiver','template')->latest();
        return $this->withOrg('messages.sent', ['messages'=>$q->paginate(25)]);
    }

    public function compose()
    {
        $users = User::orderBy('name')->get();
        $templates = \App\Models\EmailTemplate::active()->get();
        return $this->withOrg('messages.compose', compact('users','templates'));
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject'     => 'required|string|max:255',
            'body'        => 'required|string',
            'type'        => 'in:email,internal',
            'template_id' => 'nullable|exists:email_templates,id',
        ]);

        $data['sender_id'] = auth()->id();
        $data['type']      = $data['type'] ?? 'internal';
        $data['body']      = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $data['body']);

        Message::create($data + ['body'=>nl2br(e($data['body']))]);
        return redirect()->route('messages.sent')->with('success','Message sent.');
    }

    public function show(Message $message): View
    {
        $message->update(['is_read'=>true]);
        return $this->withOrg('messages.show', compact('message'));
    }

    public function reply(Request $request, Message $message): RedirectResponse
    {
        $body = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $request->validate(['body'=>'required|string'])['body']);
        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id,
            'subject'     => 'Re: '.$message->subject,
            'body'        => nl2br(e($body)),
            'type'        => 'internal',
        ]);
        return back()->with('success','Reply sent.');
    }
}
