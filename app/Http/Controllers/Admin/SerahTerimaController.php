<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\SerahTerima;
use App\Models\PersonalData;
use App\Models\JenisIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SerahTerimaController extends Controller
{
    public function uploadDocument(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:personal_data,id',
                'doc_type' => 'required|string|in:foto_berkas',
                'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048' // max 2MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $personalData = PersonalData::findOrFail($request->id);
            $file = $request->file('document');
            $fileName = 'doc_' . time() . '_' . $personalData->id . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage
            $path = $file->storeAs('public/documents', $fileName);

            // Hapus file lama jika ada
            if ($personalData->serahTerima && $personalData->serahTerima->foto_berkas) {
                Storage::delete('public/' . $personalData->serahTerima->foto_berkas);
            }

            // Update atau buat record serah terima
            $serahTerima = $personalData->serahTerima ?? new SerahTerima();
            $serahTerima->personal_data_id = $personalData->id;
            $serahTerima->foto_berkas = 'documents/' . $fileName;
            $serahTerima->save();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diunggah',
                'file_path' => asset('storage/' . $serahTerima->foto_berkas)
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $data = PersonalData::with(['serahTerima', 'jenisIzin'])
                ->where('is_verified', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.serah-terima.index', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in index: ' . $e->getMessage());
            dd($e);
            // return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $personalData = PersonalData::where('is_verified', 1)
                ->whereDoesntHave('serahTerima')
                ->get();

            return view('admin.serah-terima.create', compact('personalData'));
        } catch (\Exception $e) {
            Log::error('Error in create: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'personal_data_id' => 'required|exists:personal_data,id',
                'petugas_menyerahkan' => 'required|string|max:255',
                'petugas_menerima' => 'required|string|max:255',
                'foto_berkas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'required' => 'Field :attribute wajib diisi',
                'image' => 'File harus berupa gambar',
                'mimes' => 'Format file harus jpeg, png, atau jpg',
                'max' => 'Ukuran file maksimal 2MB'
            ]);

            // Handle file upload
            $path = $request->file('foto_berkas')->store('serah-terima', 'public');

            // Create new record
            $serahTerima = new SerahTerima();
            $serahTerima->personal_data_id = $validated['personal_data_id'];
            $serahTerima->petugas_menyerahkan = $validated['petugas_menyerahkan'];
            $serahTerima->petugas_menerima = $validated['petugas_menerima'];
            $serahTerima->foto_berkas = $path;
            $serahTerima->waktu_serah_terima = now();
            $serahTerima->save();

            return redirect()->route('admin.serah-terima.index')
                ->with('success', 'Data serah terima berhasil disimpan');
        } catch (\Exception $e) {
            // Log::error('Error in store: ' . $e->getMessage());
            // return redirect()->back()
            //     ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
            //     ->withInput();
        }
    }

    public function updateField(Request $request, $id)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'field' => 'required|in:petugas_menyerahkan,petugas_menerima,foto_berkas',
                'value' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ]);

            // Start database transaction
            DB::beginTransaction();

            // Find the personal data record
            $personalData = PersonalData::findOrFail($id);

            // Get or create serah terima record
            $serahTerima = $personalData->serahTerima ?: new SerahTerima([
                'personal_data_id' => $id,
                'jenis_izin_id' => $personalData->jenis_izin_id,
                'petugas_menyerahkan' => null,
                'petugas_menerima' => null,
                'foto_berkas' => null,
                'waktu_serah_terima' => null
            ]);

            $field = $validated['field'];

            // Handle file upload if the field is foto_berkas
            if ($field === 'foto_berkas' && $request->hasFile('file')) {
                // Delete old file if exists
                if ($serahTerima->foto_berkas && Storage::disk('public')->exists($serahTerima->foto_berkas)) {
                    Storage::disk('public')->delete($serahTerima->foto_berkas);
                }

                // Store the new file
                $path = $request->file('file')->store('serah-terima', 'public');
                $serahTerima->foto_berkas = $path;
                $message = 'Foto berkas berhasil diunggah';
            } else if ($field !== 'foto_berkas') {
                // For other fields
                $serahTerima->$field = $validated['value'];
                $message = 'Data berhasil diperbarui';
            }

            // Update timestamp if both officers are filled
            if ($serahTerima->petugas_menyerahkan && $serahTerima->petugas_menerima) {
                $serahTerima->waktu_serah_terima = now();
            }

            // Save the changes
            $serahTerima->save();

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message ?? 'Data berhasil diperbarui',
                'data' => [
                    'foto_berkas' => $serahTerima->foto_berkas ? asset('storage/' . $serahTerima->foto_berkas) : null,
                    'petugas_menyerahkan' => $serahTerima->petugas_menyerahkan,
                    'petugas_menerima' => $serahTerima->petugas_menerima,
                    'waktu_serah_terima' => $serahTerima->waktu_serah_terima ?
                        $serahTerima->waktu_serah_terima->format('d/m/Y H:i') : null,
                    'status' => $serahTerima->petugas_menyerahkan && $serahTerima->petugas_menerima ?
                        'Selesai' : 'Belum Selesai'
                ]
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            Log::error('Error in updateField: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $serahTerima = SerahTerima::findOrFail($id);

            // Hapus file jika ada
            if ($serahTerima->foto_berkas && Storage::disk('public')->exists($serahTerima->foto_berkas)) {
                Storage::disk('public')->delete($serahTerima->foto_berkas);
            }

            $serahTerima->delete();

            return redirect()->route('admin.serah-terima.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            // return redirect()->back()
            //     ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
