<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title'       => '5 méthodes pour mieux réviser ses cours',
                'description' => 'Découvrez les techniques de mémorisation les plus efficaces pour réussir vos examens.',
                'content'     => "## 1. La méthode Pomodoro\n\nTravaillez 25 minutes sans interruption, "
                    . "puis faites une pause de 5 minutes. Cette technique améliore la concentration "
                    . "et évite la fatigue mentale.\n\n"
                    . "## 2. La répétition espacée\n\nRéviser à intervalles croissants (J+1, J+3, J+7, J+14) "
                    . "permet une mémorisation durable. Utilisez des flashcards.\n\n"
                    . "## 3. L'enseignement à soi-même\n\nRéexpliquer une leçon à voix haute comme si vous "
                    . "l'enseigniez à quelqu'un d'autre. C'est la méthode Feynman.\n\n"
                    . "## 4. Les cartes mentales\n\nCréez des mind maps pour relier les concepts entre eux "
                    . "et visualiser les liens logiques.\n\n"
                    . "## 5. Les exercices pratiques\n\nNe lisez pas passivement — faites des exercices, "
                    . "des annales, des quiz. La pratique active est la clé.",
                'author'      => 'Équipe Studyhub',
                'youtube_url' => null,
                'status'      => 'published',
            ],
            [
                'title'       => 'Comment préparer le Brevet des Collèges ?',
                'description' => 'Guide complet pour aborder sereinement les épreuves du brevet avec un planning efficace.',
                'content'     => "## Les épreuves du Brevet\n\nLe Brevet des collèges (DNB) comprend plusieurs épreuves "
                    . "écrites et une épreuve orale (le Brevet de l'oral).\n\n"
                    . "**Épreuves écrites :**\n- Français (3h)\n- Mathématiques (2h)\n"
                    . "- Histoire-Géographie et EMC (2h)\n- Physique-Chimie, SVT ou Technologie (2h)\n\n"
                    . "## Planning de révision\n\n**3 mois avant :** Révisez le programme de 4ème et 3ème.\n\n"
                    . "**1 mois avant :** Faites des annales chronométrées.\n\n"
                    . "**1 semaine avant :** Revoyez les points faibles identifiés.\n\n"
                    . "## Conseils le jour J\n\n- Lisez bien l'énoncé avant de commencer\n"
                    . "- Gérez votre temps (1 point = ~1 minute)\n"
                    . "- Relisez votre copie avant de rendre",
                'author'      => 'Équipe Studyhub',
                'youtube_url' => null,
                'status'      => 'published',
            ],
            [
                'title'       => 'Les secrets de la réussite en Mathématiques',
                'description' => 'Les mathématiques font peur à beaucoup d\'élèves. Voici comment les apprivoiser.',
                'content'     => "## Changer son rapport aux maths\n\nLes mathématiques ne sont pas "
                    . "une question de talent inné, mais de méthode et de pratique régulière.\n\n"
                    . "## Revoir les bases\n\nBien souvent, les difficultés viennent de notions "
                    . "fondamentales non maîtrisées (fractions, proportionnalité, équations).\n\n"
                    . "## S'entraîner tous les jours\n\nFaites au moins 30 minutes d'exercices par jour. "
                    . "La régularité est plus importante que les longues sessions ponctuelles.\n\n"
                    . "## Utiliser les ressources Studyhub\n\nNos quiz de mathématiques vous permettent "
                    . "de vous entraîner et d'identifier vos points faibles en temps réel.",
                'author'      => 'Professeur Agbodjo',
                'youtube_url' => null,
                'status'      => 'draft',
            ],
        ];

        foreach ($articles as $article) {
            Blog::firstOrCreate(
                ['title' => $article['title']],
                $article
            );
        }

        $this->command->info('✓ Articles de blog créés (' . count($articles) . ').');
    }
}
