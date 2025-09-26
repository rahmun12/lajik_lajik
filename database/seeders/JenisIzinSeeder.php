<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisIzin;
use App\Models\Persyaratan;

class JenisIzinSeeder extends Seeder
{
    public function run()
    {
        $izinUsaha = JenisIzin::create(['nama_izin' => 'Izin Usaha']);
        Persyaratan::create(['jenis_izin_id' => $izinUsaha->id, 'nama_persyaratan' => 'Fotokopi KTP']);
        Persyaratan::create(['jenis_izin_id' => $izinUsaha->id, 'nama_persyaratan' => 'Surat Pengantar RT']);
        Persyaratan::create(['jenis_izin_id' => $izinUsaha->id, 'nama_persyaratan' => 'Pas Foto']);

        $izinKeramaian = JenisIzin::create(['nama_izin' => 'Izin Keramaian']);
        Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Fotokopi KK']);
        Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Surat Keterangan Domisili']);
        Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Surat Rekomendasi Kepolisian']);
    }
}
