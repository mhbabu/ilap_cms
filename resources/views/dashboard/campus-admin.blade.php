@extends('layouts.app')

@section('title','Campus Dashboard')
@section('page-title','Campus Admin')

@section('content')

<div class="rounded-2xl bg-gradient-to-br from-blue-700 to-blue-500 px-6 py-5 text-white shadow-sm">
  <h1 class="text-xl font-bold text-white">{{ $campus?->name ?? 'My Campus' }}</h1>
  <p class="mt-1 text-sm text-white/85">Campus management and operations</p>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
        <i class="fa-solid fa-user-graduate text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($stats['total'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Students</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
        <i class="fa-solid fa-file-invoice text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($stats['payments'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Payments</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
        <i class="fa-solid fa-check-circle text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($stats['active'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Active Students</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($stats['tickets'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Open Tickets</p>
  </div>
</div>

<div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
  <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
    <h2 class="text-sm font-bold text-slate-900">Recent Students</h2>
    <a href="{{ route('students.index') }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Name</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Email</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Phone</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 bg-white">
        @forelse($recentStudents ?? [] as $i => $student)
          <tr>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $student->name }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $student->email ?? '—' }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $student->phone ?? '—' }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php
                $statusMap = ['enrolled' => 'green', 'documents_verified' => 'blue', 'completed' => 'slate'];
                $statusKey = $student->current_step ?? 'enrolled';
              @endphp
              <span class="rounded-full bg-{{ $statusMap[$statusKey] ?? 'amber' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $statusMap[$statusKey] ?? 'amber' }}-700">
                {{ ucfirst(str_replace('_', ' ', $statusKey)) }}
              </span>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No students found in this campus.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-8"></div>

@endsection
