<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PenerimaanSk;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RegularUserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the regular users.
     */
    public function index()
    {
        $penerimaanSk = PenerimaanSk::with('personalData')
            ->latest()
            ->paginate(10);

        // Debug: Log the data being passed to the view
        \Log::info('Penerimaan SK Data: ' . json_encode($penerimaanSk->toArray()));

        return view('admin.users.regular.index', [
            'penerimaanSk' => $penerimaanSk
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $personalData = null;

        if (request()->has('personal_data_id')) {
            $personalData = \App\Models\PersonalData::find(request('personal_data_id'));

            if (!$personalData) {
                return redirect()->route('admin.users.regular.index')
                    ->with('error', 'Data pemohon tidak ditemukan');
            }

            // Check if this personal data already has a penerimaan_sk
            if ($personalData->penerimaanSk()->exists()) {
                return redirect()->route('admin.users.regular.index')
                    ->with('error', 'Pemohon ini sudah memiliki data penerimaan SK');
            }
        } else {
            return redirect()->route('admin.users.regular.index')
                ->with('error', 'ID Pemohon tidak valid');
        }

        return view('admin.users.regular.create', compact('personalData'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'personal_data_id' => ['required', 'exists:personal_data,id'],
            'no_sk_izin' => ['required', 'string', 'max:100'],
            'tanggal_terbit' => ['required', 'date'],
            'tanggal_penerimaan' => ['required', 'date', 'after_or_equal:tanggal_terbit'],
            'alamat_penerimaan' => ['required', 'string', 'max:255'],
            'petugas_menyerahkan' => ['required', 'string', 'max:100'],
            'petugas_menerima' => ['required', 'string', 'max:100'],
        ]);

        PenerimaanSk::create($validated);

        return redirect()->route('admin.users.regular.index')
            ->with('success', 'Data penerimaan SK berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $penerimaanSk = PenerimaanSk::findOrFail($id);
        return view('admin.users.regular.edit', compact('penerimaanSk'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $penerimaanSk = PenerimaanSk::findOrFail($id);

        $validated = $request->validate([
            'no_sk_izin' => ['required', 'string', 'max:100'],
            'petugas_menyerahkan' => ['required', 'string', 'max:100'],
            'petugas_menerima' => ['required', 'string', 'max:100'],
            'personal_data_id' => ['required', 'exists:personal_data,id']
        ]);

        // Set tanggal_penerimaan to current date if not provided
        $validated['tanggal_penerimaan'] = now();

        $penerimaanSk->update($validated);

        return redirect()->route('admin.users.regular.index')
            ->with('success', 'Data penerimaan SK berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $penerimaanSk = \App\Models\PenerimaanSk::findOrFail($id);
        $penerimaanSk->delete();

        return redirect()->route('admin.users.regular.index')
            ->with('success', 'Data penerimaan SK berhasil dihapus');
    }
}
