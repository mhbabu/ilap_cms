@extends('layouts.app')

@section('title', 'Tickets')
@section('page-title', 'Create Ticket')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Create Support Ticket</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('tickets.store') }}" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Title *</label>
            <input type="text" name="title" required class="ilap-input" placeholder="Brief summary">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Priority *</label>
            <select name="priority" required class="ilap-select">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Type *</label>
            <select name="type" required class="ilap-select">
                <option value="technical">Technical</option>
                <option value="financial">Financial</option>
                <option value="administrative">Administrative</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Description *</label>
            <textarea name="description" rows="4" required class="ilap-input" placeholder="Detailed description..."></textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Create Ticket
            </button>
            <a href="{{ route('tickets.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection