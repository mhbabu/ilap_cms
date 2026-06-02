@extends('layouts.app')

@section('title','Sent Messages')
@section('page-title','Sent Messages')

@section('content')
<div class="mb-6">
    <a href="{{ route('messages.inbox') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Messages
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">To</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Subject</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Type</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Sent At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse(($messages ?? []) as $message)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $message->receiver?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $message->subject }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm">
                    <span class="inline-flex rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $message->type === 'email' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst($message->type) }}
                    </span>
                </td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $message->created_at?->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-5 py-12 text-center text-sm text-slate-400">No sent messages yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">{{ $messages->links() ?? '' }}</div>
</div>
@endsection
