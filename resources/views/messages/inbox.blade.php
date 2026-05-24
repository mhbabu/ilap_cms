{{-- resources/views/messaging/inbox.blade.php --}}
@extends('layouts.app')

@section('title','Messages')
@section('page-title','Messages')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between">
    <div>
        <h1 class="ilap-text-xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Your Messages</h1>
        <p class="ilap-text-xs text-slate-500">Communicate with team, students, handlers &amp; staff</p>
    </div>
    <a href="{{ route('messages.compose') }}" class="ilap-btn ilap-btn-primary ilap-btn-sm">
        + New Message
    </a>
</div>

<div class="ilap-grid-2">
    {{-- Inbox column --}}
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-m-0 ilap-font-bold text-slate-700">Inbox</h3>
        </div>
        <div class="ilap-overflow-y-auto" style="max-height:70vh">
            @forelse($messages ?? [] as $msg)
            <div class="ilap-border-b border-slate-50 ilap-p-4 hover:bg-slate-50 transition-colors cursor-pointer"
                 onclick="location.href='{{ route('messages.show',$msg) }}'">
                <div class="ilap-flex items-start gap-3">
                    <div class="ilap-avatar flex-shrink-0" style="background:{{ $msg->sender?->campus?->color_primary ?? 'var(--ilap-primary)' }}">
                        {{ strtoupper(substr($msg->sender?->name ?? '?',0,1)) }}
                    </div>
                    <div class="ilap-flex-1 min-w-0">
                        <div class="ilap-flex items-center justify-between">
                            <span class="ilap-text-sm ilap-font-bold text-slate-800">{{ $msg->sender?->name ?? 'Unknown' }}</span>
                            <span class="ilap-text-xs text-slate-400">{{ $msg->sent_at?->diffForHumans() ?? '' }}</span>
                        </div>
                        <p class="ilap-text-xs font-semibold text-slate-600 mt-0.5">{{ $msg->subject ?? 'No Subject' }}</p>
                        <p class="ilap-text-xs text-slate-400 ilap-line-clamp-2">{{ $msg->body ?? '' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="ilap-p-8 ilap-text-center">
                <p class="ilap-text-sm text-slate-400">Your inbox is empty.</p>
                <a href="{{ route('messages.compose') }}" class="ilap-btn ilap-btn-sm ilap-btn-primary ilap-mt-2">Send your first message</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Outbox column --}}
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-m-0 ilap-font-bold text-slate-700">Sent</h3>
        </div>
        <div class="ilap-overflow-y-auto" style="max-height:70vh">
            @forelse(($sent ?? collect()) as $msg)
            <div class="ilap-border-b border-slate-50 ilap-p-4 hover:bg-slate-50 transition-colors cursor-pointer">
                <div class="ilap-flex items-start gap-3">
                    <div class="ilap-avatar flex-shrink-0" style="background:var(--ilap-secondary)">
                        {{ strtoupper(substr($msg->receiver?->name ?? $msg->receiver?->name ?? '?',0,1)) }}
                    </div>
                    <div class="ilap-flex-1 min-w-0">
                        <div class="ilap-flex items-center justify-between">
                            <span class="ilap-text-sm font-bold text-slate-800">To: {{ $msg->receiver?->name ?? '?' }}</span>
                            <span class="ilap-text-xs text-slate-400">{{ $msg->sent_at?->diffForHumans() ?? '' }}</span>
                        </div>
                        <p class="ilap-text-xs font-semibold text-slate-600 mt-0.5">{{ $msg->subject ?? '—' }}</p>
                        <p class="ilap-text-xs text-slate-400 ilap-line-clamp-2">{{ $msg->body ?? '' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="ilap-p-8 ilap-text-center">
                <p class="ilap-text-sm text-slate-400">No sent messages yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
