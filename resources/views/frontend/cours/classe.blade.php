@extends('layouts.app')

@section('title', 'Cours ' . $classe->nom . ' - StudyHub')

@section('content')
<!-- Hero Section avec la couleur de la classe -->
@php
    $classeColors = [
        '6ème' => ['bg' => 'from-blue-500 to-blue-600', 'icon' => 'fa-child', 'light' => 'bg-blue-50'],
        '5ème' => ['bg' => 'from-green-500 to-green-600', 'icon' => 'fa-child', 'light' => 'bg-green-50'],
        '4ème' => ['bg' => 'from-yellow-500 to-yellow-600', 'icon' => 'fa-child', 'light' => 'bg-yellow-50'],
        '3ème' => ['bg' => 'from-orange-500 to-orange-600', 'icon' => 'fa-child', 'light' => 'bg-orange-50'],
        'Seconde' => ['bg' => 'from-purple-500 to-purple-600', 'icon' => 'fa-graduation-cap', 'light' => 'bg-purple-50'],
        'Première' => ['bg' => 'from-indigo-500 to-indigo-600', 'icon' => 'fa-graduation-cap', 'light' => 'bg-indigo-50'],
        'Terminale' => ['bg' => 'from-pink-500 to-pink-600', 'icon' => 'fa-graduation-cap', 'light' => 'bg-pink-50'],
    ];
    $classeColor = $classeColors[$classe->nom] ?? ['bg' => 'from-primary-500 to-primary-600', 'icon' => 'fa-school', 'light' => 'bg-primary-50'];
@endphp

<!-- Hero Section -->
<section class="relative bg-gradient-to-r {{ $classeColor['bg'] }} text-white py-16 overflow-hidden">
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
                <li class="text-white font-medium">{{ $classe->nom }}</li>
            </ol>
        </nav>
        
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur rounded-full px-4 py-2 mb-6">
                    <i class="fas {{ $classeColor['icon'] }} text-sm"></i>
                    <span class="text-sm font-medium">{{ in_array($classe->nom, ['6ème', '5ème', '4ème', '3ème']) ? 'Collège' : 'Lycée' }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">{{ $classe->nom }}</h1>
                
                @if($classe->description)
                    <p class="text-lg text-white/90 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        {{ $classe->description }}
                    </p>
                @else
                    <p class="text-lg text-white/90 max-w-2xl mx-auto md:mx-0">
                        Découvrez toutes les matières et ressources disponibles pour la classe de {{ $classe->nom }}.
                    </p>
                @endif
                
                <!-- Stats rapides -->
                <div class="flex flex-wrap gap-6 mt-8 justify-center md:justify-start">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $matieres->count() }}</div>
                        <div class="text-sm text-white/80">Matières</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $matieres->sum('chapitres_count') }}</div>
                        <div class="text-sm text-white/80">Chapitres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $matieres->sum('contenus_count') }}</div>
                        <div class="text-sm text-white/80">Contenus</div>
                    </div>
                </div>
            </div>
            
            <!-- Illustration -->
            <div class="hidden lg:block w-80">
                <img src="https://illustrations.popsy.co/{{ in_array($classe->nom, ['6ème', '5ème', '4ème', '3ème']) ? 'amber' : 'sky' }}/student-reading.svg" 
                     alt="Illustration" class="w-full drop-shadow-2xl">
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
    
    <!-- Section des matières -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-book-open text-primary-500"></i>
                    Matières disponibles
                </h2>
                <p class="text-gray-500 mt-1">
                    {{ $matieres->count() }} matières · {{ $matieres->sum('chapitres_count') }} chapitres · {{ $matieres->sum('contenus_count') }} contenus
                </p>
            </div>
            
            <!-- Filtres rapides -->
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-primary-50 text-primary-600 rounded-lg text-sm font-medium hover:bg-primary-100 transition-colors flex items-center gap-2">
                    <i class="fas fa-sort-amount-down"></i>
                    Trier
                </button>
                <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Filtrer
                </button>
            </div>
        </div>
        
        @if($matieres->isEmpty())
            <div class="text-center py-16 bg-gray-50 rounded-2xl">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-book-open text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune matière disponible</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Les matières pour cette classe seront bientôt disponibles. Revenez plus tard !
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($matieres as $index => $matiere)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                    <!-- En-tête avec icône et couleur -->
                    <div class="relative h-32 bg-gradient-to-r from-gray-100 to-gray-200 overflow-hidden">
                        <!-- Pattern de fond -->
                        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, {{ $matiere->couleur ?? '#3b82f6' }} 1px, transparent 0); background-size: 20px 20px;"></div>
                        
                        <!-- Cercle de couleur -->
                        <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full" 
                             style="background-color: {{ $matiere->couleur ?? '#3b82f6' }}; opacity: 0.2;"></div>
                        
                        <!-- Icône principale -->
                        <div class="absolute left-4 bottom-4 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform" 
                                 style="background-color: {{ $matiere->couleur ?? '#3b82f6' }};">
                                <i class="{{ $matiere->icone ?? 'fas fa-book' }} text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $matiere->nom }}</h3>
                                @if($matiere->code)
                                    <p class="text-xs text-gray-500">{{ $matiere->code }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Description -->
                        @if($matiere->description)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $matiere->description }}
                            </p>
                        @endif
                        
                        <!-- Statistiques -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-layer-group" style="color: {{ $matiere->couleur ?? '#3b82f6' }};"></i>
                                <span>{{ $matiere->chapitres_count }} chapitres</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-file-alt" style="color: {{ $matiere->couleur ?? '#3b82f6' }};"></i>
                                <span>{{ $matiere->contenus_count }} contenus</span>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        @if($matiere->chapitres_count > 0)
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Progression</span>
                                <span class="font-medium" style="color: {{ $matiere->couleur ?? '#3b82f6' }};">{{ rand(0, 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full" 
                                     style="width: {{ rand(0, 100) }}%; background-color: {{ $matiere->couleur ?? '#3b82f6' }};"></div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Bouton d'action -->
                        @if($matiere->chapitres_count > 0)
                            <a href="/cours/classe/{{ $classe->nom }}/matiere/{{ $matiere->nom }}" 
                               class="block w-full py-2.5 text-center rounded-xl font-medium transition-all"
                               style="color: {{ $matiere->couleur ?? '#3b82f6' }}; border: 2px solid {{ $matiere->couleur ?? '#3b82f6' }}; background-color: transparent;"
                               onmouseover="this.style.backgroundColor='{{ $matiere->couleur ?? '#3b82f6' }}'; this.style.color='white';"
                               onmouseout="this.style.backgroundColor='transparent'; this.style.color='{{ $matiere->couleur ?? '#3b82f6' }}';">
                                Explorer la matière
                            </a>
                        @else
                            <button disabled 
                                    class="block w-full py-2.5 text-center bg-gray-100 text-gray-400 rounded-xl font-medium cursor-not-allowed">
                                Bientôt disponible
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Section "Pourquoi choisir cette classe" -->
    @if($matieres->isNotEmpty())
    <section class="mt-16 bg-gray-50 rounded-3xl p-8 md:p-12">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-double text-primary-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Programme complet</h3>
                <p class="text-gray-500 text-sm">Toutes les matières du programme officiel, structurées par chapitre</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Accès illimité</h3>
                <p class="text-gray-500 text-sm">Révisez à votre rythme, où que vous soyez, 24h/24 et 7j/7</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Suivi personnalisé</h3>
                <p class="text-gray-500 text-sm">Suivez votre progression et identifiez vos points forts et faibles</p>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <div class="text-center mt-12">
        <p class="text-gray-600 mb-4">Prêt à commencer votre parcours en {{ $classe->nom }} ?</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#matieres" class="inline-flex items-center gap-2 bg-primary-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-primary-700 transition-colors shadow-lg shadow-primary-500/30">
                <i class="fas fa-rocket"></i>
                Commencer maintenant
            </a>
            <a href="/contact" class="inline-flex items-center gap-2 border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-full font-semibold hover:border-primary-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-question-circle"></i>
                Besoin d'aide ?
            </a>
        </div>
    </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}
</style>
@endsection