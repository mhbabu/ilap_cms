{{-- resources/views/dashboard/overview.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Role card + inline org color scheme --}}
<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <div class="ilap-flex items-center justify-between">
            <p class="ilap-metric__label">Students</p>
            <span class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary)">🎓</span>
        </div>
        <p class="ilap-metric__value">{{ number_format($activeStudents ?? 0) }}</p>
        <p class="ilap-text-xs text-slate-500">Enrolled this term</p>
    </div>

    <div class="ilap-metric">
        <div class="ilap-flex items-center justify-between">
            <p class="ilap-metric__label">Pending Payments</p>
            <span class="ilap-text-2xl ilap-font-extrabold" style="color:#ef4444">💰</span>
        </div>
        <p class="ilap-metric__value">{{ number_format($paymentPending ?? 0) }}</p>
        <p class="ilap-text-xs text-slate-500">Awaiting approval</p>
    </div>

    <div class="ilap-metric">
        <div class="ilap-flex items-center justify-between">
            <p class="ilap-metric__label">Open Tickets</p>
            <span class="ilap-text-2xl ilap-font-extrabold" style="color:#f59e0b">🎫</span>
        </div>
        <p class="ilap-metric__value">{{ number_format($openTickets ?? 0) }}</p>
        <p class="ilap-text-xs text-slate-500">Requires action</p>
    </div>

    <div class="ilap-metric">
        <div class="ilap-flex items-center justify-between">
            <p class="ilap-metric__label">Leads</p>
            <span class="ilap-text-2xl ilap-font-extrabold" style="color:#8b5cf6">📋</span>
        </div>
        <p class="ilap-metric__value">{{ number_format($totalLeads ?? 0) }}</p>
        <p class="ilap-text-sm text-blue-600 font-semibold">{{ round($totalLeads ?? 0 / 70 * 100) }}% discount applied</p>
    </div>
</div>

{{-- Welcome Banner --}}
<div class="ilap-card mb-6 relative overflow-hidden"
     style="background:linear-gradient(135deg,var(--ilap-primary),var(--ilap-primary-dark))">
    <div class="p-6 ilap-flex items-center justify-between">
        <div>
            <p class="ilap-text-xs text-white/60 uppercase tracking-wider ilap-mb-1">
                {{ ucfirst($role) }} Dashboard
            </p>
            <p class="ilap-text-2xl ilap-font-bold text-white" id="ilap-welcome-title">
                {{ ucfirst($role) }} - Dashboard
            </p>
            <p class="ilap-text-sm text-white/80 ilap-mt-2">
                @if(!empty($campus))
                    Managing {{ $campus->name ?? $campus['name'] }} campus
                @else
                  iLAP Global Overview — All 5 branches.
                @endif
            </p>
        </div>
    </div>
</div>

@if(!empty($myHandledStudents) && $myHandledStudents->count() > 0)
{{-- Students table --}}
<div class="ilap-card ilap-mb-6">
    <div class="ilap-card-header ilap-flex items-center justify-between">
        <h3 class="ilap-font-black text-slate-800" style="margin:0">My Students</h3>
        <a href="{{ route('students.index') }}" class="ilap-text-sm font-bold hover:underline"
           style="color:var(--ilap-primary)">View All →</a>
    </div>
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Progress</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myHandledStudents as $i => $student)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="ilap-font-semibold text-slate-700">{{ $student->name }}</td>
                    <td>{{ $student->email ?? '—' }}</td>
                    <td>{{ $student->phone ?? '—' }}</td>
                    <td>
                        <div class="ilap-flex items-center gap-3">
                            <div class="ilap-flex-1 bg-slate-100 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all"
                                     style="width:80%;background:var(--ilap-primary)"></div>
                            </div>
                            <span class="ilap-text-xs font-bold" style="color:var(--ilap-primary)">80%</span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('students.show', $student) }}" class="ilap-btn ilap-btn-sm ilap-btn-secondary">
                            Edit
                        </a>
                        <a href="{{ route('students.show', $student) }}" class="ilap-btn ilap-btn-sm ilap-btn-secondary"
                           style="background:var(--ilap-primary-light);color:var(--ilap-primary)">View</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="ilap-text-center ilap-py-4 text-slate-400">
                        No students assigned yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Recent Activity + Stats ---}}
