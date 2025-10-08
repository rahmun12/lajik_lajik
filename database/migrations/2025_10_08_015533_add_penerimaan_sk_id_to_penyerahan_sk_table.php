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
            $table->foreignId('penerimaan_sk_id')->after('id')->constrained('penerimaan_sk')->onDelete('cascade');
            
            // Tambahkan index untuk pencarian yang lebih cepat
            $table->index('penerimaan_sk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyerahan_sk', function (Blueprint $table) {
            $table->dropForeign(['penerimaan_sk_id']);
            $table->dropColumn('penerimaan_sk_id');
        });
    }
};
