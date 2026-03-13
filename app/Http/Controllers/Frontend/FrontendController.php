<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Epreuve;
use App\Models\TypeEpreuve;
use App\Models\Question; // Modèle pour les questions d'assistance
use App\Models\Reponse;  // Modèle pour les réponses
use App\Models\Quiz;
use App\Models\Resultat;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    // ==========================================
    // PAGE D'ACCUEIL - CORRIGÉE POUR 4 CLASSES
    // ==========================================
    
    public function index()
    {
        $settings = Setting::first();
        
        // Stats pour la page d'accueil
        $stats = [
            'total_epreuves' => Epreuve::where('statut', true)->count(),
            'total_cours' => Chapitre::where('statut', true)->count(),
            'total_quiz' => Quiz::where('statut', 'publie')->count(),
            'total_utilisateurs' => User::count(),
            'total_classes' => Classe::where('statut', true)->count(),
        ];
        
        // Dernières épreuves ajoutées
        $recentEpreuves = Epreuve::with(['classe', 'matiere', 'typeEpreuve'])
            ->where('statut', true)
            ->latest()
            ->take(5)
            ->get();
        
        // Derniers quiz
        $recentQuiz = Quiz::with(['classe', 'matiere'])
            ->where('statut', 'publie')
            ->latest()
            ->take(5)
            ->get();
        
        // Dernières questions d'assistance - CORRIGÉ avec 'publiee' au lieu de 'publie'
        $recentQuestions = Question::with(['user', 'matiere', 'classe'])
            ->where('statut', 'publiee') // Changé de 'publie' à 'publiee'
            ->latest()
            ->take(5)
            ->get();
        
        // CLASSES POPULAIRES - 4 classes exactement pour la grille
        // Liste des classes à afficher dans l'ordre souhaité
        $classeNames = ['6ème', '5ème', '4ème', '3ème', 'Seconde', 'Première', 'Terminale'];
        
        // Prendre les 4 premières classes disponibles dans cet ordre
        $quickClasses = collect();
        
        foreach ($classeNames as $nom) {
            if ($quickClasses->count() >= 4) {
                break;
            }
            
            $classe = Classe::where('nom', $nom)
                ->where('statut', true)
                ->first();
            
            if ($classe) {
                // Charger le nombre de matières pour chaque classe
                $classe->matieres_count = $classe->matieres()->count();
                $quickClasses->push($classe);
            }
        }
        
        // Si on a moins de 4 classes, compléter avec d'autres classes
        if ($quickClasses->count() < 4) {
            $existingIds = $quickClasses->pluck('id')->toArray();
            $autresClasses = Classe::where('statut', true)
                ->whereNotIn('id', $existingIds)
                ->orderBy('ordre')
                ->take(4 - $quickClasses->count())
                ->get();
            
            // Charger le nombre de matières pour les classes supplémentaires
            foreach ($autresClasses as $classe) {
                $classe->matieres_count = $classe->matieres()->count();
            }
            
            $quickClasses = $quickClasses->concat($autresClasses);
        }
        
        return view('frontend.index', compact(
            'settings', 
            'stats', 
            'recentEpreuves', 
            'recentQuiz',
            'recentQuestions',
            'quickClasses'
        ));
    }

    // ==========================================
    // NAVIGATION CLASSES → MATIÈRES → CHAPITRES
    // ==========================================
    
    /**
     * Étape 1: Liste toutes les classes
     */
    public function classes()
    {
        $settings = Setting::first();
        
        $classes = Classe::where('statut', true)
            ->withCount('matieres')
            ->orderBy('ordre')
            ->get();
        
        $classesByCycle = [
            'college' => $classes->filter(function($c) {
                return in_array($c->nom, ['6ème', '5ème', '4ème', '3ème']);
            }),
            'lycee' => $classes->filter(function($c) {
                return in_array($c->nom, ['Seconde', 'Première', 'Terminale']);
            })
        ];

        return view('frontend.classes', compact('settings', 'classes', 'classesByCycle'));
    }

    /**
     * Étape 2: Détail d'une classe → Liste des matières
     */
    public function classeDetail($identifier)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($identifier);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        $type = request('type', 'cours');
        
        $matieres = $classe->matieres()
            ->where('statut', true)
            ->get();
        
        if ($matieres->isEmpty()) {
            $matieres = Matiere::where('statut', true)
                ->orderBy('nom')
                ->get();
        }

        return view('frontend.classe_detail', compact('settings', 'classe', 'matieres', 'type'));
    }

    /**
     * Étape 3: Détail d'une matière → Liste des chapitres/épreuves
     */
    public function matiereDetail($identifier)
    {
        $settings = Setting::first();
        
        $matiere = $this->findMatiere($identifier);
        
        if (!$matiere) {
            abort(404, 'Matière non trouvée');
        }
        
        $classeId = request('classe');
        $classe = $this->findClasse($classeId);
        
        if (!$classe) {
            return redirect('/classes');
        }
        
        $chapitres = Chapitre::where('matiere_id', $matiere->id)
            ->where('classe_id', $classe->id)
            ->where('statut', true)
            ->withCount('contenus')
            ->orderBy('ordre')
            ->get();
        
        $epreuves = Epreuve::where('matiere_id', $matiere->id)
            ->where('classe_id', $classe->id)
            ->where('statut', true)
            ->with(['typeEpreuve', 'correction'])
            ->latest()
            ->take(10)
            ->get();
        
        $quizs = Quiz::where('matiere_id', $matiere->id)
            ->where('classe_id', $classe->id)
            ->where('statut', 'publie')
            ->latest()
            ->take(5)
            ->get();
        
        return view('frontend.matiere_detail', compact(
            'settings', 
            'matiere', 
            'classe', 
            'chapitres', 
            'epreuves',
            'quizs'
        ));
    }

    /**
     * Étape 4: Détail d'un chapitre → Contenu pédagogique
     */
    public function chapitreDetail($identifier)
    {
        $settings = Setting::first();
        
        $chapitre = is_numeric($identifier)
            ? Chapitre::where('id', $identifier)->where('statut', true)->first()
            : Chapitre::where('slug', $identifier)->where('statut', true)->first();
        
        if (!$chapitre) {
            abort(404, 'Chapitre non trouvé');
        }
        
        $chapitre->load(['matiere', 'classe', 'contenus' => function($q) {
            $q->orderBy('ordre');
        }]);

        $chapitrePrecedent = Chapitre::where('matiere_id', $chapitre->matiere_id)
            ->where('classe_id', $chapitre->classe_id)
            ->where('ordre', '<', $chapitre->ordre)
            ->where('statut', true)
            ->orderBy('ordre', 'desc')
            ->first();
        
        $chapitreSuivant = Chapitre::where('matiere_id', $chapitre->matiere_id)
            ->where('classe_id', $chapitre->classe_id)
            ->where('ordre', '>', $chapitre->ordre)
            ->where('statut', true)
            ->orderBy('ordre', 'asc')
            ->first();
        
        $contenus = $chapitre->contenus;

        return view('frontend.chapitre_detail', compact(
            'settings', 
            'chapitre', 
            'chapitrePrecedent', 
            'chapitreSuivant', 
            'contenus'
        ));
    }

    // ==========================================
    // COURS EN LIGNE
    // ==========================================
    
    public function cours()
    {
        return $this->classes();
    }
    
    public function coursDetail($identifier)
    {
        $chapitre = is_numeric($identifier)
            ? Chapitre::find($identifier)
            : Chapitre::where('slug', $identifier)->first();
        
        if ($chapitre) {
            return redirect('/chapitre/' . ($chapitre->slug ?? $chapitre->id));
        }
        
        abort(404);
    }

    // ==========================================
    // BANQUE D'ÉPREUVES
    // ==========================================
    
    /**
     * Étape 1: Liste toutes les classes pour épreuves
     */
    public function epreuvesClasses()
    {
        $settings = Setting::first();
        
        $classes = Classe::where('statut', true)
            ->orderBy('ordre')
            ->get();
        
        $classesByCycle = [
            'college' => $classes->filter(function($c) {
                return in_array($c->nom, ['6ème', '5ème', '4ème', '3ème']);
            }),
            'lycee' => $classes->filter(function($c) {
                return in_array($c->nom, ['Seconde', 'Première', 'Terminale']);
            })
        ];
        
        return view('frontend.epreuves.classes', compact('settings', 'classes', 'classesByCycle'));
    }

    /**
     * Étape 2: Liste des types d'épreuves pour une classe
     */
    public function epreuvesTypes($classeNom)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeNom);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        $types = TypeEpreuve::where('statut', true)
            ->withCount(['epreuves' => function($q) use ($classe) {
                $q->where('classe_id', $classe->id)->where('statut', true);
            }])
            ->orderBy('nom')
            ->get();
        
        return view('frontend.epreuves.types', compact('settings', 'types', 'classeNom', 'classe'));
    }

    /**
     * Étape 3: Liste des matières pour un type d'épreuve
     */
    public function epreuvesMatieres($classeNom, $typeId)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeNom);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        $type = TypeEpreuve::where('id', $typeId)->where('statut', true)->first();
        
        if (!$type) {
            abort(404, 'Type d\'épreuve non trouvé');
        }
        
        $matieres = Matiere::where('statut', true)
            ->whereHas('epreuves', function($q) use ($classe, $type) {
                $q->where('classe_id', $classe->id)
                  ->where('type_epreuve_id', $type->id)
                  ->where('statut', true);
            })
            ->withCount(['epreuves' => function($q) use ($classe, $type) {
                $q->where('classe_id', $classe->id)
                  ->where('type_epreuve_id', $type->id)
                  ->where('statut', true);
            }])
            ->orderBy('nom')
            ->get();
        
        return view('frontend.epreuves.matieres', compact(
            'settings', 
            'matieres', 
            'classeNom', 
            'typeId', 
            'type',
            'classe'
        ));
    }

    /**
     * Étape 4: Liste des épreuves pour une matière
     */
    public function epreuvesListe($classeNom, $typeId, $matiereId, Request $request)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeNom);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        $type = TypeEpreuve::where('id', $typeId)->where('statut', true)->first();
        
        if (!$type) {
            abort(404, 'Type d\'épreuve non trouvé');
        }
        
        $matiere = Matiere::where('id', $matiereId)->where('statut', true)->first();
        
        if (!$matiere) {
            abort(404, 'Matière non trouvée');
        }
        
        $query = Epreuve::with(['typeEpreuve', 'correction', 'classe', 'matiere'])
            ->where('classe_id', $classe->id)
            ->where('matiere_id', $matiere->id)
            ->where('type_epreuve_id', $type->id)
            ->where('statut', true);
        
        // Filtre par année
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }
        
        // Recherche
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        
        // Tri
        $sort = $request->get('sort', 'recent');
        if ($sort == 'recent') {
            $query->latest();
        } elseif ($sort == 'ancien') {
            $query->oldest();
        } elseif ($sort == 'titre') {
            $query->orderBy('titre');
        }
        
        $epreuves = $query->paginate(12)->withQueryString();
        
        // Années disponibles pour le filtre
        $annees = Epreuve::where('classe_id', $classe->id)
            ->where('matiere_id', $matiere->id)
            ->where('type_epreuve_id', $type->id)
            ->where('statut', true)
            ->whereNotNull('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee');
        
        return view('frontend.epreuves.liste', compact(
            'settings',
            'epreuves',
            'classeNom',
            'typeId',
            'type',
            'matiereId',
            'matiere',
            'classe',
            'annees'
        ));
    }

    /**
     * Liste des épreuves avec filtres (route existante)
     */
    public function epreuves(Request $request)
    {
        $settings = Setting::first();
        
        $query = Epreuve::with(['classe', 'matiere', 'typeEpreuve', 'correction'])
            ->where('statut', true);
        
        if ($request->filled('classe')) {
            $classeId = $request->classe;
            if (!is_numeric($classeId)) {
                $classe = Classe::where('nom', $classeId)->first();
                $classeId = $classe ? $classe->id : null;
            }
            if ($classeId) {
                $query->where('classe_id', $classeId);
            }
        }
        
        if ($request->filled('matiere')) {
            $matiereId = $request->matiere;
            if (!is_numeric($matiereId)) {
                $matiere = Matiere::where('nom', $matiereId)->first();
                $matiereId = $matiere ? $matiere->id : null;
            }
            if ($matiereId) {
                $query->where('matiere_id', $matiereId);
            }
        }
        
        if ($request->filled('type')) {
            $query->where('type_epreuve_id', $request->type);
        }
        
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        
        $epreuves = $query->latest()->paginate(15);
        
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        $types = TypeEpreuve::where('statut', true)->orderBy('nom')->get();
        
        return view('frontend.epreuves', compact(
            'settings', 
            'epreuves', 
            'classes', 
            'matieres', 
            'types'
        ));
    }

    /**
     * Détail d'une épreuve
     */
    public function epreuveDetail($identifier)
    {
        $settings = Setting::first();
        
        $epreuve = is_numeric($identifier)
            ? Epreuve::where('id', $identifier)
                ->with(['classe', 'matiere', 'typeEpreuve', 'correction'])
                ->where('statut', true)
                ->first()
            : Epreuve::where('slug', $identifier)
                ->with(['classe', 'matiere', 'typeEpreuve', 'correction'])
                ->where('statut', true)
                ->first();
        
        if (!$epreuve) {
            abort(404, 'Épreuve non trouvée');
        }
        
        $similaires = Epreuve::where('classe_id', $epreuve->classe_id)
            ->where('matiere_id', $epreuve->matiere_id)
            ->where('id', '!=', $epreuve->id)
            ->where('statut', true)
            ->latest()
            ->take(3)
            ->get();
        
        return view('frontend.epreuve_detail', compact('settings', 'epreuve', 'similaires'));
    }

    /**
     * Télécharger une épreuve
     */
    public function downloadEpreuve($id)
    {
        $epreuve = Epreuve::findOrFail($id);
        
        if (!$epreuve->fichier || !Storage::disk('public')->exists($epreuve->fichier)) {
            abort(404, 'Fichier non trouvé');
        }
        
        $epreuve->increment('downloads');
        
        return Storage::disk('public')->download(
            $epreuve->fichier,
            $epreuve->nom_fichier_original ?? 'epreuve_' . $epreuve->id . '.pdf'
        );
    }

    /**
     * Voir la correction d'une épreuve
     */
    public function correction($id)
    {
        $settings = Setting::first();
        
        $epreuve = Epreuve::with('correction')->findOrFail($id);
        
        if (!$epreuve->correction) {
            return redirect()->back()->with('error', 'La correction n\'est pas encore disponible');
        }
        
        return view('frontend.correction', compact('settings', 'epreuve'));
    }

    /**
     * Télécharger la correction
     */
    public function downloadCorrection($id)
    {
        $epreuve = Epreuve::with('correction')->findOrFail($id);
        
        if (!$epreuve->correction || !$epreuve->correction->fichier) {
            abort(404, 'Correction non trouvée');
        }
        
        if (!Storage::disk('public')->exists($epreuve->correction->fichier)) {
            abort(404, 'Fichier non trouvé');
        }
        
        return Storage::disk('public')->download(
            $epreuve->correction->fichier,
            $epreuve->correction->nom_fichier_original ?? 'correction_' . $epreuve->id . '.pdf'
        );
    }

    // ==========================================
    // QUIZ
    // ==========================================
    
    /**
     * Liste des quiz disponibles
     */
    public function quizList()
    {
        $settings = Setting::first();
        
        $quizs = Quiz::with(['classe', 'matiere'])
            ->withCount('questions')
            ->where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.quiz_list', compact('settings', 'quizs'));
    }

    /**
     * Démarrer un quiz
     */
    public function quizStart(Quiz $quiz)
    {
        $settings = Setting::first();
        
        if ($quiz->statut !== 'publie') {
            abort(404, 'Quiz non disponible');
        }
        
        $quiz->load(['questions' => function($q) {
            $q->inRandomOrder();
        }]);
        
        return view('frontend.quiz_start', compact('settings', 'quiz'));
    }

    /**
     * Soumettre les réponses d'un quiz
     */
    public function quizSubmit(Request $request, Quiz $quiz)
    {
        $reponses = $request->input('reponses', []);
        $score = 0;
        $total = $quiz->questions->count();
        $details = [];
        
        foreach ($quiz->questions as $question) {
            $reponseDonnee = $reponses[$question->id] ?? null;
            $estCorrect = $reponseDonnee == $question->bonne_reponse;
            
            if ($estCorrect) {
                $score++;
            }
            
            $details[] = [
                'question_id' => $question->id,
                'question_titre' => $question->titre,
                'reponse_donnee' => $reponseDonnee,
                'reponse_correcte' => $question->bonne_reponse,
                'est_correct' => $estCorrect
            ];
        }
        
        $pourcentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        
        $resultatId = null;
        if (auth()->check()) {
            $resultat = Resultat::create([
                'user_id' => auth()->id(),
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total' => $total,
                'pourcentage' => $pourcentage,
                'reponses' => json_encode($details),
                'temps' => $request->input('temps', 0)
            ]);
            $resultatId = $resultat->id;
        }
        
        return redirect('/quiz/' . $quiz->id . '/result?score=' . $score . '&total=' . $total . '&pourcentage=' . $pourcentage . '&resultat_id=' . $resultatId)
            ->with('success', 'Quiz terminé !');
    }

    /**
     * Voir le résultat d'un quiz
     */
    public function quizResult(Request $request, Quiz $quiz)
    {
        $settings = Setting::first();
        
        $score = $request->input('score', 0);
        $total = $request->input('total', 1);
        $pourcentage = $request->input('pourcentage', 0);
        
        $resultat = null;
        if ($request->filled('resultat_id')) {
            $resultat = Resultat::with('reponses')->find($request->resultat_id);
        }
        
        return view('frontend.quiz_result', compact(
            'settings', 
            'quiz', 
            'score', 
            'total', 
            'pourcentage',
            'resultat'
        ));
    }

    // ==========================================
    // ASSISTANCE PÉDAGOGIQUE - CORRIGÉ AVEC LE BON CHAMP 'statut'
    // ==========================================
    
    /**
     * Liste des questions d'assistance
     */
    public function assistance(Request $request)
    {
        $settings = Setting::first();
        
        $query = Question::with(['user', 'matiere', 'classe'])
            ->withCount(['reponses' => function($q) {
                $q->where('statut', 'approuvee'); // Les réponses approuvées
            }])
            ->where('statut', 'publiee'); // CORRIGÉ: 'publiee' au lieu de 'publie'
        
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
                  ->orWhere('contenu', 'like', "%{$search}%"); // CORRIGÉ: 'contenu' au lieu de 'description'
            });
        }
        
        $questions = $query->latest()->paginate(15);
        
        $classes = Classe::where('statut', true)->orderBy('nom')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        
        return view('frontend.assistance', compact('settings', 'questions', 'classes', 'matieres'));
    }

    /**
     * Formulaire pour poser une nouvelle question
     */
    public function createQuestion()
    {
        $settings = Setting::first();
        
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        
        return view('frontend.assistance.create', compact('settings', 'classes', 'matieres'));
    }

    /**
     * Enregistrer une nouvelle question
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string', // CORRIGÉ: 'contenu' au lieu de 'description'
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = [
            'user_id' => Auth::id(),
            'titre' => $request->titre,
            'contenu' => $request->contenu, // CORRIGÉ: 'contenu' au lieu de 'description'
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'statut' => 'en_attente', // CORRIGÉ: 'en_attente' au lieu de false
            'views' => 0,
            'reponses_count' => 0
        ];
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assistance', 'public');
        }
        
        $question = Question::create($data);
        
        return redirect('/assistance/question/' . $question->id)
            ->with('success', 'Votre question a été envoyée et sera publiée après modération');
    }

    /**
     * Détail d'une question
     */
    public function questionDetail($id)
    {
        $settings = Setting::first();
        
        $question = Question::with(['user', 'matiere', 'classe', 'reponses' => function($q) {
                $q->where('statut', 'approuvee') // CORRIGÉ: 'approuvee' au lieu de true
                  ->with('user')
                  ->latest();
            }])
            ->findOrFail($id);
        
        // Incrémenter le nombre de vues
        $question->increment('views');
        
        // Vérifier l'accès
        if ($question->statut != 'publiee' && Auth::id() != $question->user_id && !Auth::user()?->isAdmin()) {
            abort(404);
        }
        
        return view('frontend.assistance.detail', compact('settings', 'question'));
    }

    /**
     * Répondre à une question
     */
    public function replyQuestion(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string'
        ]);
        
        $question = Question::findOrFail($id);
        
        // Vérifier que la question est publiée ou que l'utilisateur est le propriétaire
        if ($question->statut != 'publiee' && Auth::id() != $question->user_id && !Auth::user()?->isAdmin()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas répondre à cette question');
        }
        
        $reponse = Reponse::create([
            'user_id' => Auth::id(),
            'question_id' => $question->id,
            'contenu' => $request->contenu,
            'statut' => 'en_attente' // CORRIGÉ: 'en_attente' au lieu de false
        ]);
        
        // Mettre à jour le compteur de réponses
        $question->updateReponsesCount();
        
        return redirect()->back()
            ->with('success', 'Votre réponse a été envoyée et sera publiée après modération');
    }

    /**
     * Marquer une réponse comme solution
     */
    public function markAsSolution($id, $reponseId)
    {
        $question = Question::findOrFail($id);
        
        if (Auth::id() != $question->user_id && !Auth::user()?->isAdmin()) {
            return redirect()->back()->with('error', 'Action non autorisée');
        }
        
        // Enlever le statut solution des autres réponses
        Reponse::where('question_id', $id)->update(['est_solution' => false]);
        
        // Marquer la réponse comme solution
        Reponse::where('id', $reponseId)
            ->where('question_id', $id)
            ->update(['est_solution' => true]);
        
        // Changer le statut de la question en 'resolue'
        $question->update(['statut' => 'resolue']);
        
        return redirect()->back()->with('success', 'Réponse marquée comme solution');
    }

    /**
     * Modifier une question
     */
    public function editQuestion($id)
    {
        $settings = Setting::first();
        
        $question = Question::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        
        return view('frontend.assistance.edit', compact('settings', 'question', 'classes', 'matieres'));
    }

    /**
     * Mettre à jour une question
     */
    public function updateQuestion(Request $request, $id)
    {
        $question = Question::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string', // CORRIGÉ: 'contenu' au lieu de 'description'
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = [
            'titre' => $request->titre,
            'contenu' => $request->contenu, // CORRIGÉ: 'contenu' au lieu de 'description'
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
        ];
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('assistance', 'public');
        }
        
        $question->update($data);
        
        return redirect('/assistance/question/' . $question->id)
            ->with('success', 'Question mise à jour avec succès');
    }

    /**
     * Supprimer une question
     */
    public function destroyQuestion($id)
    {
        $question = Question::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }
        
        $question->delete();
        
        return redirect('/mes-questions')->with('success', 'Question supprimée avec succès');
    }

    // ==========================================
    // CONTACT & NEWSLETTER
    // ==========================================
    
    /**
     * Page de contact
     */
    public function contact()
    {
        $settings = Setting::first();
        return view('frontend.contact', compact('settings'));
    }

    // ==========================================
    // RECHERCHE GLOBALE - CORRIGÉE AVEC BONS CHAMPS
    // ==========================================
    
    /**
     * Recherche globale
     */
    public function search(Request $request)
    {
        $settings = Setting::first();
        
        $q = $request->get('q', '');
        
        if (empty($q) || strlen($q) < 2) {
            return view('frontend.search', compact('settings', 'q'));
        }
        
        // Recherche dans les chapitres
        $chapitres = Chapitre::where('statut', true)
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhereHas('matiere', function($qry) use ($q) {
                          $qry->where('nom', 'like', "%{$q}%");
                      });
            })
            ->with(['matiere', 'classe'])
            ->paginate(5, ['*'], 'chapitres_page');
        
        // Recherche dans les épreuves
        $epreuves = Epreuve::where('statut', true)
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhereHas('matiere', function($qry) use ($q) {
                          $qry->where('nom', 'like', "%{$q}%");
                      })
                      ->orWhereHas('typeEpreuve', function($qry) use ($q) {
                          $qry->where('nom', 'like', "%{$q}%");
                      });
            })
            ->with(['matiere', 'classe', 'typeEpreuve'])
            ->paginate(5, ['*'], 'epreuves_page');
        
        // Recherche dans les quiz
        $quizs = Quiz::where('statut', 'publie')
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhereHas('matiere', function($qry) use ($q) {
                          $qry->where('nom', 'like', "%{$q}%");
                      });
            })
            ->with(['matiere', 'classe'])
            ->withCount('questions')
            ->paginate(5, ['*'], 'quizs_page');
        
        // Recherche dans les questions d'assistance - CORRIGÉ
        $questions = Question::where('statut', 'publiee') // CORRIGÉ: 'publiee'
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('contenu', 'like', "%{$q}%") // CORRIGÉ: 'contenu' au lieu de 'description'
                      ->orWhereHas('matiere', function($qry) use ($q) {
                          $qry->where('nom', 'like', "%{$q}%");
                      });
            })
            ->with(['user', 'matiere', 'classe'])
            ->withCount('reponses')
            ->paginate(5, ['*'], 'questions_page');
        
        // Statistiques des résultats
        $stats = [
            'total_chapitres' => $chapitres->total(),
            'total_epreuves' => $epreuves->total(),
            'total_quizs' => $quizs->total(),
            'total_questions' => $questions->total(),
            'total_global' => $chapitres->total() + $epreuves->total() + $quizs->total() + $questions->total()
        ];
        
        return view('frontend.search', compact(
            'settings',
            'q',
            'chapitres',
            'epreuves',
            'quizs',
            'questions',
            'stats'
        ));
    }

    // ==========================================
    // API ENDPOINTS
    // ==========================================
    
    /**
     * API Recherche
     */
    public function apiSearch(Request $request)
    {
        $q = $request->get('q', '');
        
        $results = [];
        
        if (!empty($q) && strlen($q) >= 2) {
            $results = [
                'chapitres' => Chapitre::where('titre', 'like', "%$q%")
                    ->where('statut', true)
                    ->select('id', 'titre', 'slug', 'matiere_id', 'classe_id')
                    ->with(['matiere:nom', 'classe:nom'])
                    ->take(5)
                    ->get(),
                'epreuves' => Epreuve::where('titre', 'like', "%$q%")
                    ->where('statut', true)
                    ->select('id', 'titre', 'slug', 'matiere_id', 'classe_id', 'type_epreuve_id')
                    ->with(['matiere:nom', 'classe:nom', 'typeEpreuve:nom'])
                    ->take(5)
                    ->get(),
                'quizs' => Quiz::where('titre', 'like', "%$q%")
                    ->where('statut', 'publie')
                    ->select('id', 'titre', 'matiere_id', 'classe_id')
                    ->with(['matiere:nom', 'classe:nom'])
                    ->take(5)
                    ->get()
            ];
        }
        
        return response()->json($results);
    }

    /**
     * API Stats
     */
    public function apiStats()
    {
        $stats = [
            'total_epreuves' => Epreuve::where('statut', true)->count(),
            'total_cours' => Chapitre::where('statut', true)->count(),
            'total_quiz' => Quiz::where('statut', 'publie')->count(),
            'total_utilisateurs' => User::count(),
        ];
        
        return response()->json($stats);
    }

    // ==========================================
    // PAGE 404
    // ==========================================
    
    /**
     * Page 404 personnalisée
     */
    public function notFound()
    {
        $settings = Setting::first();
        return view('frontend.404', compact('settings'));
    }

    // ==========================================
    // FONCTIONS UTILITAIRES PRIVÉES
    // ==========================================
    
    /**
     * Trouver une classe par ID ou nom
     * 
     * @param string|int $identifier
     * @return Classe|null
     */
    private function findClasse($identifier)
    {
        if (is_numeric($identifier)) {
            return Classe::where('id', $identifier)->where('statut', true)->first();
        }
        
        $classe = Classe::where('nom', $identifier)->where('statut', true)->first();
        
        if (!$classe) {
            $nomVariations = [
                '6eme' => '6ème',
                '5eme' => '5ème', 
                '4eme' => '4ème',
                '3eme' => '3ème',
                'seconde' => 'Seconde',
                'premiere' => 'Première',
                'terminale' => 'Terminale',
                '6e' => '6ème',
                '5e' => '5ème',
                '4e' => '4ème',
                '3e' => '3ème',
            ];
            
            if (isset($nomVariations[strtolower($identifier)])) {
                $classe = Classe::where('nom', $nomVariations[strtolower($identifier)])
                    ->where('statut', true)
                    ->first();
            }
        }
        
        return $classe;
    }

    /**
     * Trouver une matière par ID ou nom
     * 
     * @param string|int $identifier
     * @return Matiere|null
     */
    private function findMatiere($identifier)
    {
        if (is_numeric($identifier)) {
            return Matiere::where('id', $identifier)->where('statut', true)->first();
        }
        
        return Matiere::where('nom', $identifier)->where('statut', true)->first();
    }

    /**
     * Formater le temps en minutes:secondes
     */
    private function formatTemps($secondes)
    {
        $minutes = floor($secondes / 60);
        $secondesRestantes = $secondes % 60;
        return $minutes . ':' . str_pad($secondesRestantes, 2, '0', STR_PAD_LEFT);
    }
}