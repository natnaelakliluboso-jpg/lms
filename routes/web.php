<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Enrollment routes
Route::middleware('auth')->group(function () {
    Route::post('/enroll/{course}', [EnrollmentController::class, 'store'])->name('enrollment.store');
    
    // Admin enrollment management
    Route::middleware('role:admin')->group(function () {
        Route::post('/admin/enrollment/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('admin.enrollment.approve');
        Route::post('/admin/enrollment/{enrollment}/deny', [EnrollmentController::class, 'deny'])->name('admin.enrollment.deny');
    });
});

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/student.php';

// Main dashboard route - this should come after other includes to override
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
