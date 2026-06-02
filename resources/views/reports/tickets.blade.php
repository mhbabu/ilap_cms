@extends('layouts.app')

@section('title', 'Reports - Tickets')
@section('page-title', 'Ticket Report')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Ticket Report</h1>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ticket #</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Creator</th>
                    <th>Campus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $i => $ticket)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $ticket->ticket_number }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td><span class="ilap-badge ilap-badge--{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'closed' ? 'gray' : 'green') }}">
                        {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                    </span></td>
                    <td><span class="ilap-badge ilap-badge--{{ $ticket->priority === 'critical' ? 'red' : ($ticket->priority === 'high' ? 'orange' : ($ticket->priority === 'medium' ? 'yellow' : 'green')) }}">
                        {{ ucfirst($ticket->priority) }}
                    </span></td>
                    <td>{{ $ticket->creator?->name ?? '—' }}</td>
                    <td>{{ $ticket->campus?->name ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="ilap-text-center ilap-py-8 text-slate-400">No tickets found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $tickets->links() }}
</div>
@endsection