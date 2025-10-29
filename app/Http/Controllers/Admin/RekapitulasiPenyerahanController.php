<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenyerahanSk;
use App\Exports\RekapitulasiPenyerahanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class RekapitulasiPenyerahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PenyerahanSk::with(['personalData'])
            ->latest('tanggal_penyerahan')
            ->get();

        return view('admin.rekapitulasi-penyerahan.index', compact('items'));
    }

    /**
     * Export data to Excel
     */
    public function export()
    {
        $filename = 'rekapitulasi_penyerahan_export_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new RekapitulasiPenyerahanExport, $filename);
    }
}
