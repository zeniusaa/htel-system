<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'PPAT Demo',
            'email' => 'ppat@mail.com',
            'password' => Hash::make('password'),
            'role' => 'PPAT'
        ]);

        User::create([
            'name' => 'Bank Demo',
            'email' => 'bank@mail.com',
            'password' => Hash::make('password'),
            'role' => 'BANK'
        ]);
    }
}
