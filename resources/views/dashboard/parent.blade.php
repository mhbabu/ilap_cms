@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Parent Dashboard')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Parent Portal</h1>
</div>

<div class="ilap-card">
    <div class="ilap-p-6 ilap-text-center">
        <h3 class="ilap-font-bold text-slate-800">Welcome, Parent!</h3>
        <p class="ilap-text-sm text-slate-500 ilap-mt-2">Monitor your child's enrollment and progress.</p>
    </div>
</div>
@endsection