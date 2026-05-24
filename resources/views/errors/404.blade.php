{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')
@section('title','404 — Page Not Found')
@section('content')
<div class="ilap-flex items-center justify-center ilap-min-h-screen">
    <div class="ilap-card ilap-p-10 ilap-text-center" style="max-width:440px">
        <span class="ilap-text-6xl">🔍</span>
        <h1 class="ilap-text-3xl ilap-font-extrabold text-slate-800 mt-4">404 — Page Not Found</h1>
        <p class="ilap-text-slate-500 ilap-mt-2">The page you are looking for doesn't exist or has been moved.</p>
        <a href="{{ route('dashboard') }}" class="ilap-btn ilap-btn-primary ilap-mx-auto ilap-mt-4">Back to Dashboard</a>
    </div>
</div>
@endsection
