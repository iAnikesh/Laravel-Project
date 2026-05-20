<?php

use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\ApplicationProgressController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FinancialRecordController;
use App\Http\Controllers\GisMapController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\HousingApplicationController;
use App\Http\Controllers\MasterData\DistrictController;
use App\Http\Controllers\MasterData\SchemeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/search', SearchController::class)->name('search');
    Route::get('/gis-map', GisMapController::class)->name('gis.index');
    Route::get('/modules', fn () => view('mis.modules.index'))->name('modules.index');

    Route::resource('applications', HousingApplicationController::class);
    Route::post('applications/{application}/submit', [HousingApplicationController::class, 'submit'])->name('applications.submit');
    Route::post('applications/{application}/approve', [HousingApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('applications/{application}/reject', [HousingApplicationController::class, 'reject'])->name('applications.reject');

    Route::post('applications/{application}/progress', [ApplicationProgressController::class, 'store'])->name('applications.progress.store');
    Route::post('applications/{application}/financials', [FinancialRecordController::class, 'store'])->name('applications.financials.store');
    Route::post('applications/{application}/documents', [DocumentController::class, 'store'])->name('applications.documents.store');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::resource('grievances', GrievanceController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('grievances/{grievance}/respond', [GrievanceController::class, 'respond'])->name('grievances.respond');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::middleware('role:admin,officer')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/audit-logs', AuditLogController::class)->name('audit-logs.index');

        Route::prefix('master-data')->name('master.')->group(function () {
            Route::resource('districts', DistrictController::class)->only(['index', 'create', 'store']);
            Route::resource('schemes', SchemeController::class)->only(['index', 'create', 'store']);
        });

        Route::get('/api/districts/{district}/blocks', [DistrictController::class, 'blocks'])->name('api.districts.blocks');
        Route::get('/api/blocks/{block}/villages', [DistrictController::class, 'villages'])->name('api.blocks.villages');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('officers', OfficerController::class)->only(['index', 'create', 'store']);
});
