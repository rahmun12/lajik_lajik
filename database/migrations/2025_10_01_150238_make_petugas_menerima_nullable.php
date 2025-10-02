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
        Schema::table('serah_terima', function (Blueprint $table) {
            $table->string('petugas_menerima')->nullable()->change();
            $table->string('petugas_menyerahkan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('serah_terima', function (Blueprint $table) {
            $table->string('petugas_menerima')->nullable(false)->change();
            $table->string('petugas_menyerahkan')->nullable(false)->change();
        });
    }
};
