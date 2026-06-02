@extends('layouts.app')

@section('title', $campus->name)
@section('page-title', $campus->name .' — Campus Detail')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">{{ $campus->name }}</h1>
        <p class="ilap-text-sm text-slate-500">Campus ID: {{ $campus->id }}</p>
    </div>
    <div class="ilap-flex gap-2">
        <a href="{{ route('campuses.edit', $campus) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Edit</a>
        <a href="{{ route('campuses.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Back</a>
    </div>
</div>

<div class="ilap-grid-3 gap-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Campus Info</h3>
        </div>
        <div class="ilap-p-4 space-y-2">
            <p><span class="ilap-text-xs text-slate-500">Address:</span> {{ $campus->address ?? '—' }}</p>
            <p><span class="ilap-text-xs text-slate-500">Phone:</span> {{ $campus->phone ?? '—' }}</p>
            <p><span class="ilap-text-xs text-slate-500">Students:</span> {{ $campus->students_count ?? $campus->students()->count() }}</p>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Enrollments</h3>
        </div>
        <div class="ilap-p-4">
            @foreach($enrollmentSummary ?? [] as $status => $count)
            <div class="ilap-flex justify-between ilap-mb-1">
                <span class="ilap-text-sm">{{ ucfirst(str_replace('_',' ',$status)) }}</span>
                <span class="ilap-badge ilap-badge--blue">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Actions</h3>
        </div>
        <div class="ilap-p-4 ilap-flex ilap-flex-col ilap-gap-2">
            <a href="{{ route('students.create') }}?campus_id={{ $campus->id }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Add Student</a>
            <a href="{{ route('leads.create') }}?campus_id={{ $campus->id }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Add Lead</a>
        </div>
    </div>
</div>
@endsection