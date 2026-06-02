@extends('layouts.app')

@section('title','Edit Class')
@section('page-title','Edit Class')

@section('content')
<div class="mb-6">
    <a href="{{ route('classes.show',$class) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Class
    </a>
</div>

<form method="POST" action="{{ route('classes.update',$class) }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    @method('PUT')
    <div class="space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Class Name</label>
                <input type="text" name="name" value="{{ old('name',$class->name) }}" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Code</label>
                <input type="text" name="code" value="{{ old('code',$class->code) }}" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm uppercase outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Course</label>
                <select name="module_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($modules as $m)
                        <option value="{{ $m->id }}" {{ old('module_id',$class->module_id) == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Campus</label>
                <select name="campus_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($campuses as $c)
                        <option value="{{ $c->id }}" {{ old('campus_id',$class->campus_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Teacher</label>
                <select name="teacher_id" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}" {{ old('teacher_id',$class->teacher_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $class->is_active ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
            <label for="is_active" class="text-sm text-slate-700">Active</label>
        </div>
        <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Update Class</button>
    </div>
</form>
@endsection
