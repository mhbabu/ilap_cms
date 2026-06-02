@extends('layouts.app')

@section('title','Manager Dashboard')
@section('page-title','Campus Manager')

@section('content')

<div class="rounded-2xl bg-gradient-to-br from-teal-700 to-teal-500 px-6 py-5 text-white shadow-sm">
  <h1 class="text-xl font-bold text-white">{{ $campus?->name ?? 'My Campus' }}</h1>
  <p class="mt-1 text-sm text-white/85">Daily campus operations and team management</p>
</div>

<div class="mt-6 flex flex-wrap gap-2">
  <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white hover:bg-blue-800">
    <i class="fa-solid fa-user-plus"></i> New Student
  </a>
  <a href="{{ route('finance.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
    <i class="fa-solid fa-file-invoice-dollar"></i> Finance
  </a>
  <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
    <i class="fa-solid fa-ticket"></i> Tickets
  </a>
  <a href="{{ route('documents.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
    <i class="fa-solid fa-folder-open"></i> Documents
  </a>
  <a href="{{ route('leads.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
    <i class="fa-solid fa-user-plus"></i> Leads
  </a>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
  <a href="{{ route('students.index') }}" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md">
    <div class="flex items-center gap-3">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
        <i class="fa-solid fa-user-graduate"></i>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-900">Students</p>
        <p class="text-xs text-slate-500">View and manage all students</p>
      </div>
    </div>
  </a>
  <a href="{{ route('finance.index') }}" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md">
    <div class="flex items-center gap-3">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
        <i class="fa-solid fa-chart-line"></i>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-900">Finance</p>
        <p class="text-xs text-slate-500">Payments and invoices</p>
      </div>
    </div>
  </a>
  <a href="{{ route('tickets.index') }}" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md">
    <div class="flex items-center gap-3">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700">
        <i class="fa-solid fa-ticket"></i>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-900">Tickets</p>
        <p class="text-xs text-slate-500">Handle support tickets</p>
      </div>
    </div>
  </a>
</div>

<div class="mt-8"></div>

@endsection
