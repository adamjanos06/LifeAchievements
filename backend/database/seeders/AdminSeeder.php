<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
   
    public function run(): void
    {
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
