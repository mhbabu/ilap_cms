{{-- resources/views/students/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Students')
@section('page-title', 'Students')

@section('content')
<div class="ilap-page-header ilap-flex flex-wrap items-center justify-between gap-3">
    <div></div>
    <div class="ilap-flex items-center gap-2 flex-wrap">
        @if(request('status')) <a href="{{ route('students.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Clear</a> @endif
        <a href="{{ route('students.export') }}?campus_id={{ request('campus_id') }}"
           class="ilap-btn ilap-btn-secondary ilap-btn-sm">📥 Export CSV</a>
        <a href="{{ route('students.create') }}"
           class="ilap-px-5 py-2.5 rounded-xl text-white text-sm font-bold shadow-md transition-all
                  hover:translate-y-[-1px] hover:shadow-lg"
           style="background:var(--ilap-primary)">+ New Student</a>
    </div>
</div>

{{-- Filters --}}
<div class="ilap-card ilap-mb-6">
    <form method="GET" class="ilap-p-4 grid gap-3 md:grid-cols-4">
        <div>
            <label class="ilap-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="ilap-input"
                   placeholder="Name / Unique ID">
        </div>
        <div>
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                <option value="">All Campuses</option>
                @foreach($campuses as $c)
                    <option value="{{ $c->id }}" @selected(request('campus_id')==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="ilap-label">Status</label>
            <select name="status" class="ilap-select">
                <option value="">All</option>
                @foreach(['registered','payment_pending','enrolled','documents_verified','completed'] as $s)
                    <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="ilap-flex items-end">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-w-full">Filter</button>
        </div>
    </form>
</div>

{{-- Totals Row --}}
<div class="ilap-flex items-center gap-3 ilap-mb-4">
    <span class="ilap-badge ilap-badge--blue">
        Total Students: {{ $total ?? number_format($students->total()) }}
    </span>
</div>

{{-- Students Table --}}
<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name &amp; ID</th>
                    <th>Campus</th>
                    <th>Handler</th>
                    <th>Phone</th>
                    <th>IELTS</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($students as $i => $student)
            <tr>
                <td class="ilap-text-muted">{{ $students->firstItem() + $i }}</td>
                <td>
                    <div class="ilap-flex items-center gap-2">
                        <div class="ilap-avatar">{{ strtoupper(substr($student->name??'?',0,1)) }}</div>
                        <div>
                            <p class="ilap-text-sm ilap-font-bold text-slate-800">{{ $student->name }}</p>
                            <p class="ilap-badge ilap-badge--gray ilap-text-2xs">{{ $student->unique_id }}</p>
                        </div>
                    </div>
                </td>
                <td class="ilap-text-sm">{{ $student->campus?->name ?? '—' }}</td>
                <td class="ilap-text-sm">{{ $student->handler?->name ?? $student->handler?->email ?? '—' }}</td>
                <td class="ilap-text-sm text-slate-500">{{ $student->phone ?? '—' }}</td>
                <td>
                    @if($student->ielts_score)
                        <span class="ilap-badge ilap-badge--blue ilap-font-bold">{{ number_format($student->ielts_score,1) }}</span>
                    @else <span class="ilap-text-muted">—</span>
                    @endif
                </td>
                <td>
                    @php
                        $color = $student->current_step==='completed'?'green'
                            : ($student->current_step==='documents_verified'?'blue'
                            : ($student->current_step==='enrolled'?'yellow':'gray'));
                        $label = ucfirst(str_replace('_',' ',($student->current_step ?? 'registered')));
                    @endphp
                    <span class="ilap-badge ilap-badge--{{ $color }}">{{ $label }}</span>
                </td>
                <td>
                    <a href="{{ route('students.show',$student) }}"
                       class="ilap-btn ilap-btn-secondary ilap-btn-sm"
                       style="background:var(--ilap-primary-light);color:var(--ilap-primary)">
                        View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="ilap-text-center ilap-py-12 text-slate-400">
                    <p class="ilap-text-lg">No students found.</p>
                    <p class="ilap-text-xs ilap-mt-1">Adjust filters or add a new student.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $students->links() }}
</div>
@endsection
