@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Create User')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Create New User</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('users.store') }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Phone</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Role *</label>
            <select name="role" required class="ilap-select">
                @foreach($roles as $id => $name)
                    <option value="{{ $name }}" {{ old('role') == $name ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                <option value="">None</option>
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Password *</label>
            <input type="password" name="password" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Confirm Password *</label>
            <input type="password" name="password_confirmation" required class="ilap-input">
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Create User
            </button>
            <a href="{{ route('users.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection