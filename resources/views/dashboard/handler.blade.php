@extends('layouts.app')

@section('title','Handler Dashboard')
@section('page-title','Handler Dashboard')

@section('content')

<div class="rounded-2xl bg-gradient-to-br from-teal-700 to-teal-500 px-6 py-5 text-white shadow-sm">
  <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <p class="text-xs font-semibold uppercase tracking-wider text-white/70">Handler Dashboard</p>
      <h1 class="text-xl font-bold text-white">Welcome, {{ $user?->name ?? 'Handler' }}</h1>
      <p class="mt-1 text-sm text-white/85">Your assigned students and leads overview</p>
    </div>
    <div class="hidden md:block">
      <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 text-white">
        <i class="fa-solid fa-handshake"></i>
      </div>
    </div>
  </div>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100 text-teal-700">
        <i class="fa-solid fa-user-graduate text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($studentsCount ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">My Students</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
        <i class="fa-solid fa-user-plus text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($leadsAssigned ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Assigned Leads</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
        <i class="fa-solid fa-list text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($leadsTotal ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Total Leads</p>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
      </div>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($leadsUnassigned ?? 0) }}</p>
    <p class="text-xs font-medium text-slate-500">Unassigned Leads</p>
  </div>
</div>

<div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
  <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
    <h2 class="text-sm font-bold text-slate-900">Recent Tickets</h2>
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
          <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 bg-white">
        @forelse($tickets ?? [] as $i => $ticket)
          <tr>
            <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $ticket->title }}</td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php $s = ['open'=>'red','in_progress'=>'yellow','resolved'=>'green','closed'=>'blue','pending'=>'gray']; @endphp
              <span class="rounded-full bg-{{ $s[$ticket->status] ?? 'gray' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $s[$ticket->status] ?? 'gray' }}-700">{{ ucfirst($ticket->status) }}</span>
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              @php $p = ['critical'=>'red','high'=>'orange','medium'=>'yellow','low'=>'green']; @endphp
              <span class="rounded-full bg-{{ $p[$ticket->priority] ?? 'gray' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $p[$ticket->priority] ?? 'gray' }}-700">{{ ucfirst($ticket->priority) }}</span>
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-sm">
              <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No tickets assigned yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-8"></div>

@endsection
