<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChapitreController extends Controller
{
    /**
     * LISTE des chapitres avec filtres
     */
    public function index(Request $request)
    {
        $query = Chapitre::with(['classe', 'matiere']);

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par matière
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $chapitres = $query->orderBy('classe_id')
                          ->orderBy('matiere_id')
                          ->orderBy('ordre')
                          ->paginate(9);

        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();

        $stats = [
            'total' => Chapitre::count(),
            'actifs' => Chapitre::where('statut', true)->count(),
        ];

        return view('admin.chapitres.index', compact('chapitres', 'classes', 'matieres', 'stats'));
    }

    /**
     * AFFICHER les détails d'un chapitre (NOUVEAU)
     */
    public function show(Chapitre $chapitre)
    {
        $chapitre->load(['classe', 'matiere', 'contenus']);

        // Chapitre précédent et suivant dans la même classe/matière
        $chapitrePrecedent = Chapitre::where('classe_id', $chapitre->classe_id)
                                       ->where('matiere_id', $chapitre->matiere_id)
                                       ->where('ordre', '<', $chapitre->ordre)
                                       ->orderBy('ordre', 'desc')
                                       ->first();

        $chapitreSuivant = Chapitre::where('classe_id', $chapitre->classe_id)
                                     ->where('matiere_id', $chapitre->matiere_id)
                                     ->where('ordre', '>', $chapitre->ordre)
                                     ->orderBy('ordre', 'asc')
                                     ->first();

        return view('admin.chapitres.show', compact('chapitre', 'chapitrePrecedent', 'chapitreSuivant'));
    }

    /**
     * FORMULAIRE CRÉATION
     */
    public function create()
    {
        $classes = Classe::where('statut', true)
                         ->with('matieres')
                         ->orderBy('ordre')
                         ->get();
        
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        $ordreDefaut = Chapitre::max('ordre') + 1;

        return view('admin.chapitres.create', compact('classes', 'matieres', 'ordreDefaut'));
    }

    /**
     * ENREGISTRER un chapitre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer|min:0',
            'statut' => 'boolean',
        ]);

        // Vérifier que la matière est associée à cette classe
        $classe = Classe::find($validated['classe_id']);
        $matiereIds = $classe->matieres->pluck('id')->toArray();
        
        if (!in_array($validated['matiere_id'], $matiereIds)) {
            return back()->withErrors(['matiere_id' => 'Cette matière n\'est pas associée à cette classe.'])
                        ->withInput();
        }

        $validated['slug'] = Str::slug($validated['titre']);
        $validated['statut'] = $request->boolean('statut', true);

        // Vérifier unicité du slug
        $count = Chapitre::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        $chapitre = Chapitre::create($validated);

        return redirect()->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre créé avec succès !');
    }

    /**
     * FORMULAIRE ÉDITION
     */
    public function edit(Chapitre $chapitre)
    {
        $classes = Classe::where('statut', true)
                         ->with('matieres')
                         ->orderBy('ordre')
                         ->get();
        
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        
        $chapitre->load('contenus');

        return view('admin.chapitres.edit', compact('chapitre', 'classes', 'matieres'));
    }

    /**
     * MISE À JOUR
     */
    public function update(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer|min:0',
            'statut' => 'boolean',
        ]);

        // Vérifier que la matière est associée à cette classe
        $classe = Classe::find($validated['classe_id']);
        $matiereIds = $classe->matieres->pluck('id')->toArray();
        
        if (!in_array($validated['matiere_id'], $matiereIds)) {
            return back()->withErrors(['matiere_id' => 'Cette matière n\'est pas associée à cette classe.'])
                        ->withInput();
        }

        if ($validated['titre'] !== $chapitre->titre) {
            $validated['slug'] = Str::slug($validated['titre']);
            $count = Chapitre::where('slug', 'like', $validated['slug'] . '%')
                ->where('id', '!=', $chapitre->id)
                ->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        $validated['statut'] = $request->boolean('statut', true);

        $chapitre->update($validated);

        return redirect()->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre mis à jour avec succès !');
    }

    /**
     * SUPPRESSION
     */
    public function destroy(Chapitre $chapitre)
    {
        $chapitre->delete();

        return redirect()->route('admin.chapitres.index')
            ->with('success', 'Chapitre supprimé avec succès !');
    }
}