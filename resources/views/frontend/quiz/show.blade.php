@extends('layouts.app')

@section('title', $quiz->titre . ' - StudyHub')

@section('content')
<!-- Hero Section - Style identique à la page des cours -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[200px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        <!-- Badge et retour -->
        <div class="flex items-center justify-between mb-4">
            <a href="{{ url('quiz') }}" class="inline-flex items-center text-white/70 hover:text-white text-sm transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux quiz
            </a>
            <span class="bg-white/10 backdrop-blur-sm text-white/90 text-xs px-3 py-1 rounded-full">
                <i class="fas fa-question-circle mr-1"></i> Quiz
            </span>
        </div>
        
        <!-- Titre et infos -->
        <div class="max-w-3xl">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-3">{{ $quiz->titre }}</h1>
            
            <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                <span class="bg-white/10 px-3 py-1 rounded-full">{{ $quiz->classe->nom }}</span>
                <span class="text-white/40">•</span>
                <span class="bg-white/10 px-3 py-1 rounded-full">{{ $quiz->matiere->nom }}</span>
                @if($quiz->chapitre)
                    <span class="text-white/40">•</span>
                    <span class="bg-white/10 px-3 py-1 rounded-full">{{ $quiz->chapitre->titre }}</span>
                @endif
            </div>
        </div>
        
        <!-- Métriques style cours -->
        <div class="flex flex-wrap gap-4 mt-6">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                <span class="text-white font-bold text-lg">{{ $quiz->questions->count() }}</span>
                <span class="text-white/70 text-sm ml-2">questions</span>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                <span class="text-white font-bold text-lg">{{ $quiz->duree }}</span>
                <span class="text-white/70 text-sm ml-2">minutes</span>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                <span class="text-white font-bold text-lg">{{ $quiz->score_passer }}%</span>
                <span class="text-white/70 text-sm ml-2">minimum</span>
            </div>
        </div>
    </div>
</section>

<!-- Carte principale - Style carte de cours -->
<section class="py-10">
    <div class="container mx-auto px-4 max-w-3xl">
        @auth
            @if($dejaParticipe)
                <!-- Carte "Déjà participé" style carte de cours -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8 text-center">
                        <!-- Score -->
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-primary-600">{{ $dernierResultat->score }}</span>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">
                            {{ $dernierResultat->score }}/{{ $quiz->questions->sum('points') }}
                        </div>
                        <p class="text-sm text-gray-500 mb-6">Votre dernier score</p>
                        
                        <!-- Boutons -->
                        <div class="space-y-3">
                            <a href="{{ url('quiz/' . $quiz->id . '/start') }}" 
                               class="block w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                                <i class="fas fa-redo mr-2"></i> Refaire le quiz
                            </a>
                            <a href="{{ url('quiz/' . $quiz->id . '/result/' . $dernierResultat->id) }}" 
                               class="block w-full py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                                <i class="fas fa-chart-bar mr-2"></i> Voir mes résultats
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Carte "Prêt à commencer" style carte de cours -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- En-tête avec dégradé (comme les cartes de cours) -->
                    <div class="h-2 bg-gradient-to-r from-primary-600 to-primary-700"></div>
                    
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Prêt à commencer ?</h2>
                        
                        <!-- Statistiques en grille (style carte de cours) -->
                        <div class="grid grid-cols-3 gap-4 mb-8">
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <div class="text-2xl font-bold text-primary-600">{{ $quiz->questions->count() }}</div>
                                <div class="text-xs text-gray-500 mt-1">Questions</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <div class="text-2xl font-bold text-primary-600">{{ $quiz->duree }}</div>
                                <div class="text-xs text-gray-500 mt-1">Minutes</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <div class="text-2xl font-bold text-primary-600">{{ $quiz->score_passer }}%</div>
                                <div class="text-xs text-gray-500 mt-1">Minimum</div>
                            </div>
                        </div>
                        
                        <!-- Bouton principal -->
                        <a href="{{ url('quiz/' . $quiz->id . '/start') }}" 
                           class="block w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors text-center text-lg">
                            <i class="fas fa-play mr-2"></i> Commencer le quiz
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- Carte "Non connecté" -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-lock text-primary-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Connectez-vous</h2>
                <p class="text-gray-500 mb-8">Vous devez être connecté pour participer aux quiz.</p>
                
                <div class="space-y-3 max-w-sm mx-auto">
                    <a href="{{ route('login') }}" 
                       class="block w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                        <i class="fas fa-user-plus mr-2"></i> S'inscrire
                    </a>
                </div>
            </div>
        @endauth
    </div>
</section>

<!-- Animation au scroll -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
@endsection