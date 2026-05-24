{{-- routes/admin.php — optional nested admin CLI --}}
<?php

use Spatie\Activitylog\Models\Activity;

Route::prefix('admin')->middleware('role:super_admin')->group(function () {
    // Audit log viewer
    Route::get('/audit-logs', function () {
        $logs = Activity::latest()->paginate(50);
        return view('settings.activity_logs', compact('logs'));
    })->name('admin.audit-logs');
});
