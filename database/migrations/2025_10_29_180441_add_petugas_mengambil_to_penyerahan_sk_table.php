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
        Schema::table('penyerahan_sk', function (Blueprint $table) {
            $table->string('petugas_mengambil')->nullable()->after('penerimaan_sk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyerahan_sk', function (Blueprint $table) {
            $table->dropColumn('petugas_mengambil');
        });
    }
};
