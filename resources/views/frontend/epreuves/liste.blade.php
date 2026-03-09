@extends('layouts.app')

@section('title', 'Épreuves - ' . $matiere->nom . ' - ' . $classe->nom . ' - StudyHub')

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
                <li><a href="/epreuves/classe/{{ $classe->nom }}/type/{{ $type->slug }}/matieres" class="hover:text-white transition-colors">{{ $type->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium">{{ $matiere->nom }}</li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $matiere->nom }}</h1>
                    <p class="text-green-100">{{ $classe->nom }} • {{ $type->nom }}</p>
                </div>
            </div>
            
            <!-- Statistiques rapides -->
            <div class="bg-white/10 backdrop-blur rounded-xl px-4 py-2">
                <span class="text-white">{{ $epreuves->total() }} épreuves trouvées</span>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-12">

    <!-- Barre de filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Recherche -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Titre de l'épreuve..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            
            <!-- Filtre année -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                <select name="annee" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Toutes les années</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee }}" {{ request('annee') == $annee ? 'selected' : '' }}>
                            {{ $annee }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filtre durée -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                <select name="duree" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Toutes les durées</option>
                    <option value="court" {{ request('duree') == 'court' ? 'selected' : '' }}>Court (≤ 60 min)</option>
                    <option value="moyen" {{ request('duree') == 'moyen' ? 'selected' : '' }}>Moyen (61-120 min)</option>
                    <option value="long" {{ request('duree') == 'long' ? 'selected' : '' }}>Long (> 120 min)</option>
                </select>
            </div>
            
            <!-- Filtre correction -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correction</label>
                <select name="avec_correction" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Tous</option>
                    <option value="1" {{ request('avec_correction') == '1' ? 'selected' : '' }}>Avec correction</option>
                </select>
            </div>
            
            <!-- Tri -->
            <div class="md:col-span-3 flex items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="recent" {{ request('sort', 'recent') == 'recent' ? 'selected' : '' }}>Plus récent</option>
                        <option value="ancien" {{ request('sort') == 'ancien' ? 'selected' : '' }}>Plus ancien</option>
                        <option value="titre_asc" {{ request('sort') == 'titre_asc' ? 'selected' : '' }}>Titre (A-Z)</option>
                        <option value="titre_desc" {{ request('sort') == 'titre_desc' ? 'selected' : '' }}>Titre (Z-A)</option>
                        <option value="duree_asc" {{ request('sort') == 'duree_asc' ? 'selected' : '' }}>Durée (croissante)</option>
                        <option value="duree_desc" {{ request('sort') == 'duree_desc' ? 'selected' : '' }}>Durée (décroissante)</option>
                    </select>
                </div>
            </div>
            
            <!-- Boutons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Filtrer
                </button>
                <a href="/epreuves/classe/{{ $classe->nom }}/type/{{ $type->slug }}/matiere/{{ $matiere->nom }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    @if($epreuves->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <i class="fas fa-file-excel text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune épreuve trouvée</h3>
            <p class="text-gray-500">Essayez de modifier vos filtres de recherche.</p>
        </div>
    @else
        <!-- Grille des épreuves -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($epreuves as $epreuve)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all group">
                <div class="p-6">
                    <!-- En-tête -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                            {{ $epreuve->typeEpreuve->nom }}
                        </span>
                        @if($epreuve->correction)
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Corrigé
                            </span>
                        @endif
                    </div>
                    
                    <!-- Titre -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors line-clamp-2">
                        {{ $epreuve->titre }}
                    </h3>
                    
                    <!-- Description -->
                    @if($epreuve->description)
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $epreuve->description }}</p>
                    @endif
                    
                    <!-- Métadonnées -->
                    <div class="flex flex-wrap gap-3 mb-4">
                        @if($epreuve->annee)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="far fa-calendar"></i> {{ $epreuve->annee }}
                        </span>
                        @endif
                        
                        @if($epreuve->duree)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="far fa-clock"></i> {{ $epreuve->duree }} min
                        </span>
                        @endif
                        
                        @if($epreuve->bareme)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="fas fa-star"></i> {{ $epreuve->bareme }} pts
                        </span>
                        @endif
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
                           class="flex-1 px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors text-center">
                            Voir détails
                        </a>
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/download" 
                           class="px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors"
                           title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $epreuves->links() }}
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