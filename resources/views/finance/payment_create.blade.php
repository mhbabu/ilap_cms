{{-- resources/views/finance/payment_create.blade.php --}}
@extends('layouts.app')

@section('title','Record Payment')
@section('page-title','Record New Payment')
@section('content')

<div class="ilap-card ilap-mb-6">
    <div class="ilap-card-header">
        <h3 class="ilap-m-0">Record Payment</h3>
    </div>

    <form method="POST" action="{{ route('finance.payments.store') }}" class="ilap-p-5 grid md:grid-cols-2 gap-6">

        @csrf

        {{ hidden }}
        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Student / Payer</label>
            <select name="payer_id" class="ilap-select w-full" required>
                @foreach($payers as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->unique_id ?? '—' }})</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Amount (£)</label>
            <input type="number" step="0.01" name="amount" class="ilap-input" required>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Type</label>
            <select name="type" class="ilap-select" required>
                <option value="one_time">One-time</option>
                <option value="installation">Installment</option>
                <option value="partial">Partial</option>
                <option value="tution">Tuition</option>
                <option value="misc">Miscellaneous</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Payment Method</label>
            <select name="payment_method" class="ilap-select">
                <option value="bank_transfer">Bank Transfer</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="online">Online</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Split into Installments (optional)</label>
            <select name="installment_split[]" multiple class="ilap-select">
                <option value="2">2 installments</option>
                <option value="3">3 installments</option>
                <option value="4">4 installments</option>
                <option value="6">6 installments</option>
            </select>
            <p class="ilap-text-xs text-slate-500 mt-1">Hold Ctrl / Cmd to select multiple</p>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Notes</label>
            <textarea name="notes" class="ilap-input" rows="3" placeholder="Optional notes…"></textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2 ilap-flex gap-3">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-rounded-lg">
                Record Payment
            </button>
            <a href="{{ route('finance.index') }}" class="ilap-btn ilap-btn-secondary">Cancel</a>
        </div>

    </form>
</div>
@endsection
