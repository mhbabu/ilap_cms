{{-- resources/views/dashboard/super-admin.blade.php --}}
@extends('layouts.app')

@section('title','Super Admin Dashboard')
@section('page-title','Super Admin Dashboard')

@section('content')

<div class="mb-6 rounded-2xl bg-gradient-to-br from-blue-700 to-blue-500 px-6 py-5 text-white shadow-sm">
  <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div>
      <p class="text-xs font-semibold uppercase tracking-wider text-white/70">Super Admin Dashboard</p>
      <h1 class="text-xl font-bold text-white">Welcome back, {{ $user?->name ?? 'Admin' }}</h1>
      <p class="mt-1 text-sm text-white/80">System overview and management center</p>
    </div>
    <div class="hidden md:block text-right">
      <p class="text-xs text-white/70">Today</p>
      <p class="text-sm font-semibold text-white">{{ date('M d, Y') }}</p>
    </div>
  </div>
</div>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
        <i class="fa-solid fa-graduation-cap text-sm"></i>
      </div>
      <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">+12%</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['students'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Students</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
        <i class="fa-solid fa-school text-sm"></i>
      </div>
      <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">Active</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['campuses'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Campuses</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
        <i class="fa-solid fa-dollar-sign text-sm"></i>
      </div>
      <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">+8%</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['payments'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Payments</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-700">
        <i class="fa-solid fa-sterling-sign text-sm"></i>
      </div>
      <span class="rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700">Revenue</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">${{ number_format($metrics['revenue'] ?? 0, 2) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Revenue</p>
  </div>
</div>

<div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
        <i class="fa-solid fa-user-plus text-sm"></i>
      </div>
      <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">New</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['leads'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">New Leads</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
      </div>
      <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Open</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['tickets'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Open Tickets</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700">
        <i class="fa-solid fa-users text-sm"></i>
      </div>
      <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">All</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['users'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Users</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
        <i class="fa-solid fa-arrow-trend-up text-sm"></i>
      </div>
      <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">Stable</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($metrics['campuses'] ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Active Campuses</p>
  </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">Quick Actions</h2>
      <span class="text-xs text-slate-500">Common tasks</span>
    </div>
    <div class="flex flex-wrap gap-2 p-4">
      <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white hover:bg-blue-800">
        <i class="fa-solid fa-user-plus"></i> Add User
      </a>
      <a href="{{ route('campuses.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-plus"></i> New Campus
      </a>
      <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-magnifying-glass"></i> View Students
      </a>
      <a href="{{ route('finance.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-file-invoice-dollar"></i> Finance
      </a>
      <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-ticket"></i> Tickets
      </a>
      <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-chart-pie"></i> Reports
      </a>
      <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-gear"></i> Settings
      </a>
    </div>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">Recent Users</h2>
      <a href="{{ route('users.index') }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
    </div>
    <div class="p-4">
      @forelse($recentUsers ?? [] as $ru)
        <div class="flex items-center gap-3 border-b border-slate-100 py-3 last:border-0">
          <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-xs font-bold text-white">{{ strtoupper(substr($ru->name, 0, 1)) }}</div>
          <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-semibold text-slate-800">{{ $ru->name }}</p>
            <p class="truncate text-xs text-slate-500">{{ $ru->email }}</p>
          </div>
          <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">{{ ucfirst($ru->role) }}</span>
        </div>
      @empty
        <p class="py-4 text-center text-sm text-slate-500">No users yet.</p>
      @endforelse
    </div>
  </div>
</div>

<div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
  <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
    <h2 class="text-sm font-bold text-slate-900">Open Tickets</h2>
    <a href="{{ route('tickets.index') }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Title</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Priority</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Created</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 bg-white">
        @forelse($openTickets ?? [] as $i => $t)
          <tr>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $t->title }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php $s = ['open'=>'red','in_progress'=>'yellow','resolved'=>'green','closed'=>'blue','pending'=>'gray']; @endphp
              <span class="rounded-full bg-{{ $s[$t->status] ?? 'gray' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $s[$t->status] ?? 'gray' }}-700">{{ ucfirst(str_replace('_',' ', $t->status)) }}</span>
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php $p = ['critical'=>'red','high'=>'orange','medium'=>'yellow','low'=>'green']; @endphp
              <span class="rounded-full bg-{{ $p[$t->priority] ?? 'gray' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $p[$t->priority] ?? 'gray' }}-700">{{ ucfirst($t->priority) }}</span>
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-500">{{ $t->created_at?->format('M d, Y') ?? '—' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No open tickets.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-8"></div>

@endsection
