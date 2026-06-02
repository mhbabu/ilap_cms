{{-- resources/views/documents/index.blade.php --}}
@extends('layouts.app')

@section('title','Documents')
@section('page-title','Documents')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Documents</h1>
        <p class="text-xs text-slate-500">{{ $documents->total() ?? $documents->count() }} documents</p>
    </div>
    <a href="{{ route('documents.create') }}"
       class="inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-800">
        + Upload Document
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Title</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Type</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Category</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Size</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Uploaded</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($documents as $i => $doc)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $doc->title }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $doc->type }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $doc->category ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $doc->size_formatted ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-xs text-slate-400">{{ $doc->created_at?->diffForHumans() ?? '—' }}</td>
                <td class="flex gap-1 whitespace-nowrap px-5 py-3 text-sm">
                    <a href="{{ route('documents.download',$doc) }}"
                       class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">⬇</a>
                    <button onclick="deleteDoc('{{ $doc->id }}')"
                            class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">🗑</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">No documents uploaded yet.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">
        {{ $documents->links() }}
    </div>
</div>
@endsection
