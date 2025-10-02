<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisIzin extends Model
{
    use SoftDeletes;
    
    protected $table = 'jenis_izins';
    
    protected $fillable = ['nama_izin', 'deskripsi'];
    
    protected $dates = ['deleted_at'];

    /**
     * Get the persyaratans for the jenis izin.
     */
    public function persyaratans()
    {
        return $this->hasMany(\App\Models\Persyaratan::class, 'jenis_izin_id')
            ->withTrashed();
    }

    /**
     * Get the izin pengajuans for the jenis izin.
     */
    public function pengajuans()
    {
        return $this->hasMany(\App\Models\IzinPengajuan::class, 'jenis_izin_id')
            ->withTrashed();
    }
    
    /**
     * Get the serah terima associated with the jenis izin.
     */
    public function serahTerima()
    {
        return $this->hasMany(\App\Models\SerahTerima::class, 'jenis_izin_id')
            ->withTrashed();
    }
}