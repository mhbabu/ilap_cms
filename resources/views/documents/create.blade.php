@extends('layouts.app')

@section('title', 'Documents')
@section('page-title', 'Upload Document')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Upload Document</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        @csrf
        
        <div class="ilap-form-group">
            <label class="ilap-label">Title *</label>
            <input type="text" name="title" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Type *</label>
            <select name="collection" required class="ilap-select">
                <option value="passport">Passport</option>
                <option value="visa">Visa</option>
                <option value="finance">Finance</option>
                <option value="result">Result</option>
                <option value="id">ID</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">File *</label>
            <input type="file" name="file" required class="ilap-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus *</label>
            <select name="campus_id" required class="ilap-select">
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Student (optional)</label>
            <select name="student_id" class="ilap-select">
                <option value="">Select Student</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Description</label>
            <textarea name="description" rows="2" class="ilap-input"></textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Upload Document
            </button>
            <a href="{{ route('documents.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection