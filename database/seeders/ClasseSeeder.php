<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['nom' => '6ème', 'cycle' => 'college', 'description' => 'Cycle d\'adaptation', 'ordre' => 1, 'statut' => true],
            ['nom' => '5ème', 'cycle' => 'college', 'description' => 'Cycle central', 'ordre' => 2, 'statut' => true],
            ['nom' => '4ème', 'cycle' => 'college', 'description' => 'Cycle central', 'ordre' => 3, 'statut' => true],
            ['nom' => '3ème', 'cycle' => 'college', 'description' => 'Diplôme du Brevet', 'ordre' => 4, 'statut' => true],
            ['nom' => 'Seconde', 'cycle' => 'lycee', 'description' => 'Classe de détermination', 'ordre' => 5, 'statut' => true],
            ['nom' => 'Première', 'cycle' => 'lycee', 'description' => 'Première année du cycle terminal', 'ordre' => 6, 'statut' => true],
            ['nom' => 'Terminale', 'cycle' => 'lycee', 'description' => 'Diplôme du Baccalauréat', 'ordre' => 7, 'statut' => true],
        ];

        foreach ($classes as $classe) {
            Classe::create($classe);
        }
    }
}