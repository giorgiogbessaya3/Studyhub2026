@extends('layouts.app')

@section('title', 'Correction - ' . $epreuve->titre . ' - StudyHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
    <div class="container mx-auto px-4">
        <!-- Fil d'Ariane -->
        <nav class="mb-6 text-sm text-white/80">
            <ol class="flex items-center flex-wrap gap-2">
                <li><a href="/" class="hover:text-white transition-colors">Accueil</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves" class="hover:text-white transition-colors">Épreuves</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" class="hover:text-white transition-colors">{{ $epreuve->titre }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium">Correction</li>
            </ol>
        </nav>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="fas fa-check-circle text-3xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">Correction</h1>
                <p class="text-blue-100">{{ $epreuve->titre }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        <!-- Carte de la correction -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-8">
                <!-- En-tête -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="w-16 h-16 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-check-circle text-blue-600 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Correction disponible</h2>
                        <p class="text-gray-500">{{ $epreuve->classe->nom }} • {{ $epreuve->matiere->nom }} • {{ $epreuve->typeEpreuve->nom }}</p>
                    </div>
                </div>
                
                <!-- Description de la correction -->
                @if($epreuve->correction->description)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">À propos de cette correction</h3>
                    <div class="bg-gray-50 rounded-xl p-6 text-gray-700">
                        {{ $epreuve->correction->description }}
                    </div>
                </div>
                @endif
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction/download" 
                       class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i>
                        Télécharger la correction
                    </a>
                    
                    <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Retour à l'épreuve
                    </a>
                </div>
                
                <!-- Aperçu du fichier (si PDF) -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Le fichier de correction sera téléchargé automatiquement après avoir cliqué sur le bouton ci-dessus.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="flex justify-between items-center mt-8">
            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
               class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Retour à l'épreuve
            </a>
            
            <a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matiere/{{ $epreuve->matiere->nom }}" 
               class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2">
                Voir toutes les épreuves
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection