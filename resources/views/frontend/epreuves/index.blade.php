@extends('layouts.app')

@section('title', 'Banque d\'épreuves - StudyHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-10">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Banque d'épreuves</h1>
        
        
        <!-- Barre de recherche -->
        <div class="max-w-xl mx-auto mt-8">
            <form action="/search" method="GET" class="flex gap-2">
                <input type="hidden" name="type" value="epreuves">
                <input type="text" name="q" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-300" 
                       placeholder="Rechercher une épreuve..." 
                       minlength="2" required>
                <button class="px-6 py-3 bg-white text-green-700 rounded-lg font-semibold hover:bg-gray-100 transition-colors flex items-center gap-2" type="submit">
                    <i class="fas fa-search"></i>
                    <span class="hidden sm:inline">Rechercher</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">
    
    <!-- Statistiques -->
   
    <!-- Message de bienvenue -->
    
    
    @if($classes->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-2xl">
            <i class="fas fa-file-alt text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune classe disponible pour le moment.</p>
        </div>
    @else
        <!-- Navigation par cycle - Collège -->
        @php
            $collegeClasses = $classes->filter(function($classe) {
                return $classe->cycle == 'college';
            });
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
                <a href="/epreuves/classe/{{ $classe->nom }}/types" 
                   class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    
                    <!-- Badge "Populaire" -->
                    @if(in_array($classe->nom, ['3ème']))
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1 z-10">
                        <i class="fas fa-fire"></i>
                        <span>BEPC</span>
                    </div>
                    @endif
                    
                    <!-- Dégradé de couleur -->
                    <div class="absolute inset-0 bg-gradient-to-br 
                        @if($index == 0) from-blue-500 to-blue-600
                        @elseif($index == 1) from-green-500 to-green-600
                        @elseif($index == 2) from-yellow-500 to-yellow-600
                        @elseif($index == 3) from-orange-500 to-orange-600
                        @endif opacity-0 group-hover:opacity-10 transition-opacity">
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl font-bold
                                @if($index == 0) bg-blue-100 text-blue-600
                                @elseif($index == 1) bg-green-100 text-green-600
                                @elseif($index == 2) bg-yellow-100 text-yellow-600
                                @elseif($index == 3) bg-orange-100 text-orange-600
                                @endif">
                                {{ preg_replace('/[^0-9]/', '', $classe->nom) }}e
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-green-500 group-hover:translate-x-1 transition-all"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            {{ $classe->nom }}
                        </h3>
                        
                        @if($classe->description)
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $classe->description }}</p>
                        @endif
                        
                        <!-- Statistiques -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-file-alt w-4 text-green-400"></i>
                                <span>{{ $classe->epreuves_count }} épreuves</span>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ rand(30, 90) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400">Taux de réussite</p>
                    </div>
                    
                    <!-- Bouton d'action au survol -->
                    <div class="absolute bottom-0 left-0 right-0 bg-green-600 text-white text-center py-2 transform translate-y-full group-hover:translate-y-0 transition-transform">
                        <span class="text-sm font-medium">Voir les types d'épreuves</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- Navigation par cycle - Lycée -->
        @php
            $lyceeClasses = $classes->filter(function($classe) {
                return $classe->cycle == 'lycee';
            });
        @endphp
        
        @if($lyceeClasses->isNotEmpty())
        <section class="mb-10">
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
                <a href="/epreuves/classe/{{ $classe->nom }}/types" 
                   class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    
                    <!-- Badge "Bac" -->
                    @if($classe->nom == 'Terminale')
                    <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1 z-10">
                        <i class="fas fa-star"></i>
                        <span>Bac</span>
                    </div>
                    @endif
                    
                    <!-- Dégradé de couleur -->
                    <div class="absolute inset-0 bg-gradient-to-br 
                        @if($index == 0) from-purple-500 to-purple-600
                        @elseif($index == 1) from-indigo-500 to-indigo-600
                        @elseif($index == 2) from-pink-500 to-pink-600
                        @endif opacity-0 group-hover:opacity-10 transition-opacity">
                    </div>
                    
                    <div class="p-6">
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
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-green-500 group-hover:translate-x-1 transition-all"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            {{ $classe->nom }}
                        </h3>
                        
                        @if($classe->description)
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $classe->description }}</p>
                        @endif
                        
                        <!-- Statistiques -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-file-alt w-4 text-green-400"></i>
                                <span>{{ $classe->epreuves_count }} épreuves</span>
                            </div>
                            @if($classe->nom == 'Terminale')
                            <div class="flex items-center gap-2 text-sm text-yellow-500">
                                <i class="fas fa-trophy w-4"></i>
                                <span>Annales du Bac</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Bouton d'action au survol -->
                    <div class="absolute bottom-0 left-0 right-0 bg-green-600 text-white text-center py-2 transform translate-y-full group-hover:translate-y-0 transition-transform">
                        <span class="text-sm font-medium">Voir les types d'épreuves</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    @endif
    
    <!-- Section avantages -->
  
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