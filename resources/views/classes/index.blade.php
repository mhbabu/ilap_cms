@extends('layouts.app')

@section('title','Classes')
@section('page-title','Classes')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Classes</h1>
        <p class="text-xs text-slate-500">{{ $classes->total() }} classes</p>
    </div>
    <a href="{{ route('classes.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-800">
        + New Class
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Code</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Module</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Campus</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Teacher</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Enrolled</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($classes as $class)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $class->name }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $class->code }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $class->module?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $class->campus?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $class->teacher?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $class->enrollments->count() }}</td>
                <td class="flex gap-1 whitespace-nowrap px-5 py-3 text-sm">
                    <a href="{{ route('classes.show',$class) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                    <a href="{{ route('classes.edit',$class) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">No classes found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">{{ $classes->links() }}</div>
</div>
@endsection
