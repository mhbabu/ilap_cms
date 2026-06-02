<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = $this->getTickets($request);
        $statusCounts = $this->getStatusCounts($request);

        return $this->withOrg('tickets.index', compact('tickets', 'statusCounts'));
    }

    public function create()
    {
        $campuses = \App\Models\Campus::active()->get();
        $users = \App\Models\User::orderBy('name')->get();
        return $this->withOrg('tickets.create', compact('campuses', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'required|in:low,medium,high,critical',
            'type'        => 'required|in:technical,financial,administrative,other',
            'campus_id'   => 'nullable|exists:campuses,id',
        ]);

        $ticket = Ticket::create([
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'priority'     => $validated['priority'],
            'type'         => $validated['type'],
            'campus_id'    => $validated['campus_id'] ?? auth()->user()->campus_id,
            'created_by'   => auth()->id(),
            'status'       => 'open',
            'ticket_number'=> 'TKT' . strtoupper(substr(uniqid(), -6)),
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['creator', 'handler', 'messages.user']);
        return $this->withOrg('tickets.show', compact('ticket'));
    }

    public function assign(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'handler_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'handler_id' => $validated['handler_id'],
            'status'     => 'in_progress',
        ]);

        return back()->with('success', 'Ticket assigned.');
    }

    public function reply(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id'   => auth()->id(),
            'message'   => $validated['message'],
            'is_internal'=> false,
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function close(Ticket $ticket): RedirectResponse
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('success', 'Ticket closed.');
    }

    private function getTickets($request)
    {
        $query = Ticket::with(['creator', 'handler'])
            ->when(!auth()->user()->hasRole('super_admin'), function ($q) {
                $q->where('campus_id', auth()->user()->campus_id)
                  ->orWhereNull('campus_id');
            })
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $query->paginate(20);
    }

    private function getStatusCounts($request): array
    {
        $counts = ['open' => 0, 'in_progress' => 0, 'resolved' => 0, 'closed' => 0];
        foreach ($counts as $status => $count) {
            $counts[$status] = Ticket::where('status', $status)->count();
        }
        return $counts;
    }
}