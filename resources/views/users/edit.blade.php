@extends('layouts.app')

@section('title', $user->name)
@section('page-title', 'Edit ' .$user->name)

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Edit User</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('users.update', $user) }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        @method('PUT')
        
        <div class="ilap-form-group">
            <label class="ilap-label">Name *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Phone</label>
            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Role *</label>
            <select name="role" required class="ilap-select">
                @foreach($roles as $id => $name)
                    <option value="{{ $name }}" {{ (old('role', $user->role) == $name) ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                <option value="">None</option>
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ (old('campus_id', $user->campus_id) == $campus->id) ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Status</label>
            <select name="is_active" class="ilap-select">
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Update User
            </button>
            <a href="{{ route('users.show', $user) }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection