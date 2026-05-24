<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $appName ?? 'iLAP CMS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- ── CSS ──────────────────────────────────────────────── --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Favicon fallback --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/ilap-logo.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    @yield('head')
</head>
<body class="font-inter bg-slate-50 text-slate-900 antialiased">

    {{-- ══════════════════════════════════════════════════════ --}}
    {{--  LOGIN SCREEN                                          --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @includeWhen(request()->is('login', 'password/*'), 'layouts.partials.login-body')

    {{-- ══════════════════════════════════════════════════════ --}}
    {{--  APP SHELL (authenticated)                              --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @unless (request()->is('login', 'password/*'))
    <div id="app-app-shell" class="flex h-screen overflow-hidden">

        {{-- ── SIDEBAR ────────────────────────────────────────── --}}
        <aside id="ilap-sidebar"
               class="ilap-sidebar ilap-sidebar--closed w-[260px] flex-shrink-0 flex flex-col
                      border-r border-slate-200/70 bg-white/70 backdrop-blur-xl
                      transition-all duration-300 ease-in-out z-50">

            {{-- Sidebar Header --}}
            <div class="ilap-sidebar-header px-5 py-5 flex items-center gap-3 border-b border-slate-100">
                @php
                    $logoAttr = $campus?->logo_mark ?? null;
                    $logoHtml = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <rect width="32" height="32" rx="8" fill="'.$primaryColor.'"/>
                        <text x="16" y="22" text-anchor="middle" fill="white" font-size="16" font-weight="bold" font-family="Inter,Arial">i</text>
                    </svg>';
                @endphp
                <div class="flex items-center gap-2 flex-1 min-w-0">
                    {!! $logoHtml ?? $logoAttr ?? '<div class="w-8 h-8 rounded-lg bg-blue-700 flex items-center justify-center text-white font-bold">i</div>' !!}
                    <span class="ilap-brand font-bold text-sm text-slate-800 whitespace-nowrap truncate">
                        {{ $orgName ?? 'iLAP CMS' }}
                    </span>
                </div>
                <button id="ilap-sidebar-toggle" class="p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Toggle Sidebar">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <nav id="ilap-sidebar-nav" class="ilap-sidebar__nav flex-1 overflow-y-auto py-4 px-3 space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="ilap-nav-item {{ request()->is('dashboard') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Dashboard</span>
                </a>

                {{-- ── Students ─────────────────────────────────────── --}}
                <a href="{{ route('students.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('students.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Students</span>
                    @php $stuCount = \App\Models\Student::count(); @endphp
                    @if($stuCount > 0)
                    <span class="ilap-nav-badge ml-auto text-[11px] font-semibold px-2 py-0.5 rounded-full">{{ $stuCount }}</span>
                    @endif
                </a>

                {{-- ── Leads ────────────────────────────────────────── --}}
                <a href="{{ route('leads.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('leads.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Leads</span>
                </a>

                {{-- ── Finance ──────────────────────────────────────── --}}
                <a href="{{ route('finance.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('finance.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8V4m0 0L8 8m4-4l4 4"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Finance</span>
                </a>

                {{-- ── Documents ─────────────────────────────────────── --}}
                <a href="{{ route('documents.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('documents.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Documents</span>
                </a>

                {{-- ── Tickets ──────────────────────────────────────── --}}
                <a href="{{ route('tickets.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('tickets.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Tickets</span>
                </a>

                {{-- ── Messaging ─────────────────────────────────────────── --}}
                <a href="{{ route('messages.inbox') }}"
                   class="ilap-nav-item {{ request()->routeIs('messages.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14.
                            a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Messages</span>
                </a>

                {{-- ── Campuses ──────────────────────────────────────── --}}
                @can('viewAny', \App\Models\Campus::class)
                <a href="{{ route('campuses.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('campuses.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-2M5 21H3a1 1 0 01-1-1v-2"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Campuses</span>
                </a>
                @endcan

                {{-- ── Reports ────────────────────────────────────────── --}}
                <a href="{{ route('reports.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('reports.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Reports</span>
                </a>

                {{-- ── Settings ─────────────────────────────────────────── --}}
                <a href="{{ route('settings.index') }}"
                   class="ilap-nav-item {{ request()->routeIs('settings.*') ? 'ilap-nav-item--active' : '' }}
                          flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                    <span class="ilap-nav-icon w-5 h-5 flex-shrink-0">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 2.924 0a1.822 1.822 0 002.045 1.082c.946.37 1.124 1.27 1.124 2.15c0 .88-.178 1.78-.532 2.586m-6.39 5.13c.249-.252.485-.515.705-.792"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317a4.888 4.888 0 011.168.48c2.325.503 3.476 1.938 3.035 3.946"/>
                        </svg>
                    </span>
                    <span class="ilap-nav-label text-sm font-medium group-hover:translate-x-0.5 transition-transform">Settings</span>
                </a>

            </nav>

            {{-- Sidebar Footer / Logout --}}
            <div class="px-3 py-4 border-t border-slate-100 space-y-1">
                <a href="{{ route('profile.index') }}"
                   class="ilap-nav-item flex items-center gap-3 px-3 py-2 rounded-xl transition-all duration-200 group">
                    <x-heroicon-o-user-circle class="w-5 h-5 text-slate-500"/>
                    <span class="text-sm">My Profile</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit"
                            class="ilap-nav-item w-full flex items-center gap-3 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-all duration-200">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5"/>
                        <span class="text-sm font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── MAIN CONTENT SHELL ─────────────────────────────────── --}}
        <div class="ilap-main flex-1 flex flex-col overflow-hidden">

            {{-- Top Bar --}}
            <header id="ilap-topbar"
                    class="ilap-topbar flex items-center h-14 px-4 gap-4 flex-shrink-0 z-40
                           border-b border-slate-200/70 bg-white/70 backdrop-blur-xl transition-all duration-300">

                {{-- Sidebar toggle (mobile) --}}
                <button id="ilap-toggle" class="p-2 rounded-lg hover:bg-slate-100 transition-colors lg:hidden">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Breadcrumb / Page title --}}
                <h1 class="ilap-page-title text-sm font-semibold text-slate-700 truncate">
                    @yield('page-title', \Illuminate\Support\Str::title(str_replace(['_','-'],' ',request()->route()?->getName() ?? '')))
                </h1>

                <div class="flex-1"></div>

                {{-- Search --}}
                <div class="ilap-search hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 focus-within:border-blue-500 transition-colors w-48">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="ilap-global-search" placeholder="Search…"
                           class="bg-transparent text-sm outline-none w-full text-slate-700 placeholder-slate-400">
                </div>

                {{-- Notifications --}}
                <button class="ilap-icon-btn p-2 rounded-xl hover:bg-slate-100 transition-colors relative">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="ilap-notif-count" class="absolute top-1 right-1 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white">
                    </span>
                </button>

                {{-- Org Selector (HQ / Super Admin only) --}}
                @if(in_array(auth()->user()?->role, ['super_admin','hq_admin']))
                <div class="relative">
                    <button id="ilap-org-btn" class="ilap-nav-item flex items-center gap-2 px-3 py-1.5 rounded-xl text-sm font-medium hover:bg-slate-100">
                        <span class="w-2 h-2 rounded-full" style="background:{{ $primaryColor ?? '#1e40af' }}"></span>
                        <span>{{ $orgName ?? 'iLAP HQ' }}</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                @endif

                {{-- User Dropdown --}}
                <div class="relative" id="ilap-user-wrap">
                    <button id="ilap-user-btn" class="ilap-nav-item flex items-center gap-2 pl-2 pr-1 py-1.5 rounded-xl transition-all">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold"
                             style="background:{{ $primaryColor ?? '#1e40af' }}">
                            {{ strtoupper(substr(auth()->user()?->name ?? '?',0,1)) }}
                        </div>
                        <div class="hidden md:flex flex-col items-start leading-tight">
                            <span class="text-xs font-semibold text-slate-800">{{ auth()->user()?->name ?? '—' }}</span>
                            <span class="text-[10px] text-slate-400">{{ ucfirst(auth()->user()?->role ?? '') }}</span>
                        </div>
                    </button>
                </div>
            </header>

            {{-- Scrollable Content Area --}}
            <main id="ilap-main" class="ilap-main-content flex-1 overflow-y-auto px-4 py-6 md:px-6 md:py-8">

                {{-- Flash Messages --}}
                @if (session('success'))
                  <div class="ilap-alert ilap-alert--success mb-6 rounded-2xl px-4 py-3 flex items-center gap-3"
                       onclick="this.closest('.ilap-alert').remove()" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button class="ml-auto" onclick="this.closest('.ilap-alert').remove()">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                @endif

                @if (session('error'))
                  <div class="ilap-alert ilap-alert--error mb-6 rounded-2xl px-4 py-3 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button class="ml-auto" onclick="this.closest('.ilap-alert').remove()">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                @endif

                @if ($errors->any())
                  <div class="ilap-alert ilap-alert--error mb-6 rounded-2xl px-4 py-3 space-y-1">
                    <p class="text-sm font-semibold">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-sm space-y-0.5">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                @yield('content')
            </main>
        </div>

        {{-- Mobile Sidebar Overlay --}}
        <div id="ilap-overlay" class="ilap-overlay fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden"></div>
    </div>
    @endunless

    @stack('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
