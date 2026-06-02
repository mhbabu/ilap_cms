@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Users</h1>
    </div>
    <a href="{{ route('users.create') }}" class="ilap-btn ilap-btn-primary ilap-px-5 py-2.5 rounded-xl text-sm font-bold"
       style="background:var(--ilap-primary)">+ Add User</a>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Campus</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td class="ilap-text-muted">{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div class="ilap-flex items-center gap-2">
                            <div class="ilap-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
                            <span class="ilap-font-semibold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td><span class="ilap-badge ilap-badge--blue">{{ ucfirst($user->role) }}</span></td>
                    <td>{{ $user->campus?->name ?? '—' }}</td>
                    <td>
                        <span class="ilap-badge {{ $user->is_active ? 'ilap-badge--green' : 'ilap-badge--gray' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="ilap-flex gap-1">
                        <a href="{{ route('users.show', $user) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">View</a>
                        <a href="{{ route('users.edit', $user) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="ilap-text-center ilap-py-12 text-slate-400">
                        <p>No users found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection