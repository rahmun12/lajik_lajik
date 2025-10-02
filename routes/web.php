<?php

use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\FieldVerificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\PenerimaanSkController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Test Route
// Include check-data routes
require __DIR__.'/check-data.php';

Route::get('/test-login', function () {
    if (Auth::attempt(['email' => 'admin@example.com', 'password' => 'password'])) {
        return redirect()->route('admin.dashboard');
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
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Existing admin routes
    Route::post('/verification/update', [PersonalDataController::class, 'updateVerification'])
        ->name('verification.update');

    Route::get('/penyesuaian-data', [PersonalDataController::class, 'penyesuaianData'])
        ->name('penyesuaian-data');

    Route::post('/personal-data/verify/{id}', [PersonalDataController::class, 'updateVerification'])
        ->name('personal-data.verify');

    Route::post('/personal-data/verify-requirement', [PersonalDataController::class, 'verifyRequirement'])
        ->name('personal-data.verify-requirement');

    Route::post('/personal-data/upload-document', [PersonalDataController::class, 'uploadDocument'])
        ->name('personal-data.upload-document');

    Route::post('/personal-data/toggle-requirement', [PersonalDataController::class, 'toggleRequirementVerification'])
        ->name('personal-data.toggle-requirement');

    // Serah Terima Routes
    Route::resource('serah-terima', 'App\Http\Controllers\Admin\SerahTerimaController')
        ->names('serah-terima')
        ->except(['edit', 'update']);
        
    Route::put('serah-terima/update-field/{id}', 'App\Http\Controllers\Admin\SerahTerimaController@updateField')
        ->name('serah-terima.update-field');
        
    Route::post('serah-terima/upload-document', 'App\Http\Controllers\Admin\SerahTerimaController@uploadDocument')
        ->name('serah-terima.upload-document');

    // Penerimaan SK Routes
    Route::resource('penerimaan-sk', 'App\Http\Controllers\Admin\PenerimaanSkController')
        ->names('penerimaan-sk');
        
    Route::put('penerimaan-sk/update-field/{id}', 'App\Http\Controllers\Admin\PenerimaanSkController@updateField')
        ->name('penerimaan-sk.update-field');
});
