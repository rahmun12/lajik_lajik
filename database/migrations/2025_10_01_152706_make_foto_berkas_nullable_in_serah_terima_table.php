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
        // First, check if the column exists
        if (Schema::hasColumn('serah_terima', 'foto_berkas')) {
            Schema::table('serah_terima', function (Blueprint $table) {
                $table->string('foto_berkas')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('serah_terima', 'foto_berkas')) {
            Schema::table('serah_terima', function (Blueprint $table) {
                $table->string('foto_berkas')->nullable(false)->change();
            });
        }
    }
};
