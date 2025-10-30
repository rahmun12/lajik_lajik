<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalData;
use App\Models\JenisIzin;
use App\Models\PenyerahanSk;
use App\Models\PenerimaanSk;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapitulasiPenerimaanExport;
use App\Exports\RekapitulasiPenyerahanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapitulasiPenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get data from PenyerahanSk with related models
        $items = \App\Models\PenyerahanSk::with([
                'personalData',
                'personalData.izinPengajuan.jenisIzin'
            ])
            ->latest()
            ->get()
            ->map(function($item) {
                // Build full address from components
                $alamat = [
                    $item->personalData->alamat_jalan ?? '',
                    $item->personalData->rt ? 'RT ' . $item->personalData->rt : '',
                    $item->personalData->rw ? 'RW ' . $item->personalData->rw : '',
                    $item->personalData->kelurahan,
                    $item->personalData->kecamatan,
                    $item->personalData->kode_pos
                ];
                
                // Filter out empty values and join with comma and space
                $alamat_lengkap = implode(', ', array_filter($alamat));

                return (object) [
                    'tanggal_penerimaan' => $item->created_at,
                    'nama_pemohon' => $item->personalData->nama ?? 'N/A',
                    'alamat' => $alamat_lengkap ?: 'N/A',
                    'jenis_izin' => $item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A',
                    'petugas_mengambil' => $item->petugas_mengambil ?? 'N/A',
                    'petugas_menyerahkan' => $item->petugas_menyerahkan ?? 'N/A'
                ];
            });

        return view('admin.rekapitulasi-penerimaan.index', compact('items'));
    }

    /**
     * Export data to Excel
     */
   public function exportExcel()
{
    $filename = 'rekapitulasi_penyerahan_export_' . date('Ymd_His') . '.xlsx';
    return Excel::download(new RekapitulasiPenyerahanExport, $filename);
}
}