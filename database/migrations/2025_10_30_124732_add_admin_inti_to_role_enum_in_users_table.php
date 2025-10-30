<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'guest', 'admin_inti') NOT NULL DEFAULT 'user'");
        }
        
        // For PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255)");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'guest', 'admin_inti'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For MySQL
        if (DB::getDriverName() === 'mysql') {
            // First, update any 'admin_inti' users to 'admin'
            DB::table('users')->where('role', 'admin_inti')->update(['role' => 'admin']);
            
            // Then modify the column back to the original enum
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'guest') NOT NULL DEFAULT 'user'");
        }
        
        // For PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            // Update any 'admin_inti' users to 'admin' first
            DB::table('users')->where('role', 'admin_inti')->update(['role' => 'admin']);
            
            // Then modify the constraint
            DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'guest'))");
        }
    }
};
