{{ FILENAME: resources/views/documents/index.blade.php }}
@extends('layouts.app')
@section('content')

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Documents</h1>
        <p class="ilap-text-xs text-slate-500">{{ $documents->total() ?? $documents->count() }} documents</p>
    </div>
    <a href="{{ route('documents.create') }}"
       class="ilap-px-5 py-2.5 rounded-xl text-white font-bold text-sm shadow-md"
       style="background:var(--ilap-primary)">+ Upload Document</a>
</div>

<div class="ilap-card" style="--ilap-primary: #64748b">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($documents as $i => $doc)
            <tr style="--ilap-primary:var(--ilap-metric-color,#3b82f6)">
                <td class="ilap-text-xs text-slate-400">{{ ++$i }}</td>
                <td>
                    <div class="ilap-flex items-center gap-2">
                        <span class="ilap-text-xl">{{ $doc->isPdf() ? '📕' : ($doc->isWord() ? '📘' : '📁') }}</span>
                        <div>
                            <p class="ilap-text-sm ilap-font-semibold text-slate-800">{{ $doc->title }}</p>
                            <p class="ilap-text-xs text-slate-400">{{ Str::limit($doc->description ?? '',40) }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="ilap-badge ilap-badge--{{ $doc->isPdf() ? 'blue' : ($doc->isWord() ? 'green' : 'gray') }}">
                        {{ strtoupper($doc->mime ?: '') }}
                    </span>
                </td>
                <td class="ilap-text-sm text-slate-500">{{ ucfirst($doc->type) }}</td>
                <td class="ilap-text-sm text-slate-500">{{ $doc->size_formatted ?? '—' }}</td>
                <td class="ilap-text-xs text-slate-400">
                    {{ $doc->created_at?->diffForHumans() ?? '—' }}
                </td>
                <td class="ilap-flex gap-1">
                    <a href="{{ route('documents.download',$doc) }}"
                       class="ilap-btn ilap-btn-secondary ilap-btn-sm">⬇</a>
                    <button onclick="deleteDoc('{{ $doc->id }}')"
                            class="ilap-btn ilap-btn-sm ilap-btn-danger">🗑</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="ilap-text-center ilap-py-12 text-slate-400">
                    <p>No documents yet. Click the button above to upload one.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $documents->links() }}
</div>
@endsection
