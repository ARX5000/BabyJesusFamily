<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1'); // Rate limit: 5 attempts per minute
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Root redirect
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Classes
        Route::resource('classes', ClassController::class)->except(['show']);

        // Activities
        Route::resource('activities', ActivityController::class)->except(['show']);

        // Students
        Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('students/pending', [AdminStudentController::class, 'pending'])->name('students.pending');
        Route::get('students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::get('students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::delete('students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
        Route::post('students/{student}/approve', [AdminStudentController::class, 'approve'])->name('students.approve');
        Route::post('students/{student}/reject', [AdminStudentController::class, 'reject'])->name('students.reject');

        // Teachers
        Route::resource('teachers', TeacherController::class)->except(['show']);
        Route::post('teachers/{teacher}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');
        Route::post('teachers/{teacher}/toggle-status', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle-status');

        // Reports / Excel Export
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');

        // Audit Logs
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        // Students
        Route::resource('students', TeacherStudentController::class);
    });
