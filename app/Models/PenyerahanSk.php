<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyerahanSk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penyerahan_sk';

    protected $fillable = [
        'personal_data_id',
        'penerimaan_sk_id',
        'no_sk_izin',
        'tanggal_terbit',
        'tanggal_penyerahan',
        'petugas_menyerahkan',
        'pemohon_menerima',
        'foto_penyerahan',
        'status',
        'keterangan'
    ];

    protected $dates = [
        'tanggal_terbit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function personalData()
    {
        return $this->belongsTo(PersonalData::class);
    }

    public function penerimaanSk()
    {
        return $this->belongsTo(\App\Models\PenerimaanSk::class);
    }
}
