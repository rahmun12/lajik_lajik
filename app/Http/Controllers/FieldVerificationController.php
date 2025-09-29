<?php

namespace App\Http\Controllers;

use App\Models\FieldVerification;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldVerificationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:personal_data,id',
            'field' => 'required|string',
            'is_verified' => 'required|boolean',
        ]);

        $fieldVerification = FieldVerification::updateOrCreate(
            [
                'personal_data_id' => $request->item_id,
                'field_name' => $request->field,
            ],
            [
                'is_verified' => $request->is_verified,
                'verified_by' => Auth::id(),
                'verified_at' => $request->is_verified ? now() : null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi berhasil diperbarui',
            'data' => $fieldVerification
        ]);
    }
}
