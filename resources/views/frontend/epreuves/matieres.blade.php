@extends('layouts.app')

@section('title', 'Matières - ' . $type->nom . ' - ' . $classe->nom . ' - StudyHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
    <div class="container mx-auto px-4">
        <!-- Fil d'Ariane -->
        <nav class="mb-6 text-sm text-white/80">
            <ol class="flex items-center flex-wrap gap-2">
                <li><a href="/" class="hover:text-white transition-colors">Accueil</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves" class="hover:text-white transition-colors">Épreuves</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $classe->nom }}/types" class="hover:text-white transition-colors">{{ $classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium">{{ $type->nom }}</li>
            </ol>
        </nav>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="{{ $type->icone ?? 'fas fa-file-alt' }} text-3xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $type->nom }}</h1>
                <p class="text-green-100">{{ $classe->nom }} • Choisissez une matière</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">

    @if($matieres->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <i class="fas fa-book text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune matière disponible</h3>
            <p class="text-gray-500">Aucune épreuve n'est disponible pour ce type dans cette classe.</p>
        </div>
    @else
        <!-- Grille des matières -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($matieres as $matiere)
            <a href="/epreuves/classe/{{ $classe->nom }}/type/{{ $type->slug }}/matiere/{{ $matiere->nom }}" 
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                
                <div class="h-32 bg-gradient-to-r from-gray-100 to-gray-200 relative overflow-hidden">
                    <!-- Cercle de couleur -->
                    <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full opacity-20"
                         style="background-color: {{ $matiere->couleur ?? '#10b981' }};"></div>
                    
                    <!-- Icône principale -->
                    <div class="absolute left-4 bottom-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform"
                             style="background-color: {{ $matiere->couleur ?? '#10b981' }};">
                            <i class="{{ $matiere->icone ?? 'fas fa-book' }} text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-green-600 transition-colors">
                        {{ $matiere->nom }}
                    </h3>
                    
                    @if($matiere->code)
                        <p class="text-xs text-gray-400 mb-3">{{ $matiere->code }}</p>
                    @endif
                    
                    <!-- Statistiques -->
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                            {{ $matiere->epreuves_count }} épreuves
                        </span>
                    </div>
                    
                    <!-- Description courte -->
                    @if($matiere->description)
                        <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $matiere->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Voir les épreuves</span>
                        <i class="fas fa-arrow-right text-xs text-green-600 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            @endforeach
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
</style>
@endsection