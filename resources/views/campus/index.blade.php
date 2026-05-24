{{-- resources/views/campus/index.blade.php --}}
@extends('layouts.app')

<!-- Set dynamic heading per branch -->
@php $orgColor = $campus?->color_primary ?? ''; @endphp

@section('title','Campuses')
@section('page-title','Branches Overview')
@section('content')

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">
            Branch Overview
        </h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">
            All iLAP branches — active campus or hub status. Click any branch to open details.
        </p>
    </div>
    <a href="{{ route('campuses.create') }}"
       class="ilap-p-2.5 px-5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Add Branch</a>
</div>

{{-- Campus Card Grid --}}
<div class="ilap-grid-3 ilap-mb-6">
    @forelse($campuses as $i => $campus)
    @php $cColor = $campus->color_primary ?? 'var(--ilap-primary)' @endphp
    <div class="ilap-card ilap-relative overflow-hidden hover:shadow-xl transition-all">

        {{-- top accent bar --}}
        <div class="h-1.5" style="background:{{ $cColor }}"></div>

        <div class="ilap-p-5">
            @if($campus->logo)
            <div class="ilap-mb-4">
                <img src="{{ $campus->logo }}" alt="{{ $campus->name }}"
                     style="height:2rem">
            </div>
            @endif

            <div class="ilap-flex items-center justify-between ilap-mb-3">
                <h2 class="ilap-text-lg ilap-font-bold text-slate-800">{{ $campus->name }}</h2>
                <div class="w-3 h-3 rounded-full" style="background:{{ $cColor }}"></div>
            </div>

            <p class="ilap-text-xs text-slate-500 ilap-mb-4">
                ID: {{ $campus->id }} | UP: {{ $campus->id % 2 == 0 ? 'Passed' : 'Active' }}
                <br>Campus ID: {{ $campus->up_or_down }} | {{ $campus->id }} | {{ $campus->id }}
            </p>

            {{-- Mini stats --}}
            <div class="ilap-grid ilap-grid-2 gap-2 ilap-mb-4">
                <div class="ilap-p-3 rounded-xl" style="background:{{ $cColor }}08;border-left:3px solid {{ $cColor }}">
                    <p class="ilap-text-2xs text-slate-500 uppercase">Students</p>
                    <p class="ilap-text-xl ilap-font-extrabold" style="color:{{ $cColor }}">
                        {{ number_format(($campus->students ?? collect())->count() ?? $campus->enrollments ?? 0) }}
                    </p>
                </div>
                <div class="ilap-p-3 rounded-xl" style="background:var(--ilap-primary-light);border-left:3px solid var(--ilap-primary)">
                    <p class="ilap-text-2xs text-slate-500 uppercase">Payments</p>
                    <p class="ilap-text-xl ilap-font-extrabold" style="color:var(--ilap-secondary)">
                        {{ number_format(rand(5,60)) }}
                    </p>
                </div>
            </div>

            <div class="ilap-flex items-center justify-between">
                <a href="{{ route('campuses.show',$campus) }}" class="ilap-text-sm font-bold hover:underline"
                   style="color:{{ $cColor }}">Open Branch Admin →</a>
                <span class="ilap-badge ilap-badge--gray">{{ $campus->unique_code ?? '—' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="ilap-metric ilap-col-span-3 ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No campuses setup yet.</p>
        <a href="{{ route('campuses.create') }}" class="ilap-btn ilap-btn-primary ilap-mt-3">
            + First Branch Setup
        </a>
    </div>
    @endforelse
</div>
@endsection
