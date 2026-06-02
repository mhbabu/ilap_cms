@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="flex flex-col gap-6">
  <div class="ilap-page-header">
    <div>
      <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Settings</h1>
      <p class="ilap-text-sm text-slate-500">Manage general, iLAP, templates, docs and audit settings</p>
    </div>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50">
      <nav class="flex gap-1 px-2 pt-2 overflow-x-auto">
        @foreach(['settings.index'=>'General','settings.ilap-config'=>'iLAP Config','settings.email-templates'=>'Email Templates','settings.system-documents'=>'System Docs','settings.activity-logs'=>'Audit Log'] as $route=>$label)
          <a href="{{ route($route) }}"
             class="px-4 py-2.5 text-sm font-semibold whitespace-nowrap rounded-t-md transition-colors
                    {{ request()->routeIs($route) ? 'bg-white text-slate-900 border-b-2 border-slate-900 -mb-px' : 'text-slate-600 hover:text-slate-800' }}">
            {{ $label }}
          </a>
        @endforeach
      </nav>
    </div>

    <div class="p-6">
      @yield('settings-content')
    </div>
  </div>
</div>
@endsection
