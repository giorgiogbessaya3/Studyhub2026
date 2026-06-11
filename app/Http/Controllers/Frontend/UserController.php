<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\QuizResultat;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Epreuve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche le tableau de bord de l'utilisateur
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistiques pour le dashboard
        $stats = [
            'total_quiz' => QuizResultat::where('user_id', $user->id)->count(),
            'quiz_reussis' => $this->compterQuizReussis($user->id),
            'total_questions' => Question::where('user_id', $user->id)->count(),
            'total_reponses' => Reponse::where('user_id', $user->id)->count(),
        ];

        // Derniers résultats de quiz
        $derniersResultats = QuizResultat::with('quiz')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Dernières questions posées
        $dernieresQuestions = Question::with(['reponses' => function($q) {
                $q->latest();
            }])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.user.dashboard', compact('user', 'stats', 'derniersResultats', 'dernieresQuestions'));
    }

    /**
     * Affiche le profil de l'utilisateur
     */
    public function profile()
    {
        $user = Auth::user();
        return view('frontend.user.profile', compact('user'));
    }

    /**
     * Met à jour le profil de l'utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
        ];

        $user->update($data);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Met à jour l'avatar de l'utilisateur
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Supprimer l'ancien avatar si existe
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload du nouvel avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Avatar mis à jour avec succès.');
    }

    /**
     * Affiche le formulaire de changement de mot de passe
     */
    public function changePassword()
    {
        return view('frontend.user.change-password');
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Mot de passe modifié avec succès.');
    }

    /**
     * Affiche les cours suivis par l'utilisateur
     */
    public function mesCours()
    {
        $cours = collect();

        return view('frontend.user.mes-cours', compact('cours'));
    }

    /**
     * Affiche les épreuves de l'utilisateur
     */
    public function mesEpreuves()
    {
        $user = Auth::user();
        $epreuves = collect();

        if ($user->classe_id) {
            $epreuves = Epreuve::whereHas('classes', function($q) use ($user) {
                    $q->where('classes.id', $user->classe_id);
                })
                ->where('statut', true)
                ->with(['typeEpreuve', 'correction'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        return view('frontend.user.mes-epreuves', compact('epreuves'));
    }

    /**
     * Affiche les résultats des quiz de l'utilisateur
     */
    public function mesResultats(Request $request)
    {
        $query = QuizResultat::with(['quiz', 'quiz.classe', 'quiz.matiere'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filtre par quiz
        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $resultats = $query->get();
            $filteredIds = [];
            
            foreach ($resultats as $resultat) {
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

        $resultats = $query->paginate(15);

        // Statistiques
        $stats = [
            'total' => QuizResultat::where('user_id', Auth::id())->count(),
            'reussites' => $this->compterQuizReussis(Auth::id()),
            'score_moyen' => $this->calculerScoreMoyen(Auth::id())
        ];

        // Liste des quiz pour le filtre
        $quizs = \App\Models\Quiz::whereHas('resultats', function($q) {
            $q->where('user_id', Auth::id());
        })->orderBy('titre')->get();

        return view('frontend.user.mes-resultats', compact('resultats', 'stats', 'quizs'));
    }

    /**
     * Affiche le détail d'un résultat
     */
    public function detailResultat($id)
    {
        $resultat = QuizResultat::with(['quiz', 'quiz.questions', 'quiz.classe', 'quiz.matiere'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Préparer les détails des réponses
        $details = [];
        foreach ($resultat->quiz->questions as $question) {
            $reponseUtilisateur = $resultat->reponses[$question->id] ?? null;
            $estCorrect = $reponseUtilisateur !== null && $reponseUtilisateur === $question->bonne_reponse;
            
            $details[] = [
                'question' => $question,
                'reponse_utilisateur' => $reponseUtilisateur,
                'est_correct' => $estCorrect,
                'points_obtenus' => $estCorrect ? $question->points : 0
            ];
        }

        $totalQuestions = $resultat->quiz->questions->count();
        $totalPoints = $resultat->quiz->questions->sum('points');
        $pourcentage = $totalPoints > 0 ? round(($resultat->score / $totalPoints) * 100, 1) : 0;
        $estReussi = $pourcentage >= ($resultat->quiz->score_passer ?? 50);

        return view('frontend.user.detail-resultat', compact('resultat', 'details', 'pourcentage', 'estReussi', 'totalQuestions', 'totalPoints'));
    }

    /**
     * Affiche les questions posées par l'utilisateur
     */
    public function mesQuestions()
    {
        $user = Auth::user();
        $questions = Question::with(['reponses' => function($q) {
                $q->latest();
            }])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('frontend.user.mes-questions', compact('questions'));
    }

    /**
     * Supprime le compte de l'utilisateur
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password']
        ]);

        $user = Auth::user();

        // Supprimer l'avatar si existe
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Déconnecter l'utilisateur
        Auth::logout();

        // Supprimer le compte
        $user->delete();

        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    // ==========================================
    // API ENDPOINTS
    // ==========================================

    /**
     * API: Profil de l'utilisateur
     */
    public function apiProfile()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $user->bio,
                'avatar_url' => $user->avatar_url,
                'role' => $user->role,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * API: Mettre à jour le profil
     */
    public function apiUpdateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'email', 'bio']));

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès',
            'data' => $user
        ]);
    }

    /**
     * API: Mes cours
     */
    public function apiMesCours()
    {
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    /**
     * API: Mes épreuves
     */
    public function apiMesEpreuves()
    {
        $user = Auth::user();
        $epreuves = collect();

        if ($user->classe_id) {
            $epreuves = Epreuve::whereHas('classes', function($q) use ($user) {
                    $q->where('classes.id', $user->classe_id);
                })
                ->where('statut', true)
                ->with(['typeEpreuve'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $epreuves
        ]);
    }

    /**
     * API: Mes résultats
     */
    public function apiMesResultats(Request $request)
    {
        $query = QuizResultat::with('quiz')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($request->filled('limit')) {
            $query->limit($request->limit);
        }

        $resultats = $query->get();

        return response()->json([
            'success' => true,
            'data' => $resultats
        ]);
    }

    /**
     * API: Détail d'un résultat
     */
    public function apiDetailResultat($id)
    {
        $resultat = QuizResultat::with(['quiz', 'quiz.questions'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $resultat
        ]);
    }

    /**
     * API: Mes questions
     */
    public function apiMesQuestions()
    {
        $questions = Question::with(['reponses' => function($q) {
                $q->latest();
            }])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    // ==========================================
    // MÉTHODES PRIVÉES
    // ==========================================

    /**
     * Compte le nombre de quiz réussis
     */
    private function compterQuizReussis($userId)
    {
        $resultats = QuizResultat::where('user_id', $userId)->get();
        $reussites = 0;

        foreach ($resultats as $resultat) {
            $totalQuestions = $resultat->quiz->questions->count();
            $pourcentage = $totalQuestions > 0 ? ($resultat->score / $totalQuestions) * 100 : 0;
            $seuilReussite = $resultat->quiz->score_passer ?? 50;
            
            if ($pourcentage >= $seuilReussite) {
                $reussites++;
            }
        }

        return $reussites;
    }

    /**
     * Calcule le score moyen
     */
    private function calculerScoreMoyen($userId)
    {
        $resultats = QuizResultat::where('user_id', $userId)->get();
        
        if ($resultats->isEmpty()) {
            return 0;
        }

        $totalPoints = 0;
        $totalQuestions = 0;

        foreach ($resultats as $resultat) {
            $totalPoints += $resultat->score;
            $totalQuestions += $resultat->quiz->questions->count();
        }

        return $totalQuestions > 0 ? round(($totalPoints / $totalQuestions) * 100, 1) : 0;
    }

}