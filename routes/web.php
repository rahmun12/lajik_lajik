<?php

use App\Http\Controllers\PersonalDataController;
use Illuminate\Support\Facades\Route;

// Route untuk form pengajuan izin yang sudah digabung
Route::get('/pengajuan-izin', [PersonalDataController::class, 'create'])->name('pengajuan.izin');
Route::post('/pengajuan-izin', [PersonalDataController::class, 'store'])->name('pengajuan.izin.store');
