@extends('layouts.app')

@section('title', $epreuve->titre . ' - StudyHub')

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
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/types" class="hover:text-white transition-colors">{{ $epreuve->classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matieres" class="hover:text-white transition-colors">{{ $epreuve->typeEpreuve->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matiere/{{ $epreuve->matiere->nom }}" class="hover:text-white transition-colors">{{ $epreuve->matiere->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium truncate max-w-xs">{{ $epreuve->titre }}</li>
            </ol>
        </nav>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="fas fa-file-pdf text-3xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $epreuve->titre }}</h1>
                <p class="text-green-100">{{ $epreuve->classe->nom }} • {{ $epreuve->matiere->nom }} • {{ $epreuve->typeEpreuve->nom }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale -->
        <div class="lg:col-span-2">
            <!-- Carte principale -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden mb-8">
                <div class="p-8">
                    <!-- Description -->
                    @if($epreuve->description)
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-align-left text-green-600"></i>
                            Description
                        </h2>
                        <div class="bg-gray-50 rounded-xl p-6 text-gray-700">
                            {{ $epreuve->description }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Informations détaillées -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-calendar text-green-600 mb-2"></i>
                            <p class="text-xs text-gray-500">Année</p>
                            <p class="font-semibold">{{ $epreuve->annee ?? 'Non précisée' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-clock text-green-600 mb-2"></i>
                            <p class="text-xs text-gray-500">Durée</p>
                            <p class="font-semibold">{{ $epreuve->duree ? $epreuve->duree . ' min' : 'Non précisée' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-star text-green-600 mb-2"></i>
                            <p class="text-xs text-gray-500">Barème</p>
                            <p class="font-semibold">{{ $epreuve->bareme ? $epreuve->bareme . ' pts' : 'Non précisé' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-download text-green-600 mb-2"></i>
                            <p class="text-xs text-gray-500">Téléchargements</p>
                            <p class="font-semibold">{{ $epreuve->downloads ?? 0 }}</p>
                        </div>
                    </div>
                    
                    <!-- Actions principales -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/download" 
                           class="flex-1 px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i>
                            Télécharger l'épreuve
                        </a>
                        
                        @if($epreuve->correction)
                            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction" 
                               class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                Voir la correction
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Informations complémentaires -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-green-600"></i>
                    Informations
                </h3>
                
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-school"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500">Classe</p>
                            <p class="font-medium">{{ $epreuve->classe->nom }}</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-book"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500">Matière</p>
                            <p class="font-medium">{{ $epreuve->matiere->nom }}</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-tag"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500">Type d'épreuve</p>
                            <p class="font-medium">{{ $epreuve->typeEpreuve->nom }}</p>
                        </div>
                    </li>
                </ul>
                
                <!-- État de la correction -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3 mb-2">
                        @if($epreuve->correction)
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="font-medium text-green-600">Correction disponible</span>
                        @else
                            <i class="fas fa-times-circle text-gray-400 text-xl"></i>
                            <span class="font-medium text-gray-500">Correction non disponible</span>
                        @endif
                    </div>
                    @if($epreuve->correction)
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction/download" 
                           class="text-sm text-green-600 hover:text-green-700 flex items-center gap-1">
                            <i class="fas fa-download"></i>
                            Télécharger la correction
                        </a>
                    @endif
                </div>
                
                <!-- Bouton de partage -->
                <button onclick="partagerEpreuve()" 
                        class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-share-alt"></i>
                    Partager cette épreuve
                </button>
            </div>
        </div>
    </div>
    
    <!-- Épreuves similaires -->
    @if($similaires->isNotEmpty())
    <section class="mt-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Épreuves similaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($similaires as $similaire)
            <a href="/epreuves/{{ $similaire->slug ?? $similaire->id }}" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-file-alt text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors line-clamp-1">
                            {{ $similaire->titre }}
                        </h3>
                        <p class="text-xs text-gray-500">{{ $similaire->typeEpreuve->nom }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2">{{ $similaire->classe->nom }} • {{ $similaire->matiere->nom }}</p>
                @if($similaire->correction)
                <span class="text-xs text-green-600 flex items-center gap-1">
                    <i class="fas fa-check-circle"></i> Corrigé disponible
                </span>
                @endif
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
function partagerEpreuve() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $epreuve->titre }}',
            text: '{{ Str::limit($epreuve->description ?? "Épreuve disponible sur StudyHub", 100) }}',
            url: window.location.href
        })
        .catch(() => {
            alert('Lien copié dans le presse-papier !');
            navigator.clipboard.writeText(window.location.href);
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papier !');
    }
}
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection