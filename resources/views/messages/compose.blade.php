@extends('layouts.app')

@section('title','Compose Message')
@section('page-title','Compose Message')

@section('content')
<div class="fixed inset-0 top-14 ml-64 z-30 bg-white">
    <div class="mx-auto max-w-2xl h-full flex flex-col p-6">
        <form action="{{ route('messages.send') }}" method="POST" class="flex-1 flex flex-col rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            @csrf
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-bold text-slate-900">New Message</h2>
            </div>
            <div class="flex-1 space-y-4 p-5 overflow-y-auto">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Recipient *</label>
                    <select name="receiver_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Subject *</label>
                    <input type="text" name="subject" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Message *</label>
                    <textarea name="body" rows="10" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Write your message..."></textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Type</label>
                    <select name="type" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="internal">Internal Message</option>
                        <option value="email">Email</option>
                    </select>
                </div>
            </div>
            <div class="border-t border-slate-100 px-5 py-3 flex items-center justify-end gap-2">
                <a href="{{ route('messages.inbox') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Send Message</button>
            </div>
        </form>
    </div>
</div>
@endsection
