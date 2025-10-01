<?php

use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\FieldVerificationController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Test Route
Route::get('/test-login', function () {
    if (Auth::attempt(['email' => 'admin@example.com', 'password' => 'password'])) {
        return redirect()->intended('/admin/penyesuaian-data');
    }
    return 'Login failed';
});

// Field Verification Routes
Route::post('/field-verification/update', [FieldVerificationController::class, 'update'])
    ->name('field.verification.update')
    ->middleware('auth');

// Public Routes
Route::get('/pengajuan-izin', [PersonalDataController::class, 'create'])
    ->name('pengajuan.izin');

// Address Dropdown Routes
Route::get('/api/kabupaten', [AddressController::class, 'getKabupatenKota']);
Route::get('/api/kecamatan/{kabupatenId}', [AddressController::class, 'getKecamatan']);
Route::get('/api/kelurahan/{kecamatanId}', [AddressController::class, 'getKelurahan']);
    
Route::post('/pengajuan-izin', [PersonalDataController::class, 'store'])
    ->name('pengajuan.izin.store');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    // Verification update route
    Route::post('/verification/update', [PersonalDataController::class, 'updateVerification'])
        ->name('verification.update');
    // Halaman penyesuaian data
    Route::get('/admin/penyesuaian-data', [PersonalDataController::class, 'penyesuaianData'])
        ->name('admin.penyesuaian-data');
        
    // Endpoint untuk verifikasi data
    Route::post('/admin/personal-data/verify/{id}', [PersonalDataController::class, 'updateVerification'])
        ->name('personal-data.verify');
        
    // Endpoint untuk verifikasi persyaratan
    Route::post('/admin/personal-data/verify-requirement', [PersonalDataController::class, 'verifyRequirement'])
        ->name('personal-data.verify-requirement');
        
    // Endpoint untuk upload dokumen
    Route::post('/admin/personal-data/upload-document', [PersonalDataController::class, 'uploadDocument'])
        ->name('personal-data.upload-document');
        
    // Endpoint untuk toggle verifikasi persyaratan
    Route::post('/admin/personal-data/toggle-requirement', [PersonalDataController::class, 'toggleRequirementVerification'])
        ->name('personal-data.toggle-requirement');
});