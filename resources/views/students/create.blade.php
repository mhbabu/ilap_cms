@extends('layouts.app')

@section('title', 'Students')
@section('page-title', 'Create Student')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Register New Student</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Full Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Phone *</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus *</label>
            <select name="campus_id" required class="ilap-select">
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Handler</label>
            <select name="handler_id" class="ilap-select">
                <option value="">Select Handler</option>
                @foreach($handlers as $handler)
                    <option value="{{ $handler->id }}" {{ old('handler_id') == $handler->id ? 'selected' : '' }}>
                        {{ $handler->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">IELTS Score</label>
            <input type="number" step="0.1" min="0" max="9.9" name="ielts_score" value="{{ old('ielts_score') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Passport Number</label>
            <input type="text" name="passport_number" value="{{ old('passport_number') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Photo</label>
            <input type="file" name="photo" accept="image/*" class="ilap-input">
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Save Student
            </button>
            <a href="{{ route('students.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection