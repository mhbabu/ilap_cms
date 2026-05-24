{{-- Settings Dashboard -- shared layout with 6 setting sections --}}
@extends('layouts.app')
@section('title','Settings')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-bold text-slate-800">Settings</h1>
    <p class="ilap-text-sm text-slate-500">iLAP configuration, templates, system documents and audit log</p>
</div>

<div class="ilap-tabs ilap-mb-6">
    @foreach(['settings.index'=>'General','settings.ilap_config'=>'iLAP Config','settings.email-templates'=>'Email Templates','settings.system-documents'=>'System Docs','settings.activity-logs'=>'Audit Log'] as $route=>$label)
        <a href="{{ route($route) }}"
           class="ilap-tab {{ request()->routeIs($route) ? 'ilap-tab--active' : '' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

@yield('settings-content')
@endsection
