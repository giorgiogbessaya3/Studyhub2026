<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// CONTROLLERS FRONTEND - STUDYHUB
// ==========================================
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\CoursController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\EpreuveControllers;
use App\Http\Controllers\Frontend\AssistanceController;
use App\Http\Controllers\Frontend\QuizController as FrontendQuizController;

// ==========================================
// CONTROLLERS AUTH
// ==========================================


// ==========================================
// CONTROLLERS ADMIN - STUDYHUB
// ==========================================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Admin\EpreuveController as AdminEpreuveController;
use App\Http\Controllers\Admin\TypeEpreuveController;
use App\Http\Controllers\Admin\ContenuController;
use App\Http\Controllers\Admin\ChapitreController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AssistanceController as AdminAssistanceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ContactController as AdminContactController; // IMPORTANT: Alias pour le contrôleur admin

// ==========================================
// ROUTES PUBLIQUES - PAGE D'ACCUEIL STUDYHUB
// ==========================================
Route::get('/', [FrontendController::class, 'index'])->name('home');

// ==========================================
// ROUTES PUBLIQUES - GESTION DES COURS
// ==========================================
Route::prefix('cours')->name('cours.')->controller(CoursController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/recherche', 'recherche')->name('recherche');
    Route::get('/classe/{classe}', 'classe')->name('classe');
    Route::get('/classe/{classe}/matiere/{matiere}', 'matiere')->name('matiere');
    Route::get('/chapitre/{chapitre}', 'chapitre')->name('chapitre');
    Route::get('/telecharger/{contenu}', 'telecharger')->name('telecharger');
});

// ==========================================
// ROUTES PUBLIQUES - BANQUE D'ÉPREUVES
// ==========================================
Route::prefix('epreuves')->name('epreuves.')->controller(EpreuveControllers::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/classes', 'index')->name('classes');
    Route::get('/classe/{classe}/types', 'typesParClasse')->name('types');
    Route::get('/classe/{classe}/type/{type}/matieres', 'matieresParType')->name('matieres');
    Route::get('/classe/{classe}/type/{type}/matiere/{matiere}', 'listeEpreuves')->name('liste');
    Route::get('/{epreuve}', 'show')->name('show');
    Route::get('/{epreuve}/download', 'download')->name('download');
    Route::get('/{epreuve}/correction', 'correction')->name('correction');
    Route::get('/{epreuve}/correction/download', 'downloadCorrection')->name('correction.download');
});

// ==========================================
// ROUTES PUBLIQUES - ASSISTANCE PÉDAGOGIQUE
// ==========================================
Route::prefix('assistance')->name('assistance.')->controller(AssistanceController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/questions', 'liste')->name('liste');
    Route::get('/question/{id}', 'show')->name('show');
    
    Route::middleware(['auth'])->group(function() {
        Route::get('/poser', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/question/{id}/repondre', 'reply')->name('reply');
        Route::post('/reponse/{id}/solution', 'markAsSolution')->name('solution');
        Route::get('/mes-questions', 'mesQuestions')->name('mes-questions');
        Route::get('/question/{id}/edit', 'edit')->name('edit');
        Route::put('/question/{id}', 'update')->name('update');
        Route::delete('/question/{id}', 'destroy')->name('destroy');
    });
});

// ==========================================
// ANCIENNES ROUTES COURS (REDIRECTIONS)
// ==========================================
Route::get('/cours-old', [FrontendController::class, 'cours'])->name('cours.old');
Route::get('/cours/{slug}', function($slug) {
    return redirect()->route('cours.chapitre', $slug);
})->name('cours.detail.old');

Route::get('/classe/{classe}', function($classe) {
    return redirect()->route('cours.classe', $classe);
})->name('classe.detail.old');

Route::get('/matiere/{matiere}', function($matiere) {
    $classeId = request('classe');
    if ($classeId) {
        return redirect()->route('cours.matiere', ['classe' => $classeId, 'matiere' => $matiere]);
    }
    return redirect()->route('cours.index');
})->name('matiere.detail.old');

// ==========================================
// ROUTES PUBLIQUES - QUIZ
// ==========================================
Route::prefix('quiz')->name('quiz.')->controller(FrontendQuizController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{quiz}', 'show')->name('show');
    Route::get('/{quiz}/start', 'start')->name('start');
    Route::post('/{quiz}/submit', 'submit')->name('submit');
    Route::get('/{quiz}/result/{resultat}', 'result')->name('result');
});

// ==========================================
// ROUTES PUBLIQUES - CONTACT & NEWSLETTER
// ==========================================
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');
Route::post('newsletter/subscribe', [ContactController::class, 'newsletter'])->name('newsletter.subscribe')->middleware('throttle:3,1');

// ==========================================
// ROUTES PUBLIQUES - RECHERCHE
// ==========================================
Route::get('search', [FrontendController::class, 'search'])->name('search');
Route::get('recherche', [FrontendController::class, 'search'])->name('recherche');

// ==========================================
// AUTHENTIFICATION
// ==========================================
Auth::routes(['verify' => true]);

// ==========================================
// ROUTES UTILISATEUR AUTHENTIFIÉ
// ==========================================
Route::middleware(['auth'])->group(function() {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar');
    Route::get('change-password', [UserController::class, 'changePassword'])->name('password.change');
    Route::post('profile/password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::delete('profile/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');
    Route::get('mes-cours', [UserController::class, 'mesCours'])->name('mes.cours');
    Route::get('mes-epreuves', [UserController::class, 'mesEpreuves'])->name('mes.epreuves');
    Route::get('mes-resultats', [UserController::class, 'mesResultats'])->name('mes.resultats');
    Route::get('mes-resultats/{id}', [UserController::class, 'detailResultat'])->name('mes.resultats.detail');
    Route::get('mes-questions', [UserController::class, 'mesQuestions'])->name('mes.questions');
});

// ==========================================
// ROUTES ADMIN
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function() {
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/epreuves', [DashboardController::class, 'dashboardEpreuves'])->name('dashboard.epreuves');
    Route::get('dashboard/cours', [DashboardController::class, 'dashboardCours'])->name('dashboard.cours');
    Route::get('dashboard/evaluations', [DashboardController::class, 'dashboardEvaluations'])->name('dashboard.evaluations');
    Route::get('dashboard/assistance', [DashboardController::class, 'dashboardAssistance'])->name('dashboard.assistance');
    Route::get('dashboard/users', [DashboardController::class, 'dashboardUsers'])->name('dashboard.users');
    
    // Profil admin
    Route::get('profil', [DashboardController::class, 'profil'])->name('profil');
    Route::post('profil', [DashboardController::class, 'updateProfil'])->name('profil.update');
    
    // Gestion des utilisateurs
    Route::prefix('users')->name('users.')->controller(AdminUserController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{user}/edit', 'edit')->name('edit');
        Route::put('{user}', 'update')->name('update');
        Route::delete('{user}', 'destroy')->name('destroy');
        Route::get('{user}', 'show')->name('show');
        Route::get('eleves', 'eleves')->name('eleves');
        Route::get('enseignants', 'enseignants')->name('enseignants');
        Route::get('admins', 'admins')->name('admins');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::post('bulk-status', 'bulkStatus')->name('bulk.status');
    });
    
    // Gestion des classes
    Route::prefix('classes')->name('classes.')->controller(ClasseController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{classe}/edit', 'edit')->name('edit');
        Route::put('{classe}', 'update')->name('update');
        Route::delete('{classe}', 'destroy')->name('destroy');
        Route::post('{classe}/toggle-status', 'toggleStatus')->name('toggle');
    });
    
    // Gestion des matières
    Route::prefix('matieres')->name('matieres.')->controller(MatiereController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{matiere}/edit', 'edit')->name('edit');
        Route::put('{matiere}', 'update')->name('update');
        Route::delete('{matiere}', 'destroy')->name('destroy');
    });
    
    // Gestion des chapitres
    Route::prefix('chapitres')->name('chapitres.')->controller(ChapitreController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{chapitre}', 'show')->name('show');
        Route::get('{chapitre}/edit', 'edit')->name('edit');
        Route::put('{chapitre}', 'update')->name('update');
        Route::delete('{chapitre}', 'destroy')->name('destroy');
        Route::post('{chapitre}/toggle-status', 'toggleStatus')->name('toggle');
        Route::get('classe/{classe}/matiere/{matiere}', 'byClasseAndMatiere')->name('by.classe.matiere');
    });
    
    // Gestion des contenus
    Route::prefix('contenus')->name('contenus.')->controller(ContenuController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('chapitre/{chapitre}/create', 'create')->name('create');
        Route::post('chapitre/{chapitre}', 'store')->name('store');
        Route::get('{contenu}', 'show')->name('show');
        Route::get('{contenu}/edit', 'edit')->name('edit');
        Route::put('{contenu}', 'update')->name('update');
        Route::delete('{contenu}', 'destroy')->name('destroy');
        Route::post('{contenu}/toggle-status', 'toggleStatus')->name('toggle');
        Route::post('reorder', 'reorder')->name('reorder');
    });
    
    // Gestion des types d'épreuves
    Route::prefix('types-epreuves')->name('types-epreuves.')->controller(TypeEpreuveController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{typeEpreuve}/edit', 'edit')->name('edit');
        Route::put('{typeEpreuve}', 'update')->name('update');
        Route::delete('{typeEpreuve}', 'destroy')->name('destroy');
        Route::post('{typeEpreuve}/toggle-status', 'toggleStatus')->name('toggle');
    });
    
    // Gestion des épreuves (admin)
    Route::resource('epreuves', AdminEpreuveController::class)->parameters([
        'epreuves' => 'epreuve'
    ]);
    
    Route::prefix('epreuves/{epreuve}')->name('epreuves.')->group(function() {
        Route::post('toggle-status', [AdminEpreuveController::class, 'toggleStatus'])->name('toggle');
        Route::post('duplicate', [AdminEpreuveController::class, 'duplicate'])->name('duplicate');
        Route::get('download', [AdminEpreuveController::class, 'download'])->name('download');
        Route::get('preview', [AdminEpreuveController::class, 'preview'])->name('preview');
    });
    
    // Gestion des corrections
    Route::prefix('epreuves/{epreuve}/correction')->name('epreuves.correction.')->group(function() {
        Route::get('/', [AdminEpreuveController::class, 'showCorrection'])->name('show');
        Route::post('/', [AdminEpreuveController::class, 'storeCorrection'])->name('store');
        Route::put('/', [AdminEpreuveController::class, 'updateCorrection'])->name('update');
        Route::delete('/', [AdminEpreuveController::class, 'destroyCorrection'])->name('destroy');
    });
    
    Route::get('corrections', [AdminEpreuveController::class, 'corrections'])->name('corrections');
    Route::get('epreuves/import', [AdminEpreuveController::class, 'showImportForm'])->name('epreuves.import.form');
    Route::post('epreuves/import', [AdminEpreuveController::class, 'import'])->name('epreuves.import');
    Route::get('epreuves/export', [AdminEpreuveController::class, 'export'])->name('epreuves.export');
    
    // ==========================================
    // GESTION DES QUIZ (ADMIN)
    // ==========================================
    Route::resource('quiz', QuizController::class)->parameters(['quiz' => 'quiz']);
    
    Route::prefix('quiz/{quiz}')->name('quiz.')->group(function() {
        Route::post('toggle-status', [QuizController::class, 'toggleStatus'])->name('toggle');
        Route::post('duplicate', [QuizController::class, 'duplicate'])->name('duplicate');
        Route::get('questions', [QuizController::class, 'questions'])->name('questions');
        Route::get('statistiques', [QuizController::class, 'statistiques'])->name('statistiques');
        Route::get('export-resultats', [QuizController::class, 'exportResultats'])->name('export-resultats');
    });
    
    // ==========================================
    // GESTION DES QUESTIONS
    // ==========================================
    Route::prefix('questions')->name('questions.')->controller(QuestionController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{question}', 'show')->name('show');
        Route::get('/{question}/edit', 'edit')->name('edit');
        Route::put('/{question}', 'update')->name('update');
        Route::delete('/{question}', 'destroy')->name('destroy');
        Route::post('/{question}/duplicate', 'duplicate')->name('duplicate');
        Route::get('/import', 'importForm')->name('import.form');
        Route::post('/import', 'import')->name('import');
        Route::get('/export', 'export')->name('export');
    });
    
    // ==========================================
    // GESTION DES RÉSULTATS (ADMIN)
    // ==========================================
    Route::prefix('resultats')->name('resultats.')->controller(QuizController::class)->group(function() {
        Route::get('/', 'resultats')->name('index');
        Route::get('/{resultat}', 'showResultat')->name('show');
        Route::delete('/{resultat}', 'destroyResultat')->name('destroy');
        Route::get('/export/all', 'exportAllResultats')->name('export.all');
        Route::get('/export/quiz/{quiz}', 'exportResultats')->name('export.quiz');
    });
    
    // Routes AJAX pour les filtres
    Route::get('/api/matieres', [QuestionController::class, 'getMatieres'])->name('api.matieres');
    Route::get('/api/chapitres', [QuestionController::class, 'getChapitres'])->name('api.chapitres');
    Route::get('/api/quizs', [QuestionController::class, 'getQuizs'])->name('api.quizs');
    
    Route::get('resultats', [QuizController::class, 'resultats'])->name('resultats');
    Route::get('resultats/{resultat}', [QuizController::class, 'showResultat'])->name('resultats.show');
    Route::delete('resultats/{resultat}', [QuizController::class, 'destroyResultat'])->name('resultats.destroy');
    Route::get('resultats/export/{quiz}', [QuizController::class, 'exportResultats'])->name('resultats.export');
    Route::post('quiz/{quiz}/toggle-status', [QuizController::class, 'toggleStatus'])->name('quiz.toggle');
    Route::get('quiz/{quiz}/statistiques', [QuizController::class, 'statistiques'])->name('quiz.statistiques');
    
    // ==========================================
    // GESTION DE L'ASSISTANCE ADMIN
    // ==========================================
    Route::prefix('assistance')->name('assistance.')->controller(AdminAssistanceController::class)->group(function() {
        Route::get('questions', 'questions')->name('questions');
        Route::get('questions/{question}', 'showQuestion')->name('questions.show');
        Route::post('questions/{question}/reply', 'reply')->name('questions.reply');
        Route::delete('questions/{question}', 'destroyQuestion')->name('questions.destroy');
        Route::post('questions/{question}/toggle-publish', 'togglePublish')->name('questions.toggle-publish');
        Route::get('reponses', 'reponses')->name('reponses');
        Route::post('reponses/{reponse}/approve', 'approveReponse')->name('reponses.approve');
        Route::post('reponses/{reponse}/reject', 'rejectReponse')->name('reponses.reject');
        Route::delete('reponses/{reponse}', 'destroyReponse')->name('reponses.destroy');
        Route::post('reponses/{reponse}/solution', 'marquerSolution')->name('reponses.solution');
        Route::get('statistiques', 'statistiques')->name('statistiques');
        Route::get('export', 'export')->name('export');
    });
    
    // ==========================================
    // GESTION DES CONTACTS (ADMIN) - CORRIGÉE
    // ==========================================
    Route::prefix('contacts')->name('contacts.')->controller(AdminContactController::class)->group(function() {
        Route::get('/', 'indexAdmin')->name('index');
        Route::get('/{contact}', 'showAdmin')->name('show');
        Route::delete('/{contact}', 'destroyAdmin')->name('destroy');
        Route::get('/{contact}/reply', 'replyAdmin')->name('reply');
        Route::post('/{contact}/status', 'updateStatus')->name('update-status');
        Route::post('/bulk-actions', 'bulkActions')->name('bulk-actions');
        Route::get('/export', 'export')->name('export');
    });
    
    // Gestion de la newsletter
    Route::prefix('newsletter')->name('newsletter.')->controller(NewsletterController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('send', 'send')->name('send');
        Route::get('subscribers', 'subscribers')->name('subscribers');
        Route::delete('subscribers/{subscriber}', 'destroySubscriber')->name('subscribers.destroy');
        Route::post('subscribers/{subscriber}/toggle', 'toggleSubscriber')->name('subscribers.toggle');
        Route::get('export', 'export')->name('export');
        Route::post('import', 'import')->name('import');
    });
    
    // Paramètres
    Route::prefix('settings')->name('settings.')->controller(SettingController::class)->group(function() {
        Route::get('general', 'general')->name('general');
        Route::put('general', 'updateGeneral')->name('general.update');
        Route::get('securite', 'securite')->name('securite');
        Route::put('securite', 'updateSecurite')->name('securite.update');
        Route::get('performance', 'performance')->name('performance');
        Route::put('performance', 'updatePerformance')->name('performance.update');
        Route::get('sauvegardes', 'sauvegardes')->name('sauvegardes');
        Route::post('sauvegardes/create', 'createBackup')->name('sauvegardes.create');
        Route::post('sauvegardes/restore', 'restoreBackup')->name('sauvegardes.restore');
        Route::delete('sauvegardes/{filename}', 'deleteBackup')->name('sauvegardes.delete');
        Route::get('technique', 'technique')->name('technique');
        Route::put('technique', 'updateTechnique')->name('technique.update');
        Route::get('apparence', 'apparence')->name('apparence');
        Route::put('apparence', 'updateApparence')->name('apparence.update');
    });
    
    // Statistiques et rapports
    Route::get('statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
    Route::get('statistiques/globales', [DashboardController::class, 'statistiquesGlobales'])->name('statistiques.globales');
    Route::get('rapports/activite', [DashboardController::class, 'rapportActivite'])->name('rapports.activite');
    Route::get('rapports/utilisateurs', [DashboardController::class, 'rapportUtilisateurs'])->name('rapports.utilisateurs');
    Route::get('rapports/contenu', [DashboardController::class, 'rapportContenu'])->name('rapports.contenu');
    Route::get('rapports/telechargements', [DashboardController::class, 'rapportTelechargements'])->name('rapports.telechargements');
    Route::get('rapports/personnalise', [DashboardController::class, 'rapportPersonnalise'])->name('rapports.personnalise');
    
    // Export
    Route::get('export/users', [DashboardController::class, 'exportUsers'])->name('export.users');
    Route::get('export/epreuves', [DashboardController::class, 'exportEpreuves'])->name('export.epreuves');
    Route::get('export/cours', [DashboardController::class, 'exportCours'])->name('export.cours');
    Route::get('export/resultats', [DashboardController::class, 'exportResultats'])->name('export.resultats');
    Route::get('export/assistance', [DashboardController::class, 'exportAssistance'])->name('export.assistance');
    
    // Logs
    Route::get('logs', [DashboardController::class, 'logs'])->name('logs');
    Route::get('logs/clear', [DashboardController::class, 'clearLogs'])->name('logs.clear');
    Route::get('logs/{log}', [DashboardController::class, 'showLog'])->name('logs.show');
    Route::post('logs/export', [DashboardController::class, 'exportLogs'])->name('logs.export');
    
    // Maintenance
    Route::post('maintenance/enable', [DashboardController::class, 'enableMaintenance'])->name('maintenance.enable');
    Route::post('maintenance/disable', [DashboardController::class, 'disableMaintenance'])->name('maintenance.disable');
    Route::get('maintenance/status', [DashboardController::class, 'maintenanceStatus'])->name('maintenance.status');
    
    // Cache
    Route::post('cache/clear', [DashboardController::class, 'clearCache'])->name('cache.clear');
    Route::post('cache/optimize', [DashboardController::class, 'optimizeCache'])->name('cache.optimize');
    
    // Upload d'images pour CKEditor
    Route::post('/upload/image', [App\Http\Controllers\Admin\UploadController::class, 'image'])->name('upload.image');
});

// ==========================================
// ROUTES API
// ==========================================
Route::prefix('api')->name('api.')->middleware(['auth:api'])->group(function() {
    Route::get('classes', [ClasseController::class, 'apiIndex'])->name('classes');
    Route::get('classes/{classe}/matieres', [MatiereController::class, 'apiByClasse'])->name('classes.matieres');
    Route::get('classes/{classe}/details', [ClasseController::class, 'apiShow'])->name('classes.show');
    Route::get('matieres', [MatiereController::class, 'apiIndex'])->name('matieres');
    Route::get('matieres/{matiere}/chapitres', [ChapitreController::class, 'apiByMatiere'])->name('matieres.chapitres');
    Route::get('chapitres', [ChapitreController::class, 'apiIndex'])->name('chapitres');
    Route::get('chapitres/{chapitre}', [ChapitreController::class, 'apiShow'])->name('chapitres.show');
    Route::get('chapitres/{chapitre}/contenus', [ContenuController::class, 'apiByChapitre'])->name('chapitres.contenus');
    Route::get('contenus', [ContenuController::class, 'apiIndex'])->name('contenus');
    Route::get('contenus/{contenu}', [ContenuController::class, 'apiShow'])->name('contenus.show');
    Route::get('epreuves', [AdminEpreuveController::class, 'apiIndex'])->name('epreuves');
    Route::get('epreuves/{epreuve}', [AdminEpreuveController::class, 'apiShow'])->name('epreuves.show');
    Route::get('epreuves/{epreuve}/download', [AdminEpreuveController::class, 'apiDownload'])->name('epreuves.download');
    Route::get('types-epreuves', [TypeEpreuveController::class, 'apiIndex'])->name('types-epreuves');
    
    // API Quiz (Frontend)
    Route::get('quiz', [FrontendQuizController::class, 'apiIndex'])->name('quiz');
    Route::get('quiz/{quiz}', [FrontendQuizController::class, 'apiShow'])->name('quiz.show');
    
    // API Questions
    Route::get('questions', [QuestionController::class, 'apiIndex'])->name('questions');
    Route::get('questions/{question}', [QuestionController::class, 'apiShow'])->name('questions.show');
    Route::get('questions/quiz/{quiz}', [QuestionController::class, 'apiByQuiz'])->name('questions.by-quiz');
    
    // API Résultats (Admin)
    Route::get('resultats', [QuizController::class, 'apiResultats'])->name('resultats');
    Route::get('resultats/{resultat}', [QuizController::class, 'apiShowResultat'])->name('resultats.show');
    Route::get('resultats/quiz/{quiz}', [QuizController::class, 'apiResultatsByQuiz'])->name('resultats.by-quiz');
    Route::get('resultats/user/{user}', [QuizController::class, 'apiResultatsByUser'])->name('resultats.by-user');
    
    // API Résultats utilisateur
    Route::get('user/resultats', [UserController::class, 'apiMesResultats'])->name('user.resultats');
    Route::get('user/resultats/{resultat}', [UserController::class, 'apiDetailResultat'])->name('user.resultats.show');
    
    Route::get('assistance/questions', [AdminAssistanceController::class, 'apiQuestions'])->name('assistance.questions');
    Route::get('assistance/questions/{question}', [AdminAssistanceController::class, 'apiShowQuestion'])->name('assistance.questions.show');
    Route::post('assistance/questions', [AdminAssistanceController::class, 'apiStoreQuestion'])->name('assistance.store');
    Route::post('assistance/questions/{question}/repondre', [AdminAssistanceController::class, 'apiReply'])->name('assistance.reply');
    Route::get('search', [FrontendController::class, 'apiSearch'])->name('search');
    
    Route::middleware('auth:api')->group(function() {
        Route::get('user/profile', [UserController::class, 'apiProfile'])->name('user.profile');
        Route::put('user/profile', [UserController::class, 'apiUpdateProfile'])->name('user.update');
        Route::get('user/mes-cours', [UserController::class, 'apiMesCours'])->name('user.mes-cours');
        Route::get('user/mes-epreuves', [UserController::class, 'apiMesEpreuves'])->name('user.mes-epreuves');
        Route::get('user/mes-resultats', [UserController::class, 'apiMesResultats'])->name('user.mes-resultats');
        Route::get('user/mes-questions', [UserController::class, 'apiMesQuestions'])->name('user.mes-questions');
    });
});

