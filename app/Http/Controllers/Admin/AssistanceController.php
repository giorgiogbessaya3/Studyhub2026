<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssistanceController extends Controller
{
    /**
     * Affiche la liste des questions avec filtres
     */
    public function questions(Request $request)
    {
        $query = Question::with(['user', 'classe', 'matiere'])
            ->withCount(['reponses' => function($q) {
                $q->where('statut', 'approuvee');
            }]);

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Tri
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $questions = $query->paginate(15)->withQueryString();

        // Données pour les filtres
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        // Statistiques complètes
        $statistiques = [
            'en_attente' => Question::where('statut', 'en_attente')->count(),
            'questions_publiees' => Question::where('statut', 'publiee')->count(),
            'questions_resolues' => Question::where('statut', 'resolue')->count(),
            'questions_fermees' => Question::where('statut', 'fermee')->count(),
            'total_questions' => Question::count(),
            'aujourd_hui' => Question::whereDate('created_at', today())->count(),
            'cette_semaine' => Question::where('created_at', '>=', now()->subDays(7))->count(),
            'taux_reponse' => $this->calculerTauxReponse(),
            'temps_moyen_reponse' => $this->calculerTempsMoyenReponse()
        ];

        return view('admin.assistance.questions', compact(
            'questions', 
            'classes', 
            'matieres',
            'statistiques'
        ));
    }

    /**
     * Affiche le détail d'une question
     */
    public function showQuestion(Question $question)
    {
        $question->load([
            'user', 
            'classe', 
            'matiere', 
            'reponses' => function($q) {
                $q->with('user')
                  ->orderBy('est_solution', 'desc')
                  ->orderBy('created_at', 'asc');
            }
        ]);

        // Compter les réponses par statut
        $statsReponses = [
            'en_attente' => $question->reponses()->where('statut', 'en_attente')->count(),
            'approuvees' => $question->reponses()->where('statut', 'approuvee')->count(),
            'rejetees' => $question->reponses()->where('statut', 'rejetee')->count(),
        ];

        // Questions similaires
        $questionsSimilaires = Question::where('id', '!=', $question->id)
            ->whereIn('statut', ['publiee', 'resolue'])
            ->where(function($q) use ($question) {
                $q->where('classe_id', $question->classe_id)
                  ->orWhere('matiere_id', $question->matiere_id);
            })
            ->with(['user', 'classe', 'matiere'])
            ->withCount(['reponses' => function($q) {
                $q->where('statut', 'approuvee');
            }])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.assistance.show-question', compact('question', 'questionsSimilaires', 'statsReponses'));
    }

    /**
     * Ajoute une réponse à une question
     */
    public function reply(Request $request, Question $question)
    {
        $request->validate([
            'contenu' => 'required|string|min:5',
            'est_solution' => 'nullable|boolean'
        ]);

        DB::transaction(function() use ($request, $question) {
            // Créer la réponse
            $reponse = Reponse::create([
                'contenu' => $request->contenu,
                'question_id' => $question->id,
                'user_id' => auth()->id(),
                'statut' => 'approuvee', // Auto-approuvée pour les admins
                'est_solution' => $request->boolean('est_solution')
            ]);

            // Mettre à jour le compteur de réponses
            $question->reponses_count = $question->reponses()->where('statut', 'approuvee')->count();
            $question->derniere_reponse_at = now();
            $question->save();

            // Si c'est une solution, mettre à jour le statut de la question
            if ($request->boolean('est_solution')) {
                // Retirer les autres solutions
                $question->reponses()->where('est_solution', true)->update(['est_solution' => false]);
                $reponse->update(['est_solution' => true]);
                $question->update(['statut' => 'resolue']);
            }
        });

        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    /**
     * Change le statut d'une question
     */
    public function togglePublish(Question $question)
    {
        $nouveauStatut = match($question->statut) {
            'en_attente' => 'publiee',
            'publiee' => 'en_attente',
            default => $question->statut
        };

        if ($nouveauStatut === $question->statut) {
            return redirect()->back()->with('error', 'Action non autorisée pour ce statut.');
        }

        $question->update(['statut' => $nouveauStatut]);

        $message = $nouveauStatut === 'publiee' 
            ? 'Question publiée avec succès.' 
            : 'Question dépubliée.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Supprime une question
     */
    public function destroyQuestion(Question $question)
    {
        DB::transaction(function() use ($question) {
            // Supprimer l'image si elle existe
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            // Supprimer les réponses associées
            $question->reponses()->delete();

            // Supprimer la question
            $question->delete();
        });

        return redirect()->route('admin.assistance.questions')
            ->with('success', 'Question supprimée avec succès.');
    }

    /**
     * Affiche la liste des réponses à modérer
     */
    public function reponses(Request $request)
    {
        $query = Reponse::with(['user', 'question', 'question.user', 'question.classe', 'question.matiere'])
            ->where('statut', 'en_attente');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('contenu', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('question', function($q) use ($search) {
                      $q->where('titre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Tri
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $reponses = $query->paginate(15)->withQueryString();

        // Statistiques
        $stats = [
            'en_attente' => Reponse::where('statut', 'en_attente')->count(),
            'approuvees' => Reponse::where('statut', 'approuvee')->count(),
            'rejetees' => Reponse::where('statut', 'rejetee')->count(),
            'total' => Reponse::count()
        ];

        return view('admin.assistance.reponses', compact('reponses', 'stats'));
    }

    /**
     * Approuve une réponse
     */
    public function approveReponse(Reponse $reponse)
    {
        DB::transaction(function() use ($reponse) {
            $reponse->update(['statut' => 'approuvee']);

            // Mettre à jour le compteur de la question
            $question = $reponse->question;
            $question->reponses_count = $question->reponses()->where('statut', 'approuvee')->count();
            $question->derniere_reponse_at = now();
            $question->save();
        });

        return redirect()->back()->with('success', 'Réponse approuvée.');
    }

    /**
     * Rejette une réponse
     */
    public function rejectReponse(Reponse $reponse)
    {
        $reponse->update(['statut' => 'rejetee']);

        return redirect()->back()->with('success', 'Réponse rejetée.');
    }

    /**
     * Supprime une réponse
     */
    public function destroyReponse(Reponse $reponse)
    {
        $question = $reponse->question;
        $reponse->delete();
        
        // Mettre à jour le compteur de la question
        $question->reponses_count = $question->reponses()->where('statut', 'approuvee')->count();
        $question->derniere_reponse_at = $question->reponses()->where('statut', 'approuvee')->latest()->first()?->created_at;
        $question->save();

        return redirect()->back()->with('success', 'Réponse supprimée.');
    }

    /**
     * Marque une réponse comme solution
     */
    public function marquerSolution(Reponse $reponse)
    {
        DB::transaction(function() use ($reponse) {
            // Retirer le statut solution des autres réponses
            $reponse->question->reponses()->update(['est_solution' => false]);
            
            // Marquer celle-ci comme solution
            $reponse->update(['est_solution' => true]);
            
            // Marquer la question comme résolue
            $reponse->question->update(['statut' => 'resolue']);
        });

        return redirect()->back()->with('success', 'Réponse marquée comme solution.');
    }

    /**
     * Actions groupées sur les réponses
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:approve,reject,delete'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $count = count($ids);

        DB::transaction(function() use ($ids, $action) {
            $reponses = Reponse::whereIn('id', $ids);
            
            switch($action) {
                case 'approve':
                    $reponses->update(['statut' => 'approuvee']);
                    // Mettre à jour les compteurs des questions
                    foreach($reponses->get() as $reponse) {
                        $question = $reponse->question;
                        $question->reponses_count = $question->reponses()->where('statut', 'approuvee')->count();
                        $question->save();
                    }
                    break;
                case 'reject':
                    $reponses->update(['statut' => 'rejetee']);
                    break;
                case 'delete':
                    $reponses->delete();
                    break;
            }
        });

        $message = $count . ' réponse(s) ' . 
                  ($action === 'approve' ? 'approuvée(s)' : 
                  ($action === 'reject' ? 'rejetée(s)' : 'supprimée(s)'));

        return redirect()->back()->with('success', $message);
    }

    /**
     * Statistiques de l'assistance
     */
    public function statistiques()
    {
        $stats = [
            'total_questions' => Question::count(),
            'questions_en_attente' => Question::where('statut', 'en_attente')->count(),
            'questions_publiees' => Question::where('statut', 'publiee')->count(),
            'questions_resolues' => Question::where('statut', 'resolue')->count(),
            'questions_fermees' => Question::where('statut', 'fermee')->count(),
            'total_reponses' => Reponse::count(),
            'reponses_en_attente' => Reponse::where('statut', 'en_attente')->count(),
            'reponses_approuvees' => Reponse::where('statut', 'approuvee')->count(),
            'reponses_rejetees' => Reponse::where('statut', 'rejetee')->count(),
            
            'par_classe' => Question::select('classe_id', DB::raw('count(*) as total'))
                ->with('classe')
                ->groupBy('classe_id')
                ->get()
                ->map(function($item) {
                    return [
                        'classe' => $item->classe?->nom ?? 'Inconnue',
                        'total' => $item->total
                    ];
                }),
            
            'par_matiere' => Question::select('matiere_id', DB::raw('count(*) as total'))
                ->with('matiere')
                ->groupBy('matiere_id')
                ->get()
                ->map(function($item) {
                    return [
                        'matiere' => $item->matiere?->nom ?? 'Inconnue',
                        'total' => $item->total
                    ];
                }),
            
            'top_contributeurs' => User::select('users.id', 'users.name', 'users.email', DB::raw('count(reponses.id) as total_reponses'))
                ->join('reponses', 'users.id', '=', 'reponses.user_id')
                ->where('reponses.statut', 'approuvee')
                ->groupBy('users.id', 'users.name', 'users.email')
                ->orderBy('total_reponses', 'desc')
                ->limit(10)
                ->get(),
            
            'evolution' => Question::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('count(*) as total')
                )
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];

        return view('admin.assistance.statistiques', compact('stats'));
    }

    /**
     * Exporte les données d'assistance
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $type = $request->get('type', 'questions');
        
        if ($type === 'questions') {
            $data = Question::with(['user', 'classe', 'matiere'])
                ->withCount(['reponses' => function($q) {
                    $q->where('statut', 'approuvee');
                }])
                ->get();
            return $this->exportQuestionsCSV($data);
        } else {
            $data = Reponse::with(['user', 'question'])
                ->where('statut', 'approuvee')
                ->get();
            return $this->exportReponsesCSV($data);
        }
    }

    /**
     * Calcule le taux de réponse
     */
    private function calculerTauxReponse()
    {
        $totalQuestions = Question::whereIn('statut', ['publiee', 'resolue'])->count();
        if ($totalQuestions === 0) return 0;

        $questionsAvecReponses = Question::whereIn('statut', ['publiee', 'resolue'])
            ->whereHas('reponses', function($q) {
                $q->where('statut', 'approuvee');
            })->count();
        
        return round(($questionsAvecReponses / $totalQuestions) * 100);
    }

    /**
     * Calcule le temps moyen de réponse
     */
    private function calculerTempsMoyenReponse()
    {
        $reponses = Reponse::where('statut', 'approuvee')
            ->with('question')
            ->get();

        if ($reponses->isEmpty()) return 'N/A';

        $totalSecondes = $reponses->sum(function($reponse) {
            return $reponse->created_at->diffInSeconds($reponse->question->created_at);
        });

        $moyenneSecondes = $totalSecondes / $reponses->count();
        
        if ($moyenneSecondes < 60) {
            return round($moyenneSecondes) . ' secondes';
        } elseif ($moyenneSecondes < 3600) {
            return round($moyenneSecondes / 60) . ' min';
        } elseif ($moyenneSecondes < 86400) {
            return round($moyenneSecondes / 3600) . ' h';
        } else {
            return round($moyenneSecondes / 86400) . ' j';
        }
    }

    /**
     * Exporte les questions en CSV
     */
    private function exportQuestionsCSV($questions)
    {
        $filename = 'questions-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // En-têtes
        fputcsv($handle, [
            'ID', 'Titre', 'Contenu', 'Classe', 'Matière', 
            'Auteur', 'Email auteur', 'Statut', 'Nb réponses', 
            'Vues', 'Date création'
        ]);
        
        // Données
        foreach ($questions as $question) {
            fputcsv($handle, [
                $question->id,
                $question->titre,
                strip_tags($question->contenu),
                $question->classe?->nom ?? 'N/A',
                $question->matiere?->nom ?? 'N/A',
                $question->user?->name ?? 'Anonyme',
                $question->user?->email ?? '',
                $question->statut,
                $question->reponses_count ?? 0,
                $question->views ?? 0,
                $question->created_at->format('d/m/Y H:i')
            ]);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Exporte les réponses en CSV
     */
    private function exportReponsesCSV($reponses)
    {
        $filename = 'reponses-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // En-têtes
        fputcsv($handle, [
            'ID', 'Contenu', 'Question', 'Auteur', 'Email auteur',
            'Est solution', 'Date création'
        ]);
        
        // Données
        foreach ($reponses as $reponse) {
            fputcsv($handle, [
                $reponse->id,
                strip_tags($reponse->contenu),
                $reponse->question?->titre ?? 'N/A',
                $reponse->user?->name ?? 'Anonyme',
                $reponse->user?->email ?? '',
                $reponse->est_solution ? 'Oui' : 'Non',
                $reponse->created_at->format('d/m/Y H:i')
            ]);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}