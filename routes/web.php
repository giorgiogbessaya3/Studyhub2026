<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// CONTROLLERS FRONTEND - STUDYHUB
// ==========================================
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\ContactController;

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
use App\Http\Controllers\Admin\EpreuveController;
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
// ROUTES PUBLIQUES - NAVIGATION CLASSE/MATIÈRE/CHAPITRE (CASCADE)
// ==========================================

// Étape 1: Liste toutes les classes (Collège + Lycée)
Route::get('classes', [FrontendController::class, 'classes'])->name('classes');

// Étape 2: Détail d'une classe → Liste des matières
Route::get('classe/{classe}', [FrontendController::class, 'classeDetail'])->name('classe.detail');

// Étape 3: Détail d'une matière → Liste des chapitres
Route::get('matiere/{matiere}', [FrontendController::class, 'matiereDetail'])->name('matiere.detail');

// Étape 4: Détail d'un chapitre → Contenu pédagogique
Route::get('chapitre/{slug}', [FrontendController::class, 'chapitreDetail'])->name('chapitre.detail');

// ==========================================
// ROUTES PUBLIQUES - BANQUE D'ÉPREUVES (VUE GLOBALE AVEC FILTRES)
// ==========================================

// Liste toutes les épreuves (avec filtres classe/matière/type)
Route::get('epreuves', [FrontendController::class, 'epreuves'])->name('epreuves');

// Détail d'une épreuve spécifique
Route::get('epreuves/{epreuve}', [FrontendController::class, 'epreuveDetail'])->name('epreuve.detail');

// Télécharger le fichier PDF d'une épreuve
Route::get('epreuves/{epreuve}/download', [FrontendController::class, 'downloadEpreuve'])->name('epreuve.download');

// Voir la correction d'une épreuve
Route::get('corrections/{epreuve}', [FrontendController::class, 'correction'])->name('correction');

// ==========================================
// ROUTES POUR LA NAVIGATION CASCADE DES ÉPREUVES (4 ÉTAPES)
// ==========================================

// ÉTAPE 1: Liste des classes pour épreuves
Route::get('epreuves/classes', [FrontendController::class, 'epreuvesClasses'])->name('epreuves.classes');

// ÉTAPE 2: Types d'épreuves pour une classe
Route::get('epreuves/classe/{classe}/types', [FrontendController::class, 'epreuvesTypes'])->name('epreuves.types');

// ÉTAPE 3: Matières pour un type d'épreuve dans une classe
Route::get('epreuves/classe/{classe}/type/{type}/matieres', [FrontendController::class, 'epreuvesMatieres'])->name('epreuves.matieres');

// ÉTAPE 4: Liste des épreuves pour une matière, un type et une classe
Route::get('epreuves/classe/{classe}/type/{type}/matiere/{matiere}', [FrontendController::class, 'epreuvesListe'])->name('epreuves.liste');

// ==========================================
// ROUTES PUBLIQUES - COURS EN LIGNE (REDIRECTION VERS CLASSES)
// ==========================================

// Redirection vers classes avec type=cours
Route::get('cours', [FrontendController::class, 'cours'])->name('cours');

// Ancienne route détail cours (redirection vers chapitre)
Route::get('cours/{slug}', [FrontendController::class, 'coursDetail'])->name('cours.detail');

// ==========================================
// ROUTES PUBLIQUES - ÉVALUATIONS/QUIZ
// ==========================================

// Liste des quiz disponibles
Route::get('quiz', [FrontendController::class, 'quizList'])->name('quiz.list');

// Démarrer un quiz spécifique
Route::get('quiz/{quiz}', [FrontendController::class, 'quizStart'])->name('quiz.start');

// Soumettre les réponses d'un quiz
Route::post('quiz/{quiz}/submit', [FrontendController::class, 'quizSubmit'])->name('quiz.submit');

// Voir le résultat d'un quiz
Route::get('quiz/{quiz}/result', [FrontendController::class, 'quizResult'])->name('quiz.result');

// ==========================================
// ROUTES PUBLIQUES - ASSISTANCE PÉDAGOGIQUE
// ==========================================

// Liste des questions d'assistance
Route::get('assistance', [FrontendController::class, 'assistance'])->name('assistance');

// Formulaire pour poser une nouvelle question (GET)
Route::get('assistance/nouvelle', [FrontendController::class, 'createQuestion'])->name('assistance.create');

// Enregistrer une nouvelle question (POST)
Route::post('assistance/question', [FrontendController::class, 'storeQuestion'])->name('assistance.store');

// Liste des questions de l'utilisateur (alias)
Route::get('assistance/questions', [FrontendController::class, 'questionsList'])->name('assistance.list');

// Détail d'une question spécifique avec ses réponses
Route::get('assistance/question/{question}', [FrontendController::class, 'questionDetail'])->name('assistance.show');

// Répondre à une question (POST)
Route::post('assistance/question/{question}/repondre', [FrontendController::class, 'replyQuestion'])->name('assistance.reply');

// ==========================================
// ROUTES PUBLIQUES - CONTACT & NEWSLETTER
// ==========================================

// Page de contact
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');

// Envoyer un message de contact
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

// S'inscrire à la newsletter
Route::post('newsletter/subscribe', [ContactController::class, 'newsletter'])->name('newsletter.subscribe');

// ==========================================
// ROUTES PUBLIQUES - RECHERCHE
// ==========================================

// Recherche globale (cours + épreuves)
Route::get('search', [FrontendController::class, 'search'])->name('search');

// ==========================================
// AUTHENTIFICATION (LARAVEL BREEZE/JETSTREAM OU DEFAULT)
// ==========================================
Auth::routes();

// ==========================================
// ROUTES UTILISATEUR AUTHENTIFIÉ (ESPACE PERSO)
// ==========================================
Route::middleware(['auth'])->group(function() {
    
    // Tableau de bord utilisateur
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    
    // Profil utilisateur
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Changement de mot de passe
    Route::get('change-password', [UserController::class, 'changePassword'])->name('password.change');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('password.update');
    
    // Mes cours suivis
    Route::get('mes-cours', [UserController::class, 'mesCours'])->name('mes.cours');
    
    // Mes épreuves téléchargées
    Route::get('mes-epreuves', [UserController::class, 'mesEpreuves'])->name('mes.epreuves');
    
    // Mes résultats aux quiz
    Route::get('mes-resultats', [UserController::class, 'mesResultats'])->name('mes.resultats');
    
    // Mes questions d'assistance
    Route::get('mes-questions', [UserController::class, 'mesQuestions'])->name('mes.questions');
    
    // Déconnexion
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});

// ==========================================
// ROUTES ADMIN - STUDYHUB (PREFIX: admin/)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function() {
    
    // ==========================================
    // TABLEAU DE BORD ADMIN
    // ==========================================
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tableaux de bord spécifiques par module
    Route::get('dashboard/epreuves', [DashboardController::class, 'dashboardEpreuves'])->name('dashboard.epreuves');
    Route::get('dashboard/cours', [DashboardController::class, 'dashboardCours'])->name('dashboard.cours');
    Route::get('dashboard/evaluations', [DashboardController::class, 'dashboardEvaluations'])->name('dashboard.evaluations');
    Route::get('dashboard/assistance', [DashboardController::class, 'dashboardAssistance'])->name('dashboard.assistance');
    Route::get('dashboard/users', [DashboardController::class, 'dashboardUsers'])->name('dashboard.users');
    
    // ==========================================
    // PROFIL ADMIN
    // ==========================================
    Route::get('profil', [DashboardController::class, 'profil'])->name('profil');
    Route::post('profil', [DashboardController::class, 'updateProfil'])->name('profil.update');
    
    // ==========================================
    // GESTION DES UTILISATEURS (ÉLÈVES/PROFESSEURS/ADMINS)
    // ==========================================
    Route::prefix('users')->name('users.')->controller(AdminUserController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{user}/edit', 'edit')->name('edit');
        Route::put('{user}', 'update')->name('update');
        Route::delete('{user}', 'destroy')->name('destroy');
        Route::get('{user}', 'show')->name('show');
        
        // Filtres par rôle
        Route::get('eleves', 'eleves')->name('eleves');
        Route::get('enseignants', 'enseignants')->name('enseignants');
        Route::get('admins', 'admins')->name('admins');
        
        // Actions groupées
        Route::post('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::post('bulk-status', 'bulkStatus')->name('bulk.status');
    });
    
    // ==========================================
    // ORGANISATION - CLASSES (6ème à Terminale)
    // ==========================================
    Route::prefix('classes')->name('classes.')->controller(ClasseController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{classe}/edit', 'edit')->name('edit');
        Route::put('{classe}', 'update')->name('update');
        Route::delete('{classe}', 'destroy')->name('destroy');
        Route::post('{classe}/toggle-status', 'toggleStatus')->name('toggle');
    });
    
    // ==========================================
    // ORGANISATION - MATIÈRES
    // ==========================================
    Route::prefix('matieres')->name('matieres.')->controller(MatiereController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{matiere}/edit', 'edit')->name('edit');
        Route::put('{matiere}', 'update')->name('update');
        Route::delete('{matiere}', 'destroy')->name('destroy');
    });
    
    // ==========================================
    // ORGANISATION - CHAPITRES (LIÉS À CLASSE+MATIÈRE)
    // ==========================================
    Route::prefix('chapitres')->name('chapitres.')->controller(ChapitreController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{chapitre}', 'show')->name('show');
        Route::get('{chapitre}/edit', 'edit')->name('edit');
        Route::put('{chapitre}', 'update')->name('update');
        Route::delete('{chapitre}', 'destroy')->name('destroy');
        
        // Routes supplémentaires pour les chapitres
        Route::post('{chapitre}/toggle-status', 'toggleStatus')->name('toggle');
        Route::get('classe/{classe}/matiere/{matiere}', 'byClasseAndMatiere')->name('by.classe.matiere');
    });
    
    // ==========================================
    // ORGANISATION - CONTENUS (LIÉS AUX CHAPITRES)
    // ==========================================
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
    
    // ==========================================
    // ORGANISATION - TYPES D'ÉPREUVES (DEVOIR/INTERRO/EXAMEN)
    // ==========================================
    Route::prefix('types-epreuves')->name('types-epreuves.')->controller(TypeEpreuveController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{typeEpreuve}/edit', 'edit')->name('edit');
        Route::put('{typeEpreuve}', 'update')->name('update');
        Route::delete('{typeEpreuve}', 'destroy')->name('destroy');
        Route::post('{typeEpreuve}/toggle-status', 'toggleStatus')->name('toggle');
    });
    
    // ==========================================
    // BANQUE D'ÉPREUVES - GESTION COMPLÈTE
    // ==========================================
    
    // CRUD Épreuves (resource génère: index, create, store, show, edit, update, destroy)
    Route::resource('epreuves', EpreuveController::class)->parameters([
        'epreuves' => 'epreuve'
    ]);
    
    // Actions spécifiques sur une épreuve
    Route::prefix('epreuves/{epreuve}')->name('epreuves.')->group(function() {
        Route::post('toggle-status', [EpreuveController::class, 'toggleStatus'])->name('toggle');
        Route::post('duplicate', [EpreuveController::class, 'duplicate'])->name('duplicate');
        Route::get('download', [EpreuveController::class, 'download'])->name('download');
        Route::get('preview', [EpreuveController::class, 'preview'])->name('preview');
    });
    
    // Gestion des corrections d'épreuves
    Route::prefix('epreuves/{epreuve}/correction')->name('epreuves.correction.')->group(function() {
        Route::get('/', [EpreuveController::class, 'showCorrection'])->name('show');
        Route::post('/', [EpreuveController::class, 'storeCorrection'])->name('store');
        Route::put('/', [EpreuveController::class, 'updateCorrection'])->name('update');
        Route::delete('/', [EpreuveController::class, 'destroyCorrection'])->name('destroy');
    });
    
    // Liste globale des corrections
    Route::get('corrections', [EpreuveController::class, 'corrections'])->name('corrections');
    
    // Import/Export d'épreuves
    Route::get('epreuves/import', [EpreuveController::class, 'showImportForm'])->name('epreuves.import.form');
    Route::post('epreuves/import', [EpreuveController::class, 'import'])->name('epreuves.import');
    Route::get('epreuves/export', [EpreuveController::class, 'export'])->name('epreuves.export');
    
    // ==========================================
    // ÉVALUATIONS/QUIZ - GESTION
    // ==========================================
    
    // CRUD Quiz
    Route::resource('quiz', QuizController::class)->parameters([
        'quiz' => 'quiz'
    ]);
    
    // Gestion des questions des quiz
    Route::prefix('questions')->name('questions.')->controller(QuestionController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create/{quiz}', 'create')->name('create');
        Route::post('{quiz}', 'store')->name('store');
        Route::get('{question}/edit', 'edit')->name('edit');
        Route::put('{question}', 'update')->name('update');
        Route::delete('{question}', 'destroy')->name('destroy');
        Route::post('reorder', 'reorder')->name('reorder');
    });
    
    // Résultats des quiz (élèves)
    Route::get('resultats', [QuizController::class, 'resultats'])->name('resultats');
    Route::get('resultats/{resultat}', [QuizController::class, 'showResultat'])->name('resultats.show');
    Route::delete('resultats/{resultat}', [QuizController::class, 'destroyResultat'])->name('resultats.destroy');
    Route::get('resultats/export/{quiz}', [QuizController::class, 'exportResultats'])->name('resultats.export');
    
    // Toggle statut quiz (activer/désactiver)
    Route::post('quiz/{quiz}/toggle-status', [QuizController::class, 'toggleStatus'])->name('quiz.toggle');
    
    // Statistiques des quiz
    Route::get('quiz/{quiz}/statistiques', [QuizController::class, 'statistiques'])->name('quiz.statistiques');
    
    // ==========================================
    // ASSISTANCE PÉDAGOGIQUE - MODÉRATION
    // ==========================================
    Route::prefix('assistance')->name('assistance.')->controller(AssistanceController::class)->group(function() {
        
        // Questions des élèves
        Route::get('questions', 'questions')->name('questions');
        Route::get('questions/{question}', 'showQuestion')->name('questions.show');
        Route::post('questions/{question}/reply', 'reply')->name('questions.reply');
        Route::delete('questions/{question}', 'destroyQuestion')->name('questions.destroy');
        Route::post('questions/{question}/toggle-publish', 'togglePublish')->name('questions.toggle-publish');
        
        // Réponses (modération)
        Route::get('reponses', 'reponses')->name('reponses');
        Route::post('reponses/{reponse}/approve', 'approveReponse')->name('reponses.approve');
        Route::post('reponses/{reponse}/reject', 'rejectReponse')->name('reponses.reject');
        Route::delete('reponses/{reponse}', 'destroyReponse')->name('reponses.destroy');
        
        // Statistiques assistance
        Route::get('statistiques', 'statistiques')->name('statistiques');
        
        // Export des questions
        Route::get('export', 'export')->name('export');
    });
    
    // ==========================================
    // COMMUNICATION - CONTACTS & NEWSLETTER
    // ==========================================
    Route::prefix('contacts')->name('contacts.')->controller(ContactController::class)->group(function() {
        Route::get('/', 'indexAdmin')->name('index');
        Route::get('{contact}', 'showAdmin')->name('show');
        Route::delete('{contact}', 'destroyAdmin')->name('destroy');
        Route::post('{contact}/reply', 'replyAdmin')->name('reply');
        Route::post('bulk-actions', 'bulkActions')->name('bulk-actions');
        Route::get('export', 'export')->name('export');
    });
    
    Route::prefix('newsletter')->name('newsletter.')->controller(NewsletterController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('send', 'send')->name('send');
        Route::get('subscribers', 'subscribers')->name('subscribers');
        Route::delete('subscribers/{subscriber}', 'destroySubscriber')->name('subscribers.destroy');
        Route::post('subscribers/{subscriber}/toggle', 'toggleSubscriber')->name('subscribers.toggle');
        Route::get('export', 'export')->name('export');
        Route::post('import', 'import')->name('import');
    });
    
    // ==========================================
    // PARAMÈTRES DU SITE
    // ==========================================
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
    
    // ==========================================
    // STATISTIQUES ET RAPPORTS
    // ==========================================
    Route::get('statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
    Route::get('statistiques/globales', [DashboardController::class, 'statistiquesGlobales'])->name('statistiques.globales');
    Route::get('rapports/activite', [DashboardController::class, 'rapportActivite'])->name('rapports.activite');
    Route::get('rapports/utilisateurs', [DashboardController::class, 'rapportUtilisateurs'])->name('rapports.utilisateurs');
    Route::get('rapports/contenu', [DashboardController::class, 'rapportContenu'])->name('rapports.contenu');
    Route::get('rapports/telechargements', [DashboardController::class, 'rapportTelechargements'])->name('rapports.telechargements');
    Route::get('rapports/personnalise', [DashboardController::class, 'rapportPersonnalise'])->name('rapports.personnalise');
    
    // ==========================================
    // EXPORT DES DONNÉES
    // ==========================================
    Route::get('export/users', [DashboardController::class, 'exportUsers'])->name('export.users');
    Route::get('export/epreuves', [DashboardController::class, 'exportEpreuves'])->name('export.epreuves');
    Route::get('export/cours', [DashboardController::class, 'exportCours'])->name('export.cours');
    Route::get('export/resultats', [DashboardController::class, 'exportResultats'])->name('export.resultats');
    Route::get('export/assistance', [DashboardController::class, 'exportAssistance'])->name('export.assistance');
    
    // ==========================================
    // JOURNAUX D'ACTIVITÉ (LOGS)
    // ==========================================
    Route::get('logs', [DashboardController::class, 'logs'])->name('logs');
    Route::get('logs/clear', [DashboardController::class, 'clearLogs'])->name('logs.clear');
    Route::get('logs/{log}', [DashboardController::class, 'showLog'])->name('logs.show');
    Route::post('logs/export', [DashboardController::class, 'exportLogs'])->name('logs.export');
    
    // ==========================================
    // MAINTENANCE DU SITE
    // ==========================================
    Route::post('maintenance/enable', [DashboardController::class, 'enableMaintenance'])->name('maintenance.enable');
    Route::post('maintenance/disable', [DashboardController::class, 'disableMaintenance'])->name('maintenance.disable');
    Route::get('maintenance/status', [DashboardController::class, 'maintenanceStatus'])->name('maintenance.status');
    
    // ==========================================
    // CACHE
    // ==========================================
    Route::post('cache/clear', [DashboardController::class, 'clearCache'])->name('cache.clear');
    Route::post('cache/optimize', [DashboardController::class, 'optimizeCache'])->name('cache.optimize');
});

// ==========================================
// ROUTES API (POUR APPLICATION MOBILE OU AJAX)
// ==========================================
Route::prefix('api')->name('api.')->middleware(['auth:api'])->group(function() {
    
    // API Classes
    Route::get('classes', [ClasseController::class, 'apiIndex'])->name('classes');
    Route::get('classes/{classe}/matieres', [MatiereController::class, 'apiByClasse'])->name('classes.matieres');
    Route::get('classes/{classe}/details', [ClasseController::class, 'apiShow'])->name('classes.show');
    
    // API Matières
    Route::get('matieres', [MatiereController::class, 'apiIndex'])->name('matieres');
    Route::get('matieres/{matiere}/chapitres', [ChapitreController::class, 'apiByMatiere'])->name('matieres.chapitres');
    
    // API Chapitres et Contenus
    Route::get('chapitres', [ChapitreController::class, 'apiIndex'])->name('chapitres');
    Route::get('chapitres/{chapitre}', [ChapitreController::class, 'apiShow'])->name('chapitres.show');
    Route::get('chapitres/{chapitre}/contenus', [ContenuController::class, 'apiByChapitre'])->name('chapitres.contenus');
    
    // API Contenus
    Route::get('contenus', [ContenuController::class, 'apiIndex'])->name('contenus');
    Route::get('contenus/{contenu}', [ContenuController::class, 'apiShow'])->name('contenus.show');
    
    // API Épreuves
    Route::get('epreuves', [EpreuveController::class, 'apiIndex'])->name('epreuves');
    Route::get('epreuves/{epreuve}', [EpreuveController::class, 'apiShow'])->name('epreuves.show');
    Route::get('epreuves/{epreuve}/download', [EpreuveController::class, 'apiDownload'])->name('epreuves.download');
    
    // API Types d'épreuves
    Route::get('types-epreuves', [TypeEpreuveController::class, 'apiIndex'])->name('types-epreuves');
    
    // API Quiz
    Route::get('quiz', [QuizController::class, 'apiIndex'])->name('quiz');
    Route::get('quiz/{quiz}', [QuizController::class, 'apiShow'])->name('quiz.show');
    Route::get('quiz/{quiz}/questions', [QuizController::class, 'apiQuestions'])->name('quiz.questions');
    Route::post('quiz/{quiz}/submit', [QuizController::class, 'apiSubmit'])->name('quiz.submit');
    Route::get('quiz/{quiz}/resultats', [QuizController::class, 'apiResultats'])->name('quiz.resultats');
    
    // API Assistance
    Route::get('assistance/questions', [AssistanceController::class, 'apiQuestions'])->name('assistance.questions');
    Route::get('assistance/questions/{question}', [AssistanceController::class, 'apiShowQuestion'])->name('assistance.questions.show');
    Route::post('assistance/questions', [AssistanceController::class, 'apiStoreQuestion'])->name('assistance.store');
    Route::post('assistance/questions/{question}/repondre', [AssistanceController::class, 'apiReply'])->name('assistance.reply');
    
    // API Recherche
    Route::get('search', [FrontendController::class, 'apiSearch'])->name('search');
    
    // API Utilisateur (authentifié)
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
// ROUTES API PUBLIQUES (SANS AUTH)
// ==========================================
Route::prefix('api/public')->name('api.public.')->group(function() {
    
    // Stats publiques
    Route::get('stats', [FrontendController::class, 'apiStats'])->name('stats');
    
    // Recherche publique
    Route::get('search', [FrontendController::class, 'apiPublicSearch'])->name('search');
    
    // Classes et matières publiques
    Route::get('classes', [ClasseController::class, 'apiPublicIndex'])->name('classes');
    Route::get('matieres', [MatiereController::class, 'apiPublicIndex'])->name('matieres');
    
    // Newsletter (publique)
    Route::post('newsletter/subscribe', [ContactController::class, 'apiNewsletterSubscribe'])->name('newsletter.subscribe');
    
    // Contact (publique)
    Route::post('contact', [ContactController::class, 'apiStore'])->name('contact');
});

// ==========================================
// REDIRECTIONS ET RACCOURCIS
// ==========================================

// Redirection vers les classes pour les anciennes URLs
Route::get('college', function() {
    return redirect()->route('classes');
})->name('college');

Route::get('lycee', function() {
    return redirect()->route('classes');
})->name('lycee');

// Redirection vers la recherche
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