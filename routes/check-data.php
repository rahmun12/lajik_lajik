<?php

use App\Models\PenerimaanSk;
use App\Models\PersonalData;
use App\Models\IzinPengajuan;
use App\Models\JenisIzin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Route::get('/fix-data', function () {
    // Delete the existing penerimaan_sk record with incorrect personal_data_id
    DB::table('penerimaan_sk')->where('id', 1)->delete();
    
    // Create a new penerimaan_sk record linked to the existing personal_data (id=1)
    $penerimaanSk = PenerimaanSk::create([
        'personal_data_id' => 1, // Link to the existing personal_data
        'no_sk_izin' => 'SK/001/2024',
        'tanggal_terbit' => Carbon::now(),
        'petugas_menyerahkan' => 'Admin',
        'petugas_menerima' => 'Pemohon',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    return redirect('/check-data');
});

Route::get('/check-data', function () {
    // Check if the tables exist
    $tables = [
        'penerimaan_sk',
        'personal_data',
        'izin_pengajuan',
        'jenis_izins'
    ];
    
    $tableData = [];
    
    foreach ($tables as $table) {
        $tableData[$table] = DB::table($table)->get()->toArray();
    }
    
    // Get PenerimaanSk with relationships
    $penerimaanSk = PenerimaanSk::with(['personalData.izinPengajuan.jenisIzin'])->first();
    $allPenerimaanSk = PenerimaanSk::all();
    
    // Get PersonalData with relationships
    $personalData = PersonalData::with(['izinPengajuan.jenisIzin'])->get();
    
    // Get IzinPengajuan with relationships
    $izinPengajuan = IzinPengajuan::with(['jenisIzin', 'personalData'])->get();
    
    // Get JenisIzin
    $jenisIzin = JenisIzin::all();
    
    // Output the data
    echo '<pre>';
    
    echo "=== Table Data ===\n\n";
    foreach ($tableData as $tableName => $data) {
        echo "Table: $tableName\n";
        echo "Count: " . count($data) . "\n";
        if (count($data) > 0) {
            echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";
        } else {
            echo "No data\n\n";
        }
    }
    
    echo "\n=== PenerimaanSk with Relationships ===\n\n";
    echo json_encode($penerimaanSk ? $penerimaanSk->toArray() : 'No PenerimaanSk found', JSON_PRETTY_PRINT) . "\n";
    
    echo "\n=== All PenerimaanSk ===\n\n";
    echo json_encode($allPenerimaanSk ? $allPenerimaanSk->toArray() : 'No PenerimaanSk found', JSON_PRETTY_PRINT) . "\n";
    
    echo "\n=== PersonalData with Relationships ===\n\n";
    echo json_encode($personalData ? $personalData->toArray() : 'No PersonalData found', JSON_PRETTY_PRINT) . "\n";
    
    echo "\n=== IzinPengajuan with Relationships ===\n\n";
    echo json_encode($izinPengajuan ? $izinPengajuan->toArray() : 'No IzinPengajuan found', JSON_PRETTY_PRINT) . "\n";
    
    echo "\n=== All JenisIzin ===\n\n";
    echo json_encode($jenisIzin ? $jenisIzin->toArray() : 'No JenisIzin found', JSON_PRETTY_PRINT) . "\n";
    
    echo '</pre>';
    
    return '';
});
