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
        $q = Message::query()
            ->where('receiver_id', auth()->id())
            ->with('sender','template')
            ->latest();
        if ($request->filled('type')) $q->where('type',$request->type);
        if ($request->filled('status')) $q->when($request->status==='unread',fn($q)=>$q->where('is_read',false));
        return $this->withOrg('messaging.inbox', ['messages'=>$q->paginate(25)]);
    }

    public function sent(Request $request)
    {
        $q = Message::query()->where('sender_id',auth()->id())
            ->with('receiver','template')->latest();
        return $this->withOrg('messaging.sent', ['messages'=>$q->paginate(25)]);
    }

    public function compose()
    {
        $users = User::orderBy('name')->get();
        $templates = \App\Models\EmailTemplate::active()->get();
        return $this->withOrg('messaging.compose', compact('users','templates'));
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

        Message::create($data + ['body'=>nl2br(e($data['body']))]);
        return redirect()->route('messages.sent')->with('success','Message sent.');
    }

    public function show(Message $message): View
    {
        $message->update(['is_read'=>true]);
        return $this->withOrg('messaging.show', compact('message'));
    }

    public function reply(Request $request, Message $message): RedirectResponse
    {
        $request->validate(['body'=>'required|string']);
        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $message->sender_id,
            'subject'     => 'Re: '.$message->subject,
            'body'        => $request->body,
            'type'        => 'internal',
        ]);
        return back()->with('success','Reply sent.');
    }
}
