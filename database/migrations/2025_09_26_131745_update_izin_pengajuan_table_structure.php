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
        // Drop existing foreign keys if they exist
        Schema::table('izin_pengajuan', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['personal_data_id']);
            $table->dropForeign(['jenis_izin_id']);
        });

        // Recreate the table with the correct structure
        Schema::dropIfExists('izin_pengajuan');
        
        Schema::create('izin_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('personal_data_id')->constrained('personal_data')->onDelete('cascade');
            $table->foreignId('jenis_izin_id')->constrained('jenis_izins')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_pengajuan');
    }
};
