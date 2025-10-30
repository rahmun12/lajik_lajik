<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminIntiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin_inti user if not exists
        User::firstOrCreate(
            ['email' => 'admin_inti@example.com'],
            [
                'name' => 'Admin Inti',
                'password' => Hash::make('password'),
                'role' => 'admin_inti',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin Inti user created successfully!');
        $this->command->info('Email: admin_inti@example.com');
        $this->command->info('Password: password');
    }
}
