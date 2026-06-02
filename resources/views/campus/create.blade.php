@extends('layouts.app')

@section('title', 'Campuses')
@section('page-title', 'Create Campus')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Create New Campus</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('campuses.store') }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Campus Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Phone</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Address</label>
            <textarea name="address" rows="2" class="ilap-input">{{ old('address') }}</textarea>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Primary Color</label>
            <input type="color" name="color_primary" value="{{ old('color_primary', '#1e40af') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Secondary Color</label>
            <input type="color" name="color_secondary" value="{{ old('color_secondary', '#3b82f6') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Manager</label>
            <select name="manager_user_id" class="ilap-select">
                <option value="">Select Manager</option>
                @foreach($hqAdmins as $admin)
                    <option value="{{ $admin->id }}" {{ old('manager_user_id') == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Create Campus
            </button>
            <a href="{{ route('campuses.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection