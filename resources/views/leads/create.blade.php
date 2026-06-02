@extends('layouts.app')

@section('title', 'Leads')
@section('page-title', 'Create Lead')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Create New Lead</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('leads.store') }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Name *</label>
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
            <label class="ilap-label">Source *</label>
            <select name="source" required class="ilap-select">
                <option value="website">Website</option>
                <option value="referral">Referral</option>
                <option value="social">Social Media</option>
                <option value="office">Office Visit</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Handler</label>
            <select name="handler_id" class="ilap-select">
                <option value="">Assign Handler</option>
                @foreach($handlers as $handler)
                    <option value="{{ $handler->id }}" {{ old('handler_id') == $handler->id ? 'selected' : '' }}>
                        {{ $handler->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Follow-up Date</label>
            <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" class="ilap-input">
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Notes</label>
            <textarea name="notes" rows="3" class="ilap-input">{{ old('notes') }}</textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Save Lead
            </button>
            <a href="{{ route('leads.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection