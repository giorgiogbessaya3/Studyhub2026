<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epreuve;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\TypeEpreuve;
use App\Models\Correction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EpreuveController extends Controller
{
    /**
     * Affiche la liste des épreuves.
     */
    public function index()
    {
        $epreuves = Epreuve::with(['classe', 'matiere', 'typeEpreuve', 'correction'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Epreuve::count(),
            'avec_correction' => Epreuve::has('correction')->count(),
            'sans_correction' => Epreuve::doesntHave('correction')->count(),
        ];

        return view('admin.epreuves.index', compact('epreuves', 'stats'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $classes = Classe::where('statut', true)->orderBy('nom')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        $types = TypeEpreuve::where('statut', true)->orderBy('nom')->get();

        return view('admin.epreuves.create', compact('classes', 'matieres', 'types'));
    }

    /**
     * Enregistre une nouvelle épreuve.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'classe_id'            => 'required|exists:classes,id',
            'matiere_id'           => 'required|exists:matieres,id',
            'type_epreuve_id'      => 'required|exists:type_epreuves,id',
            'fichier'              => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
            'annee'                => 'nullable|integer|min:2000|max:' . date('Y'),
            'duree'                => 'nullable|integer|min:0',
            'bareme'               => 'nullable|integer|min:0',
            'statut'               => 'boolean',
        ]);

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('epreuves', 'public');
            $validated['fichier'] = $path;
            $validated['nom_fichier_original'] = $request->file('fichier')->getClientOriginalName();
        }

        $validated['statut'] = $request->boolean('statut', true);
        $validated['slug']   = Str::slug($validated['titre']);

        Epreuve::create($validated);

        return redirect()->route('admin.epreuves.index')
            ->with('success', 'Épreuve créée avec succès.');
    }

    /**
     * Affiche une épreuve spécifique.
     */
    public function show(Epreuve $epreuve)
    {
        $epreuve->load(['classe', 'matiere', 'typeEpreuve', 'correction']);
        return view('admin.epreuves.show', compact('epreuve'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Epreuve $epreuve)
    {
        $classes = Classe::where('statut', true)->orderBy('nom')->get();
        $matieres = Matiere::where('statut', true)->orderBy('nom')->get();
        $types = TypeEpreuve::where('statut', true)->orderBy('nom')->get();

        return view('admin.epreuves.edit', compact('epreuve', 'classes', 'matieres', 'types'));
    }

    /**
     * Met à jour une épreuve.
     */
    public function update(Request $request, Epreuve $epreuve)
    {
        $validated = $request->validate([
            'titre'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'classe_id'            => 'required|exists:classes,id',
            'matiere_id'           => 'required|exists:matieres,id',
            'type_epreuve_id'      => 'required|exists:type_epreuves,id',
            'fichier'              => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
            'annee'                => 'nullable|integer|min:2000|max:' . date('Y'),
            'duree'                => 'nullable|integer|min:0',
            'bareme'               => 'nullable|integer|min:0',
            'statut'               => 'boolean',
        ]);

        if ($request->hasFile('fichier')) {
            if ($epreuve->fichier) {
                Storage::disk('public')->delete($epreuve->fichier);
            }
            $path = $request->file('fichier')->store('epreuves', 'public');
            $validated['fichier'] = $path;
            $validated['nom_fichier_original'] = $request->file('fichier')->getClientOriginalName();
        }

        $validated['statut'] = $request->boolean('statut', true);
        $validated['slug']   = Str::slug($validated['titre']);

        $epreuve->update($validated);

        return redirect()->route('admin.epreuves.index')
            ->with('success', 'Épreuve mise à jour avec succès.');
    }

    /**
     * Supprime une épreuve et ses fichiers associés.
     */
    public function destroy(Epreuve $epreuve)
    {
        if ($epreuve->fichier) {
            Storage::disk('public')->delete($epreuve->fichier);
        }

        if ($epreuve->correction) {
            if ($epreuve->correction->fichier) {
                Storage::disk('public')->delete($epreuve->correction->fichier);
            }
            $epreuve->correction->delete();
        }

        $epreuve->delete();

        return redirect()->route('admin.epreuves.index')
            ->with('success', 'Épreuve supprimée avec succès.');
    }

    /**
     * Active ou désactive une épreuve.
     */
    public function toggleStatus(Epreuve $epreuve)
    {
        $epreuve->statut = !$epreuve->statut;
        $epreuve->save();

        return response()->json([
            'success' => true,
            'statut'  => $epreuve->statut,
            'message' => 'Statut mis à jour.'
        ]);
    }

    /**
     * Duplique une épreuve.
     */
    public function duplicate(Epreuve $epreuve)
    {
        $newEpreuve = $epreuve->replicate();
        $newEpreuve->titre = $newEpreuve->titre . ' (copie)';
        $newEpreuve->slug = Str::slug($newEpreuve->titre);
        $newEpreuve->created_at = now();
        $newEpreuve->updated_at = now();

        if ($epreuve->fichier) {
            $extension = pathinfo($epreuve->fichier, PATHINFO_EXTENSION);
            $newPath = 'epreuves/' . Str::random(40) . '.' . $extension;
            Storage::disk('public')->copy($epreuve->fichier, $newPath);
            $newEpreuve->fichier = $newPath;
            $newEpreuve->nom_fichier_original = 'copie_' . $epreuve->nom_fichier_original;
        }

        $newEpreuve->save();

        return redirect()->route('admin.epreuves.edit', $newEpreuve)
            ->with('success', 'Épreuve dupliquée avec succès.');
    }

    /**
     * Télécharge le fichier de l'épreuve.
     */
    public function download(Epreuve $epreuve)
    {
        if (!$epreuve->fichier || !Storage::disk('public')->exists($epreuve->fichier)) {
            abort(404, 'Fichier non trouvé.');
        }

        return Storage::disk('public')->download(
            $epreuve->fichier,
            $epreuve->nom_fichier_original ?? 'epreuve_' . $epreuve->id . '.pdf'
        );
    }

    /**
     * Affiche la liste globale des corrections.
     */
    public function corrections()
    {
        $corrections = Correction::with(['epreuve.classe', 'epreuve.matiere'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.corrections.index', compact('corrections'));
    }

    /**
     * Ajoute une correction à une épreuve.
     */
    public function storeCorrection(Request $request, Epreuve $epreuve)
    {
        if ($epreuve->correction) {
            return redirect()->back()->with('error', 'Une correction existe déjà pour cette épreuve.');
        }

        $validated = $request->validate([
            'fichier'    => 'required|file|mimes:pdf,doc,docx|max:10240',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('fichier')->store('corrections', 'public');

        Correction::create([
            'epreuve_id'          => $epreuve->id,
            'fichier'             => $path,
            'nom_fichier_original' => $request->file('fichier')->getClientOriginalName(),
            'description'         => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.epreuves.show', $epreuve)
            ->with('success', 'Correction ajoutée avec succès.');
    }

    /**
     * Met à jour la correction d'une épreuve.
     */
    public function updateCorrection(Request $request, Epreuve $epreuve)
    {
        $correction = $epreuve->correction;

        if (!$correction) {
            abort(404, 'Aucune correction trouvée pour cette épreuve.');
        }

        $validated = $request->validate([
            'fichier'    => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('fichier')) {
            if ($correction->fichier) {
                Storage::disk('public')->delete($correction->fichier);
            }
            $path = $request->file('fichier')->store('corrections', 'public');
            $correction->fichier = $path;
            $correction->nom_fichier_original = $request->file('fichier')->getClientOriginalName();
        }

        if (isset($validated['description'])) {
            $correction->description = $validated['description'];
        }

        $correction->save();

        return redirect()->route('admin.epreuves.show', $epreuve)
            ->with('success', 'Correction mise à jour avec succès.');
    }

    /**
     * Supprime la correction d'une épreuve.
     */
    public function destroyCorrection(Epreuve $epreuve)
    {
        $correction = $epreuve->correction;

        if (!$correction) {
            abort(404, 'Aucune correction trouvée.');
        }

        if ($correction->fichier) {
            Storage::disk('public')->delete($correction->fichier);
        }

        $correction->delete();

        return redirect()->route('admin.epreuves.show', $epreuve)
            ->with('success', 'Correction supprimée avec succès.');
    }
}