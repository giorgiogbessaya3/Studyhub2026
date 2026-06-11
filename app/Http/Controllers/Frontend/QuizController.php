<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResultat;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Affiche la liste des quiz disponibles
     */
    public function index(Request $request)
    {
        $query = Quiz::with(['classe', 'matiere', 'chapitre'])
            ->withCount('questions')
            ->where('statut', 'publie'); // Seulement les quiz publiés

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par matière
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $quizs = $query->orderBy('created_at', 'desc')->paginate(12);

        // Pour les filtres
        $classes = Classe::where('statut', true)->orderBy('nom')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();

        // Statistiques
        $stats = [
            'total' => Quiz::where('statut', 'publie')->count(),
            'total_questions' => \App\Models\QuizQuestion::count(),
            'total_participations' => QuizResultat::count()
        ];

        return view('frontend.quiz.index', compact('quizs', 'classes', 'matieres', 'stats'));
    }

    /**
     * Affiche les détails d'un quiz
     */
    public function show(Quiz $quiz)
    {
        // Vérifier que le quiz est publié
        if ($quiz->statut !== 'publie') {
            return redirect('quiz')->with('error', 'Ce quiz n\'est pas disponible.');
        }

        $quiz->load(['classe', 'matiere', 'chapitre', 'questions']);
        
        // Vérifier si l'utilisateur a déjà participé
        $dejaParticipe = false;
        $dernierResultat = null;
        
        if (Auth::check()) {
            $dernierResultat = QuizResultat::where('quiz_id', $quiz->id)
                ->where('user_id', Auth::id())
                ->latest()
                ->first();
            
            $dejaParticipe = $dernierResultat !== null;
        }

        return view('frontend.quiz.show', compact('quiz', 'dejaParticipe', 'dernierResultat'));
    }

    /**
     * Commence un quiz (affiche les questions)
     */
    public function start(Quiz $quiz)
    {
        // Vérifier que le quiz est publié
        if ($quiz->statut !== 'publie') {
            return redirect('quiz')->with('error', 'Ce quiz n\'est pas disponible.');
        }

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Vous devez être connecté pour participer à un quiz.');
        }

        $quiz->load(['questions' => function($q) {
            $q->orderBy('ordre');
        }]);

        // Vérifier qu'il y a des questions
        if ($quiz->questions->count() === 0) {
            return redirect('quiz/' . $quiz->id)->with('error', 'Ce quiz ne contient aucune question.');
        }

        // Créer une session pour le quiz en cours
        session(['quiz_en_cours_' . $quiz->id => [
            'start_time' => time(),
            'quiz_id' => $quiz->id
        ]]);

        return view('frontend.quiz.start', compact('quiz'));
    }

    /**
     * Soumet les réponses du quiz
     */
    public function submit(Request $request, Quiz $quiz)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Vous devez être connecté pour soumettre un quiz.');
        }

        // Vérifier la session
        $sessionKey = 'quiz_en_cours_' . $quiz->id;
        if (!session()->has($sessionKey)) {
            return redirect('quiz/' . $quiz->id)->with('error', 'Session de quiz invalide.');
        }

        $quiz->load('questions');
        
        // Calculer le score
        $score = 0;
        $reponses = [];
        $totalPoints = 0;

        foreach ($quiz->questions as $question) {
            $reponseUtilisateur = $request->input('question_' . $question->id);
            $reponses[$question->id] = $reponseUtilisateur;

            if ($reponseUtilisateur !== null && $reponseUtilisateur === $question->bonne_reponse) {
                $score += $question->points;
            }

            $totalPoints += $question->points;
        }

        // Calculer le temps écoulé
        $startTime = session($sessionKey)['start_time'];
        $tempsEcoule = time() - $startTime;

        // Sauvegarder le résultat
        $resultat = QuizResultat::create([
            'quiz_id' => $quiz->id,
            'user_id' => Auth::id(),
            'score' => $score,
            'reponses' => $reponses,
            'temps_ecoule' => $tempsEcoule,
            'termine_le' => now()
        ]);

        // Nettoyer la session
        session()->forget($sessionKey);

        return redirect('quiz/' . $quiz->id . '/result/' . $resultat->id)
            ->with('success', 'Quiz terminé ! Voici vos résultats.');
    }

    /**
     * Affiche le résultat d'un quiz
     */
    public function result(Quiz $quiz, QuizResultat $resultat)
    {
        // Vérifier que le résultat appartient bien à ce quiz
        if ($resultat->quiz_id !== $quiz->id) {
            return redirect('quiz')->with('error', 'Résultat invalide.');
        }

        // Vérifier que l'utilisateur est le propriétaire du résultat
        if (Auth::id() !== $resultat->user_id) {
            return redirect('quiz')->with('error', 'Vous n\'êtes pas autorisé à voir ce résultat.');
        }

        $quiz->load('questions');
        $totalQuestions = $quiz->questions->count();
        $totalPoints = $quiz->questions->sum('points');
        $pourcentage = $totalPoints > 0 ? round(($resultat->score / $totalPoints) * 100, 1) : 0;
        $estReussi = $pourcentage >= $quiz->score_passer;

        // Préparer les détails des réponses
        $details = [];
        foreach ($quiz->questions as $question) {
            $reponseUtilisateur = $resultat->reponses[$question->id] ?? null;
            $estCorrect = $reponseUtilisateur !== null && $reponseUtilisateur === $question->bonne_reponse;

            $details[] = [
                'question' => $question,
                'reponse_utilisateur' => $reponseUtilisateur,
                'est_correct' => $estCorrect,
                'points_obtenus' => $estCorrect ? $question->points : 0
            ];
        }

        return view('frontend.quiz.result', compact('quiz', 'resultat', 'details', 'pourcentage', 'estReussi', 'totalQuestions', 'totalPoints'));
    }

    /**
     * API: Liste des quiz pour AJAX
     */
    public function apiIndex(Request $request)
    {
        $query = Quiz::with(['classe', 'matiere'])
            ->withCount('questions')
            ->where('statut', 'publie');

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $quizs = $query->orderBy('created_at', 'desc')->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $quizs
        ]);
    }
}