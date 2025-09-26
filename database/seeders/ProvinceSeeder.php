<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel terlebih dahulu
        DB::table('provinces')->truncate();
        
        // Path ke file JSON
        $json = File::get(database_path('data/wilayah/provinces.json'));
        $provinces = json_decode($json, true);
        
        foreach ($provinces as $province) {
            Province::create([
                'id' => $province['id'],
                'name' => $province['name'],
            ]);
        }
    }
}
