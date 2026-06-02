@extends('settings.settings-layout')

@section('settings-content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Email Templates</h1>
    </div>
    <button onclick="document.getElementById('createTemplate').classList.remove('hidden')" 
            class="ilap-btn ilap-btn-primary ilap-btn-sm">+ New Template</button>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                <tr>
                    <td class="ilap-font-semibold">{{ $template->name }}</td>
                    <td><span class="ilap-badge ilap-badge--blue">{{ $template->type }}</span></td>
                    <td>{{ $template->subject }}</td>
                    <td><span class="ilap-badge {{ $template->is_active ? 'ilap-badge--green' : 'ilap-badge--gray' }}">
                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                    </span></td>
                    <td class="ilap-text-xs">{{ $template->updated_at?->diffForHumans() ?? '—' }}</td>
                    <td><a href="#" class="ilap-btn ilap-btn-sm ilap-btn-secondary">Edit</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="ilap-text-center ilap-py-8 text-slate-400">No templates yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $templates->links() }}
</div>
@endsection