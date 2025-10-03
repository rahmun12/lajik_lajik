<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalData;
use App\Models\PenerimaanSk;
use App\Models\IzinPengajuan;
use App\Models\JenisIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenerimaanSkController extends Controller
{
    public function index()
    {
        try {
            $penerimaanSks = PenerimaanSk::with([
                'personalData' => function ($query) {
                    $query->withTrashed();
                },
                'personalData.izinPengajuan' => function ($query) {
                    $query->withTrashed()
                        ->with(['jenisIzin' => function ($q) {
                            $q->withTrashed();
                        }]);
                }
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Debug data
            // dd($penerimaanSks->toArray());

            $totalPersonalData = PersonalData::withTrashed()->count();
            $verifiedPersonalData = PersonalData::withTrashed()->where('is_verified', 1)->count();
            $withPenerimaanSk = PenerimaanSk::count();

            // Log first item for debugging
            if ($penerimaanSks->count() > 0) {
                $first = $penerimaanSks->first();
                Log::info('Penerimaan SK First Item:', [
                    'penerimaan_sk' => $first->toArray(),
                    'personal_data' => $first->personalData ? $first->personalData->toArray() : null,
                    'izin_pengajuan' => $first->personalData && $first->personalData->izinPengajuan ?
                        $first->personalData->izinPengajuan->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'jenis_izin_id' => $item->jenis_izin_id,
                                'jenis_izin' => $item->jenisIzin ? $item->jenisIzin->toArray() : null
                            ];
                        })->toArray() : []
                ]);
            }

            return view('admin.penerimaan-sk.index', [
                'items' => $penerimaanSks,
                'totalPersonalData' => $totalPersonalData,
                'verifiedPersonalData' => $verifiedPersonalData,
                'withPenerimaanSk' => $withPenerimaanSk
            ]);
        } catch (\Exception $e) {
            Log::error('Error in index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $personalData = PersonalData::where('is_verified', 1)
                ->whereDoesntHave('penerimaanSks')
                ->orderBy('nama', 'asc')
                ->get();

            return view('admin.penerimaan-sk.create', compact('personalData'));
        } catch (\Exception $e) {
            Log::error('Error in create: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'personal_data_id' => 'required|exists:personal_data,id',
                'no_sk_izin' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'petugas_menyerahkan' => 'required|string|max:255',
                'petugas_menerima' => 'required|string|max:255',
            ]);

            // Cek apakah sudah ada data dengan personal_data_id yang sama
            $existingData = PenerimaanSk::where('personal_data_id', $request->personal_data_id)->first();
            if ($existingData) {
                return redirect()->back()->with('error', 'Data untuk pemohon ini sudah ada. Silakan edit data yang sudah ada.');
            }

            // Buat data baru
            $data = new PenerimaanSk();
            $data->personal_data_id = $request->personal_data_id;
            $data->no_sk_izin = $request->no_sk_izin;
            $data->tanggal_terbit = $request->tanggal_terbit;
            $data->petugas_menyerahkan = $request->petugas_menyerahkan;
            $data->petugas_menerima = $request->petugas_menerima;
            $data->save();

            return redirect()->route('admin.penerimaan-sk.index')
                ->with('success', 'Data penerimaan SK berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error in store: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $item = PersonalData::with([
                'penerimaanSks' => function ($query) {
                    $query->withTrashed();
                },
                'jenisIzin'
            ])->findOrFail($id);

            if ($item->penerimaanSks->isEmpty()) {
                return redirect()->route('admin.penerimaan-sk.create')
                    ->with('error', 'Data penerimaan SK belum ada. Silakan tambahkan data terlebih dahulu.');
            }

            return view('admin.penerimaan-sk.show', compact('item'));
        } catch (\Exception $e) {
            Log::error('Error in show: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $penerimaanSk = PenerimaanSk::with('personalData')
                ->findOrFail($id);
            $item = $penerimaanSk->personalData;

            return view('admin.penerimaan-sk.edit', compact('penerimaanSk', 'item'));
        } catch (\Exception $e) {
            Log::error('Error in edit: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'Gagal membuka form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'no_sk_izin' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'petugas_menyerahkan' => 'required|string|max:255',
                'petugas_menerima' => 'required|string|max:255',
            ]);

            $penerimaanSk = PenerimaanSk::findOrFail($id);

            $penerimaanSk->update([
                'no_sk_izin' => $request->no_sk_izin,
                'tanggal_terbit' => $request->tanggal_terbit,
                'petugas_menyerahkan' => $request->petugas_menyerahkan,
                'petugas_menerima' => $request->petugas_menerima,
            ]);

            return redirect()->route('admin.penerimaan-sk.index')
                ->with('success', 'Data penerimaan SK berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error in update: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            // return redirect()->back()
            //     ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
            //     ->withInput();
        }
    }

    public function updateField(Request $request, $id)
    {
        try {
            $request->validate([
                'field' => 'required|in:no_sk_izin,tanggal_terbit,petugas_menyerahkan,petugas_menerima',
                'value' => 'required|string|max:255',
            ]);

            DB::beginTransaction();

            // Cari atau buat record PenerimaanSk
            $penerimaanSk = PenerimaanSk::withTrashed()
                ->where('personal_data_id', $id)
                ->first();

            // Jika tidak ditemukan, buat baru
            if (!$penerimaanSk) {
                $penerimaanSk = new PenerimaanSk();
                $penerimaanSk->personal_data_id = $id;
                $penerimaanSk->save(); // Simpan dulu untuk mendapatkan ID
            } elseif ($penerimaanSk->trashed()) {
                // Restore jika soft deleted
                $penerimaanSk->restore();
            }

            // Update field
            $field = $request->field;
            $penerimaanSk->$field = $request->value;
            $penerimaanSk->save();

            // Jika semua field sudah terisi, update waktu updated_at
            if (
                $penerimaanSk->no_sk_izin && $penerimaanSk->tanggal_terbit &&
                $penerimaanSk->petugas_menyerahkan && $penerimaanSk->petugas_menerima
            ) {
                $penerimaanSk->touch();
            }

            // Muat ulang relasi
            $penerimaanSk->load('personalData');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $penerimaanSk->fresh()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateField: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }
}
