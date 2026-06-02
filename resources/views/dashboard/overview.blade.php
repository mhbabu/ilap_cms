{{-- resources/views/dashboard/overview.blade.php --}}
@extends('layouts.app')

@section('title','Dashboard')
@section('page-title', ucfirst($role ?? 'Dashboard'))

@section('content')

<div class="mb-6 rounded-2xl bg-gradient-to-br from-blue-800 to-blue-500 px-6 py-5 text-white shadow-sm">
  <p class="text-xs font-semibold uppercase tracking-wider text-white/70">{{ ucfirst($role ?? 'User') }} Dashboard</p>
  <h1 class="mt-1 text-xl font-bold text-white">Welcome back</h1>
  <p class="mt-1 text-sm text-white/85">
    @if(!empty($campus))
      Managing {{ $campus->name ?? $campus['name'] ?? 'campus' }}
    @else
      System overview for all campuses.
    @endif
  </p>
</div>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
        <i class="fa-solid fa-user-graduate text-sm"></i>
      </div>
      <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">This term</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($activeStudents ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Active Students</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
        <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
      </div>
      <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Pending</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($paymentPending ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Pending Payments</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
      </div>
      <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Open</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($openTickets ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Open Tickets</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
        <i class="fa-solid fa-user-plus text-sm"></i>
      </div>
      <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">New</span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($totalLeads ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">New Leads</p>
  </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">Recent Activity</h2>
      <span class="text-xs text-slate-500">Latest updates</span>
    </div>
    <div class="p-4 space-y-3">
      @foreach(($recentActivities ?? []) as $activity)
        <div class="flex items-start gap-3">
          <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-sm">{{ $activity['icon'] ?? '📌' }}</div>
          <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold text-slate-700">{{ $activity['text'] }}</p>
            <p class="text-xs text-slate-500">{{ $activity['time'] ?? 'recently' }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">Quick Actions</h2>
    </div>
    <div class="flex flex-wrap gap-2 p-4">
      <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white hover:bg-blue-800">
        <i class="fa-solid fa-user-plus"></i> New Student
      </a>
      <a href="{{ route('finance.payments.create') ?? route('finance.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-dollar-sign"></i> Record Payment
      </a>
      <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-ticket"></i> Open Ticket
      </a>
      <a href="{{ route('leads.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-user-plus"></i> New Lead
      </a>
      <a href="{{ route('documents.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-upload"></i> Upload Document
      </a>
      <a href="{{ route('messages.compose') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-paper-plane"></i> Send Message
      </a>
    </div>
  </div>
</div>

@if(!empty($myTickets) && $myTickets->count() > 0)
<div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
  <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
    <h2 class="text-sm font-bold text-slate-900">Recent Tickets</h2>
    <a href="{{ route('tickets.index') }}" class="text-xs font-semibold text-primary hover:underline">View All <i class="fa-solid fa-arrow-right fa-xs ml-1"></i></a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Title</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Priority</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 bg-white">
        @foreach($myTickets as $i => $t)
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
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@if(!empty($myStudents) && $myStudents->count() > 0)
<div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
  <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
    <h2 class="text-sm font-bold text-slate-900">Recent Students</h2>
    <a href="{{ route('students.index') }}" class="text-xs font-semibold text-primary hover:underline">View All <i class="fa-solid fa-arrow-right fa-xs ml-1"></i></a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Name</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Email</th>
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Progress</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 bg-white">
        @foreach($myStudents as $i => $student)
          <tr>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $student->name }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $student->email ?? '—' }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php
                $pct = match($student->current_step) {
                  'documents_verified' => 100,
                  'completed' => 100,
                  'enrolled' => 85,
                  default => 40,
                };
              @endphp
              <div class="flex items-center gap-2">
                <div class="h-1.5 flex-1 rounded-full bg-slate-100">
                  <div class="h-1.5 rounded-full bg-primary" style="width: {{ $pct }}%"></div>
                </div>
                <span class="text-xs font-semibold text-primary">{{ $pct }}%</span>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

<div class="mt-8"></div>

@endsection
