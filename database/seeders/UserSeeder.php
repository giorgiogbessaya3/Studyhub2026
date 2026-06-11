<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hasIsActive = Schema::hasColumn('users', 'is_active');
        $hasClasseId = Schema::hasColumn('users', 'classe_id');

        $classe3eme  = Classe::where('nom', '3ème')->first();
        $classeTermi = Classe::where('nom', 'Terminale')->first();

        $users = [
            [
                'email'    => 'admin@studyhub.test',
                'name'     => 'Administrateur Test',
                'role'     => 'admin',
                'bio'      => 'Compte administrateur pour les tests.',
                'classe'   => null,
            ],
            [
                'email'    => 'prof@studyhub.test',
                'name'     => 'Professeur Test',
                'role'     => 'enseignant',
                'bio'      => 'Enseignant de Mathématiques et Physique-Chimie.',
                'classe'   => null,
            ],
            [
                'email'    => 'eleve@studyhub.test',
                'name'     => 'Élève Test',
                'role'     => 'eleve',
                'bio'      => 'Compte élève pour les tests.',
                'classe'   => $classe3eme,
            ],
            [
                'email'    => 'eleve2@studyhub.test',
                'name'     => 'Élève Terminale',
                'role'     => 'eleve',
                'bio'      => 'Compte élève Terminale pour les tests.',
                'classe'   => $classeTermi,
            ],
        ];

        foreach ($users as $data) {
            $attributes = [
                'name'     => $data['name'],
                'password' => Hash::make('password123'),
                'role'     => $data['role'],
                'bio'      => $data['bio'],
            ];

            if ($hasIsActive) {
                $attributes['is_active'] = true;
            }

            if ($hasClasseId) {
                $attributes['classe_id'] = $data['classe']?->id;
            }

            User::firstOrCreate(['email' => $data['email']], $attributes);
        }

        $this->command->info('✓ Utilisateurs créés :');
        $this->command->info('  admin@studyhub.test   / password123  (admin)');
        $this->command->info('  prof@studyhub.test    / password123  (enseignant)');
        $this->command->info('  eleve@studyhub.test   / password123  (élève 3ème)');
        $this->command->info('  eleve2@studyhub.test  / password123  (élève Terminale)');

        if (!$hasIsActive || !$hasClasseId) {
            $this->command->warn('  ⚠ Colonnes manquantes détectées. Lancez : php artisan migrate');
        }
    }
}
