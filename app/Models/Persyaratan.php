<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $fillable = ['jenis_izin_id','nama_persyaratan'];

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class);
    }
}
