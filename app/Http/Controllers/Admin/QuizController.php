<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResultat;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with(['classe', 'matiere', 'chapitre', 'createur'])
            ->withCount('questions');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $quizzes = $query->paginate(15)->withQueryString();

        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        $stats = [
            'total' => Quiz::count(),
            'publies' => Quiz::where('statut', 'publie')->count(),
            'brouillons' => Quiz::where('statut', 'brouillon')->count(),
            'archives' => Quiz::where('statut', 'archive')->count(),
            'questions' => QuizQuestion::count(),
            'participations' => QuizResultat::count()
        ];

        return view('admin.quiz.index', compact('quizzes', 'classes', 'matieres', 'stats'));
    }

    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $chapitres = collect();

        return view('admin.quiz.create', compact('classes', 'matieres', 'chapitres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'chapitre_id' => 'nullable|exists:chapitres,id',
            'duree' => 'required|integer|min:1|max:180',
            'score_passer' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:brouillon,publie,archive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('quiz', $filename, 'public');
            }

            $quiz = Quiz::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'classe_id' => $request->classe_id,
                'matiere_id' => $request->matiere_id,
                'chapitre_id' => $request->chapitre_id,
                'duree' => $request->duree,
                'score_passer' => $request->score_passer,
                'statut' => $request->statut,
                'image' => $imagePath,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return redirect('admin/quiz/' . $quiz->id . '/questions')
                ->with('success', 'Quiz créé avec succès. Ajoutez maintenant les questions.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création du quiz: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['classe', 'matiere', 'chapitre', 'createur', 'questions']);

        $totalQuestions = $quiz->questions()->count();
        $resultats = $quiz->resultats;
        
        $stats = [
            'nombre_tentatives' => $resultats->count(),
            'participants_uniques' => $resultats->unique('user_id')->count(),
            'score_moyen' => $resultats->isNotEmpty() ? round($resultats->avg('score'), 1) : 0,
            'taux_reussite' => $this->calculerTauxReussite($quiz),
            'dernier_resultat' => $quiz->resultats()->with('user')->latest()->first()
        ];

        $meilleursScores = $quiz->resultats()
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('temps_ecoule', 'asc')
            ->limit(5)
            ->get();

        return view('admin.quiz.show', compact('quiz', 'stats', 'meilleursScores'));
    }

    public function edit(Quiz $quiz)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $chapitres = Chapitre::where('classe_id', $quiz->classe_id)
            ->where('matiere_id', $quiz->matiere_id)
            ->where('statut', true)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return view('admin.quiz.edit', compact('quiz', 'classes', 'matieres', 'chapitres'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'chapitre_id' => 'nullable|exists:chapitres,id',
            'duree' => 'required|integer|min:1|max:180',
            'score_passer' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:brouillon,publie,archive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('image');

            if ($request->hasFile('image')) {
                if ($quiz->image) {
                    Storage::disk('public')->delete($quiz->image);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
                $data['image'] = $image->storeAs('quiz', $filename, 'public');
            }

            $quiz->update($data);

            DB::commit();

            return redirect('admin/quiz/' . $quiz->id)
                ->with('success', 'Quiz mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            if ($quiz->image) {
                Storage::disk('public')->delete($quiz->image);
            }

            foreach ($quiz->questions as $question) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }
            }

            $quiz->delete();

            DB::commit();

            return redirect('admin/quiz')
                ->with('success', 'Quiz supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Quiz $quiz)
    {
        $nouveauStatut = match($quiz->statut) {
            'brouillon' => 'publie',
            'publie' => 'archive',
            'archive' => 'brouillon',
            default => 'brouillon'
        };

        $quiz->update(['statut' => $nouveauStatut]);

        $message = "Quiz " . match($nouveauStatut) {
            'publie' => 'publié',
            'archive' => 'archivé',
            'brouillon' => 'remis en brouillon'
        };

        return redirect()->back()->with('success', "Quiz $message avec succès.");
    }

    public function duplicate(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $nouveauQuiz = $quiz->replicate();
            $nouveauQuiz->titre = $quiz->titre . ' (copie)';
            $nouveauQuiz->statut = 'brouillon';
            $nouveauQuiz->created_by = auth()->id();
            $nouveauQuiz->save();

            foreach ($quiz->questions as $question) {
                $nouvelleQuestion = $question->replicate();
                $nouvelleQuestion->quiz_id = $nouveauQuiz->id;
                $nouvelleQuestion->save();
            }

            DB::commit();

            return redirect('admin/quiz')
                ->with('success', 'Quiz dupliqué avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la duplication: ' . $e->getMessage());
        }
    }

    public function questions(Quiz $quiz)
    {
        $quiz->load(['questions' => function($q) {
            $q->orderBy('ordre');
        }]);
        
        return view('admin.quiz.questions.index', compact('quiz'));
    }

    public function statistiques(Quiz $quiz)
    {
        $resultats = $quiz->resultats()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalQuestions = $quiz->questions()->count();
        $resultatsCollection = $quiz->resultats;
        
        $stats = [
            'total' => $resultatsCollection->count(),
            'moyenne' => $resultatsCollection->isNotEmpty() ? round($resultatsCollection->avg('score'), 1) : 0,
            'max' => $resultatsCollection->isNotEmpty() ? $resultatsCollection->max('score') : 0,
            'min' => $resultatsCollection->isNotEmpty() ? $resultatsCollection->min('score') : 0,
            'reussite' => $this->calculerTauxReussite($quiz),
            'temps_moyen' => $this->calculerTempsMoyen($quiz)
        ];

        $distribution = [
            '0-20' => $quiz->resultats()->where('score', '<=', 2)->count(),
            '21-40' => $quiz->resultats()->whereBetween('score', [3, 4])->count(),
            '41-60' => $quiz->resultats()->whereBetween('score', [5, 6])->count(),
            '61-80' => $quiz->resultats()->whereBetween('score', [7, 8])->count(),
            '81-100' => $quiz->resultats()->where('score', '>=', 9)->count(),
        ];

        return view('admin.quiz.statistiques', compact('quiz', 'resultats', 'stats', 'distribution'));
    }

    public function exportResultats(Quiz $quiz)
    {
        $resultats = $quiz->resultats()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalQuestions = $quiz->questions()->count();
        $filename = 'quiz-' . $quiz->id . '-resultats-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'Élève',
            'Email',
            'Score',
            'Pourcentage',
            'Réussite',
            'Temps',
            'Date'
        ]);

        foreach ($resultats as $resultat) {
            $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
            
            fputcsv($handle, [
                $resultat->user->name,
                $resultat->user->email,
                $resultat->score . '/' . $totalQuestions,
                $pourcentage . '%',
                $pourcentage >= $quiz->score_passer ? 'Oui' : 'Non',
                $this->formatTemps($resultat->temps_ecoule),
                $resultat->created_at->format('d/m/Y H:i')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function getChapitres(Request $request)
    {
        $chapitres = Chapitre::where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('statut', true)
            ->orderBy('titre')
            ->get(['id', 'titre as nom']);

        return response()->json($chapitres);
    }

    public function resultats()
    {
        $resultats = QuizResultat::with(['quiz', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.quiz.resultats', compact('resultats'));
    }

    public function showResultat(QuizResultat $resultat)
    {
        $resultat->load(['quiz', 'user', 'quiz.questions']);
        
        return view('admin.quiz.show-resultat', compact('resultat'));
    }

    public function destroyResultat(QuizResultat $resultat)
    {
        $resultat->delete();

        return redirect('admin/quiz/resultats')
            ->with('success', 'Résultat supprimé avec succès.');
    }

    private function calculerTauxReussite(Quiz $quiz)
    {
        $resultats = $quiz->resultats;
        $total = $resultats->count();
        
        if ($total == 0) return 0;

        $totalQuestions = $quiz->questions()->count();
        if ($totalQuestions == 0) return 0;

        $reussites = $resultats->filter(function($r) use ($totalQuestions, $quiz) {
            $pourcentage = ($r->score / $totalQuestions) * 100;
            return $pourcentage >= $quiz->score_passer;
        })->count();

        return round(($reussites / $total) * 100);
    }

    private function calculerTempsMoyen(Quiz $quiz)
    {
        $tempsMoyen = $quiz->resultats()->avg('temps_ecoule');
        if (!$tempsMoyen) return 'N/A';

        return $this->formatTemps($tempsMoyen);
    }

    private function formatTemps($secondes)
    {
        $minutes = floor($secondes / 60);
        $secondesRestantes = $secondes % 60;
        return $minutes . ':' . str_pad($secondesRestantes, 2, '0', STR_PAD_LEFT);
    }
}