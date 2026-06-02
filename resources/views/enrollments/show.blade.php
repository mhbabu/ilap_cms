@extends('layouts.app')

@section('title','Enrollment Details')
@section('page-title','Enrollment Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('enrollments.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Enrollments
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm mb-6">
    <div class="border-b border-slate-100 px-6 py-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $enrollment->student->name ?? 'Student' }}</h2>
                <p class="text-xs text-slate-500 mt-1">Class: {{ $enrollment->classData->name ?? '—' }} • Module: {{ $enrollment->module?->name ?? $enrollment->classData?->module?->name ?? '—' }}</p>
            </div>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $enrollment->approved_by_hq ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $enrollment->approved_by_hq ? 'HQ Approved' : 'Pending Approval' }}
            </span>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-0 divide-x divide-slate-100">
        <div class="p-4 text-center">
            <p class="text-sm text-slate-500">Campus</p>
            <p class="text-sm font-semibold text-slate-800">{{ $enrollment->campus->name ?? '—' }}</p>
        </div>
        <div class="p-4 text-center">
            <p class="text-sm text-slate-500">Payment</p>
            <p class="text-sm font-semibold text-slate-800">£{{ number_format($enrollment->payment_amount ?? 0, 2) }}</p>
        </div>
        <div class="p-4 text-center">
            <p class="text-sm text-slate-500">Status</p>
            <p class="text-sm font-semibold text-slate-800 capitalize">{{ str_replace('_',' ', $enrollment->status) }}</p>
        </div>
    </div>
</div>

@if(!$enrollment->approved_by_hq && in_array($enrollment->status, ['registered','enrolled']))
<div class="flex gap-2 mb-6">
    <form method="POST" action="{{ route('enrollments.approve',$enrollment) }}">
        @csrf @method('POST')
        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Approve Enrollment</button>
    </form>
    <form method="POST" action="{{ route('enrollments.reject',$enrollment) }}">
        @csrf @method('POST')
        <button type="submit" class="rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Reject</button>
    </form>
</div>
@endif

<div class="flex gap-2">
    <a href="{{ route('enrollments.edit',$enrollment) }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Edit Enrollment</a>
    @if($enrollment->class_id)
        <a href="{{ route('classes.show',$enrollment->class_id) }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-900">View Class</a>
    @endif
    @if($enrollment->class_id)
        <a href="{{ route('videos.by-class',$enrollment->class_id) }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Watch Videos</a>
    @endif
</div>
@endsection
