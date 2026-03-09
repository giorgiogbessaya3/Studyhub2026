{{-- resources/views/frontend/matiere_detail.blade.php --}}
@extends('layouts.app')

@section('title', $matiere->nom . ' - ' . $classe->nom . ' - StudyHub')

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-{{ $matiere->couleur ?? 'blue' }}-600 to-{{ $matiere->couleur ?? 'blue' }}-800 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-3 mb-4 text-white/80">
            <a href="{{ route('classe.detail', $classe->id) }}" class="hover:text-white transition">{{ $classe->nom }}</a>
            <i class="fas fa-chevron-right text-sm"></i>
            <span class="text-white font-medium">{{ $matiere->nom }}</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                @if($matiere->icone)
                <i class="fas {{ $matiere->icone }} text-white text-3xl"></i>
                @else
                <span class="font-bold text-white text-2xl">{{ substr($matiere->nom, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h1 class="font-display text-4xl font-bold text-white">{{ $matiere->nom }}</h1>
                <p class="text-white/80">{{ $classe->nom }} • {{ $chapitres->count() }} chapitres</p>
            </div>
        </div>
    </div>
</section>

{{-- Tabs --}}
<div class="sticky top-20 lg:top-20 bg-white border-b border-gray-200 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            <button class="py-4 border-b-2 border-{{ $matiere->couleur ?? 'blue' }}-600 text-{{ $matiere->couleur ?? 'blue' }}-600 font-semibold">
                Chapitres
            </button>
            <button class="py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                Épreuves
            </button>
            <button class="py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                Résumés
            </button>
        </div>
    </div>
</div>

{{-- Chapitres List --}}
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($chapitres->count() > 0)
        <div class="space-y-4">
            @foreach($chapitres as $index => $chapitre)
            <a href="{{ route('chapitre.detail', $chapitre->id) }}" class="group block bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-x-1 transition-all duration-300">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-{{ $matiere->couleur ?? 'blue' }}-100 rounded-2xl flex items-center justify-center group-hover:bg-{{ $matiere->couleur ?? 'blue' }}-200 transition-colors">
                            <span class="font-bold text-{{ $matiere->couleur ?? 'blue' }}-600 text-xl">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-gray-900 text-xl mb-2 group-hover:text-{{ $matiere->couleur ?? 'blue' }}-600 transition-colors">{{ $chapitre->titre }}</h3>
                                <p class="text-gray-500 line-clamp-2">{{ $chapitre->description }}</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-{{ $matiere->couleur ?? 'blue' }}-500 group-hover:translate-x-1 transition-all flex-shrink-0 mt-1"></i>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4">
                            @if($chapitre->contenus_count > 0)
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-book mr-1"></i>{{ $chapitre->contenus_count }} leçons
                            </span>
                            @endif
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>~45 min
                            </span>
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-check mr-1"></i>Exercices inclus
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-3xl shadow-sm">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-2">Aucun chapitre disponible</h3>
            <p class="text-gray-500">Les contenus seront bientôt ajoutés pour cette matière.</p>
        </div>
        @endif
    </div>
</section>
@endsection