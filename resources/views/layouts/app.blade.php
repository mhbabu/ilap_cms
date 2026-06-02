<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $appName ?? 'iLAP CMS')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    @yield('head')
</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased">

    @includeWhen(request()->is('login', 'password/*'), 'layouts.partials.login-body')

    @unless (request()->is('login', 'password/*'))
    <div class="flex h-screen w-screen overflow-hidden">

        <aside id="ilap-sidebar" class="h-screen w-64 flex-shrink-0 flex flex-col border-r border-slate-200 bg-white transition-all duration-300 ease-in-out z-50 fixed left-0 top-0">
            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white font-bold">i</div>
                <span class="truncate text-sm font-bold text-slate-800">{{ $orgName ?? 'iLAP CMS' }}</span>
            </div>
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->is('dashboard') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('students.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('students.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-user-graduate w-5 text-center"></i> Students
                </a>
                <a href="{{ route('leads.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('leads.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-user-plus w-5 text-center"></i> Leads
                </a>
                <a href="{{ route('finance.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('finance.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Finance
                </a>
                <a href="{{ route('documents.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('documents.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-file-lines w-5 text-center"></i> Documents
                </a>
                <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('tickets.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-ticket w-5 text-center"></i> Tickets
                </a>
                <a href="{{ route('messages.inbox') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('messages.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-envelope w-5 text-center"></i> Messages
                </a>
                @can('viewAny', \App\Models\Campus::class)
                <a href="{{ route('campuses.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('campuses.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-building w-5 text-center"></i> Campuses
                </a>
                @endcan
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('reports.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Reports
                </a>
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 {{ request()->routeIs('settings.*') ? 'bg-primary/10 text-primary' : '' }}">
                    <i class="fa-solid fa-gear w-5 text-center"></i> Settings
                </a>
            </nav>
            <div class="border-t border-slate-100 px-3 py-4 space-y-1">
                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50">
                    <i class="fa-regular fa-user w-5 text-center"></i> My Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            <header class="flex items-center h-14 px-4 gap-4 flex-shrink-0 z-40 bg-white border-b border-slate-200">
                <button id="ilap-toggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-slate-600"></i>
                </button>
                <h1 class="text-sm font-semibold text-slate-700">@yield('page-title', \Illuminate\Support\Str::title(str_replace(['_','-'],' ',request()->route()?->getName() ?? '')))</h1>
                <div class="flex-1"></div>
                <div class="relative">
                    <button class="p-2 rounded-xl hover:bg-slate-100 relative">
                        <i class="fa-regular fa-bell text-slate-600"></i>
                        <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()?->name ?? '?',0,1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check"></i>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                        <p class="text-sm font-semibold">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @endunless

    @stack('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
