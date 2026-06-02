@extends('layouts.app')

@section('title','Enrollments')
@section('page-title','Enrollments')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Enrollments</h1>
        <p class="text-xs text-slate-500">{{ $enrollments->total() }} enrollments</p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-800">
        + New Enrollment
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Student</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Class</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Module</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Campus</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($enrollments as $enroll)
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $enroll->student->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $enroll->classData->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $enroll->module?->name ?? $enroll->classData?->module?->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $enroll->campus->name ?? '—' }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $enroll->enrollment_date }}</td>
                <td class="whitespace-nowrap px-5 py-3 text-sm">
                    @php
                        $map = ['registered'=>'amber','enrolled'=>'emerald','documents_verified'=>'blue','completed'=>'green','rejected'=>'red'];
                    @endphp
                    <span class="rounded-full bg-{{ $map[$enroll->status] ?? 'slate' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $map[$enroll->status] ?? 'slate' }}-700">
                        {{ ucfirst(str_replace('_',' ', $enroll->status)) }}
                    </span>
                </td>
                <td class="flex gap-1 whitespace-nowrap px-5 py-3 text-sm">
                    <a href="{{ route('enrollments.show',$enroll) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                    @if(!$enroll->approved_by_hq && in_array($enroll->status, ['registered','enrolled']))
                        <form method="POST" action="{{ route('enrollments.approve',$enroll) }}" class="inline">
                            @csrf @method('POST')
                            <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100">Approve</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">No enrollments found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">{{ $enrollments->links() }}</div>
</div>
@endsection
