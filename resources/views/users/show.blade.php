@extends('layouts.app')

@section('title', $user->name)
@section('page-title', $user->name .' — Profile')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">{{ $user->name }}</h1>
        <p class="ilap-text-sm text-slate-500">User ID: {{ $user->unique_id }}</p>
    </div>
    <a href="{{ route('users.edit', $user) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Edit</a>
</div>

<div class="ilap-grid-2 gap-6">
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">User Information</h3>
        </div>
        <div class="ilap-p-4 space-y-3">
            <div>
                <p class="ilap-text-xs text-slate-500">Email</p>
                <p class="ilap-font-semibold">{{ $user->email ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Phone</p>
                <p class="ilap-font-semibold">{{ $user->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Role</p>
                <span class="ilap-badge ilap-badge--blue">{{ ucfirst($user->role) }}</span>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Campus</p>
                <p class="ilap-font-semibold">{{ $user->campus?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="ilap-text-xs text-slate-500">Status</p>
                <span class="ilap-badge {{ $user->is_active ? 'ilap-badge--green' : 'ilap-badge--gray' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>

    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Quick Actions</h3>
        </div>
        <div class="ilap-p-4 ilap-flex ilap-flex-col ilap-gap-2">
            <form action="{{ route('users.toggle-status', $user) }}" method="POST">
                @csrf
                <button type="submit" class="ilap-btn ilap-btn-sm ilap-btn-secondary">
                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                </button>
            </form>
            <form action="{{ route('users.reset-password', $user) }}" method="POST" class="ilap-mt-2">
                @csrf
                <input type="password" name="password" placeholder="New password" required class="ilap-input ilap-mb-2">
                <input type="password" name="password_confirmation" placeholder="Confirm password" required class="ilap-input ilap-mb-2">
                <button type="submit" class="ilap-btn ilap-btn-sm ilap-btn-secondary">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection