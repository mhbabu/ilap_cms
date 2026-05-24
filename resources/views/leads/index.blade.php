{{-- resources/views/leads/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Leads')
@section('page-title', 'Lead Management')
@section('content')

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Leads</h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">
            Total: <strong>{{ number_format($campusTotal ?? ($leads->total() ?? 0)) }}</strong>
            leads currently above 70% conversion
        </p>
    </div>
    <a href="{{ route('leads.create') }}" class="ilap-btn ilap-btn-primary ilap-px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-md"
       style="background:var(--ilap-primary)">+ New Lead</a>
</div>

{{-- Stats --}}
<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <p class="ilap-metric__label">Total Leads</p>
        <p class="ilap-metric__value">{{ number_format($campusTotal ?? ($leads->total() ?? 0)) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Converted</p>
        <p class="ilap-metric__value" style="color:#16a34a">{{ number_format($leads->where('status','converted')->count()) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Pending</p>
        <p class="ilap-metric__value" style="color:#d97706">{{ number_format($leads->whereIn('status',['new','contacted'])->count()) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Flagged</p>
        <p class="ilap-metric__value" style="color:#dc2626">{{ number_format($leads->where('is_flag',true)->count()) }}</p>
    </div>
</div>

{{-- Lead Card Grid --}}
<div class="ilap-grid-3">
    @forelse($leads as $i => $lead)
    <div class="ilap-card hover:shadow-lg transition-shadow duration-200 {{ $lead->is_flag ? 'border-l-4 border-red-500' : '' }}">
        <div class="ilap-card-header ilap-flex items-center justify-between">
            <div class="ilap-flex items-center gap-2">
                @if($lead->is_flag)
                    <span class="ilap-pill" style="background:#fee2e2;color:#991b1b">⚠ Flagged</span>
                @endif
                <span class="ilap-badge ilap-badge--{{ $lead->status==='converted'?'green':($lead->status==='contacted'?'yellow':'gray') }}">
                    {{ ucfirst($lead->status) }}
                </span>
            </div>
        </div>
        <div class="ilap-p-4">
            <h3 class="ilap-font-bold text-slate-800">{{ $lead->name ?? 'Anonymous Lead' }}</h3>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1">{{ $lead->phone }}</p>
            @if($lead->email) <p class="ilap-text-xs text-slate-400">{{ $lead->email }}</p> @endif

            @if($lead->source)
            <p class="ilap-text-xs text-slate-400 ilap-mt-2">Source: {{ ucfirst($lead->source) }}</p>
            @endif

            <div class="ilap-flex items-center gap-2 ilap-mt-3">
                <a href="{{ route('leads.show',$lead) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">View</a>
                @if(!$lead->handler_id)
                    <a href="{{ route('leads.edit',$lead) }}" class="ilap-btn ilap-btn-sm" style="background:var(--ilap-primary-light);color:var(--ilap-primary)">Assign</a>
                @endif
                @if($lead->status !== 'converted')
                    <form action="{{ route('leads.convert',$lead) }}" method="POST">
                        @csrf
                        <button type="submit" class="ilap-btn ilap-btn-success ilap-btn-sm"
                                onclick="return confirm('Convert this lead to student?')">
                            Convert → Student
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="ilap-metric ilap-col-span-full ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No leads yet.</p>
        <p class="ilap-text-sm text-slate-500 ilap-mt-2">Create your first lead to get started.</p>
    </div>
    @endforelse
</div>

{{ $leads->links() }}
@endsection
