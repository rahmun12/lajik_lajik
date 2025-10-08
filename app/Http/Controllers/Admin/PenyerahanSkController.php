<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenyerahanSk;
use App\Models\PersonalData;
use App\Models\JenisIzin;
use App\Models\PenerimaanSk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PenyerahanSkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PenyerahanSk::with('personalData.izinPengajuan.jenisIzin')
            ->latest()
            ->paginate(10);

        return view('admin.penyerahan-sk.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Log semua query parameters
        if (app()->environment('local')) {
            error_log('PenyerahanSkController@create - Request Data: ' . json_encode($request->all()));
            error_log('Full URL: ' . $request->fullUrl());
        }
        
        $penerimaanSkId = $request->query('penerimaan_sk_id');
        
        if (!$penerimaanSkId) {
            if (app()->environment('local')) {
                error_log('penerimaan_sk_id tidak ditemukan di URL');
            }
            return redirect()->route('admin.penerimaan-sk.index')
                ->with('error', 'ID Penerimaan SK tidak valid');
        }

        $penerimaanSk = PenerimaanSk::with(['personalData.izinPengajuan.jenisIzin'])
            ->find($penerimaanSkId);
            
        if (!$penerimaanSk) {
            if (app()->environment('local')) {
                error_log('Data PenerimaanSk tidak ditemukan untuk ID: ' . $penerimaanSkId);
            }
            return redirect()->route('admin.penerimaan-sk.index')
                ->with('error', 'Data penerimaan SK tidak ditemukan');
        }

        // Cek apakah sudah ada penyerahan SK untuk penerimaan ini
        $existingPenyerahan = PenyerahanSk::where('penerimaan_sk_id', $penerimaanSkId)->first();
        if ($existingPenyerahan) {
            return redirect()->route('admin.penerimaan-sk.index')
                ->with('error', 'Data penyerahan SK untuk penerimaan ini sudah ada');
        }

        $jenisIzin = \App\Models\JenisIzin::all();
        return view('admin.penyerahan-sk.create', compact('penerimaanSk', 'jenisIzin'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'personal_data_id' => 'required|exists:personal_data,id',
            'penerimaan_sk_id' => 'required|exists:penerimaan_sk,id',
            'no_sk_izin' => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'tanggal_penyerahan' => 'required|date',
            'petugas_menyerahkan' => 'required|string|max:100',
            'pemohon_menerima' => 'required|string|max:100',
            'foto_penyerahan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah sudah ada data penyerahan untuk penerimaan_sk_id ini
        $existingPenyerahan = PenyerahanSk::where('penerimaan_sk_id', $validated['penerimaan_sk_id'])->first();
        if ($existingPenyerahan) {
            return redirect()->back()
                ->with('error', 'Data penyerahan SK untuk penerimaan ini sudah ada')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Handle file upload
            if ($request->hasFile('foto_penyerahan')) {
                $file = $request->file('foto_penyerahan');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('penyerahan-sk', $filename, 'public');
                $validated['foto_penyerahan'] = $path;
            }

            // Tambahkan data tambahan
            $validated['status'] = 'selesai';
            $validated['keterangan'] = 'Penyerahan SK selesai pada ' . now()->format('d/m/Y H:i:s');

            // Simpan data
            $penyerahanSk = PenyerahanSk::create($validated);

            DB::commit();

            return redirect()->route('admin.penyerahan-sk.index')
                ->with('success', 'Data penyerahan SK berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (app()->environment('local')) {
                error_log('Error saving data: ' . $e->getMessage());
                error_log($e->getTraceAsString());
            }
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . 
                    (app()->environment('local') ? $e->getMessage() : 'Silakan coba lagi'))
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = PenyerahanSk::findOrFail($id);
        $jenisIzin = \App\Models\JenisIzin::all();

        return view('admin.penyerahan-sk.edit', compact('item', 'jenisIzin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penyerahanSk = PenyerahanSk::findOrFail($id);

        $validated = $request->validate([
            'no_sk_izin' => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'petugas_menyerahkan' => 'required|string|max:100',
            'pemohon_menerima' => 'required|string|max:100',
            'foto_penyerahan' => 'nullable|image|max:2048',
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('foto_penyerahan')) {
            // Delete old file if exists
            if ($penyerahanSk->foto_penyerahan) {
                Storage::disk('public')->delete($penyerahanSk->foto_penyerahan);
            }

            $path = $request->file('foto_penyerahan')->store('penyerahan-sk', 'public');
            $validated['foto_penyerahan'] = $path;
        }

        $penyerahanSk->update($validated);

        return redirect()->route('admin.penyerahan-sk.index')
            ->with('success', 'Data penyerahan SK berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penyerahanSk = PenyerahanSk::findOrFail($id);

        // Delete associated file
        if ($penyerahanSk->foto_penyerahan) {
            Storage::disk('public')->delete($penyerahanSk->foto_penyerahan);
        }

        $penyerahanSk->delete();

        return redirect()->route('admin.penyerahan-sk.index')
            ->with('success', 'Data penyerahan SK berhasil dihapus');
    }

    /**
     * Handle file upload for penyerahan SK
     */
    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto_penyerahan' => 'required|image|max:2048',
        ]);

        $penyerahanSk = PenyerahanSk::findOrFail($id);

        // Delete old file if exists
        if ($penyerahanSk->foto_penyerahan) {
            Storage::disk('public')->delete($penyerahanSk->foto_penyerahan);
        }

        // Store new file
        $path = $request->file('foto_penyerahan')->store('penyerahan-sk', 'public');

        // Update record
        $penyerahanSk->update([
            'foto_penyerahan' => $path
        ]);

        return response()->json([
            'success' => true,
            'path' => Storage::url($path)
        ]);
    }
}
