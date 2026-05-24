{{-- resources/views/campus/show.blade.php --}}
@extends('layouts.app')

@section('title',$campus->name)
@section('page-title', $campus->name .' — Branch')
@section('content')

@php $cColor = $campus->color_primary ?? 'var(--ilap-primary)'; @endphp

<div class="ilap-grid-3 ilap-mb-6">
    <div class="ilap-card">
        <div class="ilap-p-5">
            <p class="ilap-text-2xs ilap-uppercase text-slate-400 ilap-mb-2">Students</p>
            <p class="ilap-text-3xl ilap-font-extrabold" style="color:var(--ilap-primary)">{{ number_format($campus->students->count()) }}</p>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-p-5">
            <p class="ilap-text-2xs ilap-uppercase text-slate-400 ilap-mb-2">Classes</p>
            <p class="ilap-text-3xl ilap-font-extrabold" style="color:var(--ilap-secondary)">
                {{ number_format($campus->classes->count()) }}
            </p>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-p-5">
            <p class="ilap-text-2xs ilap-uppercase text-slate-400 ilap-mb-2">Enrollments</p>
            <p class="ilap-text-3xl ilap-font-extrabold" style="color:var(--ilap-primary)">
                {{ number_format($campus->enrollments->count()) }}
            </p>
        </div>
    </div>
</div>

{{-- Enrollments table --}}
<div class="ilap-card">
    <div class="ilap-card-header ilap-flex items-center justify-between">
        <h3 class="ilap-m-0 ilap-font-bold text-slate-800">Enrollments — {{ $campus->name }}</h3>
    </div>
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Module</th>
                    <th>Enrolled</th>
                    <th>Completed</th>
                </tr>
            </thead>
            <tbody>
            @forelse($enrollments as $i => $e)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="ilap-font-semibold">{{ $e->student?->name ?? '—' }}</td>
                <td>{{ $e->classId?->name ?? '—' }}</td>
                <td>{{ $e->module?->name ?? '—' }}</td>
                <td>{{ $e->enrollment_date?->format('Y-m-d') ?? '—' }}</td>
                <td><span class="ilap-badge ilap-badge--{{ $e->status === 'enrolled' ? 'green' : 'gray' }}">{{ $e->status }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="ilap-text-center ilap-py-12 text-slate-400">No enrollments yet.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
