<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function auditLogs(): View
    {
        $logs = Activity::latest()->paginate(50);
        return $this->withOrg('settings.activity_logs', compact('logs'));
    }
}