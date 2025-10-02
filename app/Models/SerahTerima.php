<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SerahTerima extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'serah_terima';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'personal_data_id',
        'jenis_izin_id',
        'foto_berkas',
        'petugas_menyerahkan',
        'petugas_menerima',
        'waktu_serah_terima'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_serah_terima' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     * @var array
     */
    protected $dates = [
        'waktu_serah_terima',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be set to null when empty.
     *
     * @var array
     */
    protected $nullable = [
        'jenis_izin_id',
        'foto_berkas',
        'petugas_menyerahkan',
        'petugas_menerima',
        'waktu_serah_terima'
    ];

    /**
     * Set the jenis_izin_id attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setJenisIzinIdAttribute($value)
    {
        $this->attributes['jenis_izin_id'] = $value ?: null;
    }

    /**
     * Get the personal data associated with the handover.
     */
    public function personalData()
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id');
    }

    /**
     * Get the jenis izin associated with the handover.
     */
    public function jenisIzin(): BelongsTo
    {
        return $this->belongsTo(JenisIzin::class);
    }
}
