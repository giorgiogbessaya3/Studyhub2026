<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    /**
     * Affiche la page d'accueil des cours
     */
    public function index()
    {
        $settings = Setting::first();
        
        // Récupérer toutes les classes actives avec leurs matières
        $classes = Classe::with('matieres')
            ->where('statut', true)
            ->orderBy('ordre')
            ->get();
        
        // Statistiques des classes avec le champ cycle
        $stats = [
            'total' => $classes->count(),
            'total_college' => $classes->where('cycle', 'college')->count(),
            'total_lycee' => $classes->where('cycle', 'lycee')->count(),
        ];

        // Compter les chapitres pour chaque classe
        foreach ($classes as $classe) {
            $classe->chapitres_count = Chapitre::where('classe_id', $classe->id)
                ->where('statut', true)
                ->count();
            
            $classe->matieres_count = $classe->matieres->count();
        }

        return view('frontend.cours.index', compact(
            'settings', 
            'classes', 
            'stats'
        ));
    }

    /**
     * Affiche les matières d'une classe
     */
    public function classe($identifier)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($identifier);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        // Récupérer les matières associées à cette classe via la table pivot
        $matieres = $classe->matieres()
            ->where('matieres.statut', true)
            ->orderBy('matieres.nom')
            ->get();
        
        // Pour chaque matière, compter les chapitres et contenus
        foreach ($matieres as $matiere) {
            // Compter les chapitres de cette matière pour cette classe
            $matiere->chapitres_count = Chapitre::where('matiere_id', $matiere->id)
                ->where('classe_id', $classe->id)
                ->where('statut', true)
                ->count();
            
            // Compter les contenus des chapitres de cette matière pour cette classe
            $matiere->contenus_count = Contenu::whereHas('chapitre', function($q) use ($matiere, $classe) {
                $q->where('matiere_id', $matiere->id)
                  ->where('classe_id', $classe->id)
                  ->where('statut', true);
            })->count();
        }

        return view('frontend.cours.classe', compact(
            'settings', 
            'classe', 
            'matieres'
        ));
    }

    /**
     * Affiche les chapitres d'une matière pour une classe
     */
    public function matiere($classeIdentifier, $matiereIdentifier)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeIdentifier);
        $matiere = $this->findMatiere($matiereIdentifier);
        
        if (!$classe || !$matiere) {
            abort(404, 'Classe ou matière non trouvée');
        }

        // Vérifier que la matière est bien associée à cette classe
        if (!$matiere->classes()->where('classe_id', $classe->id)->exists()) {
            abort(404, 'Cette matière n\'est pas disponible pour cette classe');
        }

        // Récupérer tous les chapitres de cette matière pour cette classe
        $chapitres = Chapitre::where('matiere_id', $matiere->id)
            ->where('classe_id', $classe->id)
            ->where('statut', true)
            ->withCount('contenus')
            ->orderBy('ordre')
            ->orderBy('titre')
            ->get();

        return view('frontend.cours.matiere', compact(
            'settings',
            'classe',
            'matiere',
            'chapitres'
        ));
    }

    /**
     * Affiche le détail d'un chapitre avec ses contenus
     */
    public function chapitre($identifier)
    {
        $settings = Setting::first();
        
        $chapitre = $this->findChapitre($identifier);
        
        if (!$chapitre || !$chapitre->statut) {
            abort(404, 'Chapitre non trouvé');
        }

        // Charger les relations
        $chapitre->load([
            'matiere', 
            'classe', 
            'contenus' => function($q) {
                $q->orderBy('ordre');
            }
        ]);

        // Chapitres précédent et suivant dans la même matière/classe
        $chapitrePrecedent = Chapitre::where('matiere_id', $chapitre->matiere_id)
            ->where('classe_id', $chapitre->classe_id)
            ->where('statut', true)
            ->where('ordre', '<', $chapitre->ordre)
            ->orderBy('ordre', 'desc')
            ->first();
        
        $chapitreSuivant = Chapitre::where('matiere_id', $chapitre->matiere_id)
            ->where('classe_id', $chapitre->classe_id)
            ->where('statut', true)
            ->where('ordre', '>', $chapitre->ordre)
            ->orderBy('ordre', 'asc')
            ->first();

        return view('frontend.cours.chapitre', compact(
            'settings',
            'chapitre',
            'chapitrePrecedent',
            'chapitreSuivant'
        ));
    }

    /**
     * Recherche de cours
     */
    public function recherche(Request $request)
    {
        $settings = Setting::first();
        
        $q = $request->get('q', '');
        
        if (empty($q) || strlen($q) < 2) {
            return redirect('/cours')
                ->with('error', 'Veuillez saisir au moins 2 caractères pour la recherche');
        }

        // Recherche dans les chapitres
        $chapitres = Chapitre::with(['matiere', 'classe'])
            ->where('statut', true)
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->orderBy('titre')
            ->paginate(10, ['*'], 'chapitres_page');

        // Recherche dans les contenus
        $contenus = Contenu::with(['chapitre.matiere', 'chapitre.classe'])
            ->whereHas('chapitre', function($q) {
                $q->where('statut', true);
            })
            ->where(function($query) use ($q) {
                $query->where('titre', 'like', "%{$q}%")
                      ->orWhere('resume', 'like', "%{$q}%");
            })
            ->orderBy('titre')
            ->paginate(10, ['*'], 'contenus_page');

        // Recherche dans les matières
        $matieres = Matiere::with('classes')
            ->where('statut', true)
            ->where('nom', 'like', "%{$q}%")
            ->orderBy('nom')
            ->get();

        $total = $chapitres->total() + $contenus->total() + $matieres->count();

        return view('frontend.cours.recherche', compact(
            'settings',
            'q',
            'chapitres',
            'contenus',
            'matieres',
            'total'
        ));
    }

    /**
     * Téléchargement d'un contenu (affichage des images)
     */
    public function telecharger(Contenu $contenu)
    {
        // Vérifier que le chapitre associé est actif
        if (!$contenu->chapitre || !$contenu->chapitre->statut) {
            abort(404, 'Contenu non disponible');
        }

        return redirect('/cours/chapitre/' . $contenu->chapitre->slug)
            ->with('success', 'Les ressources sont disponibles ci-dessous');
    }

    // ==========================================
    // FONCTIONS PRIVÉES UTILITAIRES
    // ==========================================
    
    /**
     * Trouver une classe par ID ou nom
     */
    private function findClasse($identifier)
    {
        if (is_numeric($identifier)) {
            return Classe::where('id', $identifier)
                ->where('statut', true)
                ->first();
        }

        // Chercher par nom exact
        $classe = Classe::where('nom', $identifier)
            ->where('statut', true)
            ->first();
        
        // Chercher par variations courantes
        if (!$classe) {
            $nomVariations = [
                '6eme' => '6ème', '5eme' => '5ème', '4eme' => '4ème', '3eme' => '3ème',
                'seconde' => 'Seconde', 'premiere' => 'Première', 'terminale' => 'Terminale',
                '6e' => '6ème', '5e' => '5ème', '4e' => '4ème', '3e' => '3ème',
                '2nde' => 'Seconde', '1ere' => 'Première', 'tle' => 'Terminale',
            ];
            
            $identifierLower = strtolower($identifier);
            if (isset($nomVariations[$identifierLower])) {
                $classe = Classe::where('nom', $nomVariations[$identifierLower])
                    ->where('statut', true)
                    ->first();
            }
        }

        return $classe;
    }

    /**
     * Trouver une matière par ID ou nom
     */
    private function findMatiere($identifier)
    {
        if (is_numeric($identifier)) {
            return Matiere::where('id', $identifier)
                ->where('statut', true)
                ->first();
        }
        
        return Matiere::where('nom', $identifier)
            ->where('statut', true)
            ->first();
    }

    /**
     * Trouver un chapitre par ID ou slug
     */
    private function findChapitre($identifier)
    {
        if (is_numeric($identifier)) {
            return Chapitre::where('id', $identifier)->first();
        }
        
        return Chapitre::where('slug', $identifier)->first();
    }
}