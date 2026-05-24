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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::get('/',                                         [\App\Http\Controllers\MessageController::class,'inbox'])->name('inbox');
        Route::get('/sent',                                     [\App\Http\Controllers\MessageController::class,'sent'])->name('sent');
        Route::get('/ compose',                                 [\App\Http\Controllers\MessageController::class,'compose'])->name('compose');
        Route::post('/',                                        [\App\Http\Controllers\MessageController::class,'send'])->name('send');
        Route::get('/{message}',                                [\App\Http\Controllers\MessageController::class,'show'])->name('show');
        Route::post('/{message}/reply',                         [\App\Http\Controllers\MessageController::class,'reply'])->name('reply');
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
    });
});
