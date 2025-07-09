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

//        User::create([
//            'prenom' => 'CLIENT SansCompte',
//            'nom' => 'USER',
//            "telephone" => '777777777',
//            "email" => 'clientS@test.com',
//            "identifiant" => 'USER02',
//            'email_verified_at' => now(),
//            'password' => static::$password ??= Hash::make('password'),
//            'role' => 'client',
//            'remember_token' => Str::random(10),
//        ]);
        CompteBancaire::create([
                    'numero_compte'   => '12345678910',
                    'code_banque'     => '12345',
                    'code_guichet'    => '12345',
                    'RIB'             => '12',
                    'solde'           => 250.00,
                    'type_de_compte'  => 'épargne',
                    'status'          => 'en attente',
                    'user_id'         => 2,
                ]);
//
    }
}