// ==========================================
// ROUTES API PUBLIQUES
// ==========================================
Route::prefix('api/public')->name('api.public.')->group(function() {
    Route::get('stats', [FrontendController::class, 'apiStats'])->name('stats');
    Route::get('search', [FrontendController::class, 'apiPublicSearch'])->name('search');
    Route::get('classes', [ClasseController::class, 'apiPublicIndex'])->name('classes');
    Route::get('matieres', [MatiereController::class, 'apiPublicIndex'])->name('matieres');
    Route::post('newsletter/subscribe', [ContactController::class, 'apiNewsletterSubscribe'])->name('newsletter.subscribe');
    Route::post('contact', [ContactController::class, 'apiStore'])->name('contact');
    Route::get('quiz', [FrontendQuizController::class, 'apiIndex'])->name('quiz.public');
});

// ==========================================
// REDIRECTIONS ET RACCOURCIS
// ==========================================
Route::get('college', function() {
    return redirect()->route('cours.index');
})->name('college');

Route::get('lycee', function() {
    return redirect()->route('cours.index');
})->name('lycee');

Route::get('recherche', function() {
    return redirect()->route('search');
})->name('recherche');

// ==========================================
// PAGE 404 - FALLBACK
// ==========================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
})->name('notfound');

// ==========================================
// TEST DE ROUTES (UNIQUEMENT EN LOCAL)
// ==========================================
if (app()->environment('local')) {
    Route::get('/test-routes', function() {
        $routes = collect(Route::getRoutes())->map(function($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'methods' => implode('|', $route->methods()),
                'action' => $route->getActionName()
            ];
        })->filter(function($route) {
            return !str_starts_with($route['uri'], '_') && 
                   !str_starts_with($route['uri'], 'api') &&
                   $route['uri'] !== 'test-routes';
        })->values();
        
        return response()->json([
            'total' => $routes->count(),
            'routes' => $routes
        ]);
    })->name('test.routes');
}