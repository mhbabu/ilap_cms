{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('title','Forgot Password')
@section('content')
<div class="ilap-flex items-center justify-center ilap-min-h-screen bg-slate-100 -ilap-mx-6 -ilap-my-auto">
    <form method="POST" action="{{ route('login') }}" class="ilap-card ilap-p-8 ilap-w-full" style="max-width:440px">
        <div class="ilap-text-center ilap-mb-6">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:var(--ilap-primary-light)">🔑</div>
            <h2 class="ilap-text-2xl ilap-font-extrabold">Forgot Password</h2>
            <p class="ilap-text-xs text-slate-500 mt-2">Enter your email to receive a reset link.</p>
        </div>
        <div class="ilap-form-group">
            <label class="ilap-label">Email</label>
            <input type="email" name="email" class="ilap-input" required placeholder="you@example.com">
        </div>
        <button type="submit" class="ilap-btn-submit">Send Reset Link</button>
    </form>
</div>
@endsection
