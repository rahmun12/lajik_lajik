<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getRegencies($provinceId)
    {
        $regencies = Regency::where('province_id', $provinceId)->get();
        return response()->json($regencies);
    }

    public function getDistricts($regencyId)
    {
        $districts = District::where('regency_id', $regencyId)->get();
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }
}
