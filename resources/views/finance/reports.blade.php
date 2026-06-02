@extends('layouts.app')

@section('title', 'Finance Reports')
@section('page-title', 'Finance Reports')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Finance Reports</h1>
</div>

<div class="ilap-card">
    <div class="ilap-p-6">
        <p>Finance reports and analytics will be displayed here.</p>
        <a href="{{ route('finance.index') }}" class="ilap-btn ilap-btn-secondary ilap-mt-4">Back to Finance</a>
    </div>
</div>
@endsection