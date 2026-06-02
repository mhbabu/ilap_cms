@extends('layouts.app')

@section('title','HQ Dashboard')
@section('page-title','HQ Admin')

@section('content')

<div class="rounded-2xl bg-gradient-to-br from-blue-700 to-blue-500 px-6 py-5 text-white shadow-sm">
  <h1 class="text-xl font-bold text-white">Campus Overview</h1>
  <p class="mt-1 text-sm text-white/85">Managing {{ $campus->count() }} campuses across all regions</p>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
  @foreach($campus as $c)
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900">{{ $c->name }}</h3>
        <span class="rounded-full {{ $c->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} px-2 py-0.5 text-[11px] font-semibold">
          {{ $c->is_active ? 'Active' : 'Inactive' }}
        </span>
      </div>
      <div class="mt-4 flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
          <i class="fa-solid fa-user-graduate text-sm"></i>
        </div>
        <div>
          <p class="text-lg font-bold text-slate-900">{{ $c->students->count() }}</p>
          <p class="text-xs text-slate-500">Students</p>
        </div>
      </div>
      <a href="{{ route('campuses.show', $c) }}" class="mt-4 inline-flex items-center text-xs font-semibold text-primary hover:underline">
        View Details <i class="fa-solid fa-arrow-right fa-xs ml-1"></i>
      </a>
    </div>
  @endforeach
</div>

<div class="mt-8"></div>

@endsection
