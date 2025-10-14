<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupJenisIzin extends Command
{
    protected $signature = 'app:cleanup-jenis-izin';
    protected $description = 'Remove unwanted jenis izin entries';

    public function handle()
    {
        $unwanted = ['Izin Usaha', 'Izin Keramaian'];
        
        foreach ($unwanted as $name) {
            // Find and delete related records first
            $jenisIzin = DB::table('jenis_izins')->where('nama_izin', $name)->first();
            
            if ($jenisIzin) {
                // Delete related records
                DB::table('persyaratans')
                    ->where('jenis_izin_id', $jenisIzin->id)
                    ->delete();
                
                DB::table('izin_pengajuan')
                    ->where('jenis_izin_id', $jenisIzin->id)
                    ->delete();
                
                // Delete the jenis izin
                DB::table('jenis_izins')
                    ->where('id', $jenisIzin->id)
                    ->delete();
                
                $this->info("Removed: $name");
            } else {
                $this->line("Not found: $name");
            }
        }
        
        $this->info('Cleanup completed.');
    }
}
