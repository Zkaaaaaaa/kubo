<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat pengguna secara individual
        User::create([
            'name' => 'azka',
            'email' => 'azka@gmail.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'azka 2',
            'email' => 'azka2@gmail.com',
            'role' => 'employee',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'azka 3',
            'email' => 'azka3@gmail.com',
            'role' => 'customer',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Buat 20 pengguna menggunakan factory
        User::factory(20)->create();
    }
}
