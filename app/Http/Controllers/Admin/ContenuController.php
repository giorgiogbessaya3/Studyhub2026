<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenu;
use App\Models\Chapitre;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenuController extends Controller
{
    /**
     * LISTE de tous les contenus avec filtres
     */
    public function index(Request $request)
    {
        $query = Contenu::with(['chapitre.classe', 'chapitre.matiere']);

        // Filtres
        if ($request->filled('classe_id')) {
            $query->whereHas('chapitre', function($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        if ($request->filled('matiere_id')) {
            $query->whereHas('chapitre', function($q) use ($request) {
                $q->where('matiere_id', $request->matiere_id);
            });
        }

        if ($request->filled('chapitre_id')) {
            $query->where('chapitre_id', $request->chapitre_id);
        }

        $contenus = $query->orderBy('chapitre_id')->orderBy('ordre')->paginate(12);
        
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        $chapitres = Chapitre::with(['classe', 'matiere'])
                             ->where('statut', true)
                             ->orderBy('titre')
                             ->get();

        $stats = [
            'total' => Contenu::count(),
            'avec_images' => Contenu::whereNotNull('images')->count(),
            'avec_exercices' => Contenu::whereNotNull('exercices')->count(),
        ];

        return view('admin.contenus.index', compact('contenus', 'classes', 'matieres', 'chapitres', 'stats'));
    }

    /**
     * AFFICHER les détails d'un contenu (NOUVEAU)
     */
    public function show(Contenu $contenu)
    {
        $contenu->load(['chapitre.classe', 'chapitre.matiere', 'chapitre.contenus']);
        
        // Contenus précédent et suivant dans le même chapitre
        $contenuPrecedent = Contenu::where('chapitre_id', $contenu->chapitre_id)
                                   ->where('ordre', '<', $contenu->ordre)
                                   ->orderBy('ordre', 'desc')
                                   ->first();
        
        $contenuSuivant = Contenu::where('chapitre_id', $contenu->chapitre_id)
                                 ->where('ordre', '>', $contenu->ordre)
                                 ->orderBy('ordre', 'asc')
                                 ->first();

        return view('admin.contenus.show', compact('contenu', 'contenuPrecedent', 'contenuSuivant'));
    }

    /**
     * Formulaire création depuis un chapitre spécifique
     */
    public function create(Chapitre $chapitre)
    {
        $chapitre->load(['classe', 'matiere']);
        
        $ordreDefaut = Contenu::where('chapitre_id', $chapitre->id)->max('ordre') + 1;

        return view('admin.contenus.create', compact('chapitre', 'ordreDefaut'));
    }

    /**
     * Enregistrer le contenu lié au chapitre
     */
    public function store(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'resume' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'exercices' => 'nullable|array',
            'exercices.*.question' => 'required_with:exercices|string',
            'exercices.*.reponse' => 'required_with:exercices|string',
            'ordre' => 'required|integer|min:0',
        ]);

        // Upload images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('contenus/' . $chapitre->id, 'public');
                $images[] = $path;
            }
        }

        $contenu = Contenu::create([
            'chapitre_id' => $chapitre->id,
            'titre' => $validated['titre'],
            'resume' => $validated['resume'],
            'images' => $images,
            'exercices' => $validated['exercices'] ?? null,
            'ordre' => $validated['ordre'],
        ]);

        return redirect()->route('admin.contenus.show', $contenu)
            ->with('success', 'Contenu créé avec succès !');
    }

    /**
     * ÉDITION d'un contenu
     */
    public function edit(Contenu $contenu)
    {
        $contenu->load(['chapitre.classe', 'chapitre.matiere']);
        
        return view('admin.contenus.edit', compact('contenu'));
    }

    /**
     * MISE À JOUR
     */
    public function update(Request $request, Contenu $contenu)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'resume' => 'required|string',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'exercices' => 'nullable|array',
            'ordre' => 'required|integer|min:0',
        ]);

        // Gestion des images existantes
        $images = $contenu->images ?? [];
        
        // Supprimer les images cochées
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                Storage::disk('public')->delete($imageToDelete);
                $images = array_diff($images, [$imageToDelete]);
            }
        }

        // Ajouter nouvelles images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('contenus/' . $contenu->chapitre_id, 'public');
                $images[] = $path;
            }
        }

        $contenu->update([
            'titre' => $validated['titre'],
            'resume' => $validated['resume'],
            'images' => array_values($images),
            'exercices' => $validated['exercices'] ?? null,
            'ordre' => $validated['ordre'],
        ]);

        return redirect()->route('admin.contenus.show', $contenu)
            ->with('success', 'Contenu mis à jour !');
    }

    /**
     * SUPPRESSION
     */
    public function destroy(Contenu $contenu)
    {
        $chapitre = $contenu->chapitre;

        // Supprimer les images du storage
        if ($contenu->images) {
            foreach ($contenu->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $contenu->delete();

        return redirect()->route('admin.chapitres.edit', $chapitre)
            ->with('success', 'Contenu supprimé !');
    }
}