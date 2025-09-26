<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    protected $fillable = ['nama_izin','deskripsi'];

    public function persyaratans()
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function pengajuans()
    {
        return $this->hasMany(IzinPengajuan::class);
    }
}
