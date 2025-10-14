<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveDuplicateNIB extends Command
{
    protected $signature = 'app:remove-duplicate-nib';
    protected $description = 'Remove duplicate NIB entries, keeping only the most recent one';

    public function handle()
    {
        $nibName = 'Izin Penerbitan NIB (Nomor Induk Berusaha)';
        
        // Get all NIB entries ordered by creation date (newest first)
        $nibEntries = DB::table('jenis_izins')
            ->where('nama_izin', $nibName)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($nibEntries->count() <= 1) {
            $this->info('No duplicate NIB entries found.');
            return;
        }

        // Keep the most recent NIB entry
        $nibToKeep = $nibEntries->shift();
        $this->info("Keeping NIB ID: {$nibToKeep->id} (Created at: {$nibToKeep->created_at})");

        // Delete all other NIB entries and their related records
        foreach ($nibEntries as $nib) {
            // Delete related records first
            DB::table('persyaratans')
                ->where('jenis_izin_id', $nib->id)
                ->delete();
            
            DB::table('izin_pengajuan')
                ->where('jenis_izin_id', $nib->id)
                ->update(['jenis_izin_id' => $nibToKeep->id]);
            
            // Delete the duplicate NIB entry
            DB::table('jenis_izins')
                ->where('id', $nib->id)
                ->delete();
            
            $this->line("Removed duplicate NIB ID: {$nib->id}");
        }
        
        $this->info('Duplicate NIB entries have been removed.');
    }
}
