<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        // Sample data for testing
        $jawaTimur = Province::create([
            'id' => '35',
            'name' => 'JAWA TIMUR'
        ]);

        $magetan = Regency::create([
            'id' => '3520',
            'province_id' => '35',
            'name' => 'KABUPATEN MAGETAN'
        ]);

        $kecamatanPlaosan = District::create([
            'id' => '352013',
            'regency_id' => '3520',
            'name' => 'PLAOSAN'
        ]);

        // Add sample villages
        Village::insert([
            ['id' => '3520132001', 'district_id' => '352013', 'name' => 'PLAOSAN'],
            ['id' => '3520132002', 'district_id' => '352013', 'name' => 'SENDANG'],
            ['id' => '3520132003', 'district_id' => '352013', 'name' => 'DURENAN'],
            // Add more villages as needed
        ]);

        // Add more sample data as needed
    }
}
