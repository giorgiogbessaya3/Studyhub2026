<!-- assistance.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Assistance - StudyHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 pb-20">

    <header class="bg-purple-600 text-white sticky top-0 z-50">
        <div class="flex items-center justify-between px-4 py-3">
            <h1 class="font-bold text-lg">Assistance</h1>
            <button class="p-2 hover:bg-purple-700 rounded-full transition">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </header>

    <main class="px-4 py-6 max-w-md mx-auto">
        
        <!-- Nouvelle question -->
        <div class="bg-purple-50 rounded-2xl p-4 mb-6 border border-purple-100">
            <h2 class="font-bold text-purple-900 mb-2">Vous bloquez sur un exercice ?</h2>
            <p class="text-sm text-purple-700 mb-3">Posez votre question et recevez de l'aide rapidement</p>
            <button class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-purple-700 transition">
                <i class="fas fa-camera mr-2"></i>Poser une question
            </button>
        </div>

        <!-- Filtres -->
        <div class="flex gap-2 mb-4 overflow-x-auto hide-scrollbar">
            <button class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap">Toutes</button>
            <button class="bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200">Sans réponse</button>
            <button class="bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200">Mes questions</button>
        </div>

        <!-- Liste des questions -->
        <div class="space-y-3">
            
            <!-- Question 1 -->
            <a href="/question/1" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <img src="https://ui-avatars.com/api/?name=Alex+M&background=random" class="w-10 h-10 rounded-full flex-shrink-0">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-gray-800 text-sm">Alex M.</span>
                            <span class="text-xs text-gray-400">• 2h</span>
                        </div>
                        <h3 class="font-medium text-gray-800 mb-2 text-sm">Problème avec l'exercice 3 du DM de maths</h3>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">Maths</span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">Terminale</span>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-comment mr-1"></i>3 réponses</span>
                            <span class="text-green-600"><i class="fas fa-check mr-1"></i>Résolu</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Question 2 -->
            <a href="/question/2" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <img src="https://ui-avatars.com/api/?name=Sarah+L&background=random" class="w-10 h-10 rounded-full flex-shrink-0">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-gray-800 text-sm">Sarah L.</span>
                            <span class="text-xs text-gray-400">• 5h</span>
                        </div>
                        <h3 class="font-medium text-gray-800 mb-2 text-sm">Besoin d'aide sur la photosynthèse</h3>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded">SVT</span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">1ère</span>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-comment mr-1"></i>0 réponse</span>
                            <span class="text-orange-600"><i class="fas fa-clock mr-1"></i>En attente</span>
                        </div>
                    </div>
                </div>
            </a>

        </div>

    </main>

    <!-- Bottom Nav (Assistance active) -->
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
            <a href="/assistance" class="flex flex-col items-center justify-center w-full h-full gap-1 text-purple-600">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-question-circle text-lg"></i>
                </div>
                <span class="text-xs font-medium">Aide</span>
            </a>
            <a href="/profil" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400">
                <i class="fas fa-user text-lg"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>

</body>
</html>