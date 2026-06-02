@extends('layouts.app')

@section('title', 'Reports - Students')
@section('page-title', 'Student Report')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Student Report</h1>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Campus</th>
                    <th>Handler</th>
                    <th>Step</th>
                    <th>IELTS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $student->unique_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->email ?? '—' }}</td>
                    <td>{{ $student->campus?->name ?? '—' }}</td>
                    <td>{{ $student->handler?->name ?? '—' }}</td>
                    <td><span class="ilap-badge ilap-badge--blue">{{ ucfirst(str_replace('_',' ',$student->current_step)) }}</span></td>
                    <td>{{ $student->ielts_score ? number_format($student->ielts_score,1) : '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="ilap-text-center ilap-py-8 text-slate-400">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $students->links() }}
</div>
@endsection