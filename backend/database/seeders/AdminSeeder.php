<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Usage: php artisan db:seed --class=AdminSeeder
     * 
     * This seeder will create a default admin user with:
     * - Email: admin@example.com
     * - Password: password
     * - Name: Admin User
     * 
     * IMPORTANT: Change the password immediately in production!
     */
    public function run(): void
    {
        // Create or update the admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin'),
                'isAdmin' => true,
                'xp' => 0,
                'bio' => 'System Administrator',
            ]
        );

        $this->command->info('✓ Admin user created/updated: admin@example.com');
        $this->command->warn('⚠ IMPORTANT: Change the admin password immediately in production!');
    }
}
