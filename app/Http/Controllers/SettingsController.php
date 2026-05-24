<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use App\Models\EmailTemplate;
use App\Models\SystemDocumentTemplate;

class SettingsController extends Controller
{
    public function index(): View
    {
        return $this->withOrg('settings.index', []);
    }

    public function emailTemplates(Request $request)
    {
        $templates = EmailTemplate::query()
            ->when($request->filled('type'), fn($q)=>$q->where('type',$request->type))
            ->latest()
            ->paginate(20);
        return $this->withOrg('settings.email_templates', compact('templates'));
    }

    public function saveEmailTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'type'       => 'required|string|max:50',
            'subject'    => 'required|string|max:255',
            'body_html'  => 'nullable|string',
            'body_text'  => 'nullable|string',
            'is_active'  => 'boolean',
        ]);
        EmailTemplate::updateOrCreate(['name'=>$data['name']], $data);
        return back()->with('success','Template saved.');
    }

    public function systemDocuments(Request $request): \Illuminate\View\View
    {
        $docs = SystemDocumentTemplate::latest()->paginate(20);
        return $this->withOrg('settings.system_documents', compact('docs'));
    }

    public function uploadSystemDoc(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:form,result,guide,contract,other',
            'file'         => 'required|file|max:51200',
        ]);
        $file = $request->file('file');
        $path = $file->store('system/templates','public');
        SystemDocumentTemplate::create([
            'name'          => $data['name'],
            'type'          => $data['type'],
            'file_path'     => $path,
            'uploaded_by'   => auth()->id(),
            'description'   => $data['description'],
        ]);
        return back()->with('success','Template uploaded successfully.');
    }

    public function activityLogs(Request $request)
    {
        $logs = Activity::query()
            ->when($request->filled('causer'), fn($q) => $q->where('causer_id',$request->causer))
            ->latest()
            ->take(100)->get();
        return $this->withOrg('settings.activity_logs', compact('logs'));
    }

    public function ilapConfig(): View
    {
        $config = [
            'enrollment_deadline'      => config('ilap.enrollment_deadline', 30),
            'deadline_grace_days'      => config('ilap.deadline_grace_days', 14),
            'reports_auto_send'        => config('ilap.reports_auto_send', false),
            'email_notification'       => config('ilap.email_notification', true),
            'auto_approve_documents'   => config('ilap.auto_approve_documents', false),
            'mail_layout'              => config('ilap.mail_layout', 'default'),
        ];
        return $this->withOrg('settings.ilap_config', compact('config'));
    }

    public function saveIlapConfig(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'enrollment_deadline'     => 'required|integer|min:1',
            'deadline_grace_days'     => 'required|integer|min:0',
            'reports_auto_send'       => 'boolean',
            'email_notification'      => 'boolean',
            'auto_approve_documents'  => 'boolean',
            'mail_layout'             => 'required|string',
        ]);
        DB::table('settings')->updateOrInsert(['key'=>'ilap_config'], ['value'=>json_encode($data), 'updated_at'=>now()]);
        return back()->with('success','iLAP configuration saved.');
    }
}
