<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login • '.config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body class="font-inter bg-slate-50">

    <div class="ilap-min-h-screen flex ilap-login-page">

        {{-- Brand Column (desktop) --}}
        <div class="ilap-login-left hidden md:flex"
             style="background:linear-gradient(135deg,var(--ilap-primary-dark),var(--ilap-primary),var(--ilap-secondary))">
            <div class="max-w-lg mx-auto">
                <div class="mb-10">
                    <span class="ilap-text-3xl ilap-font-extrabold" style="opacity:.9">{{ config('app.name') }}</span>
                </div>
                <h1 class="ilap-text-2xl ilap-font-extrabold leading-tight mb-6">
                    International Language &amp;<br>Academic Platform
                </h1>
                <p class="text-white/80 text-lg leading-relaxed">
                    The all-in-one campus &amp; franchise management system for educational institutions — student management, finance, documents, tickets and reports in a single unified platform.
                </p>

                <div class="mt-12 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">🎓</div>
                        <span class="text-white/90 font-medium">Campus &amp; Franchise Management</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">💰</div>
                        <span class="text-white/90 font-medium">Finance &amp; Payment Tracking</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">📄</div>
                        <span class="text-white/90 font-medium">Document &amp; Certificate Management</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">📊</div>
                        <span class="text-white/90 font-medium">Real-time Reports &amp; Analytics</span>
                    </div>
                </div>

                <div class="mt-16 text-sm text-white/50">
                    &copy; {{ date('Y') }} iLAP CMS. All rights reserved.
                </div>
            </div>
        </div>

        {{-- Login Form Column --}}
        <div class="ilap-login-right flex-1">
            <div class="w-full max-w-[400px]">
                {{-- Mobile Brand --}}
                <div class="md:hidden mb-8 text-center">
                    <span class="ilap-text-2xl ilap-font-extrabold" id="mobileBrand">iLAP CMS</span>
                    <p class="ilap-text-sm ilap-text-muted ilap-mt-1">Campus &amp; Franchise Management</p>
                </div>

                {{-- Login Card --}}
                <div class="ilap-login-card">
                    <h2 class="ilap-text-2xl ilap-font-extrabold text-slate-900 mb-1">Welcome back</h2>
                    <p class="ilap-login-card .sub ilap-text-xs text-slate-500 mb-8">Sign in to your iLAP account</p>

                    {{-- Error Alert --}}
                    @if($errors->any())
                        <div class="ilap-alert ilap-alert--error mb-5 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div class="ilap-form-group">
                            <label class="ilap-label ilap-label-required">Email</label>
                            <div class="ilap-input flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zM3 8a9 9 0 0119 0v.01M3 8a9 9 0 0119 0v.01M3 8"/>
                                </svg>
                                <input type="email" name="email" id="email" required autofocus autocomplete="email"
                                       placeholder="you@example.com" class="flex-1 bg-transparent outline-none border-none pl-0"
                                       value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="ilap-form-group">
                            <label class="ilap-label ilap-label-required">Password</label>
                            <div class="ilap-input flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <input type="password" name="password" id="password" required autocomplete="current-password"
                                       placeholder="••••••••" class="flex-1 bg-transparent outline-none border-none pl-0">
                                <button type="button" onclick="togglePwd(this)" class="text-slate-400 hover:text-slate-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="ilap-flex items-center justify-between">
                            <label class="ilap-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                                <input type="checkbox" name="remember" class="ilap-check">
                                <span>Remember me</span>
                            </label>
                            <a href="#" class="ilap-text-sm font-semibold hover:underline" style="color:var(--ilap-primary)">
                                Forgot password?
                            </a>
                        </div>

                        <button type="submit" class="ilap-btn-submit">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6 text-center ilap-divider">
                        <span class="text-slate-400 text-xs">or continue with</span>
                    </div>

                    <div class="mt-6">
                        <a href="#" class="ilap-btn ilap-btn-secondary ilap-w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            Continue with SSO
                        </a>
                    </div>

                    <div class="mt-8 text-center border-t border-slate-100 pt-5">
                        <p class="ilap-text-xs text-slate-500">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePwd(btn) {
            const input = btn.parentElement.querySelector('input[type="password"],input[type="text"]');
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            btn.querySelector('svg').innerHTML = isPwd
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    </script>
</body>
</html>
