<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Affiche la liste de toutes les questions
     */
    public function index(Request $request)
    {
        $query = QuizQuestion::with(['quiz', 'quiz.classe', 'quiz.matiere']);

        // Filtres
        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhereHas('quiz', function($q) use ($search) {
                      $q->where('titre', 'like', "%{$search}%");
                  });
            });
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(15);

        // Données pour les filtres
        $quizs = Quiz::orderBy('titre')->get(['id', 'titre']);
        $types = [
            'qcm' => 'QCM',
            'vrai_faux' => 'Vrai/Faux',
            'texte' => 'Question ouverte'
        ];

        return view('admin.questions.index', compact('questions', 'quizs', 'types'));
    }

    /**
     * Formulaire de création d'une question
     */
    public function create(Request $request)
    {
        $quizs = Quiz::orderBy('titre')->get();
        $classes = Classe::orderBy('nom')->get();
        $matieres = collect();
        $chapitres = collect();
        
        $selectedQuiz = null;
        if ($request->has('quiz_id')) {
            $selectedQuiz = Quiz::with(['classe', 'matiere'])->find($request->quiz_id);
            if ($selectedQuiz) {
                $matieres = Matiere::where('id', $selectedQuiz->matiere_id)->get();
                $chapitres = Chapitre::where('classe_id', $selectedQuiz->classe_id)
                    ->where('matiere_id', $selectedQuiz->matiere_id)
                    ->orderBy('titre')
                    ->get(['id', 'titre as nom']);
            }
        }

        return view('admin.questions.create', compact('quizs', 'classes', 'matieres', 'chapitres', 'selectedQuiz'));
    }

    /**
     * Enregistre une nouvelle question
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'titre' => 'required|string',
            'type' => 'required|in:qcm,texte,vrai_faux',
            'options' => 'required_if:type,qcm|array',
            'options.*' => 'required_if:type,qcm|string',
            'bonne_reponse' => 'required|string',
            'points' => 'required|integer|min:1|max:10',
            'explication' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $quiz = Quiz::find($request->quiz_id);

            // Vérifier que le quiz est modifiable
            if ($quiz->statut === 'publie') {
                return redirect()->back()
                    ->with('error', 'Impossible d\'ajouter des questions à un quiz publié.')
                    ->withInput();
            }

            // Gestion de l'image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('quiz-questions', $filename, 'public');
            }

            // Déterminer le prochain ordre
            $ordre = $quiz->questions()->max('ordre') + 1;

            // Préparer les options pour les QCM
            $options = null;
            if ($request->type == 'qcm') {
                $options = array_values(array_filter($request->options));
            }

            // Créer la question
            QuizQuestion::create([
                'quiz_id' => $request->quiz_id,
                'titre' => $request->titre,
                'type' => $request->type,
                'options' => $options,
                'bonne_reponse' => $request->bonne_reponse,
                'points' => $request->points,
                'explication' => $request->explication,
                'image' => $imagePath,
                'ordre' => $ordre
            ]);

            // Mettre à jour le nombre de questions dans le quiz
            $quiz->nombre_questions = $quiz->questions()->count();
            $quiz->save();

            DB::commit();

            return redirect('admin/questions?quiz_id=' . $request->quiz_id)
                ->with('success', 'Question ajoutée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'ajout de la question : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche le détail d'une question
     */
    public function show(QuizQuestion $question)
    {
        $question->load(['quiz', 'quiz.classe', 'quiz.matiere']);
        
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Formulaire d'édition d'une question
     */
    public function edit(QuizQuestion $question)
    {
        $question->load('quiz');
        
        // Vérifier que le quiz est modifiable
        if ($question->quiz->statut === 'publie') {
            return redirect('admin/questions')
                ->with('error', 'Impossible de modifier les questions d\'un quiz publié.');
        }

        $quizs = Quiz::orderBy('titre')->get();
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::where('id', $question->quiz->matiere_id)->get();
        $chapitres = Chapitre::where('classe_id', $question->quiz->classe_id)
            ->where('matiere_id', $question->quiz->matiere_id)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return view('admin.questions.edit', compact('question', 'quizs', 'classes', 'matieres', 'chapitres'));
    }

    /**
     * Met à jour une question
     */
    public function update(Request $request, QuizQuestion $question)
    {
        $question->load('quiz');

        // Vérifier que le quiz est modifiable
        if ($question->quiz->statut === 'publie') {
            return redirect('admin/questions')
                ->with('error', 'Impossible de modifier les questions d\'un quiz publié.');
        }

        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'titre' => 'required|string',
            'type' => 'required|in:qcm,texte,vrai_faux',
            'options' => 'required_if:type,qcm|array',
            'options.*' => 'required_if:type,qcm|string',
            'bonne_reponse' => 'required|string',
            'points' => 'required|integer|min:1|max:10',
            'explication' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'quiz_id' => $request->quiz_id,
                'titre' => $request->titre,
                'type' => $request->type,
                'bonne_reponse' => $request->bonne_reponse,
                'points' => $request->points,
                'explication' => $request->explication,
            ];

            // Gestion des options pour QCM
            if ($request->type == 'qcm') {
                $data['options'] = array_values(array_filter($request->options));
            } else {
                $data['options'] = null;
            }

            // Gestion de l'image
            if ($request->hasFile('image')) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $data['image'] = $image->storeAs('quiz-questions', $filename, 'public');
            }

            $question->update($data);

            // Mettre à jour le nombre de questions dans l'ancien et nouveau quiz si différent
            if ($question->quiz_id != $request->quiz_id) {
                $ancienQuiz = Quiz::find($question->quiz_id);
                $ancienQuiz->nombre_questions = $ancienQuiz->questions()->count();
                $ancienQuiz->save();

                $nouveauQuiz = Quiz::find($request->quiz_id);
                $nouveauQuiz->nombre_questions = $nouveauQuiz->questions()->count();
                $nouveauQuiz->save();
            }

            DB::commit();

            return redirect('admin/questions/' . $question->id)
                ->with('success', 'Question mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprime une question
     */
    public function destroy(QuizQuestion $question)
    {
        $question->load('quiz');

        // Vérifier que le quiz est modifiable
        if ($question->quiz->statut === 'publie') {
            return redirect('admin/questions')
                ->with('error', 'Impossible de supprimer les questions d\'un quiz publié.');
        }

        try {
            DB::beginTransaction();

            $quiz = $question->quiz;

            // Supprimer l'image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            $question->delete();

            // Réordonner les questions restantes du quiz
            $questions = $quiz->questions()->orderBy('ordre')->get();
            foreach ($questions as $index => $q) {
                $q->update(['ordre' => $index + 1]);
            }

            // Mettre à jour le nombre de questions dans le quiz
            $quiz->nombre_questions = $quiz->questions()->count();
            $quiz->save();

            DB::commit();

            return redirect('admin/questions')
                ->with('success', 'Question supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Duplique une question
     */
    public function duplicate(QuizQuestion $question)
    {
        $question->load('quiz');

        // Vérifier que le quiz est modifiable
        if ($question->quiz->statut === 'publie') {
            return redirect('admin/questions')
                ->with('error', 'Impossible de dupliquer les questions d\'un quiz publié.');
        }

        try {
            DB::beginTransaction();

            $nouvelleQuestion = $question->replicate();
            $nouvelleQuestion->titre = $question->titre . ' (copie)';
            $nouvelleQuestion->ordre = $question->quiz->questions()->max('ordre') + 1;
            
            // Dupliquer l'image si elle existe
            if ($question->image) {
                $extension = pathinfo($question->image, PATHINFO_EXTENSION);
                $nouveauNom = 'copie_' . time() . '_' . Str::slug($question->titre) . '.' . $extension;
                
                Storage::disk('public')->copy($question->image, 'quiz-questions/' . $nouveauNom);
                $nouvelleQuestion->image = 'quiz-questions/' . $nouveauNom;
            }
            
            $nouvelleQuestion->save();

            // Mettre à jour le nombre de questions dans le quiz
            $question->quiz->nombre_questions = $question->quiz->questions()->count();
            $question->quiz->save();

            DB::commit();

            return redirect('admin/questions?quiz_id=' . $question->quiz_id)
                ->with('success', 'Question dupliquée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la duplication : ' . $e->getMessage());
        }
    }

    /**
     * Import de questions depuis un fichier
     */
    public function importForm()
    {
        $quizs = Quiz::orderBy('titre')->get();
        
        return view('admin.questions.import', compact('quizs'));
    }

    /**
     * Traite l'import de questions
     */
    public function import(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'fichier' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $quiz = Quiz::find($request->quiz_id);

        // Vérifier que le quiz est modifiable
        if ($quiz->statut === 'publie') {
            return redirect()->back()
                ->with('error', 'Impossible d\'importer des questions dans un quiz publié.');
        }

        // Logique d'import CSV
        // À implémenter selon vos besoins

        return redirect('admin/questions?quiz_id=' . $request->quiz_id)
            ->with('success', 'Questions importées avec succès.');
    }

    /**
     * Export des questions
     */
    public function export(Request $request)
    {
        $query = QuizQuestion::with('quiz');

        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        $questions = $query->orderBy('quiz_id')->orderBy('ordre')->get();

        $filename = 'questions-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // En-têtes
        fputcsv($handle, [
            'ID',
            'Quiz',
            'Titre',
            'Type',
            'Options',
            'Bonne réponse',
            'Points',
            'Explication',
            'Image',
            'Ordre'
        ]);

        // Données
        foreach ($questions as $question) {
            fputcsv($handle, [
                $question->id,
                $question->quiz->titre,
                $question->titre,
                $question->type,
                $question->options ? implode('|', $question->options) : '',
                $question->bonne_reponse,
                $question->points,
                $question->explication,
                $question->image,
                $question->ordre
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Récupère les matières d'une classe (AJAX)
     */
    public function getMatieres(Request $request)
    {
        $classe = Classe::with('matieres')->find($request->classe_id);
        
        return response()->json($classe ? $classe->matieres : []);
    }

    /**
     * Récupère les chapitres d'une classe et matière (AJAX)
     */
    public function getChapitres(Request $request)
    {
        $chapitres = Chapitre::where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('statut', true)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return response()->json($chapitres);
    }

    /**
     * Récupère les quiz d'une classe et matière (AJAX)
     */
    public function getQuizs(Request $request)
    {
        $quizs = Quiz::where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id)
            ->orderBy('titre')
            ->get(['id', 'titre']);

        return response()->json($quizs);
    }
}