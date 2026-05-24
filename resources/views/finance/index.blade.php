{{-- resources/views/finance/index.blade.php --}}
@extends('layouts.app')

@section('title','Finance')
@section('page-title','Finance &amp; Payments')
@section('content')

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Finance</h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">Payment tracking, receipting &amp; instalment management</p>
    </div>
    <a href="{{ route('finance.payments.create') }}"
       class="ilap-px-5 py-2.5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Record Payment</a>
</div>

{{-- Revenue Summary --}}
<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <p class="ilap-metric__label">Completed Revenue</p>
        <p class="ilap-metric__value">£{{ number_format($totalRevenue ?? 0, 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Pending Payment</p>
        <p class="ilap-metric__value" style="color:#d97706">£{{ number_format($pendingAmt ?? 0, 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Total Transactions</p>
        <p class="ilap-metric__value">{{ number_format($payments?->total() ?? ($payments->count() ?? 0)) }}</p>
    </div>
</div>

{{-- Payment Table --}}
<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Payer</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
            @forelse($payments as $i => $payment)
            <tr>
                <td class="ilap-text-xs text-slate-500">{{ $payment->id }}</td>
                <td>
                    <div class="ilap-flex items-center gap-2">
                        <div class="ilap-avatar" style="background:{{ $payment->campus?->color_primary ?? 'var(--ilap-primary)' }}">
                            {{ strtoupper(substr($payment->payer?->name ?? $payment->payer?->unique_id ?? 'P',0,1)) }}
                        </div>
                        <span class="ilap-text-sm ilap-font-semibold text-slate-700">
                            {{ $payment->payer?->name ?? ($payment->payer?->unique_id ?? '—') }}
                        </span>
                    </div>
                </td>
                <td class="ilap-font-bold" style="color:var(--ilap-primary)">£{{ number_format($payment->amount, 2) }}</td>
                <td><span class="ilap-badge ilap-badge--blue">{{ ucfirst($payment->type) }}</span></td>
                <td>
                    @php
                        $sColor = match($payment->status) {
                            'completed' => 'green',
                            'pending'   => 'yellow',
                            'approved'  => 'blue',
                            'rejected'  => 'red',
                            default     => 'gray',
                        };
                    @endphp
                    <span class="ilap-badge ilap-badge--{{ $sColor }}">{{ ucfirst($payment->status) }}</span>
                </td>
                <td class="ilap-text-sm text-slate-500">{{ $payment->campus?->name ?? '—' }}</td>
                <td class="ilap-flex gap-1">
                    @if($payment->status === 'completed')
                        <a href="{{ route('receipt', $payment) }}"
                           class="ilap-text-sm text-blue-600 font-bold hover:underline">Receipt</a>
                    @endif
                    @if($payment->status === 'pending')
                        <form action="{{ route('finance.approve', $payment) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="ilap-text-xs text-green-600 font-bold hover:underline">
                                Approve
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="ilap-text-center ilap-py-12">
                    <p class="ilap-text-slate-400">No payment records found.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart placeholder --}}
<div class="ilap-card ilap-mt-6 ilap-p-5">
    <div class="ilap-flex items-center justify-between ilap-mb-4">
        <h3 class="ilap-font-bold text-slate-800" style="background:var(--ilap-primary);color:white;padding:.25rem .625rem;border-radius:.25rem;font-size:.75rem;font-weight:700">Revenue by Campus</h3>
    </div>
    <div class="ilap-flex items-end gap-3 h-40" id="revenueChart">
        {{-- Rendered now — static bars --}}
        @foreach(($campuses ?? \App\Models\Campus::active()->get()) as $campus)
            @php $amt = $campus->payments()->completed()->sum('amount'); @endphp
            <div class="ilap-flex flex-col items-center ilap-gap-2 ilap-grow">
                <div class="ilap-font-bold ilap-text-xs" style="color:var(--ilap-primary)">£{{ number_format($amt,0) }}</div>
                <div class="ilap-w-full rounded-t-xl transition-all"
                     style="height:{{ min(max($amt/10000,4),90) }}%; background:{{ $campus->color_primary ?? 'var(--ilap-primary)' }}"></div>
                <span class="ilap-text-2xs text-slate-400">{{ Str::limit($campus->name, 10) }}</span>
            </div>
        @endforeach
    </div>
</div>

@endsection
