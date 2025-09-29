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
            $table->unsignedBigInteger('personal_data_id');
            $table->string('field_name');
            $table->boolean('is_verified')->default(false);
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Add composite unique constraint
            $table->unique(['personal_data_id', 'field_name']);
            
            // Add foreign key constraints
            $table->foreign('personal_data_id')
                  ->references('id')
                  ->on('personal_data')
                  ->onDelete('cascade');
                  
            $table->foreign('verified_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
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
