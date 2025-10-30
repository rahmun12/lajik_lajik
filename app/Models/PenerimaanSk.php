<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanSk extends Model
{
    use SoftDeletes;

    protected $table = 'penerimaan_sk';

    protected $fillable = [
        'personal_data_id',
        'no_sk_izin',
        'tanggal_terbit',
        'tanggal_penerimaan',
        'alamat_penerimaan',
        'petugas_menyerahkan',
        'petugas_menerima'
    ];

    protected $dates = [
        'tanggal_terbit',
        'tanggal_penerimaan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_penerimaan' => 'date',
    ];

    /**
     * Get the personal data that owns the penerimaan SK.
     */
    public function personalData()
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id')
            ->withTrashed()
            ->withDefault([
                'nama' => 'N/A',
            ]);
    }
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id')
            ->withTrashed();
    }
    /**
     * Get the penyerahan SK associated with the penerimaan SK.
     */
    public function penyerahanSk()
    {
        return $this->hasOne(\App\Models\PenyerahanSk::class, 'penerimaan_sk_id');
    }
}
