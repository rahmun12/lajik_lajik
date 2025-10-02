<?php

namespace Database\Seeders;

use App\Models\PersonalData;
use App\Models\PenerimaanSk;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenerimaanSkSeeder extends Seeder
{
    public function run()
    {
        // Get some personal data that doesn't have penerimaan_sk yet
        $personalData = PersonalData::whereDoesntHave('penerimaanSk')
            ->take(5)
            ->get();

        if ($personalData->isEmpty()) {
            $this->command->info('No personal data found without penerimaan_sk. Creating sample data...');
            return;
        }

        $now = Carbon::now();
        
        foreach ($personalData as $index => $data) {
            PenerimaanSk::create([
                'personal_data_id' => $data->id,
                'no_sk_izin' => 'SK-' . ($index + 1) . '-' . $now->format('Ymd'),
                'tanggal_terbit' => $now->subDays(rand(1, 30)),
                'petugas_menyerahkan' => 'Petugas ' . ($index % 3 + 1),
                'petugas_menerima' => 'Penerima ' . ($index % 3 + 1),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Successfully seeded penerimaan_sk table with ' . $personalData->count() . ' records.');
    }
}
