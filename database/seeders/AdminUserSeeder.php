<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'prenom' => 'Admin',
            'nom' => 'Principal',
            'email' => 'admin@example.com',
            'identifiant_employe' => 'ADMIN001',
            'role' => 'admin',
            'password' => Hash::make('password'), // Mot de passe par défaut
        ]);
    }
}