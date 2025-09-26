<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('persyaratans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_izin_id')->constrained('jenis_izins')->onDelete('cascade');
            $table->string('nama_persyaratan'); // bisa 3, 4, atau lebih
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratans');
    }
};
