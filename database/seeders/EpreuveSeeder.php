<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Epreuve;
use App\Models\Matiere;
use App\Models\TypeEpreuve;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EpreuveSeeder extends Seeder
{
    public function run(): void
    {
        $classe3eme  = Classe::where('nom', '3ème')->first();
        $classeTermi = Classe::where('nom', 'Terminale')->first();
        $math        = Matiere::where('code', 'MATH')->first();
        $svt         = Matiere::where('code', 'SVT')->first();
        $physique    = Matiere::where('code', 'PC')->first();
        $francais    = Matiere::where('code', 'FR')->first();

        $typeBrevet  = TypeEpreuve::where('nom', 'like', '%Brevet%')->first()
                    ?? TypeEpreuve::first();
        $typeBac     = TypeEpreuve::where('nom', 'like', '%Baccalauréat%')->orWhere('nom', 'like', '%Bac%')->first()
                    ?? TypeEpreuve::first();
        $typeDevoir  = TypeEpreuve::where('nom', 'like', '%Devoir%')->first()
                    ?? TypeEpreuve::first();

        if (!$typeBrevet || !$classe3eme) {
            $this->command->warn('Données de base manquantes pour EpreuveSeeder.');
            return;
        }

        $epreuves = [
            [
                'titre'       => 'Brevet Blanc Mathématiques — Série 1',
                'description' => 'Épreuve blanche de mathématiques pour la 3ème, couvrant algèbre et géométrie.',
                'type'        => $typeBrevet,
                'annee'       => 2024,
                'duree'       => 120,
                'bareme'      => 40,
                'classes'     => [$classe3eme],
                'matieres'    => [$math],
            ],
            [
                'titre'       => 'Devoir Commun Physique-Chimie 3ème — T1',
                'description' => 'Premier devoir commun du trimestre sur les circuits électriques.',
                'type'        => $typeDevoir ?? $typeBrevet,
                'annee'       => 2025,
                'duree'       => 60,
                'bareme'      => 20,
                'classes'     => [$classe3eme],
                'matieres'    => [$physique],
            ],
            [
                'titre'       => 'Brevet Blanc Français — Texte Fantastique',
                'description' => 'Épreuve de compréhension et d\'expression sur le genre fantastique.',
                'type'        => $typeBrevet,
                'annee'       => 2025,
                'duree'       => 180,
                'bareme'      => 40,
                'classes'     => [$classe3eme],
                'matieres'    => [$francais],
            ],
        ];

        if ($classeTermi && $svt) {
            $epreuves[] = [
                'titre'       => 'Baccalauréat SVT Terminale — Annales 2023',
                'description' => 'Annales de baccalauréat en SVT Terminale, génétique et évolution.',
                'type'        => $typeBac ?? $typeBrevet,
                'annee'       => 2023,
                'duree'       => 240,
                'bareme'      => 20,
                'classes'     => [$classeTermi],
                'matieres'    => [$svt],
            ];
        }

        foreach ($epreuves as $data) {
            $slug = Str::slug($data['titre']);
            $epreuve = Epreuve::firstOrCreate(
                ['slug' => $slug],
                [
                    'titre'               => $data['titre'],
                    'slug'                => $slug,
                    'description'         => $data['description'],
                    'type_epreuve_id'     => $data['type']->id,
                    'fichier'             => null,
                    'nom_fichier_original' => null,
                    'annee'               => $data['annee'],
                    'duree'               => $data['duree'],
                    'bareme'              => $data['bareme'],
                    'statut'              => true,
                ]
            );

            // Pivot classes
            foreach ($data['classes'] as $classe) {
                if ($classe) {
                    $epreuve->classes()->syncWithoutDetaching([$classe->id]);
                }
            }

            // Pivot matières
            foreach ($data['matieres'] as $matiere) {
                if ($matiere) {
                    $epreuve->matieres()->syncWithoutDetaching([$matiere->id]);
                }
            }
        }

        $this->command->info('✓ Épreuves créées (' . count($epreuves) . ').');
    }
}
