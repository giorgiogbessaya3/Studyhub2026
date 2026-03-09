<!-- contenus.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ request('matiere') }} - {{ request('classe') }} - StudyHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 pb-20">

    <header class="bg-blue-600 text-white sticky top-0 z-50">
        <div class="flex items-center px-4 py-3 gap-3">
            <a href="/matieres?classe={{ request('classe') }}&type={{ request('type') }}" class="p-2 -ml-2 hover:bg-blue-700 rounded-full transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex-1 min-w-0">
                <h1 class="font-bold text-lg truncate">{{ ucfirst(request('matiere')) }}</h1>
                <p class="text-blue-200 text-xs">{{ request('classe') }}</p>
            </div>
        </div>
    </header>

    <main class="max-w-md mx-auto">
        
        <!-- Tabs -->
        <div class="bg-white border-b border-gray-200 sticky top-14 z-40">
            <div class="flex">
                <button class="flex-1 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                    @if(request('type') == 'cours') Chapitres @else Épreuves @endif
                </button>
                <button class="flex-1 py-3 text-sm font-medium text-gray-500">
                    @if(request('type') == 'cours') Résumés @else Corrigés @endif
                </button>
            </div>
        </div>

        <div class="px-4 py-4 space-y-3">
            
            <!-- Si COURS -->
            @if(request('type') == 'cours')
                <!-- Chapitre 1 -->
                <a href="/chapitre/1" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="font-bold text-blue-600 text-sm">01</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-1">Suites numériques</h3>
                            <p class="text-xs text-gray-500 mb-2">Définitions, limites, raisonnement par récurrence</p>
                            <div class="flex gap-2 text-xs">
                                <span class="bg-gray-100 px-2 py-1 rounded text-gray-600">
                                    <i class="fas fa-book mr-1"></i>Cours
                                </span>
                                <span class="bg-gray-100 px-2 py-1 rounded text-gray-600">
                                    <i class="fas fa-pencil-alt mr-1"></i>Exos
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 mt-1"></i>
                    </div>
                </a>

                <!-- Chapitre 2 -->
                <a href="/chapitre/2" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="font-bold text-blue-600 text-sm">02</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-1">Fonctions dérivables</h3>
                            <p class="text-xs text-gray-500 mb-2">Dérivée, variations, extremums</p>
                            <div class="flex gap-2 text-xs">
                                <span class="bg-gray-100 px-2 py-1 rounded text-gray-600">
                                    <i class="fas fa-book mr-1"></i>Cours
                                </span>
                                <span class="bg-gray-100 px-2 py-1 rounded text-gray-600">
                                    <i class="fas fa-video mr-1"></i>Vidéo
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 mt-1"></i>
                    </div>
                </a>

            @else
                <!-- Si ÉPREUVES -->
                
                <!-- Filtres -->
                <div class="flex gap-2 overflow-x-auto hide-scrollbar pb-2">
                    <button class="bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap">Tous</button>
                    <button class="bg-white text-gray-600 px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-gray-200">Devoirs</button>
                    <button class="bg-white text-gray-600 px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-gray-200">Interros</button>
                    <button class="bg-white text-gray-600 px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-gray-200">Examens blancs</button>
                </div>

                <!-- Épreuve 1 -->
                <a href="/epreuve/1" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-2">
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-medium">Examen blanc</span>
                        <span class="text-xs text-gray-400">Jan 2024</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">DS Mathématiques - Suites et dérivation</h3>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span><i class="fas fa-clock mr-1"></i>2h</span>
                        <span><i class="fas fa-star mr-1"></i>20 points</span>
                        <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Corrigé</span>
                    </div>
                </a>

                <!-- Épreuve 2 -->
                <a href="/epreuve/2" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-2">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-medium">Devoir</span>
                        <span class="text-xs text-gray-400">Déc 2023</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Interrogation - Limites de suites</h3>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span><i class="fas fa-clock mr-1"></i>30min</span>
                        <span><i class="fas fa-star mr-1"></i>10 points</span>
                        <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Corrigé</span>
                    </div>
                </a>

            @endif

        </div>

    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 safe-area-bottom z-50">
        <div class="flex justify-around items-center h-16 max-w-md mx-auto">
            <a href="/" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs">Accueil</span>
            </a>
            <a href="/classes?type=cours" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-book text-lg"></i>
                <span class="text-xs">Cours</span>
            </a>
            <a href="/classes?type=epreuves" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-file-alt text-lg"></i>
                <span class="text-xs">Épreuves</span>
            </a>
            <a href="/assistance" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-question-circle text-lg"></i>
                <span class="text-xs">Aide</span>
            </a>
            <a href="/profil" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-user text-lg"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>

</body>
</html>