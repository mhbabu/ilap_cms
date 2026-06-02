@extends('layouts.app')

@section('title','Student Dashboard')
@section('page-title','Student Portal')

@section('content')

<div class="rounded-2xl bg-gradient-to-br from-violet-700 to-violet-500 px-6 py-5 text-white shadow-sm">
  <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <p class="text-xs font-semibold uppercase tracking-wider text-white/70">Student Portal</p>
      <h1 class="text-xl font-bold text-white">Welcome back, {{ $student?->name ?? auth()->user()?->name ?? 'Student' }}</h1>
      <p class="mt-1 text-sm text-white/85">Track your enrollment and payments</p>
    </div>
    <div class="hidden md:block">
      <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 text-white">
        <i class="fa-solid fa-user-graduate"></i>
      </div>
    </div>
  </div>
</div>

<div class="mt-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
  <div class="flex items-center gap-4">
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary text-lg font-bold text-white">
      {{ strtoupper(substr($student?->name ?? auth()->user()?->name ?? 'S', 0, 1)) }}
    </div>
    <div>
      <p class="text-sm font-bold text-slate-900">{{ $student?->name ?? auth()->user()?->name ?? '—' }}</p>
      <p class="text-xs text-slate-500">{{ $student?->email ?? auth()->user()?->email ?? '—' }}</p>
      <span class="mt-1 inline-block rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">
        {{ ucfirst(str_replace('_',' ', $student?->current_step ?? '—')) }}
      </span>
    </div>
  </div>
</div>

@if($student)
<div class="mt-6 grid gap-6 lg:grid-cols-2">
  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">Payments</h2>
      <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">{{ $payments->count() }} records</span>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-100">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Date</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Amount</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 bg-white">
          @forelse($payments ?? [] as $payment)
            <tr>
              <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $payment->created_at?->format('M d, Y') }}</td>
              <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">£{{ number_format($payment->amount, 2) }}</td>
              <td class="whitespace-nowrap px-5 py-3 text-sm">
                @php $s = ['pending'=>'amber','completed'=>'emerald','failed'=>'red','refunded'=>'slate']; @endphp
                <span class="rounded-full bg-{{ $s[$payment->status] ?? 'gray' }}-100 px-2 py-0.5 text-[11px] font-semibold text-{{ $s[$payment->status] ?? 'gray' }}-700">{{ ucfirst($payment->status) }}</span>
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500">No payments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
      <h2 class="text-sm font-bold text-slate-900">My Documents</h2>
      <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">{{ $documents->count() }} files</span>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-100">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Title</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Type</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 bg-white">
          @forelse($documents ?? [] as $i => $doc)
            <tr>
              <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600">{{ $i + 1 }}</td>
              <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800">{{ $doc->title }}</td>
              <td class="whitespace-nowrap px-5 py-3 text-sm">
                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">{{ ucfirst($doc->type) }}</span>
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500">No documents uploaded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

<div class="mt-8"></div>

@endsection
