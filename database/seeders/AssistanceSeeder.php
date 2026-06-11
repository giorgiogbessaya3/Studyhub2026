<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssistanceSeeder extends Seeder
{
    public function run(): void
    {
        $classe3eme = Classe::where('nom', '3ème')->first();
        $math       = Matiere::where('code', 'MATH')->first();
        $svt        = Matiere::where('code', 'SVT')->first();
        $physique   = Matiere::where('code', 'PC')->first();
        $eleve      = User::where('email', 'eleve@studyhub.test')->first();
        $prof       = User::where('email', 'prof@studyhub.test')->first();
        $admin      = User::where('email', 'admin@studyhub.test')->first()
                   ?? User::where('role', 'admin')->first();

        if (!$classe3eme || !$eleve || !$math) {
            $this->command->warn('Données de base manquantes pour AssistanceSeeder.');
            return;
        }

        $questions = [
            // Question résolue — avec réponse solution
            [
                'titre'   => 'Comment factoriser x² - 9 ?',
                'contenu' => "Je n'arrive pas à factoriser l'expression x² - 9.\n"
                    . "J'ai essayé de chercher un facteur commun mais je ne vois pas lequel.\n"
                    . "Quelqu'un peut-il m'expliquer la méthode ?",
                'matiere' => $math,
                'statut'  => 'resolue',
                'auteur'  => $eleve,
                'reponses' => [
                    [
                        'contenu'     => "x² - 9 est une identité remarquable de la forme a² - b².\n\n"
                            . "On utilise la formule : **a² - b² = (a + b)(a - b)**\n\n"
                            . "Ici a = x et b = 3, donc :\n**x² - 9 = (x + 3)(x - 3)**\n\n"
                            . "Il faut toujours penser aux identités remarquables quand tu vois une différence de carrés !",
                        'auteur'      => $prof ?? $admin,
                        'statut'      => 'approuvee',
                        'est_solution'=> true,
                    ],
                    [
                        'contenu'     => "Pour compléter la réponse du prof : tu peux aussi vérifier en développant (x+3)(x-3) = x² - 3x + 3x - 9 = x² - 9. ✓",
                        'auteur'      => $admin,
                        'statut'      => 'approuvee',
                        'est_solution'=> false,
                    ],
                ],
            ],
            // Question publiée — en attente de réponse
            [
                'titre'   => 'Différence entre circuit série et parallèle ?',
                'contenu' => "Je confonds toujours les circuits série et parallèle en Physique.\n"
                    . "Est-ce que quelqu'un peut expliquer la différence clairement avec un exemple concret ?",
                'matiere' => $physique,
                'statut'  => 'publiee',
                'auteur'  => $eleve,
                'reponses' => [
                    [
                        'contenu'     => "**Circuit série :** les composants sont branchés les uns à la suite des autres.\n"
                            . "→ La même intensité I traverse tous les composants.\n"
                            . "→ La tension totale = somme des tensions (U = U1 + U2)\n\n"
                            . "**Circuit parallèle :** les composants sont branchés entre les mêmes nœuds.\n"
                            . "→ La même tension U est aux bornes de chaque composant.\n"
                            . "→ L'intensité totale = somme des intensités (I = I1 + I2)\n\n"
                            . "Exemple : les ampoules d'une maison sont en parallèle — si une grille, les autres restent allumées !",
                        'auteur'      => $prof ?? $admin,
                        'statut'      => 'approuvee',
                        'est_solution'=> false,
                    ],
                ],
            ],
            // Question en attente de modération
            [
                'titre'   => 'Pourquoi les feuilles des plantes sont-elles vertes ?',
                'contenu' => "Lors du cours sur la photosynthèse, le professeur a dit que "
                    . "la chlorophylle donne la couleur verte aux feuilles.\n"
                    . "Mais pourquoi précisément la chlorophylle est-elle verte et pas une autre couleur ?",
                'matiere' => $svt,
                'statut'  => 'en_attente',
                'auteur'  => $eleve,
                'reponses' => [],
            ],
        ];

        foreach ($questions as $data) {
            $question = Question::firstOrCreate(
                ['titre' => $data['titre'], 'user_id' => $data['auteur']->id],
                [
                    'contenu'   => $data['contenu'],
                    'classe_id' => $classe3eme->id,
                    'matiere_id'=> $data['matiere']?->id,
                    'user_id'   => $data['auteur']->id,
                    'statut'    => $data['statut'],
                    'views'     => rand(5, 80),
                ]
            );

            foreach ($data['reponses'] as $rep) {
                Reponse::firstOrCreate(
                    ['question_id' => $question->id, 'user_id' => $rep['auteur']->id],
                    [
                        'contenu'      => $rep['contenu'],
                        'user_id'      => $rep['auteur']->id,
                        'statut'       => $rep['statut'],
                        'est_solution' => $rep['est_solution'],
                    ]
                );
            }

            // Mettre à jour le compteur de réponses
            $question->update(['reponses_count' => $question->reponses()->count()]);
        }

        $this->command->info('✓ Questions d\'assistance créées (' . count($questions) . ').');
    }
}
