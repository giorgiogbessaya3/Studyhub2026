<?php

namespace Database\Seeders;

use App\Models\Matiere;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $matieres = [
            [
                'nom' => 'Mathématiques',
                'code' => 'MATH',
                'description' => 'Algèbre, géométrie, analyse et probabilités',
                'image' => null,
                'couleur' => '#2563eb',
                'icone' => 'ti-calculator',
            ],
            [
                'nom' => 'Français',
                'code' => 'FR',
                'description' => 'Littérature, grammaire et expression écrite',
                'image' => null,
                'couleur' => '#9333ea',
                'icone' => 'ti-book',
            ],
            [
                'nom' => 'Physique-Chimie',
                'code' => 'PC',
                'description' => 'Mécanique, électricité, chimie organique et minérale',
                'image' => null,
                'couleur' => '#10b981',
                'icone' => 'ti-flask',
            ],
            [
                'nom' => 'SVT',
                'code' => 'SVT',
                'description' => 'Sciences de la vie et de la Terre',
                'image' => null,
                'couleur' => '#059669',
                'icone' => 'ti-leaf',
            ],
            [
                'nom' => 'Anglais',
                'code' => 'ANG',
                'description' => 'Langue anglaise et culture anglo-saxonne',
                'image' => null,
                'couleur' => '#f59e0b',
                'icone' => 'ti-language',
            ],
            [
                'nom' => 'Histoire-Géographie',
                'code' => 'HG',
                'description' => 'Histoire du monde et géographie physique et humaine',
                'image' => null,
                'couleur' => '#d97706',
                'icone' => 'ti-globe',
            ],
            [
                'nom' => 'Philosophie',
                'code' => 'PHILO',
                'description' => 'Introduction à la philosophie et aux grands penseurs',
                'image' => null,
                'couleur' => '#64748b',
                'icone' => 'ti-bulb',
            ],
            [
                'nom' => 'SES',
                'code' => 'SES',
                'description' => 'Sciences économiques et sociales',
                'image' => null,
                'couleur' => '#ec4899',
                'icone' => 'ti-chart-bar',
            ],
        ];

        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
        }
    }
}