<?php

namespace App\Http\Controllers;

use App\Models\IzinPengajuan;
use Illuminate\Support\Facades\Log;
use App\Models\PersonalData;
use App\Models\JenisIzin;
use App\Models\FieldVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\TelegramService;
use Carbon\Carbon;

class PersonalDataController extends Controller
{
    public function create()
    {
        $jenisIzins = JenisIzin::all();
        return view('personal_data', compact('jenisIzins'));
    }

    public function store(Request $request)
    {
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Validation rules
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'alamat_jalan' => 'required|string|max:255',
                'rt' => 'nullable|string|max:10',
                'rw' => 'nullable|string|max:10',
                'kabupaten_kota' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'kelurahan' => 'required|string|max:100',
                'kode_pos' => 'nullable|string|max:5',
                'no_telp' => 'nullable|string|max:20',
                'no_ktp' => 'nullable|string|size:16',
                'no_kk' => 'nullable|string|size:16',
                'jenis_izin' => 'required|exists:jenis_izins,id',
                'foto_ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'foto_kk' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'pendukung' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                
            ], [
                'kode_pos.max' => 'Kode pos maksimal 5 karakter',
                'no_ktp.size' => 'Nomor KTP harus 16 digit',
                'no_kk.size' => 'Nomor KK harus 16 digit',
                'foto_ktp.required' => 'Foto KTP wajib diunggah',
                'foto_kk.required' => 'Foto KK wajib diunggah',
                'foto_ktp.mimes' => 'Format file harus JPG, JPEG, atau PNG',
                'foto_kk.mimes' => 'Format file harus JPG, JPEG, atau PNG',
                'foto_ktp.max' => 'Ukuran file maksimal 2MB',
                'foto_kk.max' => 'Ukuran file maksimal 2MB',
                'pendukung.max' => 'Ukuran file maksimal 2MB',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                // If not authenticated, create a guest user
                $user = \App\Models\User::firstOrCreate(
                    ['email' => 'guest@example.com'],
                    [
                        'name' => 'Guest User',
                        'password' => bcrypt(Str::random(16)),
                        'role' => 'guest'
                    ]
                );
                
                // Log in the user
                Auth::login($user);
            }

            // Handle file uploads
            $ktpPath = 'ktp_photos/' . date('Y/m/d');
            $kkPath = 'kk_photos/' . date('Y/m/d');
            
