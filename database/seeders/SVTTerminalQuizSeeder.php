<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SVTTerminalQuizSeeder extends Seeder
{
    public function run()
    {
        $classeId = 1; // Terminale
        $matiereId = 2; // SVT
        $userId = 1;

        $themes = [
            'Reproduction humaine',
            'Système immunitaire',
            'Génétique',
            'Photosynthèse',
            'Respiration cellulaire',
            'Système nerveux',
            'Hormones',
            'Écosystème',
            'Digestion',
            'Excrétion'
        ];

        $questionsBank = [
            [
                'titre' => 'Où se produit la fécondation ?',
                'type' => 'qcm',
                'options' => ['Utérus', 'Trompes de Fallope', 'Ovaires', 'Vagin'],
                'bonne_reponse' => 'Trompes de Fallope',
                'explication' => 'La fécondation a lieu dans les trompes.'
            ],
            [
                'titre' => 'Les globules blancs défendent l’organisme',
                'type' => 'vrai_faux',
                'options' => ['Vrai', 'Faux'],
                'bonne_reponse' => 'Vrai'
            ],
            [
                'titre' => 'Combien de chromosomes possède l’homme ?',
                'type' => 'texte',
                'bonne_reponse' => '46'
            ],
            [
                'titre' => 'La photosynthèse se déroule dans :',
                'type' => 'qcm',
                'options' => ['Noyau', 'Mitochondrie', 'Chloroplaste', 'Membrane'],
                'bonne_reponse' => 'Chloroplaste'
            ],
            [
                'titre' => 'Les neurones sont les cellules du système nerveux',
                'type' => 'vrai_faux',
                'options' => ['Vrai', 'Faux'],
                'bonne_reponse' => 'Vrai'
            ],
        ];

        // Nombre de quiz à générer
        $nombreQuiz = 200;

        for ($i = 1; $i <= $nombreQuiz; $i++) {

            $theme = $themes[array_rand($themes)];

            $quizId = DB::table('quizzes')->insertGetId([
                'titre' => $theme . ' #' . $i,
                'description' => 'Quiz SVT Terminale sur ' . $theme,
                'classe_id' => $classeId,
                'matiere_id' => $matiereId,
                'chapitre_id' => null,
                'duree' => rand(15, 40),
                'nombre_questions' => 0,
                'score_passer' => 50,
                'statut' => 'publie',
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $nombreQuestions = rand(5, 10);
            $ordre = 1;

            for ($q = 1; $q <= $nombreQuestions; $q++) {

                $question = $questionsBank[array_rand($questionsBank)];

                DB::table('quiz_questions')->insert([
                    'quiz_id' => $quizId,
                    'titre' => $question['titre'],
                    'type' => $question['type'],
                    'options' => isset($question['options'])
                        ? json_encode($question['options'])
                        : null,
                    'bonne_reponse' => $question['bonne_reponse'],
                    'explication' => $question['explication'] ?? null,
                    'points' => rand(1, 5),
                    'ordre' => $ordre++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('quizzes')
                ->where('id', $quizId)
                ->update([
                    'nombre_questions' => $nombreQuestions
                ]);
        }
    }
}