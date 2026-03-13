@extends('layouts.app')

@section('title', 'Tableau de bord - StudyHub')
@section('page-title', 'Tableau de bord')

@section('content')
<!-- Hero Section - Plus compacte sur mobile -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[180px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs - plus légers -->
    <div class="absolute top-10 left-10 w-48 h-48 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-64 h-64 bg-secondary-500/20 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-6">
        <div class="flex items-center justify-between gap-3">
            <!-- Texte de bienvenue -->
            <div class="flex-1">
                <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-xs px-3 py-1 rounded-full mb-2">
                    👋 Bienvenue
                </span>
                <h1 class="text-xl md:text-2xl font-bold text-white leading-tight">
                    {{ explode(' ', $user->name)[0] }}
                </h1>
                <p class="text-white/70 text-xs md:text-sm mt-1">
                    {{ now()->format('l d F Y') }}
                </p>
            </div>
            
            <!-- Avatar compact -->
            <div class="relative flex-shrink-0">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-full border-3 border-white/30 overflow-hidden shadow-lg">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal - Espacement optimisé mobile -->
<div class="px-3 py-4 md:px-4 md:py-6 max-w-7xl mx-auto">
    
    <!-- Statistiques - Scroll horizontal sur mobile -->
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-600 mb-3 flex items-center gap-2 md:hidden">
            <i class="fas fa-chart-pie text-primary-500"></i>
            Aperçu rapide
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
            <!-- Carte 1 -->
            <div class="bg-white rounded-xl shadow-sm p-3 md:p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-1 md:mb-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-primary-600 text-sm md:text-base"></i>
                    </div>
                    <span class="text-lg md:text-2xl font-bold text-primary-600">{{ $stats['total_quiz'] }}</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-gray-700">Quiz</p>
                <p class="text-[10px] md:text-xs text-gray-500 mt-0.5">{{ $stats['quiz_reussis'] }} réussis</p>
            </div>

            <!-- Carte 2 -->
            <div class="bg-white rounded-xl shadow-sm p-3 md:p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-1 md:mb-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-sm md:text-base"></i>
                    </div>
                    <span class="text-lg md:text-2xl font-bold text-green-600">{{ $stats['total_questions'] }}</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-gray-700">Questions</p>
                <p class="text-[10px] md:text-xs text-gray-500 mt-0.5">posées</p>
            </div>

            <!-- Carte 3 -->
            <div class="bg-white rounded-xl shadow-sm p-3 md:p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-1 md:mb-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-reply text-orange-600 text-sm md:text-base"></i>
                    </div>
                    <span class="text-lg md:text-2xl font-bold text-orange-600">{{ $stats['total_reponses'] }}</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-gray-700">Réponses</p>
                <p class="text-[10px] md:text-xs text-gray-500 mt-0.5">reçues</p>
            </div>

            <!-- Carte 4 -->
            <div class="bg-white rounded-xl shadow-sm p-3 md:p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-1 md:mb-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-purple-600 text-sm md:text-base"></i>
                    </div>
                    <span class="text-lg md:text-2xl font-bold text-purple-600">{{ round($stats['quiz_reussis'] / max($stats['total_quiz'], 1) * 100) }}%</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-gray-700">Taux</p>
                <p class="text-[10px] md:text-xs text-gray-500 mt-0.5">réussite</p>
            </div>
        </div>
    </div>

    <!-- Grille principale - Empilée sur mobile -->
    <div class="space-y-4 md:space-y-0 md:grid md:grid-cols-2 md:gap-6 mb-6">
        <!-- Derniers résultats -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm md:text-base font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-chart-line text-white/90"></i>
                        Derniers résultats
                    </h2>
                    <a href="{{ url('/mes-resultats') }}" class="text-white/80 hover:text-white text-xs flex items-center gap-1">
                        Voir <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            
            <div class="p-3 md:p-4">
                @if($derniersResultats->isEmpty())
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-chart-bar text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500">Aucun résultat</p>
                        <a href="{{ url('/quiz') }}" class="inline-block mt-2 text-xs text-primary-600">Commencer un quiz →</a>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($derniersResultats as $resultat)
                            @php
                                $totalQuestions = $resultat->quiz->questions->count();
                                $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100) : 0;
                                $estReussi = $pourcentage >= ($resultat->quiz->score_passer ?? 50);
                            @endphp
                            <a href="{{ url('/mes-resultats/' . $resultat->id) }}" 
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg active:bg-gray-100 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xs md:text-sm font-medium text-gray-800 truncate">{{ $resultat->quiz->titre }}</h3>
                                    <p class="text-[10px] text-gray-500 mt-0.5">{{ $resultat->created_at->format('d/m/Y') }}</p>
                                </div>
                                <span class="ml-2 px-2 py-1 text-[10px] font-medium rounded-md {{ $estReussi ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $resultat->score }}/{{ $totalQuestions }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Dernières questions -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm md:text-base font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-question-circle text-white/90"></i>
                        Mes questions
                    </h2>
                    <a href="{{ url('/mes-questions') }}" class="text-white/80 hover:text-white text-xs flex items-center gap-1">
                        Voir <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            
            <div class="p-3 md:p-4">
                @if($dernieresQuestions->isEmpty())
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-question-circle text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500">Aucune question</p>
                        <a href="{{ url('/assistance/poser') }}" class="inline-block mt-2 text-xs text-primary-600">Poser →</a>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($dernieresQuestions as $question)
                            <a href="{{ url('/assistance/question/' . $question->id) }}" 
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg active:bg-gray-100 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xs md:text-sm font-medium text-gray-800 truncate">{{ Str::limit($question->titre, 40) }}</h3>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] text-gray-500">{{ $question->created_at->format('d/m/Y') }}</span>
                                        <span class="text-[10px] text-gray-400">•</span>
                                        <span class="text-[10px] text-gray-500">{{ $question->reponses->count() }} réponse(s)</span>
                                    </div>
                                </div>
                                @if($question->est_resolu)
                                    <span class="ml-2 px-1.5 py-0.5 bg-green-100 text-green-700 text-[8px] rounded-full flex items-center">
                                        <i class="fas fa-check mr-0.5"></i>
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions rapides - Optimisées pour le tactile -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <i class="fas fa-bolt text-primary-500"></i>
            Actions rapides
        </h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <a href="{{ url('/quiz') }}" 
               class="flex flex-col items-center p-3 bg-primary-50 rounded-xl active:bg-primary-100 transition-colors">
                <div class="w-10 h-10 bg-primary-600 text-white rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-play text-sm"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Quiz</span>
            </a>
            
            <a href="{{ url('/cours') }}" 
               class="flex flex-col items-center p-3 bg-green-50 rounded-xl active:bg-green-100 transition-colors">
                <div class="w-10 h-10 bg-green-600 text-white rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-book-open text-sm"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Cours</span>
            </a>
            
            <a href="{{ url('/epreuves') }}" 
               class="flex flex-col items-center p-3 bg-orange-50 rounded-xl active:bg-orange-100 transition-colors">
                <div class="w-10 h-10 bg-orange-600 text-white rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-file-alt text-sm"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Épreuves</span>
            </a>
            
            <a href="{{ url('/assistance/poser') }}" 
               class="flex flex-col items-center p-3 bg-purple-50 rounded-xl active:bg-purple-100 transition-colors">
                <div class="w-10 h-10 bg-purple-600 text-white rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-question text-sm"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Aide</span>
            </a>
        </div>
    </div>

    <!-- Petit conseil du jour (optionnel) -->
    <div class="mt-4 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-3 text-white">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-lightbulb text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-medium mb-0.5">Conseil du jour</p>
                <p class="text-[11px] text-white/80 leading-relaxed">
                    Les quiz réguliers améliorent votre mémoire de 40% ! Continuez comme ça.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
/* Optimisations tactiles */
@media (max-width: 768px) {
    .active\:bg-gray-100:active {
        background-color: #f3f4f6;
    }
    .active\:bg-primary-100:active {
        background-color: #dbeafe;
    }
    .active\:bg-green-100:active {
        background-color: #d1fae5;
    }
    .active\:bg-orange-100:active {
        background-color: #ffedd5;
    }
    .active\:bg-purple-100:active {
        background-color: #f3e8ff;
    }
}

/* Animation au scroll */
[data-aos] {
    opacity: 0;
    transition-property: opacity, transform;
    transition-duration: 0.4s;
}

[data-aos].aos-animate {
    opacity: 1;
}

[data-aos="fade-up"] {
    transform: translateY(15px);
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
}
</style>

@push('scripts')
<script>
    // Animation simple
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[data-aos]');
        
        function checkVisibility() {
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9) {
                    el.classList.add('aos-animate');
                }
            });
        }
        
        checkVisibility();
        window.addEventListener('scroll', checkVisibility);
        window.addEventListener('resize', checkVisibility);
    });
</script>
@endpush
@endsection