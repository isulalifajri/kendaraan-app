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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'penyetuju'
        ]);

        User::create([
            'name' => 'Direktur',
            'email' => 'direktur@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'penyetuju'
        ]);
    }
}
