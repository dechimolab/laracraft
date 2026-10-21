<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\WebauthnController;
use App\Http\Controllers\GeneratorController;
use App\Http\Middleware\NoCacheAuthenticated;
use Illuminate\Support\Facades\Route;

// Authentication & Landing Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public WebAuthn / Passkey Login Endpoints
Route::prefix('webauthn')->name('webauthn.')->group(function () {
    Route::post('/login/options', [WebauthnController::class, 'loginOptions'])->name('login.options');
    Route::post('/login/verify', [WebauthnController::class, 'loginVerify'])->name('login.verify');
});

// Authenticated Pipeline Routes with NoCacheAuthenticated
Route::middleware([NoCacheAuthenticated::class])->group(function () {
    Route::prefix('generator')->name('generator.')->group(function () {
        Route::get('/new', [GeneratorController::class, 'newProject'])->name('new');
        Route::get('/step1', [GeneratorController::class, 'step1'])->name('step1');
        Route::post('/step1', [GeneratorController::class, 'saveStep1'])->name('step1.save');
        Route::post('/active-preset', [GeneratorController::class, 'setActivePreset'])->name('activePreset');
        Route::post('/clear-preset', [GeneratorController::class, 'clearActivePreset'])->name('clearPreset');
        Route::post('/test-db', [GeneratorController::class, 'testDbConnection'])->name('testDb');
        Route::post('/test-ums', [GeneratorController::class, 'testUmsConnection'])->name('testUms');
        Route::get('/step2', [GeneratorController::class, 'step2'])->name('step2');
        Route::post('/step2', [GeneratorController::class, 'saveStep2'])->name('step2.save');
        Route::get('/step3', [GeneratorController::class, 'step3'])->name('step3');
        Route::post('/step3', [GeneratorController::class, 'saveStep3'])->name('step3.save');
        Route::get('/step4', [GeneratorController::class, 'step4'])->name('step4');
        Route::post('/step4', [GeneratorController::class, 'saveStep4'])->name('step4.save');
        Route::get('/step5', [GeneratorController::class, 'step5'])->name('step5');
        Route::get('/preview-ui', [GeneratorController::class, 'previewUi'])->name('previewUi');
        Route::get('/preview-file', [GeneratorController::class, 'previewFile'])->name('previewFile');
        Route::post('/dry-run', [GeneratorController::class, 'dryRun'])->name('dryRun');
        Route::get('/export', [GeneratorController::class, 'exportZip'])->name('export');
    });

    // User Profile & Preferences
    Route::get('/profile', [GeneratorController::class, 'profile'])->name('profile');
    Route::post('/profile', [GeneratorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/deactivate', [GeneratorController::class, 'deactivateAccount'])->name('profile.deactivate');

    // Authenticated WebAuthn / Passkey Registration & Device Management
    Route::prefix('webauthn')->name('webauthn.')->group(function () {
        Route::post('/register/options', [WebauthnController::class, 'registerOptions'])->name('register.options');
        Route::post('/register/verify', [WebauthnController::class, 'registerVerify'])->name('register.verify');
        Route::get('/credentials', [WebauthnController::class, 'listCredentials'])->name('credentials.list');
        Route::delete('/credentials/{id}', [WebauthnController::class, 'deleteCredential'])->name('credentials.delete');
    });

    // Administration, Settings & User Management (Enforced via EnsureAdmin & sec-permission-from-database)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/setting', [SettingController::class, 'index'])->name('setting');
        Route::post('/setting/sync', [SettingController::class, 'sync'])->name('setting.sync');

        // User Management (จัดการบุคคล ลบ ปิดบัญชี แก้ไขสิทธิ์)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });
});
