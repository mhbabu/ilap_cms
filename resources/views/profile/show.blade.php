@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', auth()->user()->name .' — Profile')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">My Profile</h1>
</div>

<div class="ilap-grid-2 gap-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Account Information</h3>
        </div>
        <div class="ilap-p-4 space-y-3">
            <div>
                <p class="ilap-text-xs text-slate-500 uppercase">Name</p>
                <p class="ilap-font-semibold">{{ $user->name }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500 uppercase">Email</p>
                <p class="ilap-font-semibold">{{ $user->email }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500 uppercase">Phone</p>
                <p class="ilap-font-semibold">{{ $user->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500 uppercase">Role</p>
                <span class="ilap-badge ilap-badge--blue">{{ ucfirst($user->role) }}</span>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500 uppercase">Campus</p>
                <p class="ilap-font-semibold">{{ $user->campus?->name ?? '—' }}</p>
            </div>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Statistics</h3>
        </div>
        <div class="ilap-p-4 space-y-3">
            <div class="ilap-flex items-between">
                <span class="ilap-text-sm">Enrollments</span>
                <span class="ilap-font-bold">{{ $user->enrollments_count ?? $user->enrollments()->count() }}</span>
            </div>
            <div class="ilap-flex items-between">
                <span class="ilap-text-sm">Payments</span>
                <span class="ilap-font-bold">{{ $user->payments_count ?? $user->payments()->count() }}</span>
            </div>
            <div class="ilap-flex items-between">
                <span class="ilap-text-sm">Tickets</span>
                <span class="ilap-font-bold">{{ $user->tickets_count ?? $user->tickets()->count() }}</span>
            </div>
            <div class="ilap-flex items-between">
                <span class="ilap-text-sm">Documents</span>
                <span class="ilap-font-bold">{{ $user->documents_count ?? $user->documents()->count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection