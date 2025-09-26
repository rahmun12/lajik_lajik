<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinPengajuan extends Model
{
    protected $table = 'izin_pengajuan';
    
    protected $fillable = ['user_id','personal_data_id','jenis_izin_id','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalData()
    {
        return $this->belongsTo(PersonalData::class);
    }

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class);
    }
}
