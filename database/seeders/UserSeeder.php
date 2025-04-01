<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Beheerder',
            'email' => 'beheerder@example.com',
            'password' => Hash::make('password'),
            'role' => 'beheerder',
        ]);

        User::create([
            'name' => 'Jan',
            'email' => 'klant@example.com',
            'password' => Hash::make('password'),
            'role' => 'klant',
        ]);
    }
}
