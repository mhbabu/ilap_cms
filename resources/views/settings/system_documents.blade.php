@extends('settings.settings-layout')

@section('settings-content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">System Documents</h1>
    <button onclick="document.getElementById('uploadDoc').classList.remove('hidden')" 
            class="ilap-btn ilap-btn-primary ilap-btn-sm">+ Upload Template</button>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docs as $doc)
                <tr>
                    <td>{{ $doc->name }}</td>
                    <td><span class="ilap-badge ilap-badge--blue">{{ ucfirst($doc->type) }}</span></td>
                    <td class="ilap-text-xs">{{ $doc->created_at?->diffForHumans() ?? '—' }}</td>
                    <td><a href="{{ asset('storage/'.$doc->file_path) }}" class="ilap-btn ilap-btn-sm ilap-btn-secondary" target="_blank">Download</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="ilap-text-center ilap-py-8 text-slate-400">No system documents uploaded.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $docs->links() }}
</div>

{{-- Upload Form (hidden) --}}
<div id="uploadDoc" class="hidden ilap-card ilap-mt-6">
    <form action="{{ route('settings.upload-system-doc') }}" method="POST" enctype="multipart/form-data" class="ilap-p-4 grid gap-4 md:grid-cols-2">
        @csrf
        <div class="ilap-form-group">
            <label class="ilap-label">Document Name *</label>
            <input type="text" name="name" required class="ilap-input">
        </div>
        <div class="ilap-form-group">
            <label class="ilap-label">Type *</label>
            <select name="type" required class="ilap-select">
                <option value="form">Form</option>
                <option value="result">Result</option>
                <option value="guide">Guide</option>
                <option value="contract">Contract</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">File *</label>
            <input type="file" name="file" required class="ilap-input">
        </div>
        <div class="ilap-form-group md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary">Upload</button>
        </div>
    </form>
</div>
@endsection