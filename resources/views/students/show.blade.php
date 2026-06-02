@extends('layouts.app')

@section('title', $student->name)
@section('page-title', $student->name .' — Student Detail')

@section('content')
<div class="ilap-page-header ilap-flex items-center justify-between gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">{{ $student->name }}</h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">Student ID: {{ $student->unique_id }}</p>
    </div>
    <div class="ilap-flex gap-2">
        <a href="{{ route('students.edit', $student) }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Edit</a>
        <form action="{{ route('students.advance-status', $student) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-btn-sm" onclick="return confirm('Advance student status?')">
                Advance Status
            </button>
        </form>
    </div>
</div>

<div class="ilap-grid-2 gap-6">
    {{-- Student Info Card --}}
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Student Info</h3>
        </div>
        <div class="ilap-p-4 space-y-3">
            <div class="ilap-grid-2">
                <div>
                    <p class="ilap-text-xs text-slate-500">Phone</p>
                    <p class="ilap-font-semibold">{{ $student->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="ilap-text-xs text-slate-500">Email</p>
                    <p class="ilap-font-semibold">{{ $student->email ?? '—' }}</p>
                </div>
                <div>
                    <p class="ilap-text-xs text-slate-500">Campus</p>
                    <p class="ilap-font-semibold">{{ $student->campus?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="ilap-text-xs text-slate-500">Handler</p>
                    <p class="ilap-font-semibold">{{ $student->handler?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="ilap-text-xs text-slate-500">IELTS Score</p>
                    <p class="ilap-font-semibold">{{ $student->ielts_score ? number_format($student->ielts_score, 1) : '—' }}</p>
                </div>
                <div>
                    <p class="ilap-text-xs text-slate-500">Passport</p>
                    <p class="ilap-font-semibold">{{ $student->passport_number ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Card --}}
    <div class="ilap-card">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Enrollment Status</h3>
        </div>
        <div class="ilap-p-4">
            @php
                $steps = ['registered','payment_pending','enrolled','documents_verified','completed'];
                $currentStep = $student->current_step;
                $idx = array_search($currentStep, $steps);
            @endphp
            <div class="ilap-flex items-center gap-2 ilap-mb-3">
                @foreach($steps as $i => $step)
                    <div class="ilap-flex items-center">
                        <span class="ilap-w-8 ilap-h-8 ilap-rounded-full ilap-flex ilap-items-center ilap-justify-center ilap-font-bold
                            {{ $i <= $idx ? 'ilap-bg-primary text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $i + 1 }}
                        </span>
                        @if($i < count($steps) - 1)
                            <span class="ilap-w-6 h-0.5 {{ $i < $idx ? 'bg-primary' : 'bg-slate-300' }}"></span>
                        @endif
                    </div>
                @endforeach
            </div>
            <p class="ilap-text-sm ilap-font-semibold">Current Step: {{ ucfirst(str_replace('_',' ',$currentStep)) }}</p>
        </div>
    </div>

    {{-- Documents --}}
    <div class="ilap-card md:col-span-2">
        <div class="ilap-card-header ilap-flex items-center justify-between">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Documents</h3>
            <button onclick="document.getElementById('docUpload').classList.remove('hidden')" 
                    class="ilap-btn ilap-btn-secondary ilap-btn-sm">+ Upload</button>
        </div>
        <div class="ilap-table__wrap">
            <table class="ilap-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Uploaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $i => $doc)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $doc->title }}</td>
                        <td><span class="ilap-badge ilap-badge--blue">{{ ucfirst($doc->type) }}</span></td>
                        <td class="ilap-text-xs">{{ $doc->created_at?->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('documents.download', $doc) }}" class="ilap-btn ilap-btn-sm ilap-btn-secondary">Download</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="ilap-text-center ilap-py-8 text-slate-400">No documents uploaded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payments --}}
    <div class="ilap-card md:col-span-2">
        <div class="ilap-card-header">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Payments</h3>
        </div>
        <div class="ilap-table__wrap">
            <table class="ilap-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at?->format('M d, Y') }}</td>
                        <td>£{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst($payment->type) }}</td>
                        <td><span class="ilap-badge ilap-badge--{{ $payment->status === 'completed' ? 'green' : 'yellow' }}">
                            {{ ucfirst($payment->status) }}
                        </span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="ilap-text-center ilap-py-8 text-slate-400">No payments recorded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tickets --}}
    <div class="ilap-card md:col-span-2">
        <div class="ilap-card-header ilap-flex items-center justify-between">
            <h3 class="ilap-font-bold text-slate-800 ilap-m-0">Support Tickets</h3>
            <a href="{{ route('tickets.create') }}?student_id={{ $student->id }}" class="ilap-btn ilap-btn-secondary ilap-btn-sm">+ New Ticket</a>
        </div>
        <div class="ilap-table__wrap">
            <table class="ilap-table">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket_number }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td><span class="ilap-badge ilap-badge--{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'closed' ? 'gray' : 'green') }}">
                            {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                        </span></td>
                        <td class="ilap-text-xs">{{ $ticket->updated_at?->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="ilap-text-center ilap-py-8 text-slate-400">No tickets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection