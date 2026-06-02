@extends('layouts.app')

@section('title','Course Details')
@section('page-title','Course Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Courses
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm mb-6">
    <div class="border-b border-slate-100 px-6 py-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $module->name }}</h2>
                <p class="text-xs text-slate-500 mt-1">Code: {{ $module->code }}</p>
            </div>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $module->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                {{ $module->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <p class="mt-3 text-sm text-slate-600">{{ $module->description }}</p>
    </div>
    <div class="grid grid-cols-3 gap-0 divide-x divide-slate-100">
        <div class="p-4 text-center">
            <p class="text-2xl font-bold text-slate-900">{{ $module->classes->count() }}</p>
            <p class="text-xs text-slate-500">Classes</p>
        </div>
        <div class="p-4 text-center">
            <p class="text-2xl font-bold text-slate-900">{{ $module->enrollments->count() }}</p>
            <p class="text-xs text-slate-500">Enrollments</p>
        </div>
        <div class="p-4 text-center">
            <p class="text-2xl font-bold text-slate-900">{{ $module->records->count() }}</p>
            <p class="text-xs text-slate-500">Class Records</p>
        </div>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <h3 class="mb-3 text-sm font-bold text-slate-900">Classes</h3>
        <div class="space-y-2">
            @forelse($module->classes as $class)
            <a href="{{ route('classes.show',$class) }}" class="block rounded-xl border border-slate-200 bg-white p-4 hover:shadow-sm">
                <p class="text-sm font-semibold text-slate-800">{{ $class->name }}</p>
                <p class="text-xs text-slate-500">{{ $class->campus->name ?? '—' }} • Teacher: {{ $class->teacher->name ?? '—' }}</p>
            </a>
            @empty
            <p class="text-sm text-slate-400">No classes yet.</p>
            @endforelse
        </div>
    </div>
    <div>
        <h3 class="mb-3 text-sm font-bold text-slate-900">Affiliates</h3>
        <div class="space-y-2">
            @forelse($module->affiliates as $aff)
            <div class="rounded-xl border border-slate-200 bg-white p-4">
                <p class="text-sm font-semibold text-slate-800">{{ $aff->provider_name }}</p>
                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">Affiliated</span>
            </div>
            @empty
            <p class="text-sm text-slate-400">No affiliates.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
