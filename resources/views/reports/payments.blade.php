@extends('layouts.app')

@section('title', 'Reports - Payments')
@section('page-title', 'Payment Report')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Payment Report</h1>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payer</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Initiated By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->payer?->name ?? '—' }}</td>
                    <td>£{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->type) }}</td>
                    <td><span class="ilap-badge ilap-badge--{{ $payment->status === 'completed' ? 'green' : ($payment->status === 'pending' ? 'yellow' : 'gray') }}">
                        {{ ucfirst($payment->status) }}
                    </span></td>
                    <td>{{ $payment->campus?->name ?? '—' }}</td>
                    <td>{{ $payment->initiator?->name ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="ilap-text-center ilap-py-8 text-slate-400">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $payments->links() }}
</div>
@endsection