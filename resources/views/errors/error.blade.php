{{-- Error Layout: 403, 404, 419, 500 --}}
@extends('layouts.app')
@section('title', $code ?? 'Error')
@section('content')
<div class="ilap-flex items-center justify-center ilap-h-full ilap-min-h-screen">
    <div class="ilap-card ilap-p-10 ilap-text-center" style="max-width:420px">
        <div class="ilap-text-6xl mb-4">{{ $icon ?? '⚠' }}</div>
        <h1 class="ilap-text-4xl ilap-font-extrabold text-slate-900">HTTP {{ $code ?? 500 }}</h1>
        <p class="ilap-text-lg text-slate-500 ilap-my-4">{{ $message ?? 'An error occurred.' }}</p>
        <a href="{{ route('dashboard') }}" class="ilap-btn ilap-btn-primary ilap-mx-auto">Back to Dashboard</a>
    </div>
</div>
@endsection
