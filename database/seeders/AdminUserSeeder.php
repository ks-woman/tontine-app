<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Membre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Admin Diarra',
            'email' => 'admin@exemple.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        Membre::create([
            'user_id' => $user->id,
            'nom' => 'Admin',
            'prenom' => 'Diarra',
            'email' => 'admin@exemple.com',
            'telephone' => '771234567',
            'date_naissance' => '1990-01-01',
            'lieu_naissance' => 'Dakar',
            'numero_piece_identite' => 'ADMIN001',
            'date_adhesion' => now(),
            'adresse' => 'Dakar, Sénégal',
        ]);
    }
}
