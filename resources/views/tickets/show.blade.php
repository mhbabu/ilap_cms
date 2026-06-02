@extends('layouts.app')

@section('title', $ticket->title)
@section('page-title', $ticket->ticket_number)

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">{{ $ticket->title }}</h1>
        <p class="ilap-text-sm text-slate-500">Ticket #{{ $ticket->ticket_number }}</p>
    </div>
    <div class="ilap-flex gap-2">
        @if($ticket->status !== 'closed')
        <form action="{{ route('tickets.close', $ticket) }}" method="POST">
            @csrf
            <button type="submit" class="ilap-btn ilap-btn-sm ilap-btn-danger" onclick="return confirm('Close this ticket?')">Close</button>
        </form>
        @endif
        <a href="{{ route('tickets.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Back</a>
    </div>
</div>

<div class="ilap-grid-2 gap-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Ticket Details</h3>
        </div>
        <div class="ilap-p-4 space-y-3">
            <div>
                <p class="ilap-text-xs text-slate-500">Priority</p>
                <span class="ilap-badge ilap-badge--{{ $ticket->priority === 'critical' ? 'red' : ($ticket->priority === 'high' ? 'orange' : ($ticket->priority === 'medium' ? 'yellow' : 'gray')) }}">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Status</p>
                <span class="ilap-badge ilap-badge--{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'closed' ? 'gray' : 'green') }}">
                    {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                </span>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Type</p>
                <p>{{ ucfirst($ticket->type) }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Created By</p>
                <p>{{ $ticket->creator?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Handler</p>
                <p>{{ $ticket->handler?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Description</p>
                <p class="ilap-text-sm">{{ $ticket->description }}</p>
            </div>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Messages</h3>
        </div>
        <div class="ilap-p-4 max-h-80 overflow-y-auto">
            @foreach($ticket->messages as $message)
            <div class="ilap-mb-3 pb-3 border-b border-slate-100">
                <div class="ilap-flex items-center justify-between">
                    <span class="ilap-font-semibold text-slate-700">{{ $message->user?->name }}</span>
                    <span class="ilap-text-xs text-slate-400">{{ $message->created_at?->diffForHumans() }}</span>
                </div>
                <p class="ilap-text-sm ilap-mt-1">{{ $message->message }}</p>
            </div>
            @endforeach
        </div>

        @if($ticket->status !== 'closed')
        <div class="ilap-p-4 border-t">
            <form action="{{ route('tickets.reply', $ticket) }}" method="POST">
                @csrf
                <textarea name="message" rows="3" required class="ilap-input" placeholder="Write reply..."></textarea>
                <button type="submit" class="ilap-btn ilap-btn-primary ilap-mt-2">Send Reply</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection