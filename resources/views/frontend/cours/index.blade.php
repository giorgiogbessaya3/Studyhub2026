@extends('layouts.app')

@section('title', 'Cours en ligne - StudyHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Cours en ligne</h1>
        
        
        <!-- Barre de recherche -->
        <div class="max-w-xl mx-auto mt-8">
            <form action="/cours/recherche" method="GET" class="flex gap-2">
                <input type="text" name="q" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-300" 
                       placeholder="Rechercher un cours, un chapitre..." 
                       minlength="2" required>
                <button class="px-6 py-3 bg-white text-primary-700 rounded-lg font-semibold hover:bg-gray-100 transition-colors flex items-center gap-2" type="submit">
                    <i class="fas fa-search"></i>
                    <span class="hidden sm:inline">Rechercher</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">
    
    
    
    <!-- Message de bienvenue -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-3">Choisissez votre niveau</h2>
        
    </div>
    
    @if($classes->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-2xl">
            <i class="fas fa-book-open text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune classe disponible pour le moment.</p>
        </div>
    @else
        <!-- Navigation par cycle - Collège -->
        @php
            $collegeClasses = $classes->where('cycle', 'college');
        @endphp
        
        @if($collegeClasses->isNotEmpty())
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-child text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Collège</h2>
                    <p class="text-gray-500">{{ $collegeClasses->count() }} classes disponibles</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($collegeClasses as $index => $classe)
                <a href="/cours/classe/{{ $classe->nom }}" 
                   class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    
                    <!-- Badge "Populaire" pour certaines classes -->
                    @if(in_array($classe->nom, ['3ème']))
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1 z-10">
                        <i class="fas fa-fire"></i>
                        <span>Populaire</span>
                    </div>
                    @endif
                    
                    <!-- Dégradé de couleur selon l'index -->
                    <div class="absolute inset-0 bg-gradient-to-br 
                        @if($index == 0) from-blue-500 to-blue-600
                        @elseif($index == 1) from-green-500 to-green-600
                        @elseif($index == 2) from-yellow-500 to-yellow-600
                        @elseif($index == 3) from-orange-500 to-orange-600
                        @endif opacity-0 group-hover:opacity-10 transition-opacity">
                    </div>
                    
                    <div class="p-6">
                        <!-- Icône et titre -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl font-bold
                                @if($index == 0) bg-blue-100 text-blue-600
                                @elseif($index == 1) bg-green-100 text-green-600
                                @elseif($index == 2) bg-yellow-100 text-yellow-600
                                @elseif($index == 3) bg-orange-100 text-orange-600
                                @endif">
                                {{ preg_replace('/[^0-9]/', '', $classe->nom) }}e
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-primary-500 group-hover:translate-x-1 transition-all"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $classe->nom }}
                        </h3>
                        
                        @if($classe->description)
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $classe->description }}</p>
                        @endif
                        
                        <!-- Statistiques -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-book-open w-4 text-primary-400"></i>
                                <span>{{ $classe->matieres_count ?? $classe->matieres->count() ?? 0 }} matières</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-layer-group w-4 text-green-400"></i>
                                <span>{{ $classe->chapitres_count ?? 0 }} chapitres</span>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                            <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ rand(30, 90) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400">Progression globale</p>
                    </div>
                    
                    <!-- Bouton d'action au survol -->
                    <div class="absolute bottom-0 left-0 right-0 bg-primary-600 text-white text-center py-2 transform translate-y-full group-hover:translate-y-0 transition-transform">
                        <span class="text-sm font-medium">Explorer la classe</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- Navigation par cycle - Lycée -->
        @php
            $lyceeClasses = $classes->where('cycle', 'lycee');
        @endphp
        
        @if($lyceeClasses->isNotEmpty())
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Lycée</h2>
                    <p class="text-gray-500">{{ $lyceeClasses->count() }} classes disponibles</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($lyceeClasses as $index => $classe)
                <a href="/cours/classe/{{ $classe->nom }}" 
                   class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    
                    <!-- Badge "Bac" pour la Terminale -->
                    @if($classe->nom == 'Terminale')
                    <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1 z-10">
                        <i class="fas fa-star"></i>
                        <span>Bac</span>
                    </div>
                    @endif
                    
                    <!-- Dégradé de couleur selon l'index -->
                    <div class="absolute inset-0 bg-gradient-to-br 
                        @if($index == 0) from-purple-500 to-purple-600
                        @elseif($index == 1) from-indigo-500 to-indigo-600
                        @elseif($index == 2) from-pink-500 to-pink-600
                        @endif opacity-0 group-hover:opacity-10 transition-opacity">
                    </div>
                    
                    <div class="p-6">
                        <!-- Icône et titre -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-bold
                                @if($index == 0) bg-purple-100 text-purple-600
                                @elseif($index == 1) bg-indigo-100 text-indigo-600
                                @elseif($index == 2) bg-pink-100 text-pink-600
                                @endif">
                                @if($classe->nom == 'Seconde') 2<sup>nde</sup>
                                @elseif($classe->nom == 'Première') 1<sup>ère</sup>
                                @elseif($classe->nom == 'Terminale') T<sup>le</sup>
                                @endif
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-primary-500 group-hover:translate-x-1 transition-all"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $classe->nom }}
                        </h3>
                        
                        @if($classe->description)
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $classe->description }}</p>
                        @endif
                        
                        <!-- Statistiques avec icônes -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-book-open w-4 text-primary-400"></i>
                                <span>{{ $classe->matieres_count ?? $classe->matieres->count() ?? 0 }} matières</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-layer-group w-4 text-green-400"></i>
                                <span>{{ $classe->chapitres_count ?? 0 }} chapitres</span>
                            </div>
                            @if($classe->nom == 'Terminale')
                            <div class="flex items-center gap-2 text-sm text-yellow-500">
                                <i class="fas fa-trophy w-4"></i>
                                <span>Préparation au Bac</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Spécialités pour la Première/Terminale -->
                        @if(in_array($classe->nom, ['Première', 'Terminale']))
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Maths</span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Physique</span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">SVT</span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">+</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Bouton d'action au survol -->
                    <div class="absolute bottom-0 left-0 right-0 bg-primary-600 text-white text-center py-2 transform translate-y-full group-hover:translate-y-0 transition-transform">
                        <span class="text-sm font-medium">Explorer la classe</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    @endif
    
    
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection