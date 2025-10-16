<?php

namespace App\Http\Controllers;

use App\Models\IzinPengajuan;
use App\Models\JenisIzin;
use App\Models\PersonalData;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IzinPengajuanController extends Controller
{
    public function create()
    {
        $personalData = PersonalData::where('user_id', Auth::id())->first();
        $jenisIzin = JenisIzin::with('persyaratans')->get();

        if (!$personalData) {
            return redirect()->route('personal_data.create')->with('error', 'Isi data diri terlebih dahulu.');
        }

        return view('izin_pengajuan.create', compact('personalData', 'jenisIzin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin_id' => 'required|exists:jenis_izins,id',
        ]);

        $personalData = PersonalData::where('user_id', Auth::id())->first();
        $jenisIzin = JenisIzin::find($request->jenis_izin_id);

        $pengajuan = IzinPengajuan::create([
            'user_id' => Auth::id(),
            'personal_data_id' => $personalData->id,
            'jenis_izin_id' => $request->jenis_izin_id,
            'status' => 'pending',
        ]);

        // Send Telegram notification
        $telegramService = new TelegramService();
        $wibTime = Carbon::now('Asia/Jakarta');
        $message = "📢 *PENGAJUAN IZIN BARU*\n\n" .
                  "📅 Tanggal: " . $wibTime->translatedFormat('l, d F Y') . "\n" .
                  "🕒 Waktu: " . $wibTime->format('H:i:s') . " WIB\n" .
                  "👤 Nama: " . $personalData->nama . "\n" .
                  "🏠 Alamat: " . $personalData->alamat_jalan . "\n" .
                  "📋 Jenis Izin: " . $jenisIzin->nama_izin . "\n\n" .
                  "Segera lakukan verifikasi data pengajuan ini.";

        $telegramService->sendNotification($message);

        return redirect()->route('izin_pengajuan.create')
            ->with('success', 'Pengajuan izin berhasil dikirim. Notifikasi telah dikirim ke admin.');
    }
}
