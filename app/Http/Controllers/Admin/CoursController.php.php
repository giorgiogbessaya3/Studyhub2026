<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    /**
     * Afficher la liste des cours
     */
    public function index(Request $request)
    {
        $query = Cours::with(['classe', 'matiere', 'chapitres']);

        // Filtres
        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        if ($request->filled('matiere')) {
            $query->where('matiere_id', $request->matiere);
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $cours = $query->latest()->paginate(10);
        $classes = Classe::where('statut', true)->get();
        $matieres = Matiere::where('statut', true)->get();

        return view('admin.cours.index', compact('cours', 'classes', 'matieres'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->get();

        return view('admin.cours.create', compact('classes', 'matieres'));
    }

    /**
     * Enregistrer un nouveau cours
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'resume' => 'nullable|string',
            'video_url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'boolean',
            'ordre' => 'integer|min:0',
        ]);

        // Gestion des fichiers
        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('cours/documents', 'public');
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('cours/images', 'public');
        }

        $validated['statut'] = $request->boolean('statut', true);
        $validated['user_id'] = auth()->id();

        $cours = Cours::create($validated);

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours créé avec succès !');
    }

    /**
     * Afficher un cours spécifique
     */
    public function show(Cours $cours)
    {
        $cours->load(['classe', 'matiere', 'chapitres', 'user']);

        return view('admin.cours.show', compact('cours'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Cours $cours)
    {
        $classes = Classe::where('statut', true)->orderBy('ordre')->get();
        $matieres = Matiere::where('statut', true)->get();

        return view('admin.cours.edit', compact('cours', 'classes', 'matieres'));
    }

    /**
     * Mettre à jour un cours
     */
    public function update(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'resume' => 'nullable|string',
            'video_url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'boolean',
            'ordre' => 'integer|min:0',
        ]);

        // Supprimer ancien document si nouveau uploadé
        if ($request->hasFile('document')) {
            if ($cours->document_path) {
                Storage::disk('public')->delete($cours->document_path);
            }
            $validated['document_path'] = $request->file('document')->store('cours/documents', 'public');
        }

        // Supprimer ancienne image si nouvelle uploadée
        if ($request->hasFile('image')) {
            if ($cours->image_path) {
                Storage::disk('public')->delete($cours->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('cours/images', 'public');
        }

        $validated['statut'] = $request->boolean('statut', true);

        $cours->update($validated);

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours mis à jour avec succès !');
    }

    /**
     * Supprimer un cours
     */
    public function destroy(Cours $cours)
    {
        // Supprimer les fichiers associés
        if ($cours->document_path) {
            Storage::disk('public')->delete($cours->document_path);
        }

        if ($cours->image_path) {
            Storage::disk('public')->delete($cours->image_path);
        }

        $cours->delete();

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours supprimé avec succès !');
    }

    /**
     * Changer le statut d'un cours
     */
    public function toggleStatut(Cours $cours)
    {
        $cours->update(['statut' => !$cours->statut]);

        return response()->json([
            'success' => true,
            'statut' => $cours->statut,
            'message' => 'Statut mis à jour !'
        ]);
    }

    /**
     * Dupliquer un cours
     */
    public function duplicate(Cours $cours)
    {
        $newCours = $cours->replicate();
        $newCours->titre = $cours->titre . ' (Copie)';
        $newCours->statut = false;
        $newCours->save();

        // Dupliquer les chapitres
        foreach ($cours->chapitres as $chapitre) {
            $newChapitre = $chapitre->replicate();
            $newChapitre->cours_id = $newCours->id;
            $newChapitre->save();
        }

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours dupliqué avec succès !');
    }

    /**
     * API: Récupérer les matières par classe
     */
    public function getMatieresByClasse(Classe $classe)
    {
        $matieres = $classe->matieres()->where('statut', true)->get();

        return response()->json($matieres);
    }
}