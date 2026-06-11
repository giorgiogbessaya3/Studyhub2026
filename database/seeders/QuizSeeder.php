<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResultat;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $classe3eme  = Classe::where('nom', '3ème')->first();
        $classeTermi = Classe::where('nom', 'Terminale')->first();
        $math        = Matiere::where('code', 'MATH')->first();
        $svt         = Matiere::where('code', 'SVT')->first();
        $admin       = User::where('email', 'admin@studyhub.test')->first()
                    ?? User::where('role', 'admin')->first();
        $eleve       = User::where('email', 'eleve@studyhub.test')->first();

        if (!$classe3eme || !$math || !$admin) {
            $this->command->warn('Données de base manquantes pour QuizSeeder.');
            return;
        }

        // ─── Quiz 1 : Mathématiques 3ème ────────────────────────────────────
        $quiz1 = Quiz::firstOrCreate(
            ['titre' => 'Quiz Calcul Littéral — 3ème'],
            [
                'description'       => 'Testez vos connaissances sur le calcul littéral : développement, factorisation et identités remarquables.',
                'classe_id'         => $classe3eme->id,
                'matiere_id'        => $math->id,
                'chapitre_id'       => null,
                'duree'             => 20,
                'nombre_questions'  => 5,
                'score_passer'      => 60,
                'statut'            => 'publie',
                'created_by'        => $admin->id,
            ]
        );

        $questions1 = [
            [
                'titre'        => 'Développer 3(x + 4)',
                'type'         => 'qcm',
                'options'      => ['3x + 4', '3x + 12', 'x + 12', '3x + 7'],
                'bonne_reponse'=> '3x + 12',
                'points'       => 2,
                'explication'  => '3 × x = 3x et 3 × 4 = 12, donc 3(x+4) = 3x + 12.',
                'ordre'        => 1,
            ],
            [
                'titre'        => 'Factoriser : 5x + 20',
                'type'         => 'qcm',
                'options'      => ['5(x + 4)', '5(x + 5)', 'x(5 + 20)', '5x(1 + 4)'],
                'bonne_reponse'=> '5(x + 4)',
                'points'       => 2,
                'explication'  => 'Le facteur commun est 5 : 5x = 5×x et 20 = 5×4.',
                'ordre'        => 2,
            ],
            [
                'titre'        => '(a + b)² est égal à a² + 2ab + b²',
                'type'         => 'vrai_faux',
                'options'      => ['Vrai', 'Faux'],
                'bonne_reponse'=> 'Vrai',
                'points'       => 1,
                'explication'  => 'C\'est l\'identité remarquable : (a+b)² = a² + 2ab + b².',
                'ordre'        => 3,
            ],
            [
                'titre'        => 'Résoudre : 2x + 6 = 14. Trouver x.',
                'type'         => 'qcm',
                'options'      => ['x = 4', 'x = 5', 'x = 10', 'x = 3'],
                'bonne_reponse'=> 'x = 4',
                'points'       => 2,
                'explication'  => '2x = 14 - 6 = 8 → x = 4.',
                'ordre'        => 4,
            ],
            [
                'titre'        => 'Développer (x + 3)(x - 3)',
                'type'         => 'qcm',
                'options'      => ['x² - 9', 'x² + 9', 'x² - 6x + 9', 'x² + 6x - 9'],
                'bonne_reponse'=> 'x² - 9',
                'points'       => 3,
                'explication'  => 'Identité (a+b)(a-b) = a² - b², donc (x+3)(x-3) = x² - 9.',
                'ordre'        => 5,
            ],
        ];

        $this->creerQuestions($quiz1, $questions1);

        // ─── Quiz 2 : SVT Terminale ─────────────────────────────────────────
        if ($classeTermi && $svt) {
            $quiz2 = Quiz::firstOrCreate(
                ['titre' => 'Quiz Photosynthèse — Terminale SVT'],
                [
                    'description'      => 'Évaluez vos connaissances sur la photosynthèse et les échanges gazeux.',
                    'classe_id'        => $classeTermi->id,
                    'matiere_id'       => $svt->id,
                    'chapitre_id'      => null,
                    'duree'            => 15,
                    'nombre_questions' => 5,
                    'score_passer'     => 50,
                    'statut'           => 'publie',
                    'created_by'       => $admin->id,
                ]
            );

            $questions2 = [
                [
                    'titre'        => 'Dans quel organite se déroule la photosynthèse ?',
                    'type'         => 'qcm',
                    'options'      => ['Mitochondrie', 'Noyau', 'Chloroplaste', 'Ribosome'],
                    'bonne_reponse'=> 'Chloroplaste',
                    'points'       => 2,
                    'explication'  => 'La photosynthèse a lieu dans les chloroplastes, grâce à la chlorophylle.',
                    'ordre'        => 1,
                ],
                [
                    'titre'        => 'La photosynthèse produit du dioxygène (O₂)',
                    'type'         => 'vrai_faux',
                    'options'      => ['Vrai', 'Faux'],
                    'bonne_reponse'=> 'Vrai',
                    'points'       => 1,
                    'explication'  => 'L\'O₂ est un sous-produit de la photolyse de l\'eau.',
                    'ordre'        => 2,
                ],
                [
                    'titre'        => 'Quel gaz est absorbé par les stomates lors de la photosynthèse ?',
                    'type'         => 'qcm',
                    'options'      => ['O₂', 'N₂', 'CO₂', 'H₂O'],
                    'bonne_reponse'=> 'CO₂',
                    'points'       => 2,
                    'explication'  => 'Les plantes absorbent le CO₂ atmosphérique par les stomates.',
                    'ordre'        => 3,
                ],
                [
                    'titre'        => 'La chlorophylle absorbe principalement quelle couleur de lumière ?',
                    'type'         => 'qcm',
                    'options'      => ['Le vert', 'Le rouge et le bleu', 'Le jaune', 'L\'ultraviolet'],
                    'bonne_reponse'=> 'Le rouge et le bleu',
                    'points'       => 2,
                    'explication'  => 'La chlorophylle absorbe surtout le rouge et le bleu, et réfléchit le vert.',
                    'ordre'        => 4,
                ],
                [
                    'titre'        => 'La photosynthèse peut se dérouler sans lumière',
                    'type'         => 'vrai_faux',
                    'options'      => ['Vrai', 'Faux'],
                    'bonne_reponse'=> 'Faux',
                    'points'       => 1,
                    'explication'  => 'La lumière est indispensable à la phase photochimique.',
                    'ordre'        => 5,
                ],
            ];

            $this->creerQuestions($quiz2, $questions2);
        }

        // ─── Quiz 3 (brouillon) pour tester l'état brouillon ────────────────
        Quiz::firstOrCreate(
            ['titre' => '[BROUILLON] Quiz Statistiques 3ème'],
            [
                'description'      => 'Quiz en cours de préparation sur les statistiques.',
                'classe_id'        => $classe3eme->id,
                'matiere_id'       => $math->id,
                'duree'            => 15,
                'nombre_questions' => 3,
                'score_passer'     => 50,
                'statut'           => 'brouillon',
                'created_by'       => $admin->id,
            ]
        );

        // ─── Résultats de test pour l'élève ─────────────────────────────────
        if ($eleve) {
            $this->creerResultatEleve($quiz1, $eleve->id, $questions1);
        }

        $this->command->info('✓ Quiz créés avec questions et résultats élève.');
    }

    private function creerQuestions(Quiz $quiz, array $questions): void
    {
        foreach ($questions as $data) {
            QuizQuestion::firstOrCreate(
                ['quiz_id' => $quiz->id, 'ordre' => $data['ordre']],
                [
                    'titre'         => $data['titre'],
                    'type'          => $data['type'],
                    'options'       => $data['options'],
                    'bonne_reponse' => $data['bonne_reponse'],
                    'points'        => $data['points'],
                    'explication'   => $data['explication'],
                ]
            );
        }
    }

    private function creerResultatEleve(Quiz $quiz, int $userId, array $questionsData): void
    {
        if (QuizResultat::where('quiz_id', $quiz->id)->where('user_id', $userId)->exists()) {
            return;
        }

        $questions = $quiz->questions()->orderBy('ordre')->get();
        $reponses  = [];
        $score     = 0;

        foreach ($questions as $question) {
            // L'élève répond correctement aux 3 premières questions
            $questData  = collect($questionsData)->firstWhere('ordre', $question->ordre);
            $repondCorrect = $question->ordre <= 3;
            $reponse    = $repondCorrect ? $question->bonne_reponse : ($question->options[0] ?? 'mauvaise');

            $reponses[$question->id] = $reponse;

            if ($reponse === $question->bonne_reponse) {
                $score += $question->points;
            }
        }

        QuizResultat::create([
            'quiz_id'     => $quiz->id,
            'user_id'     => $userId,
            'score'       => $score,
            'reponses'    => $reponses,
            'temps_ecoule'=> 840,
            'termine_le'  => now()->subDays(3),
        ]);
    }
}
