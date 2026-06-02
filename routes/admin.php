<?php

use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Lead;
use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

Route::prefix('admin')->middleware(['role:super_admin'])->group(function () {
    // Audit log viewer
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('admin.audit-logs');

    // System stats dashboard
    Route::get('/stats', function () {
        $stats = [
            'total_users'    => User::count(),
            'active_users'   => User::where('is_active', true)->count(),
            'total_campuses' => Campus::count(),
            'active_campuses'=> Campus::where('is_active', true)->count(),
            'total_students' => Student::count(),
            'total_leads'    => Lead::count(),
            'open_tickets'   => Ticket::whereIn('status', ['open', 'in_progress'])->count(),
        ];
        return view('admin.stats', compact('stats'));
    })->name('admin.stats');

    // Clear application cache
    Route::post('/clear-cache', function () {
        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return back()->with('success', 'Application cache cleared successfully.');
    })->name('admin.clear-cache');

    // Database backup trigger
    Route::post('/backup', function () {
        Artisan::call('db:backup');
        return back()->with('success', 'Database backup completed.');
    })->name('admin.backup');
});
