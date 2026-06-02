@extends('layouts.app')

@section('title', $document->title)
@section('page-title', 'Edit ' .$document->title)

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Edit Document</h1>
</div>

<div class="ilap-card">
    <form action="{{ route('documents.update', $document) }}" method="POST" class="ilap-p-6 grid gap-4">
        @csrf
        @method('PUT')
        
        <div class="ilap-form-group">
            <label class="ilap-label">Title *</label>
            <input type="text" name="title" value="{{ old('title', $document->title) }}" required class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Description</label>
            <textarea name="description" rows="3" class="ilap-input">{{ old('description', $document->description) }}</textarea>
        </div>

        <div class="ilap-mt-4">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Update Document
            </button>
            <a href="{{ route('documents.index') }}" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
@endsection