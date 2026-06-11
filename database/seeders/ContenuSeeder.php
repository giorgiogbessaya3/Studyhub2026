<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\Classe;
use App\Models\Contenu;
use App\Models\Matiere;
use Illuminate\Database\Seeder;

class ContenuSeeder extends Seeder
{
    public function run(): void
    {
        $classe3eme = Classe::where('nom', '3ème')->first();
        $math       = Matiere::where('code', 'MATH')->first();
        $francais   = Matiere::where('code', 'FR')->first();
        $svt        = Matiere::where('code', 'SVT')->first();
        $physique   = Matiere::where('code', 'PC')->first();

        if (!$classe3eme) {
            $this->command->warn('Aucune classe trouvée — relancez ClasseSeeder d\'abord.');
            return;
        }

        // Assurer les pivots classe_matiere
        foreach ([$math, $francais, $svt, $physique] as $matiere) {
            if ($matiere) {
                $classe3eme->matieres()->syncWithoutDetaching([$matiere->id]);
            }
        }

        // Contenus Mathématiques
        $chapMath = Chapitre::where('classe_id', $classe3eme->id)
            ->where('matiere_id', $math?->id)
            ->where('titre', 'Calcul littéral')
            ->first();

        if ($chapMath && $math) {
            $this->creerContenus($chapMath->id, [
                [
                    'titre'  => 'Introduction au calcul littéral',
                    'resume' => "Le calcul littéral consiste à utiliser des lettres pour représenter des nombres.\n\n"
                        . "**Développement :**\nDévelopper une expression, c'est la transformer en une somme ou une différence.\n"
                        . "Exemple : 3(x + 2) = 3x + 6\n\n"
                        . "**Factorisation :**\nFactoriser, c'est transformer une somme en un produit.\n"
                        . "Exemple : 3x + 6 = 3(x + 2)\n\n"
                        . "**Identités remarquables :**\n"
                        . "• (a + b)² = a² + 2ab + b²\n"
                        . "• (a - b)² = a² - 2ab + b²\n"
                        . "• (a + b)(a - b) = a² - b²",
                    'exercices' => [
                        ['question' => 'Développer : 2(x + 5)', 'reponse' => '2x + 10'],
                        ['question' => 'Factoriser : 4x + 12', 'reponse' => '4(x + 3)'],
                        ['question' => 'Développer : (x + 3)²', 'reponse' => 'x² + 6x + 9'],
                        ['question' => 'Calculer (5 + 3)(5 - 3) avec l\'identité remarquable', 'reponse' => '16'],
                    ],
                    'ordre' => 1,
                ],
                [
                    'titre'  => 'Équations du premier degré',
                    'resume' => "Une équation du premier degré est de la forme ax + b = 0.\n\n"
                        . "**Méthode de résolution :**\n"
                        . "1. Transposer les termes en x d'un côté\n"
                        . "2. Transposer les constantes de l'autre\n"
                        . "3. Diviser par le coefficient de x\n\n"
                        . "**Exemple :** Résoudre 3x - 7 = 2\n"
                        . "3x = 2 + 7 → 3x = 9 → x = 3",
                    'exercices' => [
                        ['question' => 'Résoudre : 2x + 4 = 10', 'reponse' => 'x = 3'],
                        ['question' => 'Résoudre : 5x - 3 = 2x + 9', 'reponse' => 'x = 4'],
                    ],
                    'ordre' => 2,
                ],
            ]);
        }

        // Contenus Français
        $chapFr = Chapitre::where('classe_id', $classe3eme->id)
            ->where('matiere_id', $francais?->id)
            ->where('titre', 'Le récit fantastique')
            ->first();

        if ($chapFr && $francais) {
            $this->creerContenus($chapFr->id, [
                [
                    'titre'  => 'Caractéristiques du récit fantastique',
                    'resume' => "Le récit fantastique est un genre littéraire apparu au XIXe siècle.\n\n"
                        . "**Définition :**\nLe fantastique crée une hésitation entre une explication naturelle "
                        . "et une explication surnaturelle d'un événement étrange.\n\n"
                        . "**Auteurs majeurs :**\n• Maupassant (Le Horla)\n• Poe (La Chute de la maison Usher)\n"
                        . "• Mérimée (La Vénus d'Ille)\n\n"
                        . "**Procédés stylistiques :**\n"
                        . "• Champ lexical de la peur et du doute\n"
                        . "• Narrateur à la première personne\n"
                        . "• Atmosphère nocturne et oppressante",
                    'exercices' => [
                        ['question' => 'Quel auteur a écrit Le Horla ?', 'reponse' => 'Guy de Maupassant'],
                        ['question' => 'Qu\'est-ce qui définit le fantastique selon Todorov ?', 'reponse' => 'L\'hésitation entre le naturel et le surnaturel'],
                    ],
                    'ordre' => 1,
                ],
            ]);
        }

        // Contenus SVT
        $chapSVT = Chapitre::where('classe_id', $classe3eme->id)
            ->where('matiere_id', $svt?->id)
            ->where('titre', 'La photosynthèse')
            ->first();

        if ($chapSVT && $svt) {
            $this->creerContenus($chapSVT->id, [
                [
                    'titre'  => 'La photosynthèse — mécanisme',
                    'resume' => "La photosynthèse est le processus par lequel les plantes fabriquent leur matière organique.\n\n"
                        . "**Équation bilan :**\n6 CO₂ + 6 H₂O + lumière → C₆H₁₂O₆ + 6 O₂\n\n"
                        . "**Conditions nécessaires :**\n• Lumière (énergie solaire)\n"
                        . "• Eau (absorbée par les racines)\n• CO₂ (absorbé par les stomates)\n"
                        . "• Chlorophylle (pigment vert dans les chloroplastes)\n\n"
                        . "**Produits :**\n• Glucose (matière organique stockée)\n• Dioxygène (rejeté dans l'air)",
                    'exercices' => [
                        ['question' => 'Dans quel organite se déroule la photosynthèse ?', 'reponse' => 'Le chloroplaste'],
                        ['question' => 'Quel gaz est absorbé lors de la photosynthèse ?', 'reponse' => 'Le dioxyde de carbone (CO₂)'],
                        ['question' => 'Quel gaz est produit lors de la photosynthèse ?', 'reponse' => 'Le dioxygène (O₂)'],
                    ],
                    'ordre' => 1,
                ],
            ]);
        }

        // Contenus Physique-Chimie
        $chapPC = Chapitre::where('classe_id', $classe3eme->id)
            ->where('matiere_id', $physique?->id)
            ->where('titre', 'Circuits électriques')
            ->first();

        if ($chapPC && $physique) {
            $this->creerContenus($chapPC->id, [
                [
                    'titre'  => 'Loi d\'Ohm et résistance',
                    'resume' => "La loi d'Ohm établit la relation entre tension, intensité et résistance.\n\n"
                        . "**Formule :** U = R × I\n"
                        . "• U : tension en Volts (V)\n• R : résistance en Ohms (Ω)\n• I : intensité en Ampères (A)\n\n"
                        . "**Loi des nœuds (circuit parallèle) :**\nLa somme des intensités entrant = somme des intensités sortant\n\n"
                        . "**Loi des mailles (circuit série) :**\nLa tension totale = somme des tensions partielles",
                    'exercices' => [
                        ['question' => 'Calculer U si R = 10Ω et I = 2A', 'reponse' => 'U = 20 V'],
                        ['question' => 'Calculer I si U = 12V et R = 4Ω', 'reponse' => 'I = 3 A'],
                    ],
                    'ordre' => 1,
                ],
            ]);
        }

        $this->command->info('✓ Contenus de cours créés.');
    }

    private function creerContenus(int $chapitreId, array $contenus): void
    {
        foreach ($contenus as $data) {
            Contenu::firstOrCreate(
                ['chapitre_id' => $chapitreId, 'titre' => $data['titre']],
                [
                    'resume'    => $data['resume'],
                    'images'    => null,
                    'exercices' => $data['exercices'] ?? null,
                    'ordre'     => $data['ordre'],
                ]
            );
        }
    }
}
