<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldVerification extends Model
{
    protected $fillable = [
        'personal_data_id',
        'field_name',
        'is_verified',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function personalData(): BelongsTo
    {
        return $this->belongsTo(PersonalData::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
