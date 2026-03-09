<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Epreuve;
use App\Models\TypeEpreuve;
use App\Models\Assistance;
use App\Models\Quiz;
use App\Models\Resultat;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    // ==========================================
    // PAGE D'ACCUEIL
    // ==========================================
    
    public function index()
    {
        $settings = Setting::first();
        
        // Stats pour la page d'accueil
        $stats = [
            'total_epreuves' => Epreuve::where('statut', true)->count(),
            'total_cours' => Chapitre::where('statut', true)->count(),
            'total_classes' => Classe::where('statut', true)->count(),
        ];
        
        // Dernières épreuves ajoutées
        $recentEpreuves = Epreuve::with(['classe', 'matiere', 'typeEpreuve'])
            ->where('statut', true)
            ->latest()
            ->take(5)
            ->get();
        
        // Classes populaires
        $quickClasses = Classe::whereIn('nom', ['6ème', '3ème', 'Terminale'])
            ->where('statut', true)
            ->orderBy('ordre')
            ->get();
        
        return view('frontend.index', compact('settings', 'stats', 'recentEpreuves', 'quickClasses'));
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
            return redirect()->route('classes');
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
        
        return view('frontend.matiere_detail', compact('settings', 'matiere', 'classe', 'chapitres', 'epreuves'));
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
        
        $chapitre->load(['matiere', 'classe', 'contenus']);

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
        
        $contenus = $chapitre->contenus()
            ->orderBy('ordre')
            ->get();

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
        return redirect()->route('classes');
    }
    
    public function coursDetail($identifier)
    {
        $chapitre = is_numeric($identifier)
            ? Chapitre::find($identifier)
            : Chapitre::where('slug', $identifier)->first();
        
        if ($chapitre) {
            return redirect()->route('chapitre.detail', $chapitre->slug);
        }
        
        abort(404);
    }

    // ==========================================
    // BANQUE D'ÉPREUVES - NAVIGATION CASCADE COMPLÈTE
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
        
        $query = Epreuve::with(['typeEpreuve', 'correction'])
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
            ? Epreuve::where('id', $identifier)->with(['classe', 'matiere', 'typeEpreuve', 'correction'])->where('statut', true)->first()
            : Epreuve::where('slug', $identifier)->with(['classe', 'matiere', 'typeEpreuve', 'correction'])->where('statut', true)->first();
        
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
        
        return view('frontend.epreuves.liste', compact('settings', 'epreuve', 'similaires'));
    }

    /**
     * Télécharger une épreuve
     */
    public function downloadEpreuve(Epreuve $epreuve)
    {
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
    public function correction(Epreuve $epreuve)
    {
        $settings = Setting::first();
        
        if (!$epreuve->correction) {
            return redirect()->back()->with('error', 'La correction n\'est pas encore disponible');
        }
        
        return view('frontend.correction', compact('settings', 'epreuve'));
    }

    // ==========================================
    // ÉVALUATIONS / QUIZ
    // ==========================================
    
    /**
     * Liste des quiz disponibles
     */
    public function quizList()
    {
        $settings = Setting::first();
        
        $quizs = Quiz::where('statut', true)
            ->with(['classe', 'matiere', 'questions'])
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
        
        if (!$quiz->statut) {
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
            $estCorrect = $reponseDonnee == $question->reponse_correcte;
            
            if ($estCorrect) {
                $score++;
            }
            
            $details[] = [
                'question_id' => $question->id,
                'question_titre' => $question->titre,
                'reponse_donnee' => $reponseDonnee,
                'reponse_correcte' => $question->reponse_correcte,
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
        
        return redirect()->route('quiz.result', [
            'quiz' => $quiz->id,
            'score' => $score,
            'total' => $total,
            'pourcentage' => $pourcentage,
            'resultat_id' => $resultatId
        ]);
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
    // ASSISTANCE PÉDAGOGIQUE
    // ==========================================
    
    /**
     * Liste des questions d'assistance
     */
    public function assistance()
    {
        $settings = Setting::first();
        
        $questions = Assistance::with(['user', 'matiere', 'classe', 'reponses' => function($q) {
                $q->where('approuve', true);
            }])
            ->where('statut', true)
            ->where('publie', true)
            ->latest()
            ->paginate(20);
        
        return view('frontend.assistance', compact('settings', 'questions'));
    }

    /**
     * Formulaire pour poser une nouvelle question
     */
    public function createQuestion()
    {
        $settings = Setting::first();
        
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        
        return view('frontend.assistance_create', compact('settings', 'classes', 'matieres'));
    }

    /**
     * Enregistrer une nouvelle question
     */
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = [
            'user_id' => auth()->id(),
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'classe_id' => $validated['classe_id'],
            'matiere_id' => $validated['matiere_id'],
            'statut' => true,
            'publie' => false
        ];
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assistance', 'public');
        }
        
        $question = Assistance::create($data);
        
        return redirect()->route('assistance')
            ->with('success', 'Votre question a été envoyée et sera publiée après modération');
    }

    /**
     * Liste des questions (alias)
     */
    public function questionsList()
    {
        return $this->assistance();
    }

    /**
     * Détail d'une question
     */
    public function questionDetail(Assistance $question)
    {
        $settings = Setting::first();
        
        if (!$question->publie && auth()->id() != $question->user_id) {
            abort(404);
        }
        
        $question->load(['user', 'matiere', 'classe', 'reponses' => function($q) {
            $q->where('approuve', true)->with('user');
        }]);
        
        return view('frontend.assistance_detail', compact('settings', 'question'));
    }

    /**
     * Répondre à une question
     */
    public function replyQuestion(Request $request, Assistance $question)
    {
        $validated = $request->validate([
            'contenu' => 'required|string'
        ]);
        
        $question->reponses()->create([
            'user_id' => auth()->id(),
            'contenu' => $validated['contenu'],
            'approuve' => false
        ]);
        
        return redirect()->back()
            ->with('success', 'Votre réponse a été envoyée et sera publiée après modération');
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
    // RECHERCHE GLOBALE
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
        
        $chapitres = Chapitre::where('titre', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%")
            ->orWhere('contenu', 'like', "%$q%")
            ->where('statut', true)
            ->with(['matiere', 'classe'])
            ->take(10)
            ->get();
        
        $epreuves = Epreuve::where('titre', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%")
            ->where('statut', true)
            ->with(['matiere', 'classe', 'typeEpreuve'])
            ->take(10)
            ->get();
        
        $matieres = Matiere::where('nom', 'like', "%$q%")
            ->where('statut', true)
            ->take(5)
            ->get();
        
        $classes = Classe::where('nom', 'like', "%$q%")
            ->where('statut', true)
            ->take(5)
            ->get();
        
        $results = [
            'chapitres' => $chapitres,
            'epreuves' => $epreuves,
            'matieres' => $matieres,
            'classes' => $classes,
            'total' => $chapitres->count() + $epreuves->count() + $matieres->count() + $classes->count()
        ];
        
        return view('frontend.search', compact('settings', 'q', 'results'));
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
                    ->get()
            ];
        }
        
        return response()->json($results);
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
}