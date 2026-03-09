<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeEpreuve;
use Illuminate\Http\Request;

class TypeEpreuveController extends Controller
{
    /**
     * Affiche la liste des types d'épreuves.
     */
    public function index()
    {
        $types = TypeEpreuve::orderBy('nom')->get();

        $stats = [
            'total' => TypeEpreuve::count(),
            'actifs' => TypeEpreuve::where('statut', true)->count(),
        ];

        return view('admin.types-epreuves.index', compact('types', 'stats'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.types-epreuves.create');
    }

    /**
     * Enregistre un nouveau type d'épreuve.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:type_epreuves,nom',
            'description' => 'nullable|string',
            'icone' => 'nullable|string|max:50',
            'statut' => 'boolean',
        ]);

        $validated['statut'] = $request->boolean('statut', true);

        TypeEpreuve::create($validated);

        return redirect()->route('admin.types-epreuves.index')
            ->with('success', 'Type d\'épreuve créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(TypeEpreuve $typeEpreuve)
    {
        return view('admin.types-epreuves.edit', compact('typeEpreuve'));
    }

    /**
     * Met à jour un type d'épreuve.
     */
    public function update(Request $request, TypeEpreuve $typeEpreuve)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:type_epreuves,nom,' . $typeEpreuve->id,
            'description' => 'nullable|string',
            'icone' => 'nullable|string|max:50',
            'statut' => 'boolean',
        ]);

        $validated['statut'] = $request->boolean('statut', true);

        $typeEpreuve->update($validated);

        return redirect()->route('admin.types-epreuves.index')
            ->with('success', 'Type d\'épreuve mis à jour avec succès.');
    }

    /**
     * Supprime un type d'épreuve.
     */
    public function destroy(TypeEpreuve $typeEpreuve)
    {
        $typeEpreuve->delete();

        return redirect()->route('admin.types-epreuves.index')
            ->with('success', 'Type d\'épreuve supprimé avec succès.');
    }
}