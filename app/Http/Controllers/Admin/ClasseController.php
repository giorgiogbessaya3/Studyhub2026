<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Liste des classes
     */
    public function index()
    {
        // Récupérer toutes les classes ordonnées
        $classes = Classe::orderBy('ordre')->get();
        
        // Stats simples
        $stats = [
            'total_lycee' => Classe::where('cycle', 'lycee')->count(),
            'total_college' => Classe::where('cycle', 'college')->count(),
            'total' => Classe::count(),
        ];
        
        return view('admin.classes.index', compact('classes', 'stats'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Enregistrer classe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50|unique:classes',
            'cycle' => 'required|in:college,lycee',
            'description' => 'nullable|string',
            'ordre' => 'integer|min:0',
            'statut' => 'boolean',
        ]);

        // Valeurs par défaut
        $validated['statut'] = $request->boolean('statut', true);
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Classe::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès !');
    }

    /**
     * Afficher une classe
     */
    public function show(Classe $classe)
    {
        // Pour l'instant, affichage simple sans relations
        return view('admin.classes.show', compact('classe'));
    }

    /**
     * Formulaire édition
     */
    public function edit(Classe $classe)
    {
        return view('admin.classes.edit', compact('classe'));
    }

    /**
     * Mettre à jour
     */
    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50|unique:classes,nom,' . $classe->id,
            'cycle' => 'required|in:college,lycee',
            'description' => 'nullable|string',
            'ordre' => 'integer|min:0',
            'statut' => 'boolean',
        ]);

        $validated['statut'] = $request->boolean('statut', true);

        $classe->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe mise à jour avec succès !');
    }

    /**
     * Supprimer
     */
    public function destroy(Classe $classe)
    {
        // Suppression simple sans vérification de relations
        $classe->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès !');
    }
}