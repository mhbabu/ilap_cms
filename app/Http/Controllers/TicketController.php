<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Middleware\Transfer;

class TicketController extends Controller
{
    /* ─── List tickets ─── */
    public function __invoke()
    {
        $tickets = $this->listTickets();
        $assigned = $this->assignedList();

        return $this->withOrg('tickets.index', compact('tickets', 'assigned'));
    }

    private function listTickets()
    {
        $query = Ticket::with(['creator', 'handler', 'campus'])
            ->when(!auth()->user()->hasRole('super_admin'), function ($q) {
                $q->where('campus_id', auth()->user()->campus_id)
                  ->orWhereNull('campus_id');
            })
            ->orderByDesc('updated_at')
            ->take(15);

        return $query->get();
    }

    private function assignedList()
    {
        return Ticket::where('handler_id', auth()->id())
            ->orWhere('assigned_to', auth()->id())
            ->latest()
            ->take(15)
            ->get();
    }

    /* ─── Transfer action (called from transfer middleware) ─── */
    public function transfer(Request $request, Ticket $ticket): Ticket
    {
        $data = $request->validate([
            'handler_id' => 'required|exists:users,id',
        ]);

        $transferTarget = User::findOrFail($data['handler_id']);

        // record note
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => sprintf(
                "Ticket transferred from %s to %s.",
                auth()->user()->name,
                $transferTarget->name,
            ),
            'is_internal' => true,
        ]);
        $ticket->update(['handler_id' => $transferTarget->id, 'status' => 'in_progress']);

        return $ticket;
    }

    /* ─── Raw update (used directly by update route) ─── */
    public function update(Request $request, Ticket $ticket): Ticket
    {
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'handler_id'    => 'required|exists:users,id',
            'status'        => 'required|in:open,in_progress,closed',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        $ticket->update($validated);

        return $ticket;
    }
}
