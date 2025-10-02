<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\IzinPengajuan;
use App\Models\JenisIzin;
use App\Models\FieldVerification;
use App\Models\SerahTerima;
use App\Models\PenerimaanSk;

class PersonalData extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'nama',
        'alamat_jalan',
        'rt',
        'rw',
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'no_telp',
        'no_ktp',
        'no_kk',
        'foto_ktp',
        'foto_kk',
        'pendukung',
        'foto_selfie_ktp',
        'is_verified',
        'verification_notes',
        'verified_by',
        'verified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the izin pengajuan for the personal data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get the izin pengajuan for the personal data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function izinPengajuan()
    {
        return $this->hasMany(IzinPengajuan::class, 'personal_data_id', 'id')
            ->withTrashed()
            ->with(['jenisIzin' => function ($query) {
                $query->withTrashed();
            }]);
    }

    /**
     * Get the field verifications for the personal data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fieldVerifications()
    {
        return $this->hasMany(FieldVerification::class, 'personal_data_id', 'id');
    }

    public function getFieldVerificationStatus($fieldName)
    {
        $verification = $this->fieldVerifications->firstWhere('field_name', $fieldName);
        return $verification ? $verification->is_verified : false;
    }

    /**
     * Get the serah terima associated with the personal data.
     */
    /**
     * Get the serah terima for the personal data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function serahTerima()
    {
        return $this->hasOne(SerahTerima::class, 'personal_data_id', 'id');
    }

    /**
     * Get the jenis izin associated with the personal data through izin pengajuan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    /**
     * Get the jenis izin through izin pengajuan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function jenisIzin()
    {
        return $this->hasOneThrough(
            JenisIzin::class,
            IzinPengajuan::class,
            'personal_data_id', // Foreign key on izin_pengajuan table
            'id', // Foreign key on jenis_izin table
            'id', // Local key on personal_data table
            'jenis_izin_id' // Local key on izin_pengajuan table
        )->latest('izin_pengajuan.created_at');
    }

    /**
     * Get the penerimaanSk associated with the PersonalData
     */
    /**
     * Get the penerimaan SK for the personal data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penerimaanSk()
    {
        return $this->hasOne(PenerimaanSk::class, 'personal_data_id', 'id')
            ->withTrashed();
    }
}
