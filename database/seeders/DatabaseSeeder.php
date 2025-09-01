<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'prenom' => 'Admin',
            'nom' => 'Principal',
            'email' => 'admin@example.com',
            'identifiant_employe' => 'ADMIN001',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

    }
}


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appeler le seeder pour l'administrateur
        $this->call(AdminUserSeeder::class);
    }
}