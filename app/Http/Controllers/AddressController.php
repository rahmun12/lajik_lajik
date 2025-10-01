<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $kabupatenKota = [
        ['id' => '3519', 'name' => 'KABUPATEN MAGETAN']
    ];

    private $kecamatans = [
        ['id' => '3519010', 'kabupaten_id' => '3519', 'name' => 'PONCOL'],
        ['id' => '3519020', 'kabupaten_id' => '3519', 'name' => 'PARANG'],
        ['id' => '3519030', 'kabupaten_id' => '3519', 'name' => 'LEMBEYAN'],
        ['id' => '3519040', 'kabupaten_id' => '3519', 'name' => 'TAKERAN'],
        ['id' => '3519050', 'kabupaten_id' => '3519', 'name' => 'KAWEDANAN'],
        ['id' => '3519060', 'kabupaten_id' => '3519', 'name' => 'MAGETAN'],
        ['id' => '3519070', 'kabupaten_id' => '3519', 'name' => 'NGUNTORONADI'],
        ['id' => '3519080', 'kabupaten_id' => '3519', 'name' => 'SIDOREJO'],
        ['id' => '3519090', 'kabupaten_id' => '3519', 'name' => 'PANEKAN'],
        ['id' => '3519100', 'kabupaten_id' => '3519', 'name' => 'SUKOMORO'],
        ['id' => '3519110', 'kabupaten_id' => '3519', 'name' => 'BENDO'],
        ['id' => '3519120', 'kabupaten_id' => '3519', 'name' => 'MAOSPATI'],
        ['id' => '3519130', 'kabupaten_id' => '3519', 'name' => 'KARANGREJO'],
        ['id' => '3519140', 'kabupaten_id' => '3519', 'name' => 'KARAS'],
        ['id' => '3519150', 'kabupaten_id' => '3519', 'name' => 'BARAT'],
        ['id' => '3519160', 'kabupaten_id' => '3519', 'name' => 'KARTOHARJO'],
        ['id' => '3519170', 'kabupaten_id' => '3519', 'name' => 'NGARIBOYO'],
        ['id' => '3519180', 'kabupaten_id' => '3519', 'name' => 'NGUNTORONADI'],
        ['id' => '3519190', 'kabupaten_id' => '3519', 'name' => 'SIDOREJO'],
    ];

    private $kelurahans = [
        // Kecamatan MAGETAN (id: 3519060)
        ['id' => '3519060001', 'kecamatan_id' => '3519060', 'kode_pos' => '63314', 'name' => 'MAGETAN'],
        ['id' => '3519060002', 'kecamatan_id' => '3519060', 'kode_pos' => '63314', 'name' => 'TAMBAKREJO'],
        ['id' => '3519060003', 'kecamatan_id' => '3519060', 'kode_pos' => '63314', 'name' => 'PURWOSARI'],
        ['id' => '3519060004', 'kecamatan_id' => '3519060', 'kode_pos' => '63314', 'name' => 'KARANGTENGAH'],
        
        // Kecamatan MAOSPATI (id: 3519120)
        ['id' => '3519120001', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'MAOSPATI'],
        ['id' => '3519120002', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'KLAGEN GAMBIR'],
        ['id' => '3519120003', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'NGUJUNG'],
        
        // Kecamatan KARANGREJO (id: 3519130)
        ['id' => '3519130001', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'KARANGREJO'],
        ['id' => '3519130002', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'MANISREJO'],
        ['id' => '3519130003', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'BALEREJO'],
    ];

    public function getKabupatenKota()
    {
        return response()->json($this->kabupatenKota);
    }

    public function getKecamatan($kabupatenId)
    {
        $filtered = collect($this->kecamatans)
            ->where('kabupaten_id', $kabupatenId)
            ->values();
            
        return response()->json($filtered);
    }

    public function getKelurahan($kecamatanId)
    {
        $filtered = array_filter($this->kelurahans, function($item) use ($kecamatanId) {
            return $item['kecamatan_id'] === $kecamatanId;
        });

        $result = [];
        foreach ($filtered as $kelurahan) {
            $result[] = [
                'id' => $kelurahan['id'],
                'name' => $kelurahan['name'],
                'kode_pos' => $kelurahan['kode_pos']
            ];
        }
            
        return response()->json($result);
    }
}
