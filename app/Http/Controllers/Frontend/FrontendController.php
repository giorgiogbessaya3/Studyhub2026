<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Epreuve;
use App\Models\TypeEpreuve;
use App\Models\Question;
use App\Models\Reponse;
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
    // PAGE D'ACCUEIL
    // ==========================================
    
    public function index()
    {
        $settings = Setting::first();
        
        $stats = [
            'total_epreuves' => Epreuve::where('statut', true)->count(),
            'total_cours' => Chapitre::where('statut', true)->count(),
            'total_quiz' => Quiz::where('statut', 'publie')->count(),
            'total_utilisateurs' => User::count(),
            'total_classes' => Classe::where('statut', true)->count(),
        ];
        
        // Dernières épreuves - AVEC LES NOUVELLES RELATIONS
        $recentEpreuves = Epreuve::with(['classes', 'matieres', 'typeEpreuve', 'correction'])
            ->where('statut', true)
            ->latest()
            ->take(5)
            ->get();
        
        $recentQuiz = Quiz::with(['classe', 'matiere'])
            ->where('statut', 'publie')
            ->latest()
            ->take(5)
            ->get();
        
        $recentQuestions = Question::with(['user', 'matiere', 'classe'])
            ->where('statut', 'publiee')
            ->latest()
            ->take(5)
            ->get();
        
        $classeNames = ['6ème', '5ème', '4ème', '3ème', 'Seconde', 'Première', 'Terminale'];
        
        $quickClasses = collect();
        
        foreach ($classeNames as $nom) {
            if ($quickClasses->count() >= 4) {
                break;
            }
            
            $classe = Classe::where('nom', $nom)
                ->where('statut', true)
                ->first();
            
            if ($classe) {
                $classe->matieres_count = $classe->matieres()->count();
                $quickClasses->push($classe);
            }
        }
        
        if ($quickClasses->count() < 4) {
            $existingIds = $quickClasses->pluck('id')->toArray();
            $autresClasses = Classe::where('statut', true)
                ->whereNotIn('id', $existingIds)
                ->orderBy('ordre')
                ->take(4 - $quickClasses->count())
                ->get();
            
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
    // BANQUE D'ÉPREUVES - VERSION CORRIGÉE MANY-TO-MANY
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
                $q->where('statut', true)
                  ->whereHas('classes', function($query) use ($classe) {
                      $query->where('classes.id', $classe->id);
                  });
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
                $q->where('statut', true)
                  ->where('type_epreuve_id', $type->id)
                  ->whereHas('classes', function($query) use ($classe) {
                      $query->where('classes.id', $classe->id);
                  });
            })
            ->withCount(['epreuves' => function($q) use ($classe, $type) {
                $q->where('statut', true)
                  ->where('type_epreuve_id', $type->id)
                  ->whereHas('classes', function($query) use ($classe) {
                      $query->where('classes.id', $classe->id);
                  });
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
        
        $query = Epreuve::with(['classes', 'matieres', 'typeEpreuve', 'correction'])
            ->where('statut', true)
            ->where('type_epreuve_id', $type->id)
            ->whereHas('classes', function($q) use ($classe) {
                $q->where('classes.id', $classe->id);
            })
            ->whereHas('matieres', function($q) use ($matiere) {
                $q->where('matieres.id', $matiere->id);
            });
        
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        
        $sort = $request->get('sort', 'recent');
        if ($sort == 'recent') {
            $query->latest();
        } elseif ($sort == 'ancien') {
            $query->oldest();
        } elseif ($sort == 'titre') {
            $query->orderBy('titre');
        }
        
        $epreuves = $query->paginate(12)->withQueryString();
        
        $annees = Epreuve::where('statut', true)
            ->where('type_epreuve_id', $type->id)
            ->whereHas('classes', function($q) use ($classe) {
                $q->where('classes.id', $classe->id);
            })
            ->whereHas('matieres', function($q) use ($matiere) {
                $q->where('matieres.id', $matiere->id);
            })
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
     * Détail d'une épreuve
     */
    public function epreuveDetail($identifier)
    {
        $settings = Setting::first();
        
        $epreuve = is_numeric($identifier)
            ? Epreuve::where('id', $identifier)
                ->with(['classes', 'matieres', 'typeEpreuve', 'correction'])
                ->where('statut', true)
                ->first()
            : Epreuve::where('slug', $identifier)
                ->with(['classes', 'matieres', 'typeEpreuve', 'correction'])
                ->where('statut', true)
                ->first();
        
        if (!$epreuve) {
            abort(404, 'Épreuve non trouvée');
        }
        
        $similaires = Epreuve::where('statut', true)
            ->where('id', '!=', $epreuve->id)
            ->where(function($q) use ($epreuve) {
                $q->whereHas('classes', function($query) use ($epreuve) {
                    $query->whereIn('classes.id', $epreuve->classes->pluck('id')->toArray());
                })->orWhereHas('matieres', function($query) use ($epreuve) {
                    $query->whereIn('matieres.id', $epreuve->matieres->pluck('id')->toArray());
                });
            })
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
    // NAVIGATION CLASSES → MATIÈRES → CHAPITRES
    // ==========================================
    
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
        
        $epreuves = Epreuve::where('statut', true)
            ->where('type_epreuve_id', $matiere->id) // À adapter selon votre besoin
            ->whereHas('classes', function($q) use ($classe) {
                $q->where('classes.id', $classe->id);
            })
            ->whereHas('matieres', function($q) use ($matiere) {
                $q->where('matieres.id', $matiere->id);
            })
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
    // FONCTIONS UTILITAIRES PRIVÉES
    // ==========================================
    
    private function findClasse($identifier)
    {
        if (is_numeric($identifier)) {
            return Classe::where('id', $identifier)->where('statut', true)->first();
        }
        
        $classe = Classe::where('nom', $identifier)->where('statut', true)->first();
        
        if (!$classe) {
            $nomVariations = [
                '6eme' => '6ème', '5eme' => '5ème', '4eme' => '4ème', '3eme' => '3ème',
                'seconde' => 'Seconde', 'premiere' => 'Première', 'terminale' => 'Terminale',
                '6e' => '6ème', '5e' => '5ème', '4e' => '4ème', '3e' => '3ème',
                '2nde' => 'Seconde', '1ere' => 'Première', 'tle' => 'Terminale',
            ];
            
            if (isset($nomVariations[strtolower($identifier)])) {
                $classe = Classe::where('nom', $nomVariations[strtolower($identifier)])
                    ->where('statut', true)
                    ->first();
            }
        }
        
        return $classe;
    }

    private function findMatiere($identifier)
    {
        if (is_numeric($identifier)) {
            return Matiere::where('id', $identifier)->where('statut', true)->first();
        }
        
        return Matiere::where('nom', $identifier)->where('statut', true)->first();
    }

    // ==========================================
    // AUTRES MÉTHODES (QUIZ, ASSISTANCE, CONTACT, RECHERCHE...)
    // À CONSERVER TELS QUELS
    // ==========================================
}