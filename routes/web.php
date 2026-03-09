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
use App\Http\Controllers\Frontend\EpreuveControllers; // Avec S

// ==========================================
// CONTROLLERS AUTH
// ==========================================
use App\Http\Controllers\HomeController;

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
use App\Http\Controllers\Admin\AssistanceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NewsletterController;

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
// SUPPRIMER TOUTES LES ANCIENNES ROUTES D'ÉPREUVES ET GARDER UNIQUEMENT CELLES-CI :

Route::prefix('epreuves')->name('epreuves.')->controller(EpreuveControllers::class)->group(function() {
    // Page d'accueil des épreuves (liste des classes)
    Route::get('/', 'index')->name('index');
    Route::get('/classes', 'index')->name('classes'); // Alias pour compatibilité
    
    // Navigation en cascade
    Route::get('/classe/{classe}/types', 'typesParClasse')->name('types');
    Route::get('/classe/{classe}/type/{type}/matieres', 'matieresParType')->name('matieres');
    Route::get('/classe/{classe}/type/{type}/matiere/{matiere}', 'listeEpreuves')->name('liste');
    
    // Détail d'une épreuve
    Route::get('/{epreuve}', 'show')->name('show');
    
    // Téléchargement
    Route::get('/{epreuve}/download', 'download')->name('download');
    
    // Correction
    Route::get('/{epreuve}/correction', 'correction')->name('correction');
    Route::get('/{epreuve}/correction/download', 'downloadCorrection')->name('correction.download');
});

// ==========================================
// ANCIENNES ROUTES COURS (REDIRECTIONS POUR COMPATIBILITÉ)
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
// ROUTES PUBLIQUES - ÉVALUATIONS/QUIZ
// ==========================================
Route::get('quiz', [FrontendController::class, 'quizList'])->name('quiz.list');
Route::get('quiz/{quiz}', [FrontendController::class, 'quizStart'])->name('quiz.start');
Route::post('quiz/{quiz}/submit', [FrontendController::class, 'quizSubmit'])->name('quiz.submit');
Route::get('quiz/{quiz}/result', [FrontendController::class, 'quizResult'])->name('quiz.result');

// ==========================================
// ROUTES PUBLIQUES - ASSISTANCE PÉDAGOGIQUE
// ==========================================
Route::get('assistance', [FrontendController::class, 'assistance'])->name('assistance');
Route::get('assistance/nouvelle', [FrontendController::class, 'createQuestion'])->name('assistance.create');
Route::post('assistance/question', [FrontendController::class, 'storeQuestion'])->name('assistance.store');
Route::get('assistance/questions', [FrontendController::class, 'questionsList'])->name('assistance.list');
Route::get('assistance/question/{question}', [FrontendController::class, 'questionDetail'])->name('assistance.show');
Route::post('assistance/question/{question}/repondre', [FrontendController::class, 'replyQuestion'])->name('assistance.reply');

// ==========================================
// ROUTES PUBLIQUES - CONTACT & NEWSLETTER
// ==========================================
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('newsletter/subscribe', [ContactController::class, 'newsletter'])->name('newsletter.subscribe');

// ==========================================
// ROUTES PUBLIQUES - RECHERCHE
// ==========================================
Route::get('search', [FrontendController::class, 'search'])->name('search');

// ==========================================
// AUTHENTIFICATION
// ==========================================
Auth::routes();

