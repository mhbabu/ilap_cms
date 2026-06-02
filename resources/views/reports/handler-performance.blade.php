@extends('layouts.app')

@section('title', 'Handler Performance')
@section('page-title', 'Handler Performance Report')

@section('content')
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Handler Performance</h1>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Handler</th>
                    <th>Email</th>
                    <th>Students</th>
                    <th>Leads</th>
                    <th>Campus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($handlers as $i => $handler)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="ilap-font-semibold">{{ $handler->name }}</td>
                    <td>{{ $handler->email }}</td>
                    <td>{{ $handler->student_count ?? 0 }}</td>
                    <td>{{ $handler->lead_count ?? 0 }}</td>
                    <td>{{ $handler->campus?->name ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="ilap-text-center ilap-py-8 text-slate-400">No handlers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection