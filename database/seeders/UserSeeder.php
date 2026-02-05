<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Developer',
            'email' => 'dev@company.com',
            'password' => Hash::make('password123'),
            'role' => 'developer',
        ]);

        User::create([
            'name' => 'Basilius Dimas',
            'email' => 'basiliusarilla06@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);
    }
}