// ==========================================
// ROUTES UTILISATEUR AUTHENTIFIÉ
// ==========================================
Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('change-password', [UserController::class, 'changePassword'])->name('password.change');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::get('mes-cours', [UserController::class, 'mesCours'])->name('mes.cours');
    Route::get('mes-epreuves', [UserController::class, 'mesEpreuves'])->name('mes.epreuves');
    Route::get('mes-resultats', [UserController::class, 'mesResultats'])->name('mes.resultats');
    Route::get('mes-questions', [UserController::class, 'mesQuestions'])->name('mes.questions');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
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
    
    // Actions sur les épreuves
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
    
    // Gestion des quiz
    Route::resource('quiz', QuizController::class)->parameters(['quiz' => 'quiz']);
    
    Route::prefix('questions')->name('questions.')->controller(QuestionController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create/{quiz}', 'create')->name('create');
        Route::post('{quiz}', 'store')->name('store');
        Route::get('{question}/edit', 'edit')->name('edit');
        Route::put('{question}', 'update')->name('update');
        Route::delete('{question}', 'destroy')->name('destroy');
        Route::post('reorder', 'reorder')->name('reorder');
    });
    
    Route::get('resultats', [QuizController::class, 'resultats'])->name('resultats');
    Route::get('resultats/{resultat}', [QuizController::class, 'showResultat'])->name('resultats.show');
    Route::delete('resultats/{resultat}', [QuizController::class, 'destroyResultat'])->name('resultats.destroy');
    Route::get('resultats/export/{quiz}', [QuizController::class, 'exportResultats'])->name('resultats.export');
    Route::post('quiz/{quiz}/toggle-status', [QuizController::class, 'toggleStatus'])->name('quiz.toggle');
    Route::get('quiz/{quiz}/statistiques', [QuizController::class, 'statistiques'])->name('quiz.statistiques');
    
    // Gestion de l'assistance
    Route::prefix('assistance')->name('assistance.')->controller(AssistanceController::class)->group(function() {
        Route::get('questions', 'questions')->name('questions');
        Route::get('questions/{question}', 'showQuestion')->name('questions.show');
        Route::post('questions/{question}/reply', 'reply')->name('questions.reply');
        Route::delete('questions/{question}', 'destroyQuestion')->name('questions.destroy');
        Route::post('questions/{question}/toggle-publish', 'togglePublish')->name('questions.toggle-publish');
        Route::get('reponses', 'reponses')->name('reponses');
        Route::post('reponses/{reponse}/approve', 'approveReponse')->name('reponses.approve');
        Route::post('reponses/{reponse}/reject', 'rejectReponse')->name('reponses.reject');
        Route::delete('reponses/{reponse}', 'destroyReponse')->name('reponses.destroy');
        Route::get('statistiques', 'statistiques')->name('statistiques');
        Route::get('export', 'export')->name('export');
    });
    
    // Gestion des contacts
    Route::prefix('contacts')->name('contacts.')->controller(ContactController::class)->group(function() {
        Route::get('/', 'indexAdmin')->name('index');
        Route::get('{contact}', 'showAdmin')->name('show');
        Route::delete('{contact}', 'destroyAdmin')->name('destroy');
        Route::post('{contact}/reply', 'replyAdmin')->name('reply');
        Route::post('bulk-actions', 'bulkActions')->name('bulk-actions');
        Route::get('export', 'export')->name('export');
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
    Route::get('quiz', [QuizController::class, 'apiIndex'])->name('quiz');
    Route::get('quiz/{quiz}', [QuizController::class, 'apiShow'])->name('quiz.show');
    Route::get('quiz/{quiz}/questions', [QuizController::class, 'apiQuestions'])->name('quiz.questions');
    Route::post('quiz/{quiz}/submit', [QuizController::class, 'apiSubmit'])->name('quiz.submit');
    Route::get('quiz/{quiz}/resultats', [QuizController::class, 'apiResultats'])->name('quiz.resultats');
    Route::get('assistance/questions', [AssistanceController::class, 'apiQuestions'])->name('assistance.questions');
    Route::get('assistance/questions/{question}', [AssistanceController::class, 'apiShowQuestion'])->name('assistance.questions.show');
    Route::post('assistance/questions', [AssistanceController::class, 'apiStoreQuestion'])->name('assistance.store');
    Route::post('assistance/questions/{question}/repondre', [AssistanceController::class, 'apiReply'])->name('assistance.reply');
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
Route::fallback([FrontendController::class, 'notFound'])->name('notfound');

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