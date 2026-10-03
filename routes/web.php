<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LegalManagerController;
use App\Http\Controllers\ReleaseManagerController;
use App\Http\Controllers\PermissionManagerController;

/*
|--------------------------------------------------------------------------
| Vynqo Official Web Application Routes
|--------------------------------------------------------------------------
*/

// Landing & Product Showcase
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/features', [HomeController::class, 'features'])->name('features');

// APK Download & Release Info
Route::get('/download', [DownloadController::class, 'index'])->name('download.page');
Route::get('/download/apk', [DownloadController::class, 'downloadApk'])->name('download.apk');

// Legal & Security Policies (Android Studio & App Store Compliance)
Route::get('/community-guidelines', [LegalController::class, 'guidelines'])->name('legal.guidelines');
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/security', [LegalController::class, 'security'])->name('legal.security');

// Contact & Support (Rate Limited: Max 5 submissions per minute)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->middleware('throttle:5,1')->name('contact.submit');

// Admin Authentication Routes (Rate Limited Login: Max 5 attempts per minute to prevent brute-force)
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Panel Routes (Requires Authentication Middleware)
Route::middleware('auth')->prefix('admin')->group(function () {
    // Master Dashboard Hub
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.alias');

    // APK Release Manager
    Route::get('/release', [ReleaseManagerController::class, 'index'])->name('admin.release');
    Route::post('/release', [ReleaseManagerController::class, 'updateRelease'])->name('admin.release.update');

    // Android App Device Permissions Manager (Dynamic Privacy Permissions)
    Route::get('/permissions', [PermissionManagerController::class, 'index'])->name('admin.permissions.index');
    Route::post('/permissions', [PermissionManagerController::class, 'store'])->name('admin.permissions.store');
    Route::put('/permissions/{permission}', [PermissionManagerController::class, 'update'])->name('admin.permissions.update');
    Route::post('/permissions/{permission}/toggle', [PermissionManagerController::class, 'toggle'])->name('admin.permissions.toggle');
    Route::delete('/permissions/{permission}', [PermissionManagerController::class, 'destroy'])->name('admin.permissions.delete');

    // Legal & Community Policy Manager
    Route::get('/legal', [LegalManagerController::class, 'index'])->name('admin.legal.index');
    Route::get('/legal/{slug}/edit', [LegalManagerController::class, 'edit'])->name('admin.legal.edit');
    Route::post('/legal/{slug}', [LegalManagerController::class, 'update'])->name('admin.legal.update');
    Route::post('/legal/{slug}/reset', [LegalManagerController::class, 'reset'])->name('admin.legal.reset');

    // Support & Inquiries Manager
    Route::get('/messages', [AdminDashboardController::class, 'messages'])->name('admin.messages');
    Route::post('/messages/{message}/toggle', [AdminDashboardController::class, 'toggleMessage'])->name('admin.messages.toggle');
    Route::delete('/messages/{message}', [AdminDashboardController::class, 'deleteMessage'])->name('admin.messages.delete');
});
