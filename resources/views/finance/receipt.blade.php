@extends('layouts.app')

@section('title', 'Receipt #' . $payment->id)
@section('page-title', 'Payment Receipt')

@section('content')
<div class="ilap-card">
    <div class="ilap-p-6">
        <div class="ilap-flex items-center justify-between ilap-mb-4">
            <h2 class="ilap-text-xl ilap-font-extrabold" style="color:var(--ilap-primary)">Receipt</h2>
            <span class="ilap-badge ilap-badge--{{ $payment->status === 'completed' ? 'green' : 'yellow' }}">
                {{ ucfirst($payment->status) }}
            </span>
        </div>
        
        <div class="ilap-grid-2 gap-4">
            <div>
                <p class="ilap-text-xs text-slate-500">Payer</p>
                <p class="ilap-font-semibold">{{ $payment->payer?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Amount</p>
                <p class="ilap-font-extrabold" style="color:var(--ilap-primary)">£{{ number_format($payment->amount, 2) }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Type</p>
                <p>{{ ucfirst($payment->type) }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Campus</p>
                <p>{{ $payment->campus?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Transaction Ref</p>
                <p>{{ $payment->transaction_ref ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Date</p>
                <p>{{ $payment->created_at?->format('M d, Y') ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection