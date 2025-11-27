<?php

namespace App\Http\Controllers;

use App\Models\IzinPengajuan;
use App\Models\PersonalData;
use App\Models\JenisIzin;
use App\Models\FieldVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Services\LocationService;

class PersonalDataController extends Controller
{
    public function create()
    {
        $jenisIzins = JenisIzin::all();
        return view('personal_data', compact('jenisIzins'));
    }

    public function store(Request $request)
    {
        // 1) VALIDASI terlebih dahulu (agar tidak membuka transaksi lalu gagal karena validasi)
        $rules = [
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
        ];

        $messages = [
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
        ];

        try {
            $validated = $request->validate($rules, $messages);
        } catch (ValidationException $ve) {
            // biarkan laravel meng-handle redirect dengan errors + old input
            throw $ve;
        }

        // 2) Mulai transaksi DB setelah validasi berhasil
        DB::beginTransaction();

        try {
            // jika belum auth -> buat guest (firstOrCreate untuk mencegah duplikasi)
            if (!Auth::check()) {
                $user = \App\Models\User::firstOrCreate(
                    ['email' => 'guest@example.com'],
                    [
                        'name' => 'Guest User',
                        'password' => bcrypt(Str::random(16)),
                        'role' => 'guest'
                    ]
                );

                Auth::login($user);
            }

            // 3) Handle file uploads dengan Storage (disk 'public')
            $fotoKtpPath = null;
            $fotoKkPath = null;

            if ($request->hasFile('foto_ktp')) {
                $ktpPath = 'ktp_photos/' . date('Y/m/d');
                $fotoKtpPath = $request->file('foto_ktp')->store($ktpPath, 'public');
            }

            if ($request->hasFile('foto_kk')) {
                $kkPath = 'kk_photos/' . date('Y/m/d');
                $fotoKkPath = $request->file('foto_kk')->store($kkPath, 'public');
            }

            // optional 'pendukung'
            $pendukungPath = null;
            if ($request->hasFile('pendukung')) {
                $pendukungPath = $request->file('pendukung')->store('pendukung_photos/' . date('Y/m/d'), 'public');
            }

            // 4) Simpan personal data
            $data = $request->only([
                'nama',
                'alamat_jalan',
                'rt',
                'rw',
                'kabupaten_kota',
                'kecamatan',
                'kelurahan',
                'kode_pos',
                'no_telp',
                'no_ktp',
                'no_kk'
            ]);

            $data['user_id'] = Auth::id();
            $data['foto_ktp'] = $fotoKtpPath;
            $data['foto_kk'] = $fotoKkPath;
            if ($pendukungPath) $data['pendukung'] = $pendukungPath;

            $personalData = PersonalData::create($data);

            // 5) Buat record pengajuan izin
            $izin = IzinPengajuan::create([
                'user_id' => $data['user_id'],
                'personal_data_id' => $personalData->id,
                'jenis_izin_id' => $request->jenis_izin,
                'status' => 'pending'
            ]);

            // Commit transaksi
            DB::commit();

            // 6) Kirim notifikasi Telegram setelah commit
            try {
                $telegramService = new TelegramService();
                $locationService = new LocationService();
                $wibTime = Carbon::now('Asia/Jakarta');
                $jenisIzin = JenisIzin::find($request->jenis_izin);

                $kecamatanName = $locationService->getKecamatanName($personalData->kecamatan);
                $kelurahanName = $locationService->getKelurahanName($personalData->kelurahan);

                $message = "📢 *PENGAJUAN IZIN BARU*\n\n" .
                    "📅 Tanggal: " . $wibTime->translatedFormat('l, d F Y') . "\n" .
                    "🕒 Waktu: " . $wibTime->format('H:i:s') . " WIB\n" .
                    "👤 Nama: " . $personalData->nama . "\n" .
                    "🏠 Alamat: " . $personalData->alamat_jalan .
                    (($personalData->rt || $personalData->rw) ?
                        " RT " . $personalData->rt .
                        "/RW " . $personalData->rw . "\n" : "\n") .
                    "🏘️ Desa/Kel: " . $kelurahanName . "\n" .
                    "🏙️ Kecamatan: " . $kecamatanName . "\n" .
                    "📱 No HP: " . $personalData->no_telp . "\n" .
                    "📋 Jenis Izin: " . ($jenisIzin ? $jenisIzin->nama_izin : '-') . "\n\n" .
                    "Segera lakukan verifikasi data pengajuan ini.";

                $telegramService->sendNotification($message);
            } catch (\Exception $e) {
                Log::error('Failed to send Telegram notification: ' . $e->getMessage());
            }

            // 7) Redirect sukses (mengikuti alert blade yang sudah ada)
            $jenisIzinName = $jenisIzin ? $jenisIzin->nama_izin : '';
            return redirect()->back()->with([
                'success' => 'Terima kasih, ' . $personalData->nama . '!',
                'message' => 'Pengajuan izin ' . $jenisIzinName . ' Anda berhasil dikirim. Kami akan segera memproses permohonan Anda. Nomor pengajuan Anda adalah #' . $personalData->id . '.'
            ]);
        } catch (\Exception $e) {
            // rollback kalau ada error
            DB::rollBack();

            // jika file sudah tersimpan, kita tidak otomatis hapus semuanya di sini
            // (opsional: hapus file hasil upload untuk menjaga konsistensi)
            try {
                if (!empty($fotoKtpPath) && Storage::disk('public')->exists($fotoKtpPath)) {
                    Storage::disk('public')->delete($fotoKtpPath);
                }
                if (!empty($fotoKkPath) && Storage::disk('public')->exists($fotoKkPath)) {
                    Storage::disk('public')->delete($fotoKkPath);
                }
                if (!empty($pendukungPath) && Storage::disk('public')->exists($pendukungPath)) {
                    Storage::disk('public')->delete($pendukungPath);
                }
            } catch (\Exception $inner) {
                Log::warning('Failed to cleanup uploaded files after error: ' . $inner->getMessage());
            }

            // Log error detail untuk debugging
            Log::error('Error storing personal data: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect kembali dengan pesan error yang ramah user
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->with('message', config('app.debug') ? $e->getMessage() : null);
        }
    }

    /**
     * Display the admin view for reviewing and approving personal data
     */
    public function penyesuaianData()
    {
        try {
            $data = PersonalData::with([
                'izinPengajuan' => function ($query) {
                    // bila model IzinPengajuan memakai SoftDeletes, withTrashed() bisa dipakai di relation
                    $query->withTrashed()->with(['jenisIzin.persyaratans' => function($q) {
                        $q->withTrashed();
                    }]);
                },
                'fieldVerifications',
                'penerimaanSk',
                'serahTerima',
                'user'
            ])->orderBy('created_at', 'desc')->get();

            if ($data->isNotEmpty()) {
                Log::info('First personal data item:', [
                    'id' => $data->first()->id,
                    'izin_pengajuan_count' => optional($data->first()->izinPengajuan)->count() ?? 0,
                    'has_penerimaan_sk' => $data->first()->penerimaanSk ? 'yes' : 'no',
                    'has_serah_terima' => $data->first()->serahTerima ? 'yes' : 'no'
                ]);
            }

            return view('penyesuaian_data', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in penyesuaianData: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan: ' . ($e->getMessage()));
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

        if (!$request->hasFile('document')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang diunggah'
            ], 400);
        }

        try {
            // Hapus file lama jika ada
            $oldFile = $personalData->{$fieldMap[$request->doc_type]} ?? null;
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            // Simpan file baru
            $path = $request->file('document')->store('documents/' . date('Y/m/d'), 'public');

            // Update personal data dan field verification
            $personalData->{$fieldMap[$request->doc_type]} = $path;
            $personalData->save();

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
        } catch (\Exception $e) {
            Log::error('uploadDocument error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload dokumen',
                'detail' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
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
