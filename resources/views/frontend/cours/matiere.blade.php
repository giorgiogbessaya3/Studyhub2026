@extends('layouts.app')

@section('title', $matiere->nom . ' - ' . $classe->nom . ' - StudyHub')

@section('content')
<!-- Hero Section avec la couleur de la matière -->
<section class="relative py-16 overflow-hidden" 
         style="background: linear-gradient(135deg, {{ $matiere->couleur ?? '#3b82f6' }} 0%, {{ $matiere->couleur ?? '#3b82f6' }}dd 100%);">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Fil d'Ariane -->
        <nav class="mb-6 text-sm text-white/80">
            <ol class="flex items-center flex-wrap gap-1">
                <li><a href="/" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-xs"></i> Accueil
                </a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/cours" class="hover:text-white transition-colors">Cours</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/cours/classe/{{ $classe->nom }}" class="hover:text-white transition-colors">{{ $classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium">{{ $matiere->nom }}</li>
            </ol>
        </nav>
        
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur rounded-full px-4 py-2 mb-6">
                    <i class="{{ $matiere->icone ?? 'fas fa-book' }} text-sm"></i>
                    <span class="text-sm font-medium">{{ $classe->nom }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $matiere->nom }}</h1>
                
                @if($matiere->description)
                    <p class="text-lg text-white/90 max-w-2xl leading-relaxed">
                        {{ $matiere->description }}
                    </p>
                @endif
            </div>
            
            <!-- Stats Card -->
            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/20 min-w-[250px]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/60 text-xs">Aperçu</p>
                        <p class="text-white font-semibold">{{ $classe->nom }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-white">
                        <span class="text-sm">Chapitres</span>
                        <span class="font-bold text-xl">{{ $chapitres->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-white">
                        <span class="text-sm">Contenus</span>
                        <span class="font-bold text-xl">{{ $chapitres->sum('contenus_count') }}</span>
                    </div>
                    
                    @if($chapitres->count() > 0)
                    <div class="pt-2">
                        <div class="flex justify-between text-xs text-white/80 mb-1">
                            <span>Progression</span>
                            <span>{{ rand(0, 100) }}%</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-1.5">
                            <div class="bg-white h-1.5 rounded-full" style="width: {{ rand(0, 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
            <path d="M0 120L60 112.5C120 105 240 90 360 82.5C480 75 600 75 720 78.75C840 82.5 960 90 1080 93.75C1200 97.5 1320 97.5 1380 97.5L1440 97.5V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.2"/>
        </svg>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">
    
    <!-- En-tête de section avec stats -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list" style="color: {{ $matiere->couleur ?? '#3b82f6' }};"></i>
                Chapitres disponibles
            </h2>
            <p class="text-gray-500 mt-1">
                {{ $chapitres->count() }} chapitres · {{ $chapitres->sum('contenus_count') }} contenus au total
            </p>
        </div>
        
        <!-- Options de tri -->
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
                <i class="fas fa-sort-amount-down"></i>
                Trier
            </button>
            <button class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
                <i class="fas fa-expand"></i>
                Tout développer
            </button>
        </div>
    </div>
    
    @if($chapitres->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book-open text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun chapitre disponible</h3>
            <p class="text-gray-500 max-w-md mx-auto">
                Les chapitres pour cette matière seront bientôt disponibles. Revenez plus tard !
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($chapitres as $index => $chapitre)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                <!-- En-tête du chapitre (cliquable) -->
                <div class="p-6 cursor-pointer hover:bg-gray-50 transition-colors" 
                     onclick="toggleChapitre({{ $chapitre->id }})">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <!-- Numéro de chapitre avec la couleur de la matière -->
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white"
                                     style="background: linear-gradient(135deg, {{ $matiere->couleur ?? '#3b82f6' }} 0%, {{ $matiere->couleur ?? '#3b82f6' }}dd 100%);">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $chapitre->titre }}</h3>
                                    @if($chapitre->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $chapitre->description }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Métadonnées -->
                            <div class="flex flex-wrap items-center gap-4 ml-14">
                                <span class="flex items-center gap-1 text-xs px-2 py-1 rounded-full"
                                      style="background-color: {{ $matiere->couleur ?? '#3b82f6' }}20; color: {{ $matiere->couleur ?? '#3b82f6' }};">
                                    <i class="fas fa-file-alt text-xs"></i>
                                    {{ $chapitre->contenus_count }} contenus
                                </span>
                                <span class="flex items-center gap-1 text-xs text-gray-500">
                                    <i class="fas fa-clock"></i>
                                    {{ rand(30, 120) }} min
                                </span>
                                @if($chapitre->contenus_count > 0)
                                <span class="flex items-center gap-1 text-xs text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                    {{ rand(0, $chapitre->contenus_count) }}/{{ $chapitre->contenus_count }} complété
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Chevron avec animation -->
                        <div class="flex items-center gap-3">
                            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1.5 rounded-full">
                                {{ $chapitre->contenus_count }} contenu(s)
                            </span>
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" 
                                   id="chevron-{{ $chapitre->id }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contenu détaillé du chapitre -->
                <div id="chapitre-{{ $chapitre->id }}" 
                     class="border-t border-gray-100 bg-gray-50 p-6 {{ $index === 0 ? '' : 'hidden' }}">
                    
                    @if($chapitre->contenus_count > 0)
                        <!-- Grille d'aperçu des contenus -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-sm transition-shadow">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                         style="background-color: {{ $matiere->couleur ?? '#3b82f6' }}20;">
                                        <i class="fas fa-video" style="color: {{ $matiere->couleur ?? '#3b82f6' }};"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-700">Cours vidéo</h4>
                                </div>
                                <p class="text-sm text-gray-500 ml-11">{{ rand(3, 8) }} vidéos · {{ rand(45, 120) }} min</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-sm transition-shadow">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                         style="background-color: {{ $matiere->couleur ?? '#3b82f6' }}20;">
                                        <i class="fas fa-pencil-alt" style="color: {{ $matiere->couleur ?? '#3b82f6' }};"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-700">Exercices</h4>
                                </div>
                                <p class="text-sm text-gray-500 ml-11">{{ rand(5, 15) }} exercices avec corrigés</p>
                            </div>
                        </div>
                        
                        <!-- Barre de progression du chapitre -->
                        @php $progression = rand(0, 100); @endphp
                        <div class="mb-6">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500">Progression du chapitre</span>
                                <span class="font-medium" style="color: {{ $matiere->couleur ?? '#3b82f6' }};">{{ $progression }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all" 
                                     style="width: {{ $progression }}%; background-color: {{ $matiere->couleur ?? '#3b82f6' }};"></div>
                            </div>
                        </div>
                        
                        <!-- Bouton d'accès -->
                        <a href="/cours/chapitre/{{ $chapitre->slug }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium transition-all group"
                           style="color: {{ $matiere->couleur ?? '#3b82f6' }}; border: 2px solid {{ $matiere->couleur ?? '#3b82f6' }};"
                           onmouseover="this.style.backgroundColor='{{ $matiere->couleur ?? '#3b82f6' }}'; this.style.color='white';"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='{{ $matiere->couleur ?? '#3b82f6' }}';">
                            <span>Accéder au chapitre complet</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-hourglass-half text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">Les contenus de ce chapitre sont en cours de préparation.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Navigation entre les chapitres -->
        <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                Affichage de <span class="font-medium">{{ $chapitres->count() }}</span> chapitres
            </p>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button class="w-10 h-10 rounded-lg bg-primary-600 text-white flex items-center justify-center hover:bg-primary-700 transition-colors">
                    1
                </button>
                <button class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    2
                </button>
                <button class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    3
                </button>
                <button class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <!-- Section "Vous pourriez aussi aimer" -->
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-lightbulb text-yellow-500"></i>
                Vous pourriez aussi aimer
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $autresMatieres = $classe->matieres()
                        ->where('matieres.id', '!=', $matiere->id)
                        ->where('matieres.statut', true)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
                @endphp
                
                @forelse($autresMatieres as $autreMatiere)
                <a href="/cours/classe/{{ $classe->nom }}/matiere/{{ $autreMatiere->nom }}" 
                   class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                             style="background-color: {{ $autreMatiere->couleur ?? '#3b82f6' }}20;">
                            <i class="{{ $autreMatiere->icone ?? 'fas fa-book' }}" 
                               style="color: {{ $autreMatiere->couleur ?? '#3b82f6' }};"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $autreMatiere->nom }}</h3>
                            <p class="text-xs text-gray-500">{{ $classe->nom }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                        {{ $autreMatiere->description ?? 'Explorez les chapitres de cette matière' }}
                    </p>
                    <span class="text-sm font-medium" style="color: {{ $autreMatiere->couleur ?? '#3b82f6' }};">
                        Découvrir <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </a>
                @empty
                    @foreach([
                        ['nom' => 'Mathématiques', 'icone' => 'fas fa-calculator', 'couleur' => '#ef4444'],
                        ['nom' => 'Physique-Chimie', 'icone' => 'fas fa-flask', 'couleur' => '#3b82f6'],
                        ['nom' => 'SVT', 'icone' => 'fas fa-leaf', 'couleur' => '#10b981']
                    ] as $suggestion)
                    <a href="/cours/classe/{{ $classe->nom }}/matiere/{{ $suggestion['nom'] }}" 
                       class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all group">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                 style="background-color: {{ $suggestion['couleur'] }}20;">
                                <i class="{{ $suggestion['icone'] }}" style="color: {{ $suggestion['couleur'] }};"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $suggestion['nom'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $classe->nom }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Explorez les chapitres de cette matière</p>
                        <span class="text-sm font-medium text-primary-600">
                            Découvrir <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                    @endforeach
                @endforelse
            </div>
        </section>
    @endif
</div>

<script>
function toggleChapitre(id) {
    const content = document.getElementById('chapitre-' + id);
    const chevron = document.getElementById('chevron-' + id);
    
    content.classList.toggle('hidden');
    
    if (content.classList.contains('hidden')) {
        chevron.style.transform = 'rotate(0deg)';
    } else {
        chevron.style.transform = 'rotate(180deg)';
    }
}

// Initialiser les chevrons
document.addEventListener('DOMContentLoaded', function() {
    @foreach($chapitres as $index => $chapitre)
        const chevron{{ $chapitre->id }} = document.getElementById('chevron-{{ $chapitre->id }}');
        if (chevron{{ $chapitre->id }}) {
            chevron{{ $chapitre->id }}.style.transform = 'rotate({{ $index === 0 ? '180deg' : '0deg' }})';
        }
    @endforeach
});

// Animation smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

<style>
.hidden {
    display: none;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection