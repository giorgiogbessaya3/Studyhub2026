<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MatiereController extends Controller
{
    /**
     * Liste des matières
     */
    public function index()
    {
        $matieres = Matiere::with('classes')->orderBy('nom')->get();
        
        $stats = [
            'total' => Matiere::count(),
            'actives' => Matiere::where('statut', true)->count(),
        ];
        
        return view('admin.matieres.index', compact('matieres', 'stats'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        return view('admin.matieres.create', compact('classes'));
    }

    /**
     * Enregistrer matière avec image
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:matieres',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // VALIDATION IMAGE
            'couleur' => 'nullable|string|max:7',
            'icone' => 'nullable|string|max:50',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'statut' => 'boolean',
        ]);

        // Upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('matieres', 'public');
        }

        $validated['statut'] = $request->boolean('statut', true);

        $matiere = Matiere::create($validated);
        
        // Attacher les classes
        if ($request->has('classes')) {
            $matiere->classes()->attach($request->classes);
        }

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière créée avec succès !');
    }

    /**
     * Afficher une matière
     */
    public function show(Matiere $matiere)
    {
        $matiere->load('classes');
        return view('admin.matieres.show', compact('matiere'));
    }

    /**
     * Formulaire édition
     */
    public function edit(Matiere $matiere)
    {
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matiere->load('classes');
        return view('admin.matieres.edit', compact('matiere', 'classes'));
    }

    /**
     * Mettre à jour avec image
     */
    public function update(Request $request, Matiere $matiere)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:matieres,code,' . $matiere->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // VALIDATION IMAGE
            'couleur' => 'nullable|string|max:7',
            'icone' => 'nullable|string|max:50',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'statut' => 'boolean',
        ]);

        // Upload nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($matiere->image) {
                Storage::disk('public')->delete($matiere->image);
            }
            $validated['image'] = $request->file('image')->store('matieres', 'public');
        }

        $validated['statut'] = $request->boolean('statut', true);

        $matiere->update($validated);
        
        // Sync les classes
        $matiere->classes()->sync($request->classes ?? []);

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière mise à jour avec succès !');
    }

    /**
     * Supprimer avec image
     */
    public function destroy(Matiere $matiere)
    {
        // Supprimer l'image associée
        if ($matiere->image) {
            Storage::disk('public')->delete($matiere->image);
        }

        $matiere->delete();

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière supprimée avec succès !');
    }
}