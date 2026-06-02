@extends('layouts.app')

@section('title', 'Leads')
@section('page-title', 'Edit Lead')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Edit Lead</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('leads.update', $lead) }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        @method('PUT')
        
        <div class="ilap-form-group">
            <label class="ilap-label">Name *</label>
            <input type="text" name="name" value="{{ old('name', $lead->name) }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Phone *</label>
            <input type="tel" name="phone" value="{{ old('phone', $lead->phone) }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $lead->email) }}" class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus *</label>
            <select name="campus_id" required class="ilap-select">
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ (old('campus_id', $lead->campus_id) == $campus->id) ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Source *</label>
            <select name="source" required class="ilap-select">
                @foreach(['website'=>'Website','referral'=>'Referral','social'=>'Social Media','office'=>'Office Visit','other'=>'Other'] as $val=>$label)
                    <option value="{{ $val }}" {{ (old('source', $lead->source) == $val) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Status *</label>
            <select name="status" required class="ilap-select">
                @foreach(['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','disqualified'=>'Disqualified','converted'=>'Converted'] as $val=>$label)
                    <option value="{{ $val }}" {{ (old('status', $lead->status) == $val) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Notes</label>
            <textarea name="notes" rows="3" class="ilap-input">{{ old('notes', $lead->notes) }}</textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Update Lead
            </button>
            <a href="{{ route('leads.show', $lead) }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection