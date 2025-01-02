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
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'azka 2',
            'email' => 'azka2@gmail.com',
            'role' => 'employee',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'azka 3',
            'email' => 'azka3@gmail.com',
            'role' => 'customer',
            'password' => Hash::make('password'),
        ]);

        // Buat 20 pengguna menggunakan factory
        User::factory(20)->create();
    }
}