            // Upload KTP
            $fotoKtpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $fotoKtpPath = $request->file('foto_ktp')->store($ktpPath, 'public');
            }
            
            // Upload KK
            $fotoKkPath = null;
            if ($request->hasFile('foto_kk')) {
                $fotoKkPath = $request->file('foto_kk')->store($kkPath, 'public');
            }
            
            // Save personal data
            $data = $request->only([
                'nama', 'alamat_jalan', 'rt', 'rw', 
                'kabupaten_kota', 'kecamatan', 'kelurahan', 'kode_pos',
                'no_telp', 'no_ktp', 'no_kk'
            ]);
            
            $data['user_id'] = Auth::id();
            $data['foto_ktp'] = $fotoKtpPath;
            $data['foto_kk'] = $fotoKkPath;
            
            // Create personal data
            $personalData = PersonalData::create($data);
            
            // Create izin pengajuan
            IzinPengajuan::create([
                'user_id' => $data['user_id'],
                'personal_data_id' => $personalData->id,
                'jenis_izin_id' => $request->jenis_izin,
                'status' => 'pending'
            ]);
            
            // Commit the transaction
            DB::commit();

            // Send Telegram notification
            try {
                $telegramService = new TelegramService();
                $wibTime = Carbon::now('Asia/Jakarta');
                $message = "📢 *PENGAJUAN IZIN BARU*\n\n" .
                          "📅 Tanggal: " . $wibTime->translatedFormat('l, d F Y') . "\n" .
                          "🕒 Waktu: " . $wibTime->format('H:i:s') . " WIB\n" .
                          "👤 Nama: " . $personalData->nama . "\n" .
                          "🏠 Alamat: " . $personalData->alamat_jalan . 
                          (($personalData->rt || $personalData->rw) ? 
                              " RT " . $personalData->rt . 
                              "/RW " . $personalData->rw . "\n" : "\n") .
                          "📋 Jenis Izin: " . JenisIzin::find($request->jenis_izin)->nama_izin . "\n\n" .
                          "Segera lakukan verifikasi data pengajuan ini.";

                $telegramService->sendNotification($message);
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Illuminate\Support\Facades\Log::error('Failed to send Telegram notification: ' . $e->getMessage());
            }

            // Get the jenis izin name for the success message
            $jenisIzin = JenisIzin::find($request->jenis_izin);
            
            // Always redirect back to the form page with success message (removed admin check)
            return redirect()->back()
                ->with([
                    'success' => 'Terima kasih, ' . $request->nama . '!',
                    'message' => 'Pengajuan izin ' . ($jenisIzin ? $jenisIzin->nama_izin : '') . ' Anda berhasil dikirim. Kami akan segera memproses permohonan Anda. Nomor pengajuan Anda adalah #' . $personalData->id . '.'
                ]);
            
        } catch (\Exception $e) {
            // Rollback the transaction on error
            // DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the admin view for reviewing and approving personal data
     */
    public function penyesuaianData()
    {
        try {
            // Get all personal data with their related data
            $data = PersonalData::with([
                'izinPengajuan' => function($query) {
                    $query->withTrashed()
                          ->with(['jenisIzin' => function($q) {
                              $q->withTrashed();
                          }]);
                },
                'fieldVerifications',
                'penerimaanSk',
                'serahTerima'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
            // Debug: Log the first item's data
            if ($data->isNotEmpty()) {
                Log::info('First personal data item:', [
                    'id' => $data->first()->id,
                    'izin_pengajuan_count' => $data->first()->izinPengajuan ? $data->first()->izinPengajuan->count() : 0,
                    'has_penerimaan_sk' => $data->first()->penerimaanSk ? 'yes' : 'no',
                    'has_serah_terima' => $data->first()->serahTerima ? 'yes' : 'no'
                ]);
            }
            
            return view('penyesuaian_data', compact('data'));
            
        } catch (\Exception $e) {
            Log::error('Error in penyesuaianData: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the verification status of personal data
     */
    public function updateVerification(Request $request, $id)
    {
        $request->validate([
            'is_verified' => 'required|boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        $personalData = PersonalData::findOrFail($id);
        $personalData->is_verified = $request->is_verified;
        $personalData->verification_notes = $request->notes;
        $personalData->verified_by = Auth::id();
        $personalData->verified_at = now();
        $personalData->save();

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi berhasil diperbarui',
            'data' => $personalData
        ]);
    }

    /**
     * Verify a specific requirement for personal data
     */
    public function verifyRequirement(Request $request)
    {
        $request->validate([
            'personal_data_id' => 'required|exists:personal_data,id',
            'field_name' => 'required|string',
            'is_verified' => 'required|boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        $verification = FieldVerification::updateOrCreate(
            [
                'personal_data_id' => $request->personal_data_id,
                'field_name' => $request->field_name
            ],
            [
                'is_verified' => $request->is_verified,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'notes' => $request->notes
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi persyaratan berhasil diperbarui',
            'data' => $verification
        ]);
    }

    /**
     * Handle document upload for personal data
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:personal_data,id',
            'doc_type' => 'required|in:ktp,kk,selfie',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:1000'
        ]);

        $personalData = PersonalData::findOrFail($request->id);
        $fieldMap = [
            'ktp' => 'foto_ktp',
            'kk' => 'foto_kk',
            'selfie' => 'foto_selfie_ktp'
        ];

        // Handle file upload
        if ($request->hasFile('document')) {
            // Delete old file if exists
            $oldFile = $personalData->{$fieldMap[$request->doc_type]};
            if ($oldFile && file_exists(storage_path('app/public/' . $oldFile))) {
                unlink(storage_path('app/public/' . $oldFile));
            }

            // Store new file
            $path = $request->file('document')->store('documents', 'public');
            
            // Update personal data with new file path
            $personalData->{$fieldMap[$request->doc_type]} = $path;
            $personalData->save();

            // Update or create field verification
            FieldVerification::updateOrCreate(
                [
                    'personal_data_id' => $personalData->id,
                    'field_name' => $request->doc_type
                ],
                [
                    'is_verified' => true,
                    'verified_by' => Auth::id(),
                    'verified_at' => now(),
                    'notes' => $request->notes
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'data' => [
                    'id' => $personalData->id,
                    'document_path' => $path,
                    'document_url' => asset('storage/' . $path)
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupload dokumen'
        ], 400);
    }

    /**
     * Toggle requirement verification status
     */
    public function toggleRequirementVerification(Request $request)
    {
        $request->validate([
            'personal_data_id' => 'required|exists:personal_data,id',
            'field_name' => 'required|string',
            'is_verified' => 'required|boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        $verification = FieldVerification::updateOrCreate(
            [
                'personal_data_id' => $request->personal_data_id,
                'field_name' => $request->field_name
            ],
            [
                'is_verified' => $request->is_verified,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'notes' => $request->notes
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi persyaratan berhasil diperbarui',
            'data' => $verification
        ]);
    }
}
