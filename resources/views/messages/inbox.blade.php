@extends('layouts.app')

@section('title','Messages')
@section('page-title','Messages')

@section('content')
<div class="fixed inset-0 top-14 ml-64 z-30 bg-white">
    <div class="flex h-full">
        <div class="flex w-full flex-col md:w-80 md:border-r md:border-slate-200">
            <div class="border-b border-slate-200 p-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Chats</h2>
                    <a href="{{ route('messages.compose') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-800">
                        <i class="fa-solid fa-pen-to-square"></i> New
                    </a>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto">
                @foreach(($conversations ?? collect()) as $msg)
                    @php
                        $other = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender;
                        $active = !empty($activeConversation) && $activeConversation->id === $other->id;
                    @endphp
                    <a href="{{ route('messages.inbox', ['with' => $other->id]) }}"
                       class="flex items-center gap-3 px-4 py-3 transition-colors {{ $active ? 'bg-slate-100' : 'hover:bg-slate-50' }}">
                        <div class="relative flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white"
                                 style="background: {{ $other->campus?->color_primary ?? '#1e40af' }}">
                                {{ strtoupper(substr($other->name ?? '?', 0, 1)) }}
                            </div>
                            @if(!$msg->is_read && $msg->receiver_id === auth()->id())
                                <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-blue-500"></span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="truncate text-sm font-semibold text-slate-800">{{ $other->name ?? 'Unknown' }}</span>
                                <span class="flex-shrink-0 text-[11px] text-slate-400">{{ $msg->sent_at?->diffForHumans() ?? '' }}</span>
                            </div>
                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ $msg->sender_id === auth()->id() ? 'You: ' : '' }}{{ $msg->subject ?? $msg->body ?? 'No subject' }}
                            </p>
                        </div>
                    </a>
                @endforeach
                @if(($conversations ?? collect())->isEmpty())
                    <div class="p-6 text-center">
                        <p class="text-xs text-slate-400">No conversations yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="hidden flex-1 flex-col md:flex">
            @if(!empty($activeConversation))
                <div class="flex items-center gap-3 border-b border-slate-200 px-5 py-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold text-white"
                         style="background: {{ $activeConversation->campus?->color_primary ?? '#1e40af' }}">
                        {{ strtoupper(substr($activeConversation->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ $activeConversation->name ?? 'Unknown' }}</p>
                        <p class="text-[11px] text-slate-500">{{ ucfirst($activeConversation->role ?? 'User') }}</p>
                    </div>
                </div>

                <div class="flex-1 space-y-4 overflow-y-auto bg-slate-50 p-5">
                    @foreach(($activeMessages ?? collect()) as $msg)
                        @php $isMe = $msg->sender_id === auth()->id(); @endphp
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                            <div class="flex max-w-[75%] items-end gap-2 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                @if(!$isMe)
                                    <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-[11px] font-bold text-white"
                                         style="background: {{ $msg->sender?->campus?->color_primary ?? '#1e40af' }}">
                                        {{ strtoupper(substr($msg->sender?->name ?? '?', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="{{ $isMe ? 'rounded-2xl rounded-br-sm bg-blue-600 text-white' : 'rounded-2xl rounded-bl-sm border border-slate-200 bg-white text-slate-800' }} px-4 py-2.5 text-sm leading-relaxed shadow-sm">
                                        @if(!$isMe)
                                            <p class="mb-1 text-[11px] font-semibold" style="color: {{ $msg->sender?->campus?->color_primary ?? '#1e40af' }}">
                                                {{ $msg->sender?->name ?? 'Unknown' }}
                                            </p>
                                        @endif
                                        <p>{{ $msg->body }}</p>
                                    </div>
                                    <p class="mt-1 text-[10px] text-slate-400 {{ $isMe ? 'mr-1 text-right' : 'ml-9' }}">
                                        {{ $msg->sent_at?->format('H:i') ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if(($activeMessages ?? collect())->isEmpty())
                        <div class="flex h-full items-center justify-center">
                            <p class="text-sm text-slate-400">No messages yet. Start the conversation!</p>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('messages.reply', $activeMessages->last() ?? 0) }}" class="border-t border-slate-200 bg-white p-4">
                    @csrf
                    <div class="flex items-center gap-2">
                        <input type="text" name="body" required placeholder="Type a message…"
                               class="flex-1 rounded-full border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <button type="submit" class="rounded-full bg-blue-600 p-2.5 text-white transition-colors hover:bg-blue-700">
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                        </button>
                    </div>
                </form>
            @else
                <div class="flex flex-1 items-center justify-center bg-slate-50">
                    <div class="text-center">
                        <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-slate-200">
                            <i class="fa-solid fa-comments text-2xl text-slate-400"></i>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Select a conversation</p>
                        <p class="mt-1 text-xs text-slate-400">Choose from your existing conversations or start a new one.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
