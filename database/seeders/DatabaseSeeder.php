<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin Kos Ayuni',
            'no_ktp' => '1234567890123456',
            'email' => 'admin@ayuni.com',
            'password' => bcrypt('admin123'),
            'no_hp' => '081234567890',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Penghuni Test',
            'no_ktp' => '1234567890123457',
            'email' => 'user@example.com',
            'password' => bcrypt('user123'),
            'no_hp' => '081234567891',
            'role' => 'user',
        ]);
    }
}
