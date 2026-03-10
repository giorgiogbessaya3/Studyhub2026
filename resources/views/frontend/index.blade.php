{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.app')

@section('title', 'StudyHub - Votre plateforme d\'apprentissage')

@section('content')
<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 py-20 overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Texte -->
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                    Apprenez, Révisez,<br>
                    <span class="text-primary-300">Réussissez</span>
                </h1>
                
                <p class="text-slate-300 text-lg mb-8 max-w-xl mx-auto lg:mx-0">
                    Accédez à des cours, exercices et examens corrigés pour réussir votre année scolaire.
                </p>
                
                <!-- Search bar -->
                <form action="/search" method="GET" 
                      class="flex items-center bg-white rounded-xl shadow-lg p-1.5 max-w-lg mx-auto lg:mx-0">
                    <i class="fas fa-search text-slate-400 ml-3"></i>
                    <input type="text" 
                           name="q" 
                           placeholder="Rechercher une matière..." 
                           class="flex-1 px-3 py-2 text-slate-700 focus:outline-none text-sm">
                    <button class="bg-primary-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-primary-700 transition">
                        Rechercher
                    </button>
                </form>
            </div>
            
            <!-- Image -->
            <div class="hidden lg:block flex-1">
                <img src="img/car1.png" 
                     alt="Student" 
                     class="w-full max-w-md mx-auto">
            </div>
        </div>
    </div>
</section>

<!-- SECTION 2 - SERVICES CARDS (INCHANGÉE) -->
<section class="py-16 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-5">
            <span class="text-primary-600 text-sm uppercase tracking-wider font-semibold">Nos Services</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6 perspective">
            <!-- COURS CARD -->
            <div class="group bg-white rounded-2xl p-8 border border-blue-100 hover:border-blue-300 shadow-lg hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 hover:-translate-y-2 hover:rotate-1 transform-3d">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-book-open text-white text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Cours en ligne</h3>
                <p class="text-slate-600 mb-6">Des cours complets et structurés par chapitre avec résumés, illustrations et exercices corrigés.</p>
                <a href="/cours" class="inline-flex items-center text-blue-600 font-medium group-hover:gap-3 transition-all">
                    <span>Explorer les cours</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- EPREUVES CARD -->
            <div class="group bg-white rounded-2xl p-8 border border-green-100 hover:border-green-300 shadow-lg hover:shadow-2xl hover:shadow-green-500/20 transition-all duration-500 hover:-translate-y-2 hover:rotate-1 transform-3d">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-file-alt text-white text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Banque d'épreuves</h3>
                <p class="text-slate-600 mb-6">Des milliers de devoirs, interrogations et examens blancs avec leurs corrigés détaillés.</p>
                <a href="/epreuves" class="inline-flex items-center text-green-600 font-medium group-hover:gap-3 transition-all">
                    <span>Explorer les épreuves</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- ASSISTANCE CARD -->
            <div class="group bg-white rounded-2xl p-8 border border-purple-100 hover:border-purple-300 shadow-lg hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:-translate-y-2 hover:rotate-1 transform-3d">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-question-circle text-white text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Assistance</h3>
                <p class="text-slate-600 mb-6">Bloqué sur un exercice ? Posez vos questions et recevez de l'aide de professeurs et d'autres élèves.</p>
                <a href="/assistance" class="inline-flex items-center text-purple-600 font-medium group-hover:gap-3 transition-all">
                    <span>Poser une question</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 3 - CLASSES (STYLE PAGE CLASSE) -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Choisissez votre niveau</h2>
            <a href="/cours" class="text-primary-600 text-sm font-medium hover:underline">Voir tout</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($quickClasses as $classe)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                <!-- En-tête avec dégradé -->
                <div class="relative h-32 bg-gradient-to-r from-primary-500 to-primary-600 overflow-hidden">
                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                    </div>
                    
                    <!-- Icône et titre dans l'en-tête -->
                    <div class="absolute left-4 bottom-4 flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">{{ $classe->nom }}</h3>
                            <p class="text-xs text-white/80">{{ $classe->matieres_count ?? 8 }} matières</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        Accédez à tous les cours et exercices pour la classe de {{ $classe->nom }}.
                    </p>
                    
                    <!-- Statistiques rapides -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-book-open text-primary-500"></i>
                            <span>{{ rand(8, 12) }} matières</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-file-alt text-primary-500"></i>
                            <span>{{ rand(40, 80) }} contenus</span>
                        </div>
                    </div>
                    
                    <!-- Bouton d'action -->
                    <a href="/cours/classe/{{ $classe->nom }}" 
                       class="block w-full py-2.5 text-center rounded-xl font-medium transition-all border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white">
                        Explorer la classe
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



@endsection

<style>
.perspective {
    perspective: 1000px;
}
.transform-3d {
    transform-style: preserve-3d;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}
.hover\:-translate-y-2:hover {
    transform: translateY(-0.5rem);
}
</style>