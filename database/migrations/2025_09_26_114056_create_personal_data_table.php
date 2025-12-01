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
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('alamat_jalan');
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kode_pos', 5)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('no_ktp', 16)->nullable();
            $table->string('foto_ktp')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_data');
    }
};
