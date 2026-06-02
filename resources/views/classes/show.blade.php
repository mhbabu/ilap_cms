@extends('layouts.app')

@section('title','Class Details')
@section('page-title', $class->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Classes
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm mb-6">
    <div class="border-b border-slate-100 px-6 py-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $class->name }}</h2>
                <p class="text-xs text-slate-500 mt-1">Code: {{ $class->code }} • Teacher: {{ $class->teacher->name ?? '—' }}</p>
            </div>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $class->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                {{ $class->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <p class="mt-3 text-sm text-slate-600">Campus: {{ $class->campus->name ?? '—' }} • Module: {{ $class->module->name ?? '—' }}</p>
    </div>
    <div class="grid grid-cols-3 gap-0 divide-x divide-slate-100">
        <div class="p-4 text-center">
            <p class="text-2xl font-bold text-slate-900">{{ $class->enrollments->count() }}</p>
            <p class="text-xs text-slate-500">Enrolled</p>
        </div>
        <div class="p-4 text-center">
            <p class="text-2xl font-bold text-slate-900">{{ $class->records->count() }}</p>
            <p class="text-xs text-slate-500">Records</p>
        </div>
        <div class="p-4 text-center">
            <a href="{{ route('videos.by-class',$class) }}" class="text-sm font-semibold text-primary hover:underline">View Videos</a>
        </div>
    </div>
</div>

<h3 class="mb-3 text-sm font-bold text-slate-900">Class Records</h3>
<div class="space-y-2">
    @forelse($class->records as $record)
    <a href="{{ route('videos.play',$record) }}" class="block rounded-xl border border-slate-200 bg-white p-4 hover:shadow-sm">
        <p class="text-sm font-semibold text-slate-800">{{ $record->topic }}</p>
        <p class="text-xs text-slate-500">Date: {{ $record->record_date }} • Teacher: {{ $record->teacher->name ?? '—' }}</p>
    </a>
    @empty
    <p class="text-sm text-slate-400">No class records yet.</p>
    @endforelse
</div>
@endsection
