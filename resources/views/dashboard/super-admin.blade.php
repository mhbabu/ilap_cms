{{-- resources/views/dashboard/super-admin.blade.php --}}
@extends('layouts.app')

@section('title','Super Admin Dashboard')
@section('page-title','Super Admin')

@section('content')
@php
    $m = $metrics ?? [];
@endphp
<div class="ilap-metrics ilap-mb-6">
    @foreach([
        'Students'=>['icon'=>'🎓','value'=>$m['students'] ?? 0],
        'Campuses'=>['icon'=>'🏫','value'=>$m['campuses'] ?? 0],
        'Payments'=>['icon'=>'💰','value'=>$m['payments'] ?? 0],
        'Revenue' =>['icon'=>'💷','value'=>number_format($m['revenue'] ?? 0)],
        'New Leads'=>['icon'=>'📋','value'=>$m['leads'] ?? 0],
        'Open Tkt'=>['icon'=>'🎫','value'=>$m['tickets'] ?? 0],
        'Users'   =>['icon'=>'👥','value'=>$m['users'] ?? 0],
    ] as $label=>$stat)
    <div class="ilap-metric">
        <div class="ilap-flex items-center justify-between">
            <span class="ilap-metric__label">{{ $label }}</span>
            <span class="ilap-text-2xl">{{ $stat['icon'] }}</span>
        </div>
        <p class="ilap-metric__value">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="ilap-card ilap-p-5">
    <h3 class="ilap-font-bold ilap-mb-4">Quick Links</h3>
    <div class="ilap-flex ilap-flex-wrap gap-2">
        <a href="{{ route('campuses.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">🏫 Campuses</a>
        <a href="{{ route('students.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">🎓 Students</a>
        <a href="{{ route('finance.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">💰 Finance</a>
        <a href="{{ route('tickets.index') }}"  class="ilap-btn ilap-btn-secondary ilap-btn-sm">🎫 Tickets</a>
        <a href="{{ route('leads.index') }}"    class="ilap-btn ilap-btn-secondary ilap-btn-sm">📋 Leads</a>
        <a href="{{ route('reports.index') }}"  class="ilap-btn ilap-btn-secondary ilap-btn-sm">📊 Reports</a>
        <a href="{{ route('settings.index') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">⚙️ Settings</a>
        <a href="{{ route('users.index') }}"    class="ilap-btn ilap-btn-secondary ilap-btn-sm">👥 Users</a>
    </div>
</div>
@endsection
