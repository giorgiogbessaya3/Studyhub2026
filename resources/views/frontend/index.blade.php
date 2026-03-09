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
                <img src="https://illustrations.popsy.co/amber/student-reading.svg" 
                     alt="Student" 
                     class="w-full max-w-md mx-auto">
            </div>
        </div>
    </div>
</section>

<!-- SERVICES CARDS - Style section 3 (cours par classe) -->
<section class="py-16 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-primary-600 text-sm uppercase tracking-wider font-semibold">Nos services</span>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $services = [
                    ['nom' => 'Cours en ligne', 'icone' => 'fas fa-book-open', 'couleur' => '#3b82f6', 'description' => 'Des cours complets et structurés par chapitre avec résumés, illustrations et exercices corrigés.', 'lien' => '/cours'],
                    ['nom' => 'Banque d\'épreuves', 'icone' => 'fas fa-file-alt', 'couleur' => '#10b981', 'description' => 'Des milliers de devoirs, interrogations et examens blancs avec leurs corrigés détaillés.', 'lien' => '/epreuves'],
                    ['nom' => 'Assistance', 'icone' => 'fas fa-question-circle', 'couleur' => '#8b5cf6', 'description' => 'Bloqué sur un exercice ? Posez vos questions et recevez de l\'aide.', 'lien' => '/assistance']
                ];
            @endphp
            
            @foreach($services as $service)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                <!-- En-tête avec icône et couleur -->
                <div class="relative h-32 bg-gradient-to-r from-gray-100 to-gray-200 overflow-hidden">
                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, {{ $service['couleur'] }} 1px, transparent 0); background-size: 20px 20px;"></div>
                    
                    <!-- Cercle de couleur -->
                    <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full" 
                         style="background-color: {{ $service['couleur'] }}; opacity: 0.2;"></div>
                    
                    <!-- Icône principale -->
                    <div class="absolute left-4 bottom-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform" 
                             style="background-color: {{ $service['couleur'] }};">
                            <i class="{{ $service['icone'] }} text-white text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $service['nom'] }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $service['description'] }}</p>
                    
                    <a href="{{ $service['lien'] }}" 
                       class="inline-flex items-center text-sm font-medium transition-all group-hover:gap-2"
                       style="color: {{ $service['couleur'] }};">
                        <span>Explorer</span>
                        <i class="fas fa-arrow-right text-xs ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CLASSES NIVEAUX - Style section 3 (cours par classe) -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Choisissez votre niveau</h2>
            <a href="/cours" class="text-primary-600 text-sm font-medium hover:underline">Voir tout</a>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($quickClasses as $classe)
            <a href="/cours/classe/{{ $classe->nom }}" 
               class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $classe->nom }}</h3>
                        <p class="text-xs text-gray-500">{{ $classe->matieres_count ?? 8 }} matières</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-sm group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- DERNIERS CONTENUS - Style section 4 (matière) -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Derniers contenus</h2>
            <div class="flex gap-2">
                <a href="/epreuves" class="bg-primary-600 text-white px-4 py-1.5 rounded-full text-xs font-medium">Épreuves</a>
                <a href="/cours" class="bg-white text-gray-600 px-4 py-1.5 rounded-full text-xs font-medium border">Cours</a>
            </div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recentEpreuves as $epreuve)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs px-2 py-1 rounded-full bg-primary-50 text-primary-600 font-medium">
                            {{ $epreuve->matiere->nom ?? 'Mathématiques' }}
                        </span>
                        <span class="text-xs text-gray-400">•</span>
                        <span class="text-xs text-gray-500">2h</span>
                    </div>
                    
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $epreuve->titre }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($epreuve->description ?? 'Épreuve avec corrigé disponible', 70) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="fas fa-download"></i> 234 téléchargements
                        </span>
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
                           class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                            Voir <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
                @foreach([
                    ['titre' => 'Devoir commun de Mathématiques', 'matiere' => 'Mathématiques', 'couleur' => '#ef4444'],
                    ['titre' => 'Composition de Physique-Chimie', 'matiere' => 'Physique-Chimie', 'couleur' => '#3b82f6'],
                    ['titre' => 'Dissertation de Français', 'matiere' => 'Français', 'couleur' => '#8b5cf6']
                ] as $default)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs px-2 py-1 rounded-full" 
                                  style="background-color: {{ $default['couleur'] }}20; color: {{ $default['couleur'] }};">
                                {{ $default['matiere'] }}
                            </span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500">2h</span>
                        </div>
                        
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $default['titre'] }}</h3>
                        <p class="text-sm text-gray-600 mb-4">Épreuve avec corrigé disponible en téléchargement</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-download"></i> 234 téléchargements
                            </span>
                            <a href="/epreuves" 
                               class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                                Voir <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforelse
        </div>
        
        <div class="text-center mt-10">
            <a href="/epreuves" 
               class="inline-flex items-center gap-2 bg-primary-600 text-white px-6 py-2.5 rounded-full text-sm font-medium hover:bg-primary-700 transition shadow-sm">
                Voir toutes les épreuves
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endsection

<style>
.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}
</style>