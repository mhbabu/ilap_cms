<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Force-login (Super Admin only)
Route::post('/admin/force-login/{user}', [AuthController::class, 'forceLogin'])
    ->middleware(['role:super_admin'])
    ->name('admin.force-login');

/*
|--------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/overview', [DashboardController::class, 'overview'])->name('dashboard.overview');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

    // ── User Management ──────────────────────────────────────
    Route::prefix('users')->name('users.')->middleware(['role:super_admin,hq_admin,campus_admin'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\UserController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\UserController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\UserController::class,'store'])->name('store');
        Route::get('/{user}',                          [\App\Http\Controllers\UserController::class,'show'])->name('show');
        Route::get('/{user}/edit',                     [\App\Http\Controllers\UserController::class,'edit'])->name('edit');
        Route::put('/{user}',                          [\App\Http\Controllers\UserController::class,'update'])->name('update');
        Route::delete('/{user}',                       [\App\Http\Controllers\UserController::class,'destroy'])->name('destroy');
        Route::post('/{user}/reset-password',          [\App\Http\Controllers\UserController::class,'resetPassword'])->name('reset-password');
        Route::post('/{user}/toggle-status',           [\App\Http\Controllers\UserController::class,'toggleStatus'])->name('toggle-status');
        Route::post('/search',                         [\App\Http\Controllers\UserController::class,'search'])->name('search');
    });

    // ── Leads ───────────────────────────────────────────────
    Route::prefix('leads')->name('leads.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\LeadController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\LeadController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\LeadController::class,'store'])->name('store');
        Route::get('/{lead}',                          [\App\Http\Controllers\LeadController::class,'show'])->name('show');
        Route::get('/{lead}/edit',                     [\App\Http\Controllers\LeadController::class,'edit'])->name('edit');
        Route::put('/{lead}',                          [\App\Http\Controllers\LeadController::class,'update'])->name('update');
        Route::post('/{lead}/convert',                 [\App\Http\Controllers\LeadController::class,'convert'])->name('convert');
        Route::post('/{lead}/assign',                  [\App\Http\Controllers\LeadController::class,'assign'])->name('assign');
        Route::post('/search',                         [\App\Http\Controllers\LeadController::class,'search'])->name('search');
    });

    // ── Students ────────────────────────────────────────────
    Route::prefix('students')->name('students.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\StudentController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\StudentController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\StudentController::class,'store'])->name('store');
        Route::get('/{student}',                       [\App\Http\Controllers\StudentController::class,'show'])->name('show');
        Route::get('/{student}/edit',                  [\App\Http\Controllers\StudentController::class,'edit'])->name('edit');
        Route::put('/{student}',                       [\App\Http\Controllers\StudentController::class,'update'])->name('update');
        Route::post('/{student}/advance-status',        [\App\Http\Controllers\StudentController::class,'advanceStatus'])->name('advance-status');
        Route::post('/{student}/documents',            [\App\Http\Controllers\StudentController::class,'uploadDocument'])->name('upload-document');
        Route::post('/search',                         [\App\Http\Controllers\StudentController::class,'search'])->name('search');
        Route::get('/export',                          [\App\Http\Controllers\StudentController::class,'export'])->name('export');
    });

    // ── Campus Management ───────────────────────────────────
    Route::prefix('campuses')->name('campuses.')->middleware(['role:super_admin,hq_admin'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\CampusController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\CampusController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\CampusController::class,'store'])->name('store');
        Route::get('/{campus}',                        [\App\Http\Controllers\CampusController::class,'show'])->name('show');
        Route::get('/{campus}/edit',                   [\App\Http\Controllers\CampusController::class,'edit'])->name('edit');
        Route::put('/{campus}',                        [\App\Http\Controllers\CampusController::class,'update'])->name('update');
        Route::delete('/{campus}',                     [\App\Http\Controllers\CampusController::class,'destroy'])->name('destroy');
        Route::get('/{campus}/stats',                  [\App\Http\Controllers\CampusController::class,'stats'])->name('stats');
    });

    // ── Finance ─────────────────────────────────────────────
    Route::prefix('finance')->name('finance.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\FinanceController::class,'index'])->name('index');
        Route::get('/payments/create',                 [\App\Http\Controllers\FinanceController::class,'createPayment'])->name('payments.create');
        Route::post('/payments',                       [\App\Http\Controllers\FinanceController::class,'storePayment'])->name('payments.store');
        Route::get('/payments/{payment}',              [\App\Http\Controllers\FinanceController::class,'showPayment'])->name('payments.show');
        Route::get('/receipt/{payment}',               [\App\Http\Controllers\FinanceController::class,'receipt'])->name('receipt');
        Route::post('/payments/{payment}/approve',     [\App\Http\Controllers\FinanceController::class,'approvePayment'])->name('payments.approve');
        Route::post('/installments/split',             [\App\Http\Controllers\FinanceController::class,'splitInstallment'])->name('installments.split');
        Route::get('/reports',                         [\App\Http\Controllers\FinanceController::class,'reports'])->name('reports');
    });

    // ── Documents ───────────────────────────────────────────
    Route::prefix('documents')->name('documents.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\DocumentController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\DocumentController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\DocumentController::class,'store'])->name('store');
        Route::get('/{document}',                      [\App\Http\Controllers\DocumentController::class,'show'])->name('show');
        Route::delete('/{document}',                   [\App\Http\Controllers\DocumentController::class,'destroy'])->name('destroy');
        Route::get('/{document}/download',             [\App\Http\Controllers\DocumentController::class,'download'])->name('download');
        Route::get('/{document}/edit',                 [\App\Http\Controllers\DocumentController::class,'edit'])->name('edit');
        Route::put('/{document}',                      [\App\Http\Controllers\DocumentController::class,'update'])->name('update');
    });

    // ── Tickets ─────────────────────────────────────────────
    Route::prefix('tickets')->name('tickets.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\TicketController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\TicketController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\TicketController::class,'store'])->name('store');
        Route::get('/{ticket}',                        [\App\Http\Controllers\TicketController::class,'show'])->name('show');
        Route::post('/{ticket}/assign',                [\App\Http\Controllers\TicketController::class,'assign'])->name('assign');
        Route::post('/{ticket}/reply',                 [\App\Http\Controllers\TicketController::class,'reply'])->name('reply');
        Route::post('/{ticket}/close',                 [\App\Http\Controllers\TicketController::class,'close'])->name('close');
    });

    // ── Messaging ───────────────────────────────────────────
    Route::prefix('messages')->name('messages.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\MessageController::class,'inbox'])->name('inbox');
        Route::get('/sent',                            [\App\Http\Controllers\MessageController::class,'sent'])->name('sent');
        Route::get('/compose',                         [\App\Http\Controllers\MessageController::class,'compose'])->name('compose');
        Route::post('/',                               [\App\Http\Controllers\MessageController::class,'send'])->name('send');
        Route::get('/{message}',                       [\App\Http\Controllers\MessageController::class,'show'])->name('show');
        Route::post('/{message}/reply',                [\App\Http\Controllers\MessageController::class,'reply'])->name('reply');
    });

    // ── Courses / Modules ───────────────────────────────────
    Route::prefix('modules')->name('modules.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\ModuleController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\ModuleController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\ModuleController::class,'store'])->name('store');
        Route::get('/{module}',                        [\App\Http\Controllers\ModuleController::class,'show'])->name('show');
        Route::get('/{module}/edit',                   [\App\Http\Controllers\ModuleController::class,'edit'])->name('edit');
        Route::put('/{module}',                        [\App\Http\Controllers\ModuleController::class,'update'])->name('update');
        Route::delete('/{module}',                     [\App\Http\Controllers\ModuleController::class,'destroy'])->name('destroy');
    });

    // ── Classes ─────────────────────────────────────────────
    Route::prefix('classes')->name('classes.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\ClassRoomController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\ClassRoomController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\ClassRoomController::class,'store'])->name('store');
        Route::get('/{class}',                         [\App\Http\Controllers\ClassRoomController::class,'show'])->name('show');
        Route::get('/{class}/edit',                    [\App\Http\Controllers\ClassRoomController::class,'edit'])->name('edit');
        Route::put('/{class}',                         [\App\Http\Controllers\ClassRoomController::class,'update'])->name('update');
        Route::delete('/{class}',                      [\App\Http\Controllers\ClassRoomController::class,'destroy'])->name('destroy');
    });

    // ── Enrollments ────────────────────────────────────────
    Route::prefix('enrollments')->name('enrollments.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\EnrollmentController::class,'index'])->name('index');
        Route::get('/create',                          [\App\Http\Controllers\EnrollmentController::class,'create'])->name('create');
        Route::post('/',                               [\App\Http\Controllers\EnrollmentController::class,'store'])->name('store');
        Route::get('/{enrollment}',                    [\App\Http\Controllers\EnrollmentController::class,'show'])->name('show');
        Route::get('/{enrollment}/edit',               [\App\Http\Controllers\EnrollmentController::class,'edit'])->name('edit');
        Route::put('/{enrollment}',                    [\App\Http\Controllers\EnrollmentController::class,'update'])->name('update');
        Route::post('/{enrollment}/approve',           [\App\Http\Controllers\EnrollmentController::class,'approve'])->name('approve');
        Route::post('/{enrollment}/reject',            [\App\Http\Controllers\EnrollmentController::class,'reject'])->name('reject');
    });

    // ── Video / Class Records ───────────────────────────────
    Route::prefix('videos')->name('videos.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager,handler,counsellor,student'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\VideoController::class,'index'])->name('index');
        Route::get('/class/{class}',                   [\App\Http\Controllers\VideoController::class,'byClass'])->name('by-class');
        Route::get('/record/{record}',                 [\App\Http\Controllers\VideoController::class,'play'])->name('play');
        Route::post('/record/{record}/progress',       [\App\Http\Controllers\VideoController::class,'updateProgress'])->name('update-progress');
    });

    // ── Reports ─────────────────────────────────────────────
    Route::prefix('reports')->name('reports.')->middleware(['role:super_admin,hq_admin,campus_admin,campus_manager',])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\ReportController::class,'index'])->name('index');
        Route::get('/student',                         [\App\Http\Controllers\ReportController::class,'students'])->name('students');
        Route::get('/payments',                        [\App\Http\Controllers\ReportController::class,'payments'])->name('payments');
        Route::get('/tickets',                         [\App\Http\Controllers\ReportController::class,'tickets'])->name('tickets');
        Route::get('/campus/{campus}',                 [\App\Http\Controllers\ReportController::class,'campus'])->name('campus');
        Route::get('/lead-status',                     [\App\Http\Controllers\ReportController::class,'leadStatus'])->name('lead-status');
        Route::get('/handler-performance',             [\App\Http\Controllers\ReportController::class,'handlerPerformance'])->name('handler-performance');
        Route::post('/export/{type}',                  [\App\Http\Controllers\ReportController::class,'export'])->name('export');
    });

    // ── Settings (Super Admin only) ─────────────────────────
    Route::prefix('settings')->name('settings.')->middleware(['role:super_admin,hq_admin'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\SettingsController::class,'index'])->name('index');
        Route::get('/email-templates',                 [\App\Http\Controllers\SettingsController::class,'emailTemplates'])->name('email-templates');
        Route::post('/email-templates',                [\App\Http\Controllers\SettingsController::class,'saveEmailTemplate'])->name('save-email-template');
        Route::get('/system-documents',                [\App\Http\Controllers\SettingsController::class,'systemDocuments'])->name('system-documents');
        Route::post('/system-documents',               [\App\Http\Controllers\SettingsController::class,'uploadSystemDoc'])->name('upload-system-doc');
        Route::get('/activity-logs',                   [\App\Http\Controllers\SettingsController::class,'activityLogs'])->name('activity-logs');
        Route::get('/ilap-config',                     [\App\Http\Controllers\SettingsController::class,'ilapConfig'])->name('ilap-config');
        Route::put('/ilap-config',                     [\App\Http\Controllers\SettingsController::class,'saveIlapConfig'])->name('save-ilap-config');
        Route::post('/colors',                         [\App\Http\Controllers\SettingsController::class,'updateColors'])->name('update-colors');
    });

    // ── Courses and Videos ───────────────────────────────────────
    Route::prefix('courses')->name('courses.')->middleware(['auth'])->group(function () {
        Route::get('/',                                [\App\Http\Controllers\CourseController::class,'index'])->name('index');
        Route::get('/my',                              [\App\Http\Controllers\CourseController::class,'myCourses'])->name('my');
        Route::post('{course}/enroll',                 [\App\Http\Controllers\CourseController::class,'enroll'])->name('enroll');
        Route::prefix('{course}/videos')->name('videos.')->group(function () {
            Route::get('/',                            [\App\Http\Controllers\CourseVideoController::class,'index'])->name('index');
            Route::get('{video}/play',                 [\App\Http\Controllers\CourseVideoController::class,'play'])->name('play');
        });
    });
});
