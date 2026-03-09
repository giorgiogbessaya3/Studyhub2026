<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\TypeEpreuve;
use App\Models\Epreuve;
use App\Models\Correction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpreuveControllers extends Controller
{
    /**
     * Affiche la page d'accueil des épreuves (liste des classes)
     */
    public function index()
    {
        $settings = Setting::first();
        
        // Récupérer toutes les classes actives avec le comptage des épreuves
        $classes = Classe::withCount(['epreuves' => function($q) {
                $q->where('statut', true);
            }])
            ->where('statut', true)
            ->orderBy('ordre')
            ->get();
        
        // Statistiques
        $stats = [
            'total' => Epreuve::where('statut', true)->count(),
            'total_college' => Epreuve::whereHas('classe', function($q) {
                $q->where('cycle', 'college');
            })->where('statut', true)->count(),
            'total_lycee' => Epreuve::whereHas('classe', function($q) {
                $q->where('cycle', 'lycee');
            })->where('statut', true)->count(),
            'avec_correction' => Epreuve::has('correction')->where('statut', true)->count(),
        ];

        return view('frontend.epreuves.index', compact('settings', 'classes', 'stats'));
    }

    /**
     * ÉTAPE 1: Affiche les types d'épreuves pour une classe
     */
    public function typesParClasse($classeIdentifier)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeIdentifier);
        
        if (!$classe) {
            abort(404, 'Classe non trouvée');
        }
        
        // Récupérer les types d'épreuves qui ont des épreuves pour cette classe
        $types = TypeEpreuve::where('statut', true)
            ->withCount(['epreuves' => function($q) use ($classe) {
                $q->where('classe_id', $classe->id)->where('statut', true);
            }])
            ->having('epreuves_count', '>', 0)
            ->orderBy('nom')
            ->get();

        return view('frontend.epreuves.types', compact('settings', 'classe', 'types'));
    }

    /**
     * ÉTAPE 2: Affiche les matières pour un type d'épreuve dans une classe
     */
    public function matieresParType($classeIdentifier, $typeIdentifier)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeIdentifier);
        $type = $this->findTypeEpreuve($typeIdentifier);
        
        if (!$classe || !$type) {
            abort(404, 'Classe ou type d\'épreuve non trouvé');
        }
        
        // Récupérer les matières qui ont des épreuves pour cette classe et ce type
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

        return view('frontend.epreuves.matieres', compact('settings', 'classe', 'type', 'matieres'));
    }

    /**
     * ÉTAPE 3: Affiche la liste des épreuves pour une matière, un type et une classe
     */
    public function listeEpreuves($classeIdentifier, $typeIdentifier, $matiereIdentifier, Request $request)
    {
        $settings = Setting::first();
        
        $classe = $this->findClasse($classeIdentifier);
        $type = $this->findTypeEpreuve($typeIdentifier);
        $matiere = $this->findMatiere($matiereIdentifier);
        
        if (!$classe || !$type || !$matiere) {
            abort(404, 'Éléments non trouvés');
        }

        // Construction de la requête
        $query = Epreuve::with(['classe', 'matiere', 'typeEpreuve', 'correction'])
            ->where('classe_id', $classe->id)
            ->where('matiere_id', $matiere->id)
            ->where('type_epreuve_id', $type->id)
            ->where('statut', true);

        // Filtre par année
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }

        // Recherche par titre
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Filtre par durée
        if ($request->filled('duree')) {
            switch ($request->duree) {
                case 'court':
                    $query->where('duree', '<=', 60);
                    break;
                case 'moyen':
                    $query->whereBetween('duree', [61, 120]);
                    break;
                case 'long':
                    $query->where('duree', '>', 120);
                    break;
            }
        }

        // Filtre par correction disponible
        if ($request->boolean('avec_correction')) {
            $query->has('correction');
        }

        // Tri
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'recent':
                $query->latest();
                break;
            case 'ancien':
                $query->oldest();
                break;
            case 'titre_asc':
                $query->orderBy('titre');
                break;
            case 'titre_desc':
                $query->orderBy('titre', 'desc');
                break;
            case 'duree_asc':
                $query->orderBy('duree');
                break;
            case 'duree_desc':
                $query->orderBy('duree', 'desc');
                break;
            default:
                $query->latest();
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
            'classe',
            'type',
            'matiere',
            'annees'
        ));
    }

    /**
     * Affiche le détail d'une épreuve
     */
    public function show($identifier)
    {
        $settings = Setting::first();
        
        $epreuve = $this->findEpreuve($identifier);
        
        if (!$epreuve || !$epreuve->statut) {
            abort(404, 'Épreuve non trouvée');
        }

        $epreuve->load(['classe', 'matiere', 'typeEpreuve', 'correction']);
        
        // Épreuves similaires
        $similaires = Epreuve::with(['classe', 'matiere', 'typeEpreuve'])
            ->where('classe_id', $epreuve->classe_id)
            ->where('matiere_id', $epreuve->matiere_id)
            ->where('id', '!=', $epreuve->id)
            ->where('statut', true)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.epreuves.show', compact('settings', 'epreuve', 'similaires'));
    }

    /**
     * Télécharge le fichier de l'épreuve
     */
    public function download($identifier)
    {
        $epreuve = $this->findEpreuve($identifier);
        
        if (!$epreuve || !$epreuve->statut) {
            abort(404, 'Épreuve non disponible');
        }

        if (!$epreuve->fichier || !Storage::disk('public')->exists($epreuve->fichier)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download(
            $epreuve->fichier,
            $epreuve->nom_fichier_original ?? 'epreuve_' . $epreuve->id . '.pdf'
        );
    }

    /**
     * Affiche la correction d'une épreuve
     */
    public function correction($identifier)
    {
        $settings = Setting::first();
        
        $epreuve = $this->findEpreuve($identifier);

        if (!$epreuve || !$epreuve->statut) {
            abort(404, 'Épreuve non disponible');
        }

        if (!$epreuve->correction) {
            return redirect('/epreuves/' . ($epreuve->slug ?? $epreuve->id))
                ->with('error', 'La correction n\'est pas encore disponible');
        }

        $epreuve->load(['classe', 'matiere', 'typeEpreuve', 'correction']);

        return view('frontend.epreuves.correction', compact('settings', 'epreuve'));
    }

    /**
     * Télécharge la correction d'une épreuve
     */
    public function downloadCorrection($identifier)
    {
        $epreuve = $this->findEpreuve($identifier);
        
        if (!$epreuve || !$epreuve->statut || !$epreuve->correction) {
            abort(404, 'Correction non disponible');
        }

        if (!$epreuve->correction->fichier || !Storage::disk('public')->exists($epreuve->correction->fichier)) {
            abort(404, 'Fichier de correction non trouvé');
        }

        return Storage::disk('public')->download(
            $epreuve->correction->fichier,
            $epreuve->correction->nom_fichier_original ?? 'correction_' . $epreuve->id . '.pdf'
        );
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

        $classe = Classe::where('nom', $identifier)
            ->where('statut', true)
            ->first();
        
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
     * Trouver un type d'épreuve par ID, slug ou nom
     */
    private function findTypeEpreuve($identifier)
    {
        if (is_numeric($identifier)) {
            return TypeEpreuve::where('id', $identifier)
                ->where('statut', true)
                ->first();
        }
        
        $type = TypeEpreuve::where('slug', $identifier)
            ->where('statut', true)
            ->first();
        
        if (!$type) {
            $type = TypeEpreuve::where('nom', $identifier)
                ->where('statut', true)
                ->first();
        }
        
        return $type;
    }

    /**
     * Trouver une épreuve par ID ou slug
     */
    private function findEpreuve($identifier)
    {
        if (is_numeric($identifier)) {
            return Epreuve::where('id', $identifier)
                ->where('statut', true)
                ->first();
        }
        
        return Epreuve::where('slug', $identifier)
            ->where('statut', true)
            ->first();
    }
}