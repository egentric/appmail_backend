<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // création de l'administrateur
        User::create([
            'user_firstname' => 'Erwan',
            'user_lastname' => 'Gentric',
            'user_email' => 'egentric@gmail.com',
            'user_center' => 'Saint Nazaire',
            'password' => Hash::make('password'),
            'remember_token' => str::random(10),
            'email_verified_at' => now(),
            'role_id' => 1
        ]);

        // création de l'user
        User::create([
            'user_firstname' => 'Tricus',
            'user_lastname' => 'Gentric',
            'user_email' => 'infogentric@gmail.com',
            'user_center' => 'Saint Nazaire',
            'password' => Hash::make('password'),
            'remember_token' => str::random(10),
            'email_verified_at' => now(),
            'role_id' => 2
        ]);
    }
}
