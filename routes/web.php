<?php

use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\FieldVerificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\PenerimaanSkController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Test Route
// Include check-data routes
require __DIR__ . '/check-data.php';

// Homepage Route
Route::get('/', function () {
    return view('welcome');
});

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
Route::get('/api/kelurahan/{id}', [AddressController::class, 'getKelurahan']);

Route::post('/pengajuan-izin', [PersonalDataController::class, 'store'])
    ->name('pengajuan.izin.store');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Admin Inti Routes (direct access; guarded by CheckAdminInti which auto-creates/logs in admin_inti)
Route::prefix('admin-inti')->name('admin_inti.')->middleware([\App\Http\Middleware\CheckAdminInti::class])->group(function () {
    // User Management
    Route::resource('users', 'App\Http\Controllers\Admin\UserController')
        ->names('users');

    // Add other admin-inti specific routes here
});

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

    Route::delete('/personal-data/{id}', [PersonalDataController::class, 'destroy'])
        ->name('personal-data.destroy');

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

    // Regular User Management
    Route::resource('users/regular', 'App\Http\Controllers\Admin\RegularUserController')
        ->names('users.regular')
        ->except(['show']);

    // Penyerahan SK Routes
    // Export Penyerahan SK to Excel - must be defined before resource to avoid route conflict
    Route::get('penyerahan-sk/export', 'App\Http\Controllers\Admin\PenyerahanSkController@exportExcel')
        ->name('penyerahan-sk.export');

    Route::get('penyerahan-sk/pending', 'App\Http\Controllers\Admin\PenyerahanSkController@pending')
        ->name('penyerahan-sk.pending');

    // Resource route for Penyerahan SK (exclude show method if not needed)
    Route::resource('penyerahan-sk', 'App\Http\Controllers\Admin\PenyerahanSkController')
        ->names('penyerahan-sk')
        ->except(['show']);

    Route::post('penyerahan-sk/upload-foto/{id}', 'App\Http\Controllers\Admin\PenyerahanSkController@uploadFoto')
        ->name('penyerahan-sk.upload-foto');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // ... other routes
    Route::resource('rekapitulasi-penerimaan', 'App\\Http\\Controllers\\Admin\\RekapitulasiPenerimaanController')
        ->only(['index']);
    Route::get('rekapitulasi-penerimaan/export', 'App\\Http\\Controllers\\Admin\\RekapitulasiPenerimaanController@exportExcel')
        ->name('rekapitulasi-penerimaan.export');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // ... other routes
    Route::resource('rekapitulasi-penyerahan', 'App\\Http\\Controllers\\Admin\\RekapitulasiPenyerahanController')
        ->only(['index', 'exportExcel']);
    Route::get('rekapitulasi-penyerahan/export', 'App\\Http\\Controllers\\Admin\\RekapitulasiPenyerahanController@export')
        ->name('rekapitulasi-penyerahan.export');
});

// File access route
Route::get('/file/{filename}', 'App\Http\Controllers\FileController@show')
    ->name('file.show');

use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/qrcode', function () {
    // URL tujuan ketika QR di-scan
    $url = url('/'); // bisa kamu ganti ke route lain
    return view('qrcode', compact('url'));
});
