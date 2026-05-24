{{-- extends settings-layout --}}
@extends('settings.settings-layout')

@section('content')
<div class="ilap-card ilap-mb-6">
    <div class="ilap-card-header">
        <h3 class="ilap-m-0">iLAP System Configuration</h3>
    </div>
    <form method="POST" action="{{ route('settings.save-ilap-config') }}" class="ilap-p-5 grid md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        <div class="ilap-form-group">
            <label class="ilap-label">Enrollment deadline (days) — doesn’t fall between</label>
            <input type="number" name="enrollment_deadline" value="{{ $config['enrollment_deadline'] ?? 30 }}"
                   class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Grace period (days)</label>
            <input type="number" name="deadline_grace_days" value="{{ $config['deadline_grace_days'] ?? 14 }}"
                   class="ilap-input">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Email Reminders</label>
            <label class="ilap-flex items-center gap-2">
                <span class="ilap-text-sm">Enabled</span>
                <div class="ilap-switch">
                    <input type="checkbox" name="email_notification" @checked(($config['email_notification'] ?? true))>
                    <div></div>
                </div>
            </label>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Reports Auto-send</label>
            <label class="ilap-flex items-center gap-2">
                <span class="ilap-text-sm">Enabled</span>
                <div class="ilap-switch">
                    <input type="checkbox" name="reports_auto_send" @checked(($config['reports_auto_send'] ?? false))>
                    <div></div>
                </div>
            </label>
        </div>

        <div class="ili ap-form-group md:col-span-2">
            <label class="ilap-label">Purchase Cards Enabled</label>
            <label class="ilap-flex items-center gap-2">
                <span class="ilap-text-sm">Enabled</span>
                <div class="ilap-switch">
                    <input type="checkbox" name="purchase_card_enabled" checked>
                </div>
            </label>
            <p class="ilap-text-xs text-slate-500 ilap-mt-1">
                Controls whether enrollment CRM, Film, and Visual pages are accessible.
            </p>
        </div>

        <div class="ili ap-form-group md:col-span-2">
            <label class="ilap-label">Mail Layout Template</label>
            <select name="mail_layout" class="ilap-select">
                <option value="default" {{ ($config['mail_layout'] ?? 'default')==='default'?'selected':'' }}>Default (plain text)</option>
                <option value="html" {{ ($config['mail_layout'] ?? '') === 'html' ? 'selected' : '' }}>HTML branded</option>
            </select>
        </div>

        <div class="ilap-mt-3 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                💾 Save Configuration
            </button>
        </div>
    </form>
</div>
@endsection
