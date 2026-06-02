@extends('layouts.app')

@section('title','Edit Enrollment')
@section('page-title','Edit Enrollment')

@section('content')
<div class="mb-6">
    <a href="{{ route('enrollments.show',$enrollment) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Enrollment
    </a>
</div>

<form method="POST" action="{{ route('enrollments.update',$enrollment) }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <div class="space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Student</label>
                <select name="student_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ old('student_id', $enrollment->student_id) == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->email ?? '—' }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Class</label>
                <select name="class_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ old('class_id', $enrollment->class_id) == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->module->name ?? '—' }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Campus</label>
                <select name="campus_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($campuses as $c)
                        <option value="{{ $c->id }}" {{ old('campus_id', $enrollment->campus_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach(['registered'=>'Registered','enrolled'=>'Enrolled','documents_verified'=>'Documents Verified','completed'=>'Completed'] as $k=>$v)
                        <option value="{{ $k }}" {{ old('status', $enrollment->status) == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Payment Amount</label>
                <input type="number" step="0.01" name="payment_amount" value="{{ old('payment_amount', $enrollment->payment_amount) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Payment Method</label>
                <select name="payment_method" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach(['cash'=>'Cash','card'=>'Card','bkash'=>'bKash','nagad'=>'Nagad','online'=>'Online'] as $k=>$v)
                        <option value="{{ $k }}" {{ old('payment_method', $enrollment->payment_method) == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Payment Status</label>
                <select name="payment_status" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach(['pending'=>'Pending','completed'=>'Completed','failed'=>'Failed','refunded'=>'Refunded'] as $k=>$v)
                        <option value="{{ $k }}" {{ old('payment_status', $enrollment->payment_status) == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Transaction Ref</label>
                <input type="text" name="transaction_ref" value="{{ old('transaction_ref', $enrollment->transaction_ref) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
        </div>
        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Enrollment Date</label>
            <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date) }}" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
        </div>
        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Notes</label>
            <textarea name="notes" rows="2" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('notes', $enrollment->notes) }}</textarea>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Update Enrollment</button>
            <a href="{{ route('enrollments.show',$enrollment) }}" class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
        </div>
    </div>
</form>
@endsection
