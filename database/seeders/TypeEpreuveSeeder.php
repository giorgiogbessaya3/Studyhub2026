<?php

namespace Database\Seeders;

use App\Models\TypeEpreuve;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeEpreuveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'nom' => 'Devoir',
                'description' => 'Évaluation écrite ou pratique portant sur une partie du programme.',
                'icone' => 'ti-file-text',
                'statut' => true,
            ],
            [
                'nom' => 'Interrogation',
                'description' => 'Courte évaluation souvent inopinée, portant sur une notion spécifique.',
                'icone' => 'ti-checklist',
                'statut' => true,
            ],
            [
                'nom' => 'Examen blanc',
                'description' => 'Simulation d\'examen dans des conditions réelles pour préparer l\'épreuve officielle.',
                'icone' => 'ti-edit',
                'statut' => true,
            ],
            [
                'nom' => 'Révision',
                'description' => 'Exercices et supports destinés à consolider les connaissances.',
                'icone' => 'ti-book',
                'statut' => true,
            ],
        ];

        foreach ($types as $type) {
            // Utilisation de firstOrCreate pour éviter les doublons si le seeder est exécuté plusieurs fois
            TypeEpreuve::firstOrCreate(
                ['nom' => $type['nom']],
                [
                    'slug' => Str::slug($type['nom']),
                    'description' => $type['description'],
                    'icone' => $type['icone'],
                    'statut' => $type['statut'],
                ]
            );
        }
    }
}