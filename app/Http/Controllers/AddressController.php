<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $locationService;

    public function __construct(\App\Services\LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getKabupatenKota()
    {
        return response()->json($this->locationService->getAllKabupaten());
    }

    public function getKecamatan($kabupatenId)
    {
        return response()->json($this->locationService->getKecamatanByKabupaten($kabupatenId));
    }

    public function getKelurahan($kecamatanId)
    {
        return response()->json($this->locationService->getKelurahanByKecamatan($kecamatanId));
    }
}