<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the table exists
        if (!Schema::hasTable('serah_terima')) {
            Schema::create('serah_terima', function (Blueprint $table) {
                $table->id();
                $table->foreignId('personal_data_id')->constrained('personal_data')->onDelete('cascade');
                $table->foreignId('jenis_izin_id')->constrained('jenis_izins')->onDelete('cascade');
                $table->string('foto_berkas');
                $table->string('petugas_menyerahkan');
                $table->string('petugas_menerima');
                $table->timestamp('waktu_serah_terima')->useCurrent();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serah_terima');
    }
};
