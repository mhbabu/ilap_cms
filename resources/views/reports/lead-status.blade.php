@extends('layouts.app')

@section('title', 'Lead Status Report')
@section('page-title', 'Lead Status Report')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Lead Status Report</h1>
</div>

<div class="ilap-grid-2 gap-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">By Status</h3>
        </div>
        <div class="ilap-p-4">
            @foreach($byStatus as $status => $count)
            <div class="ilap-flex justify-between ilap-mb-2">
                <span>{{ ucfirst($status) }}</span>
                <span class="ilap-badge ilap-badge--blue">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">By Source</h3>
        </div>
        <div class="ilap-p-4">
            @foreach($bySource as $source => $count)
            <div class="ilap-flex justify-between ilap-mb-2">
                <span>{{ ucfirst($source) }}</span>
                <span class="ilap-badge ilap-badge--green">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection