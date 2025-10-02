<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penerimaan_sk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_data_id')->constrained('personal_data')->onDelete('cascade');
            $table->string('no_sk_izin')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('petugas_menyerahkan')->nullable();
            $table->string('petugas_menerima')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerimaan_sk');
    }
};
