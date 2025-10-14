<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisIzin;
use App\Models\Persyaratan;

class JenisIzinSeeder extends Seeder
{
    public function run()
    {
        $izinNIB = JenisIzin::create(['nama_izin' => 'Izin Penerbitan NIB (Nomor Induk Berusaha)']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => ' KTP']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => 'Email Aktif']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => 'Nomor HP']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => 'NPWP (Jika Ada)']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => 'BPJS Kesehatan/Ketenagakerjaan']);
        Persyaratan::create(['jenis_izin_id' =>  $izinNIB->id, 'nama_persyaratan' => 'Luas Usaha Kurang Dari 100 m2']);

        // $izinKeramaian = JenisIzin::create(['nama_izin' => 'Izin Keramaian']);
        // Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Fotokopi KK']);
        // Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Surat Keterangan Domisili']);
        // Persyaratan::create(['jenis_izin_id' => $izinKeramaian->id, 'nama_persyaratan' => 'Surat Rekomendasi Kepolisian']);
    }
}
