{{-- resources/views/leads/show.blade.php --}}
@extends('layouts.app')

@section('title', $lead->name)
@section('page-title', $lead->name .' — Lead Detail')

@section('content')

<div class="ilap-card ilap-p-6">
    <div class="ilap-flex items-start justify-between ilap-mb-6">
        <div>
            <h1 class="ilap-text-2xl ilap-font-extrabold text-slate-800">{{ $lead->name }}</h1>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1">Lead #{{ $lead->id }}
                @if($lead->is_flag) &middot; <span class="ilap-pill" style="background:#fee2e2;color:#991b1b">Flagged</span> @endif
            </p>
        </div>
        <a href="{{ route('leads.index') }}" class="ilap-btn ilap-btn-secondary">← Back</a>
    </div>

    <div class="ilap-grid-3 ilap-mb-6">
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Phone</p>
                <p class="ilap-text-lg ilap-font-bold" style="color:var(--ilap-primary)">{{ $lead->phone ?? '—' }}</p>
            </div>
        </div>
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Email</p>
                <p class="ilap-text-lg ilap-font-bold text-slate-800">{{ $lead->email ?? '—' }}</p>
            </div>
        </div>
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Status</p>
                <span class="ilap-badge ilap-badge--{{ $lead->status === 'converted' ? 'green' : 'blue' }} ilap-text-lg">
                    {{ ucfirst($lead->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="ilap-card ilap-mb-6 ilap-p-5">
        <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-2 ilap-font-bold">Source</p>
        <span class="ilap-badge ilap-badge--blue">{{ $lead->source }}</span>
        @if($lead->notes)<p class="ilap-mt-3 ilap-text-sm text-slate-600">{{ $lead->notes }}</p>@endif
    </div>

    <div class="ilap-flex gap-3">
        @if($lead->status !== 'converted')
        <form action="{{ route('leads.convert',$lead) }}" method="POST">
            @csrf
            <button type="submit" class="ilap-btn ilap-btn-success"
                    onclick="return confirm('Convert this lead to a student?')">
                Convert → Student
            </button>
        </form>
        @endif

        <a href="{{ route('students.create') }}" class="ilap-btn ilap-btn-secondary">Still No Update?</a>

        <form action="{{ route('leads.destroy',$lead) }}" method="POST" class="inline"
              onsubmit="return confirm('Delete this lead?')">
            @csrf @method('DELETE')
            <button type="submit" class="ilap-btn ilap-btn-danger">Delete Lead</button>
        </form>
    </div>
</div>
@endsection
