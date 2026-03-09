@extends('layouts.app')

@section('title', 'Résultats de recherche - StudyHub')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Fil d'Ariane -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="/" class="hover:text-primary-600 transition-colors">Accueil</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/cours" class="hover:text-primary-600 transition-colors">Cours</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-primary-600 font-medium">Recherche</li>
        </ol>
    </nav>
    
    <!-- En-tête -->
    <div class="max-w-2xl mx-auto text-center mb-8">
        <h1 class="text-3xl font-bold mb-4">Résultats de recherche</h1>
        
        <form action="/cours/recherche" method="GET" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="q" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" 
                       value="{{ $q ?? '' }}" placeholder="Rechercher un cours..." 
                       minlength="2" required>
                <button class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2" type="submit">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
        
        @if(isset($total))
            <p class="text-gray-500">
                {{ $total }} résultat(s) pour "{{ $q }}"
            </p>
        @endif
    </div>
    
    @if(isset($total) && $total > 0)
        <!-- Résultats par catégorie -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Résultats Chapitres -->
            @if(isset($chapitres) && $chapitres->total() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-primary-600 text-white px-4 py-3">
                        <h5 class="font-semibold">Chapitres ({{ $chapitres->total() }})</h5>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($chapitres as $chapitre)
                            <a href="/cours/chapitre/{{ $chapitre->slug }}" 
                               class="block p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <h6 class="font-semibold text-gray-800">{{ $chapitre->titre }}</h6>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $chapitre->classe->nom ?? 'N/A' }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mb-1">{{ Str::limit($chapitre->description ?? '', 100) }}</p>
                                <span class="text-xs text-primary-600">{{ $chapitre->matiere->nom ?? '' }}</span>
                            </a>
                        @endforeach
                    </div>
                    @if($chapitres->hasPages())
                        <div class="border-t border-gray-200 px-4 py-3 bg-gray-50">
                            {{ $chapitres->links() }}
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Résultats Contenus -->
            @if(isset($contenus) && $contenus->total() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-green-600 text-white px-4 py-3">
                        <h5 class="font-semibold">Contenus ({{ $contenus->total() }})</h5>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($contenus as $contenu)
                            <a href="/cours/chapitre/{{ $contenu->chapitre->slug }}#contenu-{{ $contenu->id }}" 
                               class="block p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <h6 class="font-semibold text-gray-800">{{ $contenu->titre }}</h6>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $contenu->chapitre->classe->nom ?? 'N/A' }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mb-1">{{ Str::limit($contenu->resume ?? '', 100) }}</p>
                                <span class="text-xs text-green-600">
                                    Chapitre: {{ $contenu->chapitre->titre ?? '' }} | 
                                    {{ $contenu->chapitre->matiere->nom ?? '' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                    @if($contenus->hasPages())
                        <div class="border-t border-gray-200 px-4 py-3 bg-gray-50">
                            {{ $contenus->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Résultats Matières (sur toute la largeur) -->
        @if(isset($matieres) && $matieres->isNotEmpty())
            <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-600 text-white px-4 py-3">
                    <h5 class="font-semibold">Matières ({{ $matieres->count() }})</h5>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($matieres as $matiere)
                            @php
                                $premiereClasse = $matiere->classes->first();
                            @endphp
                            <a href="/cours/classe/{{ $premiereClasse?->nom ?? 'classe' }}/matiere/{{ $matiere->nom }}" 
                               class="block bg-gray-100 rounded-lg p-4 text-center hover:bg-gray-200 transition-colors no-underline">
                                <h6 class="font-semibold text-gray-800 mb-1">{{ $matiere->nom }}</h6>
                                <small class="text-gray-500">
                                    {{ $matiere->classes->pluck('nom')->join(', ') }}
                                </small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
    @elseif(isset($q))
        <div class="text-center py-12">
            <i class="fas fa-search fa-4x text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun résultat trouvé</h3>
            <p class="text-gray-500 mb-6">Essayez avec d'autres mots-clés</p>
            <a href="/cours" class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                Retour aux cours
            </a>
        </div>
    @endif
</div>

<!-- Styles pour la pagination si nécessaire -->
<style>
/* Style personnalisé pour les liens de pagination si nécessaire */
.pagination {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}
.pagination a, .pagination span {
    padding: 0.5rem 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    color: #374151;
    text-decoration: none;
}
.pagination a:hover {
    background-color: #f3f4f6;
}
.pagination .active span {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}
</style>
@endsection