<div class="ilap-grid-3 ilap-mb-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0" style="background:var(--ilap-primary);color:white;padding:.5rem .75rem;border-radius:.375rem .375rem 0 0">Recent Activity</h3>
        </div>
        <ul class="p-4 space-y-3">
            @foreach(($recentActivities ?? []) as $activity)
            <li class="ilap-flex items-center gap-3">
                <span class="text-xl">{{ $activity['icon'] ?? '📌' }}</span>
                <div class="ilap-flex-1">
                    <p class="ilap-text-sm ilap-font-semibold text-slate-700">{{ $activity['text'] }}</p>
                    <p class="ilap-text-xs text-slate-400">{{ $activity['time'] ?? 'recently' }}</p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Performance Overview</h3>
        </div>
        <div class="p-4 space-y-4">
            @foreach([
                ['label'=>'Students', 'value'=>$activeStudents ?? 0, 'total'=>$totalStudents ?? $activeStudents ?? 0, 'color'=>'#3b82f6'],
                ['label'=>'Leads Converted', 'value'=>round(($totalLeads ?? 0) / 2), 'total'=>($totalLeads ?? 0), 'color'=>'#8b5cf6'],
                ['label'=>'Payments', 'value'=>$totalStudents ?? 0, 'total'=>$totalStudents ?? 100, 'color'=>'#10b981'],
            ] as $stat)
            <div>
                <div class="ilap-flex items-center justify-between ilap-mb-1">
                    <span class="ilap-text-xs font-semibold text-slate-600">{{ $stat['label'] }}</span>
                    <span class="ilap-text-xs font-bold" style="color:{{ $stat['color'] }}">
                        {{ $stat['value'] }} / {{ $stat['total'] }}
                    </span>
                </div>
                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all"
                         style="width:{{ round($stat['value']/$stat['total']*100) }}%;background:{{ $stat['color'] }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header"><h3 class="ilap-font-bold text-slate-800 ilap-m-0">Quick Actions</h3></div>
        <div class="ilap-flex ilap-flex-wrap gap-2 p-4">
            <a href="{{ route('students.create') }}"
               class="ilap-btn ilap-btn-primary ilap-btn-sm" style="background:var(--ilap-primary)">
                + New Student
            </a>
            <a href="{{ route('payments.index') }}"
               class="ilap-btn ilap-btn-secondary ilap-btn-sm" style="background:var(--ilap-secondary);color:white;border:none">
                Record Payment
            </a>
            <a href="{{ route('tickets.create') }}"
               class="ilap-btn ilap-btn-secondary ilap-btn-sm">
                Open Ticket
            </a>
            <a href="{{ route('leads.index') }}"
               class="ilap-btn ilap-btn-secondary ilap-btn-sm">
                Manage Leads
            </a>
            <a href="{{ route('documents.create') }}"
               class="ilap-btn ilap-btn-secondary ilap-btn-sm">
                + Upload Document
            </a>
        </div>
    </div>
</div>

{{-- My Tickets (handler) --}}
@if(!empty($myTickets) && $myTickets->count() > 0)
<div class="ilap-card ilap-mb-6">
    <div class="ilap-card-header ilap-flex items-center justify-between">
        <h3 class="ilap-font-bold ilap-m-0" style="color:var(--ilap-primary)">
            @if($role === 'handler') My Pending Tickets @else Recent Tickets @endif
        </h3>
        <a href="{{ route('tickets.index') }}" class="ilap-text-xs font-bold uppercase"
           style="color:var(--ilap-primary)">View All →</a>
    </div>
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                </tr>
            </thead>
            <tbody>
            @foreach($myTickets as $i => $t)
            <tr>
                <td>{{ ++$i }}</td>
                <td class="ilap-font-semibold text-slate-700">{{ $t->title }}</td>
                <td>
                    @php $statusColor = ['open'=>'red','in_progress'=>'yellow','resolved'=>'green','closed'=>'blue']; @endphp
                    <span class="ilap-badge ilap-badge--{{ $statusColor[$t->status] ?? 'gray' }}">
                        {{ ucfirst(str_replace('_',' ',$t->status)) }}
                    </span>
                </td>
                <td>
                    @php $pColor=['critical'=>'red','high'=>'orange','medium'=>'yellow','low'=>'green']; @endphp
                    <span class="ilap-badge ilap-badge--{{ $pColor[$t->priority] ?? 'gray' }}">
                        {{ ucfirst($t->priority) }}
                    </span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Footer spacing --}}
<div class="ilap-py-6"></div>

@endsection
