@extends('layouts.app')

@section('title','Videos by Class')
@section('page-title',$class->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('videos.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Videos
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm mb-6">
    <h2 class="text-lg font-bold text-slate-900">{{ $class->name }}</h2>
    <p class="text-xs text-slate-500 mt-1">Module: {{ $class->module?->name ?? '—' }} • Teacher: {{ $class->teacher?->name ?? '—' }}</p>
</div>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($class->records as $record)
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="aspect-video bg-black flex items-center justify-center">
                <a href="{{ route('videos.play',$record) }}" class="flex flex-col items-center gap-2 text-white">
                    <i class="fa-solid fa-play-circle text-4xl opacity-80 hover:opacity-100"></i>
                    <span class="text-xs font-semibold">Play Video</span>
                </a>
            </div>
            <div class="p-4">
                <h3 class="text-sm font-bold text-slate-900 line-clamp-2">{{ $record->topic }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $record->record_date }} • Teacher: {{ $record->teacher?->name ?? '—' }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-xl border border-slate-200 bg-white p-8 text-center">
            <p class="text-sm text-slate-400">No videos recorded for this class yet.</p>
        </div>
    @endforelse
</div>
@endsection
