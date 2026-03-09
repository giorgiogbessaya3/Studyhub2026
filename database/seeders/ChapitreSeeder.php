<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Database\Seeder;

class ChapitreSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer la classe 3ème (ou créer si n'existe pas)
        $classe3eme = Classe::where('nom', 'like', '%3ème%')->first() 
                   ?? Classe::first();

        if (!$classe3eme) {
            $this->command->error('Aucune classe trouvée. Créez d\'abord des classes.');
            return;
        }

        // Récupérer les matières
        $math = Matiere::where('code', 'MATH')->first();
        $francais = Matiere::where('code', 'FR')->first();
        $physique = Matiere::where('code', 'PC')->first();
        $svt = Matiere::where('code', 'SVT')->first();
        $anglais = Matiere::where('code', 'ANG')->first();
        $hg = Matiere::where('code', 'HG')->first();

        // Mathématiques - 3ème
        if ($math) {
            $chapitresMath = [
                ['titre' => 'Calcul littéral', 'description' => 'Développement, factorisation et équations', 'ordre' => 1],
                ['titre' => 'Fonctions affines', 'description' => 'Représentation graphique et variations', 'ordre' => 2],
                ['titre' => 'Théorème de Thalès', 'description' => 'Configuration et démonstration', 'ordre' => 3],
                ['titre' => 'Trigonométrie', 'description' => 'Cosinus, sinus et tangente', 'ordre' => 4],
                ['titre' => 'Statistiques', 'description' => 'Moyenne, médiane et étendue', 'ordre' => 5],
            ];

            foreach ($chapitresMath as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $math->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }

        // Français - 3ème
        if ($francais) {
            $chapitresFr = [
                ['titre' => 'Le récit fantastique', 'description' => 'Analyse du genre fantastique', 'ordre' => 1],
                ['titre' => 'La poésie engagée', 'description' => 'Étude des poèmes engagés', 'ordre' => 2],
                ['titre' => 'L\'argumentation', 'description' => 'Techniques et structure argumentative', 'ordre' => 3],
                ['titre' => 'Le théâtre classique', 'description' => 'Molière et la comédie de caractère', 'ordre' => 4],
            ];

            foreach ($chapitresFr as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $francais->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }

        // Physique-Chimie - 3ème
        if ($physique) {
            $chapitresPC = [
                ['titre' => 'Circuits électriques', 'description' => 'Loi d\'Ohm et circuits', 'ordre' => 1],
                ['titre' => 'La lumière', 'description' => 'Propagation et réfraction', 'ordre' => 2],
                ['titre' => 'Réactions chimiques', 'description' => 'Transformation de la matière', 'ordre' => 3],
                ['titre' => 'Le mouvement', 'description' => 'Vitesse et trajectoire', 'ordre' => 4],
            ];

            foreach ($chapitresPC as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $physique->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }

        // SVT - 3ème
        if ($svt) {
            $chapitresSVT = [
                ['titre' => 'La photosynthèse', 'description' => 'Production de matière par les plantes', 'ordre' => 1],
                ['titre' => 'Le système nerveux', 'description' => 'De la réception à la réponse', 'ordre' => 2],
                ['titre' => 'La tectonique des plaques', 'description' => 'Dérive des continents', 'ordre' => 3],
            ];

            foreach ($chapitresSVT as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $svt->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }

        // Anglais - 3ème
        if ($anglais) {
            $chapitresAng = [
                ['titre' => 'Daily routines', 'description' => 'Present simple and adverbs', 'ordre' => 1],
                ['titre' => 'Future plans', 'description' => 'Be going to and will', 'ordre' => 2],
                ['titre' => 'Past experiences', 'description' => 'Present perfect simple', 'ordre' => 3],
            ];

            foreach ($chapitresAng as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $anglais->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }

        // Histoire-Géo - 3ème
        if ($hg) {
            $chapitresHG = [
                ['titre' => 'La Révolution française', 'description' => '1789-1799 : de l\'Ancien Régime à l\'Empire', 'ordre' => 1],
                ['titre' => 'La Seconde Guerre mondiale', 'description' => '1939-1945 : conflit mondial', 'ordre' => 2],
                ['titre' => 'Les dynamiques territoriales', 'description' => 'Aménagement durable', 'ordre' => 3],
            ];

            foreach ($chapitresHG as $chapitre) {
                Chapitre::create([
                    'classe_id' => $classe3eme->id,
                    'matiere_id' => $hg->id,
                    'titre' => $chapitre['titre'],
                    'slug' => \Illuminate\Support\Str::slug($chapitre['titre']),
                    'description' => $chapitre['description'],
                    'ordre' => $chapitre['ordre'],
                    'statut' => true,
                ]);
            }
        }
    }
}