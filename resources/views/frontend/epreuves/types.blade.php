@extends('layouts.app')

@section('title', 'Types d\'épreuves - ' . $classe->nom . ' - StudyHub')

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
                <li class="text-white font-medium">{{ $classe->nom }}</li>
            </ol>
        </nav>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="fas fa-tag text-3xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $classe->nom }}</h1>
                <p class="text-green-100">Choisissez le type d'épreuve que vous recherchez</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">

    @if($types->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <i class="fas fa-tag text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun type d'épreuve disponible</h3>
            <p class="text-gray-500">Aucune épreuve n'est disponible pour cette classe pour le moment.</p>
        </div>
    @else
        <!-- Grille des types d'épreuves -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($types as $index => $type)
            <a href="/epreuves/classe/{{ $classe->nom }}/type/{{ $type->slug }}/matieres" 
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl
                            @if($index % 4 == 0) bg-blue-100 text-blue-600
                            @elseif($index % 4 == 1) bg-green-100 text-green-600
                            @elseif($index % 4 == 2) bg-yellow-100 text-yellow-600
                            @else bg-purple-100 text-purple-600
                            @endif">
                            <i class="{{ $type->icone ?? 'fas fa-file-alt' }}"></i>
                        </div>
                        <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">
                            {{ $type->epreuves_count }} épreuves
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                        {{ $type->nom }}
                    </h3>
                    
                    @if($type->description)
                        <p class="text-sm text-gray-500 mb-4">{{ Str::limit($type->description, 80) }}</p>
                    @else
                        <p class="text-sm text-gray-400 mb-4">Toutes les épreuves de type {{ $type->nom }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Cliquez pour voir les matières</span>
                        <i class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection