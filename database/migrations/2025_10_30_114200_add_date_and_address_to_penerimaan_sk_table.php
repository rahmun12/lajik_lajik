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
        Schema::table('penerimaan_sk', function (Blueprint $table) {
            $table->date('tanggal_penerimaan')->nullable()->after('tanggal_terbit');
            $table->text('alamat_penerimaan')->nullable()->after('tanggal_penerimaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_sk', function (Blueprint $table) {
            $table->dropColumn(['tanggal_penerimaan', 'alamat_penerimaan']);
        });
    }
};
