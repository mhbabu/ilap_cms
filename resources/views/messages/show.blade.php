@extends('layouts.app')

@section('title','Message Details')
@section('page-title','Message')

@section('content')
<div class="fixed inset-0 top-14 ml-64 z-30 bg-white">
    <div class="mx-auto max-w-3xl h-full flex flex-col p-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm flex-1 flex flex-col overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4 flex items-center gap-3">
                <a href="{{ route('messages.inbox') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <h2 class="text-base font-bold text-slate-900 flex-1">{{ $message->subject }}</h2>
            </div>

            <div class="flex-1 overflow-y-auto p-5 space-y-4">
                <div class="grid gap-4 sm:grid-cols-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-500">From</p>
                        <p class="font-semibold text-slate-800">{{ $message->sender?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">To</p>
                        <p class="font-semibold text-slate-800">{{ $message->receiver?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Sent At</p>
                        <p class="font-semibold text-slate-800">{{ $message->sent_at?->format('Y-m-d H:i') ?? '—' }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                    <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $message->body }}</p>
                </div>
            </div>

            <div class="border-t border-slate-100 px-5 py-3 flex items-center justify-between">
                <a href="{{ route('messages.inbox') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back to Messages</a>
                <a href="{{ route('messages.reply', $message) }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Reply</a>
            </div>
        </div>
    </div>
</div>
@endsection
