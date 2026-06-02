@extends('layouts.app')

@section('title','Videos')
@section('page-title','Videos')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Videos</h1>
        <p class="text-xs text-slate-500">{{ $records->total() }} records</p>
    </div>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Topic</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Class</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Module</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Teacher</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($records as $record)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $record->topic }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $record->classData->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $record->module?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $record->teacher->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $record->record_date }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm">
                    <a href="{{ route('videos.play',$record) }}" class="inline-flex items-center rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-800">
                        <i class="fa-solid fa-play fa-xs"></i> Play
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400">No videos found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">{{ $records->links() }}</div>
</div>
@endsection
