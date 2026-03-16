<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epreuve;
use App\Models\Chapitre;
use App\Models\User;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\TypeEpreuve;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'epreuves' => Epreuve::count(),
            'cours' => Chapitre::count(),
            'utilisateurs' => User::count(),
            'questions' => Question::where('statut', 'en_attente')->count(),
            'quiz' => Quiz::count(),
            'contacts_non_lus' => Contact::where('lu', false)->count(),
        ];

        // Dernières épreuves
        $dernieresEpreuves = Epreuve::with(['classe', 'matiere', 'typeEpreuve'])
            ->latest()
            ->take(5)
            ->get();

        // Derniers cours
        $derniersCours = Chapitre::with(['classe', 'matiere'])
            ->latest()
            ->take(5)
            ->get();

        // Derniers utilisateurs inscrits
        $derniersUtilisateurs = User::latest()
            ->take(5)
            ->get();

        // Questions en attente
        $questionsEnAttente = Question::with(['user', 'classe', 'matiere'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        // Derniers quiz
        $derniersQuiz = Quiz::with(['classe', 'matiere'])
            ->latest()
            ->take(5)
            ->get();

        // Répartition par classe
        $classes = Classe::withCount('epreuves')
            ->orderBy('ordre')
            ->get()
            ->map(function($classe) {
                return [
                    'nom' => $classe->nom,
                    'total' => $classe->epreuves_count,
                ];
            });

        // Total des épreuves pour les pourcentages
        $totalEpreuves = $stats['epreuves'] > 0 ? $stats['epreuves'] : 1;

        return view('admin.dashboard', compact(
            'stats',
            'dernieresEpreuves',
            'derniersCours',
            'derniersUtilisateurs',
            'questionsEnAttente',
            'derniersQuiz',
            'classes',
            'totalEpreuves'
        ));
    }

    /**
     * Dashboard spécifique pour les épreuves
     */
    public function dashboardEpreuves()
    {
        // Statistiques des épreuves
        $stats = [
            'total' => Epreuve::count(),
            'avec_correction' => Epreuve::has('correction')->count(),
            'sans_correction' => Epreuve::doesntHave('correction')->count(),
            'publiees' => Epreuve::where('statut', true)->count(),
            'brouillons' => Epreuve::where('statut', false)->count(),
        ];

        // Épreuves par classe
        $epreuves_par_classe = Classe::withCount('epreuves')
            ->having('epreuves_count', '>', 0)
            ->orderBy('epreuves_count', 'desc')
            ->get();

        // Épreuves par matière (top 10)
        $epreuves_par_matiere = Matiere::withCount('epreuves')
            ->having('epreuves_count', '>', 0)
            ->orderBy('epreuves_count', 'desc')
            ->take(10)
            ->get();

        // Épreuves par type
        $epreuves_par_type = TypeEpreuve::withCount('epreuves')
            ->having('epreuves_count', '>', 0)
            ->orderBy('epreuves_count', 'desc')
            ->get();

        // Épreuves par année
        $epreuves_par_annee = Epreuve::selectRaw('annee, count(*) as total')
            ->whereNotNull('annee')
            ->groupBy('annee')
            ->orderBy('annee', 'desc')
            ->get();

        // Dernières épreuves ajoutées
        $dernieres_epreuves = Epreuve::with(['classe', 'matiere', 'typeEpreuve'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.epreuves', compact(
            'stats',
            'epreuves_par_classe',
            'epreuves_par_matiere',
            'epreuves_par_type',
            'epreuves_par_annee',
            'dernieres_epreuves'
        ));
    }

    /**
     * Dashboard spécifique pour les cours
     */
    public function dashboardCours()
    {
        $stats = [
            'total' => Chapitre::count(),
            'par_classe' => Chapitre::with('classe')
                ->get()
                ->groupBy('classe.nom')
                ->map->count(),
        ];

        $derniers_cours = Chapitre::with(['classe', 'matiere'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.cours', compact('stats', 'derniers_cours'));
    }

    /**
     * Dashboard spécifique pour les évaluations/quiz
     */
    public function dashboardEvaluations()
    {
        $stats = [
            'total' => Quiz::count(),
            'publies' => Quiz::where('statut', 'publie')->count(),
            'brouillons' => Quiz::where('statut', 'brouillon')->count(),
            'archives' => Quiz::where('statut', 'archive')->count(),
        ];

        $derniers_quiz = Quiz::with(['classe', 'matiere'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.evaluations', compact('stats', 'derniers_quiz'));
    }

    /**
     * Dashboard spécifique pour l'assistance
     */
    public function dashboardAssistance()
    {
        $stats = [
            'questions_en_attente' => Question::where('statut', 'en_attente')->count(),
            'questions_publiees' => Question::where('statut', 'publiee')->count(),
            'questions_resolues' => Question::where('statut', 'resolue')->count(),
        ];

        $recentesQuestions = Question::with(['user', 'classe', 'matiere'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.assistance', compact('stats', 'recentesQuestions'));
    }

    /**
     * Dashboard spécifique pour les utilisateurs
     */
    public function dashboardUsers()
    {
        $stats = [
            'total' => User::count(),
            'administrateurs' => User::where('role', 'admin')->count(),
            'enseignants' => User::where('role', 'enseignant')->count(),
            'eleves' => User::where('role', 'eleve')->count(),
            'actifs' => User::where('is_active', true)->count(),
            'inactifs' => User::where('is_active', false)->count(),
        ];

        $derniersInscrits = User::latest()->take(10)->get();

        return view('admin.dashboard.users', compact('stats', 'derniersInscrits'));
    }
}