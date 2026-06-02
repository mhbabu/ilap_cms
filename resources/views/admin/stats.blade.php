@extends('layouts.app')

@section('title', 'Admin Stats')
@section('page-title', 'System Statistics')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">System Statistics</h1>
    <p class="ilap-text-sm text-slate-500">Overview of platform metrics and activity.</p>
</div>

<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <p class="ilap-metric__label">Total Users</p>
        <p class="ilap-metric__value">{{ number_format($stats['total_users'] ?? 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Active Users</p>
        <p class="ilap-metric__value">{{ number_format($stats['active_users'] ?? 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Campuses</p>
        <p class="ilap-metric__value">{{ number_format($stats['active_campuses'] ?? 0) }} / {{ number_format($stats['total_campuses'] ?? 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Students</p>
        <p class="ilap-metric__value">{{ number_format($stats['total_students'] ?? 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Leads</p>
        <p class="ilap-metric__value">{{ number_format($stats['total_leads'] ?? 0) }}</p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Open Tickets</p>
        <p class="ilap-metric__value">{{ number_format($stats['open_tickets'] ?? 0) }}</p>
    </div>
</div>

<div class="ilap-card">
    <div class="ilap-card-header">
        <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Quick Actions</h3>
    </div>
    <div class="ilap-p-4 ilap-flex gap-3">
        <form method="POST" action="{{ route('admin.clear-cache') }}">
            @csrf
            <button type="submit" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Clear Cache</button>
        </form>
        <form method="POST" action="{{ route('admin.backup') }}">
            @csrf
            <button type="submit" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Database Backup</button>
        </form>
        <a href="{{ route('admin.audit-logs') }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">View Audit Logs</a>
    </div>
</div>
@endsection