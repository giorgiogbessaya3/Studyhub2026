<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssistanceController extends Controller
{
    /**
     * Affiche la page d'accueil de l'assistance
     */
    public function index()
    {
        // Dernières questions publiées
        $questionsRecentes = Question::with(['user', 'classe', 'matiere', 'reponses' => function($q) {
                $q->where('statut', 'approuvee');
            }])
            ->whereIn('statut', ['publiee', 'resolue'])
            ->latest()
            ->limit(6)
            ->get();

        // Statistiques
        $stats = [
            'total_questions' => Question::whereIn('statut', ['publiee', 'resolue'])->count(),
            'total_reponses' => Reponse::where('statut', 'approuvee')->count(),
            'total_resolues' => Question::where('statut', 'resolue')->count(),
            'total_contributeurs' => User::whereHas('reponses', function($q) {
                $q->where('statut', 'approuvee');
            })->count()
        ];

        // Questions populaires (les plus vues)
        $questionsPopulaires = Question::with(['user', 'classe', 'matiere'])
            ->whereIn('statut', ['publiee', 'resolue'])
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.assistance.index', compact(
            'questionsRecentes', 
            'stats', 
            'questionsPopulaires'
        ));
    }

    /**
     * Affiche le formulaire de nouvelle question
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('frontend.assistance.create', compact('classes', 'matieres'));
    }

    /**
     * Enregistre une nouvelle question
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|min:10|max:255',
            'contenu' => 'required|string|min:20',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.min' => 'Le titre doit faire au moins 10 caractères',
            'contenu.required' => 'La description est obligatoire',
            'contenu.min' => 'La description doit faire au moins 20 caractères',
            'classe_id.required' => 'Veuillez sélectionner une classe',
            'matiere_id.required' => 'Veuillez sélectionner une matière',
            'image.image' => 'Le fichier doit être une image',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo'
        ]);

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('assistance', $filename, 'public');
        }

        // Création de la question
        $question = Question::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'statut' => 'en_attente', // En attente de modération
            'views' => 0,
            'reponses_count' => 0
        ]);

        return redirect()->route('assistance.show', $question->id)
            ->with('success', 'Votre question a été publiée et sera visible après modération.');
    }

    /**
     * Affiche le détail d'une question
     */
    public function show($id)
    {
        $question = Question::with(['user', 'classe', 'matiere'])->findOrFail($id);
        
        // Incrémenter le nombre de vues
        $question->increment('views');

        // Charger les réponses approuvées
        $question->load(['reponses' => function($q) {
            $q->with('user')
              ->where('statut', 'approuvee')
              ->orderBy('est_solution', 'desc')
              ->orderBy('created_at', 'asc');
        }]);

        // Vérifier si l'utilisateur peut voir cette question
        if (!in_array($question->statut, ['publiee', 'resolue'])) {
            if (!Auth::check() || (Auth::id() !== $question->user_id && !Auth::user()?->isAdmin())) {
                abort(403, 'Cette question n\'est pas encore publiée.');
            }
        }

        // Questions similaires
        $questionsSimilaires = Question::where('id', '!=', $question->id)
            ->whereIn('statut', ['publiee', 'resolue'])
            ->where(function($q) use ($question) {
                $q->where('classe_id', $question->classe_id)
                  ->orWhere('matiere_id', $question->matiere_id);
            })
            ->with(['user', 'classe', 'matiere'])
            ->latest()
            ->limit(5)
            ->get();

        return view('frontend.assistance.show', compact('question', 'questionsSimilaires'));
    }

    /**
     * Ajoute une réponse à une question
     */
    public function reply(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'contenu' => 'required|string|min:5'
        ], [
            'contenu.required' => 'La réponse ne peut pas être vide',
            'contenu.min' => 'La réponse doit faire au moins 5 caractères'
        ]);

        // Vérifier que la question est publiée
        if (!in_array($question->statut, ['publiee', 'resolue'])) {
            return redirect()->back()->with('error', 'Impossible de répondre à cette question.');
        }

        // Créer la réponse
        $reponse = Reponse::create([
            'contenu' => $request->contenu,
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'statut' => 'en_attente' // En attente de modération
        ]);

        return redirect()->route('assistance.show', $question->id)
            ->with('success', 'Votre réponse a été ajoutée et sera visible après modération.');
    }

    /**
     * Marque une réponse comme solution (par l'auteur de la question)
     */
    public function markAsSolution($id)
    {
        $reponse = Reponse::with('question')->findOrFail($id);
        $question = $reponse->question;

        // Vérifier que l'utilisateur est l'auteur de la question
        if (Auth::id() !== $question->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        // Vérifier que la réponse est approuvée
        if ($reponse->statut !== 'approuvee') {
            return redirect()->back()->with('error', 'Seules les réponses approuvées peuvent être marquées comme solution.');
        }

        // Marquer comme solution
        DB::transaction(function() use ($reponse, $question) {
            // Retirer le statut solution des autres réponses
            $question->reponses()->update(['est_solution' => false]);
            
            // Marquer celle-ci comme solution
            $reponse->update(['est_solution' => true]);
            
            // Marquer la question comme résolue
            $question->update(['statut' => 'resolue']);
        });

        return redirect()->back()->with('success', 'Réponse marquée comme solution. La question est maintenant résolue.');
    }

    /**
     * Liste toutes les questions avec filtres
     */
    public function liste(Request $request)
    {
        $query = Question::with(['user', 'classe', 'matiere'])
            ->withCount(['reponses' => function($q) {
                $q->where('statut', 'approuvee');
            }])
            ->whereIn('statut', ['publiee', 'resolue']);

        // Filtre par classe
        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        // Filtre par matière
        if ($request->filled('matiere')) {
            $query->where('matiere_id', $request->matiere);
        }

        // Filtre par recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%");
            });
        }

        // Tri
        $orderBy = $request->get('order', 'latest');
        switch($orderBy) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'replies':
                $query->orderBy('reponses_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $questions = $query->paginate(12)->withQueryString();

        // Données pour les filtres
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('frontend.assistance.liste', compact('questions', 'classes', 'matieres'));
    }

    /**
     * Affiche les questions de l'utilisateur connecté
     */
    public function mesQuestions()
    {
        $questions = Question::with(['classe', 'matiere'])
            ->withCount(['reponses' => function($q) {
                $q->where('statut', 'approuvee');
            }])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('frontend.assistance.mes-questions', compact('questions'));
    }

    /**
     * Affiche le formulaire d'édition d'une question
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $question->user_id) {
            abort(403);
        }

        // Ne peut modifier que si la question est en attente
        if ($question->statut !== 'en_attente') {
            return redirect()->route('assistance.show', $question->id)
                ->with('error', 'Vous ne pouvez plus modifier cette question car elle a déjà été publiée.');
        }

        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('frontend.assistance.edit', compact('question', 'classes', 'matieres'));
    }

    /**
     * Met à jour une question
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $question->user_id) {
            abort(403);
        }

        // Ne peut modifier que si la question est en attente
        if ($question->statut !== 'en_attente') {
            return redirect()->route('assistance.show', $question->id)
                ->with('error', 'Vous ne pouvez plus modifier cette question.');
        }

        $request->validate([
            'titre' => 'required|string|min:10|max:255',
            'contenu' => 'required|string|min:20',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Gestion de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
            $question->image = $image->storeAs('assistance', $filename, 'public');
        }

        // Mise à jour
        $question->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id
        ]);

        return redirect()->route('assistance.show', $question->id)
            ->with('success', 'Votre question a été mise à jour.');
    }

    /**
     * Supprime une question
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'auteur ou admin
        if (Auth::id() !== $question->user_id && !Auth::user()?->isAdmin()) {
            abort(403);
        }

        // Supprimer l'image
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        // Supprimer les réponses associées
        $question->reponses()->delete();

        // Supprimer la question
        $question->delete();

        return redirect()->route('assistance.mes-questions')
            ->with('success', 'Question supprimée avec succès.');
    }
}