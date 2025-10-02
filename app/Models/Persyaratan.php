<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persyaratan extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['jenis_izin_id', 'nama_persyaratan'];
    
    protected $dates = ['deleted_at'];

    /**
     * Get the jenis izin that owns the persyaratan.
     */
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class)->withTrashed();
    }
}
