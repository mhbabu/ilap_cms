{{-- resources/views/tickets/index.blade.php --}}
@extends('layouts.app')

@section('title','Tickets')
@section('page-title','Tickets')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Tickets</h1>
        <p class="ilap-text-xs text-slate-500" id="ilap-ticket-status-note">No tickets yet.</p>
    </div>
    <a href="{{ route('tickets.create') }}"
       class="ilap-px-5 py-2.5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Open Ticket</a>
</div>

{{-- Status Filter Pill Row --}}
<div class="ilap-flex items-center gap-2 ilap-flex-wrap ilap-mb-6">
    @foreach(['open'=>'Open','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed'] as $status=>$label)
        @php $sCount = ($statusCounts ?? collect())[$status] ?? 0; $activeFilter = request('status') === $status; @endphp
        <a href="{{ request()->fullUrlWithQuery(['status' => $activeFilter ? '' : $status]) }}"
           class="ilap-px-4 py-1.5 rounded-full text-sm font-bold border transition-all {{ $activeFilter ? 'ilap-font-bold' : 'ilap-text-muted' }}"
           style="border-color:{{ $activeFilter ? 'var(--ilap-primary)':'#e2e8f0' }};background:{{ $activeFilter ? 'var(--ilap-primary-light)':'transparent' }}
               ;color:{{ $activeFilter ? 'var(--ilap-primary)':'#64748b' }}">
            {{ $label }} <span class="ilap-font-extrabold">{{ $sCount }}</span>
        </a>
    @endforeach
</div>

{{-- Ticket Card Grid --}}
<div class="ilap-grid-2">
    @forelse($tickets as $ticket)
    <div class="ilap-card hover:shadow-lg transition-shadow">
        <div class="ilap-p-4">
            {{-- Header row --}}
            <div class="ilap-flex items-start justify-between ilap-mb-2">
                <span class="ilap-text-2xs text-slate-400 font-semibold ilap-uppercase">{{ $ticket->ticket_number }}</span>
                @php
                    $ps = ['critical'=>'red','high'=>'orange','medium'=>'#f59e0b','low'=>'green'];
                    $ss = ['open'=>'red','in_progress'=>'blue','resolved'=>'green','closed'=>'gray'];
                @endphp
                <span class="ilap-badge ilap-badge--{{ $ss[$ticket->status] ?? 'gray' }}">
                    {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                </span>
            </div>

            <h3 class="ilap-text-lg ilap-font-bold text-slate-800">{{ $ticket->title }}</h3>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1 ilap-line-clamp-2">{{ $ticket->description }}</p>

            <div class="ilap-flex items-center justify-between ilap-mt-4 ilap-pt-3 ilap-border-t border-slate-100">
                <div class="ilap-flex items-center gap-2">
                    <span class="ilap-badge ilap-badge--{{ $ps[$ticket->priority] ?? 'gray' }}">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                    <span class="ilap-text-2xs text-slate-400">• {{ $ticket->type }}</span>
                    <span class="ilap-text-2xs text-slate-400">• {{ $ticket->creator?->name ?? '—' }}</span>
                </div>
                <a href="{{ route('tickets.show',$ticket) }}"
                   class="ilap-btn ilap-btn-sm ilap-btn-secondary">View</a>
            </div>
        </div>
    </div>
    @empty
    <div class="ilap-metric ilap-col-span-2 ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No tickets found</p>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">Create your first ticket to get started.</p>
    </div>
    @endforelse
</div>

{{ $tickets->links() }}
@endsection
