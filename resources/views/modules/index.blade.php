@extends('layouts.app')

@section('title','Courses')
@section('page-title','Courses')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Courses</h1>
        <p class="text-xs text-slate-500">{{ $modules->total() }} courses</p>
    </div>
    @can('create modules')
    <a href="{{ route('modules.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-800">
        + New Course
    </a>
    @endcan
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Code</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Campus</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Classes</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Enrollments</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($modules as $module)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $module->name }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $module->code }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $module->campus->name ?? 'HQ' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $module->classes->count() }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $module->enrollments->count() }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm">
                    @if($module->is_active)
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">Active</span>
                    @else
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700">Inactive</span>
                    @endif
                </td>
                <td class="flex gap-1 whitespace-nowrap px-5 py-3 text-sm">
                    <a href="{{ route('modules.show',$module) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                    @can('edit modules')
                    <a href="{{ route('modules.edit',$module) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                    @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">No courses found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">{{ $modules->links() }}</div>
</div>
@endsection
