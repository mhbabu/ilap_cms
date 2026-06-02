@extends('layouts.app')

@section('title', $campus->name .' - Campus Report')
@section('page-title', 'Campus Report: ' .$campus->name)

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">{{ $campus->name }} Report</h1>
</div>

<div class="ilap-grid-3 gap-6">
    <div class="ilap-card">
        <div class="ilap-p-4">
            <p class="ilap-text-xs text-slate-500 uppercase">Students</p>
            <p class="ilap-text-2xl ilap-font-extrabold">{{ $campus->students->count() }}</p>
        </div>
    </div>
    <div class="ilap-card">
        <div class="ilap-p-4">
            <p class="ilap-text-xs text-slate-500 uppercase">Enrollments</p>
            <p class="ilap-text-2xl ilap-font-extrabold">{{ $campus->enrollments->count() }}</p>
        </div>
    </div>
    <div class="ilap-card">
        <div class="ilap-p-4">
            <p class="ilap-text-xs text-slate-500 uppercase">Payments</p>
            <p class="ilap-text-2xl ilap-font-extrabold">£{{ number_format($campus->payments->sum('amount'), 0) }}</p>
        </div>
    </div>
</div>

<div class="ilap-card ilap-mt-6">
    <div class="ilap-card-header">
        <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Enrollment by Status</h3>
    </div>
    <div class="ilap-p-4">
        @foreach($enrollmentSummary as $status => $count)
        <div class="ilap-flex justify-between ilap-mb-2">
            <span>{{ ucfirst(str_replace('_',' ',$status)) }}</span>
            <span class="ilap-badge ilap-badge--blue">{{ $count }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection