<!-- matieres.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Matières - {{ request('classe') }} - StudyHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 pb-20">

    <header class="bg-blue-600 text-white sticky top-0 z-50">
        <div class="flex items-center px-4 py-3 gap-3">
            <a href="/classes?type={{ request('type') }}" class="p-2 -ml-2 hover:bg-blue-700 rounded-full transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="font-bold text-lg">Matières</h1>
                <p class="text-blue-200 text-xs">{{ request('classe') }} • {{ request('type') }}</p>
            </div>
        </div>
    </header>

    <main class="px-4 py-6 max-w-md mx-auto">
        
        <!-- Filière Techno (si Terminale) -->
        @if(request('classe') == 'terminale' || request('classe') == 'premiere')
        <div class="mb-4 flex gap-2 overflow-x-auto hide-scrollbar pb-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap">Générale</button>
            <button class="bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200">STI2D</button>
            <button class="bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200">STMG</button>
            <button class="bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200">STL</button>
        </div>
        @endif

        <div class="space-y-2">
            <!-- Mathématiques -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=mathematiques&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-square-root-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Mathématiques</span>
                        <span class="text-xs text-gray-500">12 chapitres • 45 épreuves</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- Physique-Chimie -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=physique-chimie&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-atom text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Physique-Chimie</span>
                        <span class="text-xs text-gray-500">8 chapitres • 32 épreuves</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- SVT -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=svt&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-leaf text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">SVT</span>
                        <span class="text-xs text-gray-500">6 chapitres • 28 épreuves</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- Français -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=francais&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book-open text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Français</span>
                        <span class="text-xs text-gray-500">Littérature • Méthodologie</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- Histoire-Géo -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=histoire-geo&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-globe-europe text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Histoire-Géographie</span>
                        <span class="text-xs text-gray-500">Histoire • Géographie • EMC</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- Anglais -->
            <a href="/contenus?classe={{ request('classe') }}&matiere=anglais&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-language text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Anglais</span>
                        <span class="text-xs text-gray-500">Compréhension • Expression</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>

            <!-- Philosophie (si Terminale) -->
            @if(request('classe') == 'terminale')
            <a href="/contenus?classe=terminale&matiere=philosophie&type={{ request('type') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between active:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-brain text-slate-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800 block">Philosophie</span>
                        <span class="text-xs text-gray-500">Notions • Méthodologie</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
            @endif
        </div>

    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 safe-area-bottom z-50">
        <!-- ... -->
    </nav>

</body>
</html>