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
        Schema::create('field_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_data_id')->constrained()->onDelete('cascade');
            $table->string('field_name'); // ktp, kk, selfie, etc.
            $table->boolean('is_verified')->default(false);
            $table->text('notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Ensure one verification per field per personal data
            $table->unique(['personal_data_id', 'field_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_verifications');
    }
};
