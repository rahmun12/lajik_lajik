<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $fillable = [
        'user_id', 'nama', 'alamat_jalan', 'rt', 'rw',
        'kecamatan', 'kelurahan', 'kode_pos', 'no_telp',
        'no_ktp', 'no_kk', 'foto_ktp', 'foto_kk'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
