@extends('settings.settings-layout')

@section('title', 'Audit Logs')

@section('settings-content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Audit Logs</h1>
    <p class="ilap-text-sm text-slate-500">System activity log for all admin actions.</p>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Activity</th>
                    <th>Causer</th>
                    <th>Subject</th>
                    <th>When</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td class="ilap-text-xs text-slate-500">{{ $logs->firstItem() + $i }}</td>
                    <td class="ilap-font-semibold text-slate-700">{{ ucfirst($log->description ?? $log->log_name) }}</td>
                    <td class="ilap-text-sm">{{ $log->causer?->name ?? 'System' }}</td>
                    <td class="ilap-text-sm">{{ $log->subject_type }} #{{ $log->subject_id }}</td>
                    <td class="ilap-text-xs text-slate-500">{{ $log->created_at?->diffForHumans() ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="ilap-text-center ilap-py-8 text-slate-400">
                        <p class="ilap-text-lg">No activity logs found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $logs->links() }}
</div>
@endsection