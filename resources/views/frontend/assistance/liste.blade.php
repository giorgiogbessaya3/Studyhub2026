@extends('layouts.app')

@section('title', 'Toutes les questions - StudyHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-900 mb-2">Toutes les questions</h1>
            <p class="text-slate-600">{{ $questions->total() }} questions disponibles</p>
        </div>
        
        @auth
            <a href="{{ route('assistance.create') }}" 
               class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                <i class="fas fa-plus"></i>
                Poser une question
            </a>
        @endauth
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
        <form method="GET" action="{{ route('assistance.liste') }}" class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="md:col-span-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Rechercher une question..."
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                </div>

                <!-- Classe -->
                <div>
                    <select name="classe" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Matière -->
                <div>
                    <select name="matiere" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ request('matiere') == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <!-- Tri -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-slate-600">Trier par :</label>
                    <select name="order" class="text-sm border border-slate-300 rounded-lg px-3 py-2">
                        <option value="latest" {{ request('order') == 'latest' ? 'selected' : '' }}>Plus récentes</option>
                        <option value="popular" {{ request('order') == 'popular' ? 'selected' : '' }}>Plus vues</option>
                        <option value="replies" {{ request('order') == 'replies' ? 'selected' : '' }}>Plus de réponses</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium">
                        Filtrer
                    </button>
                    <a href="{{ route('assistance.liste') }}" class="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des questions -->
    <div class="space-y-4">
        @forelse($questions as $question)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all">
                <div class="flex items-start gap-4">
                    <!-- Stats -->
                    <div class="flex-shrink-0 w-20 text-center">
                        <div class="text-2xl font-bold text-primary-600">{{ $question->reponses_count }}</div>
                        <div class="text-xs text-slate-500">réponses</div>
                        <div class="text-sm text-slate-400 mt-2">
                            <i class="far fa-eye"></i> {{ $question->views }}
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-primary-50 text-primary-600 rounded-full text-xs font-medium">
                                {{ $question->classe->nom }}
                            </span>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">
                                {{ $question->matiere->nom }}
                            </span>
                            @if($question->statut == 'resolue')
                                <span class="px-2 py-0.5 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Résolu
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('assistance.show', $question->id) }}" class="block group">
                            <h2 class="text-lg font-semibold text-slate-900 group-hover:text-primary-600 transition-colors mb-2">
                                {{ $question->titre }}
                            </h2>
                        </a>

                        <p class="text-slate-600 text-sm line-clamp-2 mb-3">
                            {{ Str::limit(strip_tags($question->contenu), 150) }}
                        </p>

                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-user"></i>
                                {{ $question->user->name }}
                            </span>
                            <span>•</span>
                            <span>{{ $question->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <i class="fas fa-comments text-5xl text-slate-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-slate-700 mb-2">Aucune question trouvée</h3>
                <p class="text-slate-500 mb-6">Essayez de modifier vos filtres ou posez votre propre question.</p>
                @auth
                    <a href="{{ route('assistance.create') }}" 
                       class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-semibold">
                        <i class="fas fa-plus"></i>
                        Poser une question
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $questions->links() }}
    </div>
</div>
@endsection