<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IzinPengajuan extends Model
{
    use SoftDeletes;
    
    protected $table = 'izin_pengajuan';
    
    protected $fillable = ['user_id', 'personal_data_id', 'jenis_izin_id', 'status'];
    
    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the izin pengajuan.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the personal data that owns the izin pengajuan.
     */
    public function personalData()
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id')->withTrashed();
    }

    /**
     * Get the jenis izin for the izin pengajuan.
     */
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id')->withTrashed();
    }
}
