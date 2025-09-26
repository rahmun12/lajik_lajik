<?php
namespace App\Http\Controllers;

use App\Models\IzinPengajuan;
use App\Models\JenisIzin;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinPengajuanController extends Controller
{
    public function create()
    {
        $personalData = PersonalData::where('user_id', Auth::id())->first();
        $jenisIzin = JenisIzin::with('persyaratans')->get();

        if (!$personalData) {
            return redirect()->route('personal_data.create')->with('error', 'Isi data diri terlebih dahulu.');
        }

        return view('izin_pengajuan.create', compact('personalData','jenisIzin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin_id' => 'required|exists:jenis_izins,id',
        ]);

        $personalData = PersonalData::where('user_id', Auth::id())->first();

        IzinPengajuan::create([
            'user_id' => Auth::id(),
            'personal_data_id' => $personalData->id,
            'jenis_izin_id' => $request->jenis_izin_id,
            'status' => 'pending',
        ]);

        return redirect()->route('izin_pengajuan.create')->with('success','Pengajuan izin berhasil dikirim.');
    }
}
