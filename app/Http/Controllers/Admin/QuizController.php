<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResultat;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Affiche la liste des quiz
     */
    public function index(Request $request)
    {
        $query = Quiz::with(['classe', 'matiere', 'chapitre', 'createur'])
            ->withCount('questions');

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
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $quizzes = $query->paginate(15)->withQueryString();

        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        $stats = [
            'total' => Quiz::count(),
            'publies' => Quiz::where('statut', 'publie')->count(),
            'brouillons' => Quiz::where('statut', 'brouillon')->count(),
            'archives' => Quiz::where('statut', 'archive')->count(),
            'questions' => QuizQuestion::count(),
            'participations' => QuizResultat::count()
        ];

        return view('admin.quiz.index', compact('quizzes', 'classes', 'matieres', 'stats'));
    }

    /**
     * Formulaire de création d'un quiz
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $chapitres = collect();

        return view('admin.quiz.create', compact('classes', 'matieres', 'chapitres'));
    }

    /**
     * Enregistre un nouveau quiz - CORRIGÉ : redirection vers admin.quiz.index
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'chapitre_id' => 'nullable|exists:chapitres,id',
            'duree' => 'required|integer|min:1|max:180',
            'score_passer' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:brouillon,publie,archive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('quiz', $filename, 'public');
            }

            $quiz = Quiz::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'classe_id' => $request->classe_id,
                'matiere_id' => $request->matiere_id,
                'chapitre_id' => $request->chapitre_id,
                'duree' => $request->duree,
                'score_passer' => $request->score_passer,
                'statut' => $request->statut,
                'image' => $imagePath,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            // CORRECTION : Rediriger vers la liste des quiz au lieu de la page des questions
            return redirect('admin/quiz')
                ->with('success', 'Quiz créé avec succès. Vous pouvez maintenant ajouter des questions.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création du quiz: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Affiche les détails d'un quiz
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['classe', 'matiere', 'chapitre', 'createur', 'questions']);

        $totalQuestions = $quiz->questions()->count();
        $resultats = $quiz->resultats;
        
        $stats = [
            'nombre_tentatives' => $resultats->count(),
            'participants_uniques' => $resultats->unique('user_id')->count(),
            'score_moyen' => $resultats->isNotEmpty() ? round($resultats->avg('score'), 1) : 0,
            'taux_reussite' => $this->calculerTauxReussite($quiz),
            'dernier_resultat' => $quiz->resultats()->with('user')->latest()->first()
        ];

        $meilleursScores = $quiz->resultats()
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('temps_ecoule', 'asc')
            ->limit(5)
            ->get();

        return view('admin.quiz.show', compact('quiz', 'stats', 'meilleursScores'));
    }

    /**
     * Formulaire d'édition d'un quiz
     */
    public function edit(Quiz $quiz)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $chapitres = Chapitre::where('classe_id', $quiz->classe_id)
            ->where('matiere_id', $quiz->matiere_id)
            ->where('statut', true)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return view('admin.quiz.edit', compact('quiz', 'classes', 'matieres', 'chapitres'));
    }

    /**
     * Met à jour un quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'chapitre_id' => 'nullable|exists:chapitres,id',
            'duree' => 'required|integer|min:1|max:180',
            'score_passer' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:brouillon,publie,archive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('image');

            if ($request->hasFile('image')) {
                if ($quiz->image) {
                    Storage::disk('public')->delete($quiz->image);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $data['image'] = $image->storeAs('quiz', $filename, 'public');
            }

            $quiz->update($data);

            DB::commit();

            return redirect('admin/quiz/' . $quiz->id)
                ->with('success', 'Quiz mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Supprime un quiz
     */
    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            if ($quiz->image) {
                Storage::disk('public')->delete($quiz->image);
            }

            foreach ($quiz->questions as $question) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }
            }

            $quiz->delete();

            DB::commit();

            return redirect('admin/quiz')
                ->with('success', 'Quiz supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Change le statut d'un quiz
     */
    public function toggleStatus(Quiz $quiz)
    {
        $nouveauStatut = match($quiz->statut) {
            'brouillon' => 'publie',
            'publie' => 'archive',
            'archive' => 'brouillon',
            default => 'brouillon'
        };

        $quiz->update(['statut' => $nouveauStatut]);

        $message = "Quiz " . match($nouveauStatut) {
            'publie' => 'publié',
            'archive' => 'archivé',
            'brouillon' => 'remis en brouillon'
        };

        return redirect()->back()->with('success', "Quiz $message avec succès.");
    }

    /**
     * Duplique un quiz
     */
    public function duplicate(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $nouveauQuiz = $quiz->replicate();
            $nouveauQuiz->titre = $quiz->titre . ' (copie)';
            $nouveauQuiz->statut = 'brouillon';
            $nouveauQuiz->created_by = auth()->id();
            $nouveauQuiz->save();

            foreach ($quiz->questions as $question) {
                $nouvelleQuestion = $question->replicate();
                $nouvelleQuestion->quiz_id = $nouveauQuiz->id;
                $nouvelleQuestion->save();
            }

            DB::commit();

            return redirect('admin/quiz')
                ->with('success', 'Quiz dupliqué avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la duplication: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les questions d'un quiz - À créer si nécessaire
     */
    public function questions(Quiz $quiz)
    {
        $quiz->load(['questions' => function($q) {
            $q->orderBy('ordre');
        }]);
        
        // Si cette vue n'existe pas, on peut rediriger vers l'édition ou la liste
        // Pour l'instant, on garde la vue mais il faudra la créer
        return view('admin.quiz.questions.index', compact('quiz'));
    }

    /**
     * Affiche les statistiques d'un quiz
     */
    public function statistiques(Quiz $quiz)
    {
        $resultats = $quiz->resultats()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalQuestions = $quiz->questions()->count();
        $resultatsCollection = $quiz->resultats;
        
        $stats = [
            'total' => $resultatsCollection->count(),
            'moyenne' => $resultatsCollection->isNotEmpty() ? round($resultatsCollection->avg('score'), 1) : 0,
            'max' => $resultatsCollection->isNotEmpty() ? $resultatsCollection->max('score') : 0,
            'min' => $resultatsCollection->isNotEmpty() ? $resultatsCollection->min('score') : 0,
            'reussite' => $this->calculerTauxReussite($quiz),
            'temps_moyen' => $this->calculerTempsMoyen($quiz)
        ];

        $distribution = [
            '0-20' => $quiz->resultats()->where('score', '<=', 2)->count(),
            '21-40' => $quiz->resultats()->whereBetween('score', [3, 4])->count(),
            '41-60' => $quiz->resultats()->whereBetween('score', [5, 6])->count(),
            '61-80' => $quiz->resultats()->whereBetween('score', [7, 8])->count(),
            '81-100' => $quiz->resultats()->where('score', '>=', 9)->count(),
        ];

        return view('admin.quiz.statistiques', compact('quiz', 'resultats', 'stats', 'distribution'));
    }

    /**
     * Exporte les résultats d'un quiz en CSV
     */
    public function exportResultats(Quiz $quiz)
    {
        $resultats = $quiz->resultats()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalQuestions = $quiz->questions()->count();
        $filename = 'quiz-' . $quiz->id . '-resultats-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'Utilisateur',
            'Email',
            'Score',
            'Pourcentage',
            'Réussite',
            'Temps',
            'Date'
        ]);

        foreach ($resultats as $resultat) {
            $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
            
            fputcsv($handle, [
                $resultat->user->name,
                $resultat->user->email,
                $resultat->score . '/' . $totalQuestions,
                $pourcentage . '%',
                $pourcentage >= $quiz->score_passer ? 'Oui' : 'Non',
                $this->formatTemps($resultat->temps_ecoule),
                $resultat->created_at->format('d/m/Y H:i')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Récupère les chapitres pour AJAX
     */
    public function getChapitres(Request $request)
    {
        $chapitres = Chapitre::where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('statut', true)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return response()->json($chapitres);
    }

    /**
     * Affiche la liste de tous les résultats
     */
    public function resultats(Request $request)
    {
        $query = QuizResultat::with(['quiz', 'quiz.classe', 'quiz.matiere', 'user']);

        // Filtre par quiz
        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        // Filtre par utilisateur
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Filtre par statut (réussi/échoué)
        if ($request->filled('statut')) {
            $resultatsTemp = $query->get();
            $filteredIds = [];
            
            foreach ($resultatsTemp as $resultat) {
                $totalQuestions = $resultat->quiz->questions->count();
                $pourcentage = $totalQuestions > 0 ? ($resultat->score / $totalQuestions) * 100 : 0;
                $seuilReussite = $resultat->quiz->score_passer ?? 50;
                $estReussi = $pourcentage >= $seuilReussite;
                
                if (($request->statut == 'reussi' && $estReussi) || 
                    ($request->statut == 'echoue' && !$estReussi)) {
                    $filteredIds[] = $resultat->id;
                }
            }
            
            $query->whereIn('id', $filteredIds);
        }

        $resultats = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calcul des statistiques globales
        $tousResultats = QuizResultat::all();
        $reussites = 0;
        $echecs = 0;

        foreach ($tousResultats as $r) {
            $totalQ = $r->quiz->questions->count();
            $pourc = $totalQ > 0 ? ($r->score / $totalQ) * 100 : 0;
            $seuil = $r->quiz->score_passer ?? 50;
            
            if ($pourc >= $seuil) {
                $reussites++;
            } else {
                $echecs++;
            }
        }

        $stats = [
            'reussites' => $reussites,
            'echecs' => $echecs,
            'participants_uniques' => QuizResultat::distinct('user_id')->count('user_id')
        ];

        // Données pour les filtres
        $quizs = Quiz::orderBy('titre')->get();
        $users = User::orderBy('name')->get();

        return view('admin.quiz.resultats', compact('resultats', 'stats', 'quizs', 'users'));
    }

    /**
     * Affiche le détail d'un résultat
     */
    public function showResultat($id)
    {
        $resultat = QuizResultat::with(['quiz', 'user', 'quiz.questions', 'quiz.classe', 'quiz.matiere'])->findOrFail($id);
        
        // Calcul des résultats précédent et suivant pour la navigation
        $tousResultats = QuizResultat::where('quiz_id', $resultat->quiz_id)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();
        
        $currentIndex = array_search($resultat->id, $tousResultats);
        $resultatPrecedent = $currentIndex > 0 ? QuizResultat::find($tousResultats[$currentIndex - 1]) : null;
        $resultatSuivant = $currentIndex < count($tousResultats) - 1 ? QuizResultat::find($tousResultats[$currentIndex + 1]) : null;

        // Statistiques pour ce résultat
        $stats = [];
        if ($resultat->quiz->questions->count() > 0) {
            $bonnesReponses = 0;
            foreach ($resultat->quiz->questions as $index => $question) {
                if (isset($resultat->reponses[$index]) && $resultat->reponses[$index] == $question->bonne_reponse) {
                    $bonnesReponses++;
                }
            }
            $stats['total_reponses'] = $resultat->quiz->questions->count();
            $stats['bonnes_reponses'] = $bonnesReponses;
            $stats['mauvaises_reponses'] = $stats['total_reponses'] - $bonnesReponses;
            $stats['taux_reussite'] = $stats['total_reponses'] > 0 ? round(($bonnesReponses / $stats['total_reponses']) * 100, 1) : 0;
        }

        return view('admin.quiz.show-resultat', compact('resultat', 'stats', 'resultatPrecedent', 'resultatSuivant'));
    }

    /**
     * Supprime un résultat
     */
    public function destroyResultat($id)
    {
        $resultat = QuizResultat::findOrFail($id);
        $resultat->delete();

        return redirect('admin/resultats')
            ->with('success', 'Résultat supprimé avec succès.');
    }

    /**
     * Suppression groupée de résultats
     */
    public function bulkDeleteResultats(Request $request)
    {
        $request->validate([
            'ids' => 'required|string'
        ]);

        $ids = explode(',', $request->ids);
        
        try {
            DB::beginTransaction();
            
            QuizResultat::whereIn('id', $ids)->delete();
            
            DB::commit();
            
            return redirect('admin/resultats')
                ->with('success', count($ids) . ' résultat(s) supprimé(s) avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Exporte tous les résultats en CSV
     */
    public function exportAllResultats(Request $request)
    {
        $query = QuizResultat::with(['quiz', 'quiz.classe', 'quiz.matiere', 'user']);

        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $resultats = $query->orderBy('created_at', 'desc')->get();

        $filename = 'tous-les-resultats-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'ID',
            'Utilisateur',
            'Email',
            'Quiz',
            'Classe',
            'Matière',
            'Score',
            'Total Questions',
            'Pourcentage',
            'Réussite',
            'Temps',
            'Date'
        ]);

        foreach ($resultats as $resultat) {
            $totalQuestions = $resultat->quiz->questions->count();
            $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
            $seuilReussite = $resultat->quiz->score_passer ?? 50;
            
            fputcsv($handle, [
                $resultat->id,
                $resultat->user->name,
                $resultat->user->email,
                $resultat->quiz->titre,
                $resultat->quiz->classe->nom ?? 'N/A',
                $resultat->quiz->matiere->nom ?? 'N/A',
                $resultat->score,
                $totalQuestions,
                $pourcentage . '%',
                $pourcentage >= $seuilReussite ? 'Oui' : 'Non',
                $this->formatTemps($resultat->temps_ecoule),
                $resultat->created_at->format('d/m/Y H:i')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Calcule le taux de réussite d'un quiz
     */
    private function calculerTauxReussite(Quiz $quiz)
    {
        $resultats = $quiz->resultats;
        $total = $resultats->count();
        
        if ($total == 0) return 0;

        $totalQuestions = $quiz->questions()->count();
        if ($totalQuestions == 0) return 0;

        $reussites = $resultats->filter(function($r) use ($totalQuestions, $quiz) {
            $pourcentage = ($r->score / $totalQuestions) * 100;
            return $pourcentage >= $quiz->score_passer;
        })->count();

        return round(($reussites / $total) * 100);
    }

    /**
     * Calcule le temps moyen d'un quiz
     */
    private function calculerTempsMoyen(Quiz $quiz)
    {
        $tempsMoyen = $quiz->resultats()->avg('temps_ecoule');
        if (!$tempsMoyen) return 'N/A';

        return $this->formatTemps($tempsMoyen);
    }

    /**
     * Formate le temps en minutes:secondes
     */
    private function formatTemps($secondes)
    {
        $minutes = floor($secondes / 60);
        $secondesRestantes = $secondes % 60;
        return $minutes . ':' . str_pad($secondesRestantes, 2, '0', STR_PAD_LEFT);
    }

    /**
     * API: Liste des quiz
     */
    public function apiIndex()
    {
        $quizs = Quiz::with(['classe', 'matiere'])->where('statut', 'publie')->get();
        return response()->json($quizs);
    }

    /**
     * API: Détail d'un quiz
     */
    public function apiShow(Quiz $quiz)
    {
        $quiz->load(['classe', 'matiere', 'questions']);
        return response()->json($quiz);
    }

    /**
     * API: Questions d'un quiz
     */
    public function apiQuestions(Quiz $quiz)
    {
        $questions = $quiz->questions()->orderBy('ordre')->get();
        return response()->json($questions);
    }

    /**
     * API: Soumettre un quiz
     */
    public function apiSubmit(Request $request, Quiz $quiz)
    {
        // Logique de soumission de quiz pour API
        return response()->json(['message' => 'API submit - À implémenter']);
    }

    /**
     * API: Résultats d'un quiz
     */
    public function apiResultats(Quiz $quiz)
    {
        $resultats = $quiz->resultats()->with('user')->get();
        return response()->json($resultats);
    }

    /**
     * API: Afficher un résultat
     */
    public function apiShowResultat($id)
    {
        $resultat = QuizResultat::with(['quiz', 'user'])->findOrFail($id);
        return response()->json($resultat);
    }

    /**
     * API: Résultats par quiz
     */
    public function apiResultatsByQuiz(Quiz $quiz)
    {
        $resultats = $quiz->resultats()->with('user')->get();
        return response()->json($resultats);
    }

    /**
     * API: Résultats par utilisateur
     */
    public function apiResultatsByUser(User $user)
    {
        $resultats = QuizResultat::with('quiz')->where('user_id', $user->id)->get();
        return response()->json($resultats);
    }
}