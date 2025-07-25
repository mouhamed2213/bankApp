<?php

namespace Database\Seeders;

use App\Models\Compte\CompteBancaire;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private static string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'prenom' => 'Mouhamed',
            'nom' => 'bassirou',
            "telephone" => '777777777',
            "email" => 'mouhamed@gmail.com',
            "identifiant" => 'USER02',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);
    }
}
