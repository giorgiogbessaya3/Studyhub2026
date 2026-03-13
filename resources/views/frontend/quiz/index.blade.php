@extends('layouts.app')

@section('title', 'Quiz interactifs - StudyHub')
@section('page-title', 'Quiz interactifs')

@section('content')
<!-- Hero Section - Même style que la page des cours -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-5">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                <i class="fas fa-question-circle mr-2"></i>
                Évaluez vos connaissances
            </span>
            
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Quiz interactifs
            </h1>
            
            <p class="text-white/80 text-base md:text-lg mb-4">
                Testez vos connaissances avec nos quiz adaptés à votre niveau
            </p>
            
            <!-- Stats élégantes -->
            <div class="flex flex-wrap justify-center gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                    <span class="text-white font-bold text-lg">{{ $stats['total'] }}</span>
                    <span class="text-white/70 text-sm ml-2">Quiz</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                    <span class="text-white font-bold text-lg">{{ $stats['total_questions'] }}</span>
                    <span class="text-white/70 text-sm ml-2">Questions</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                    <span class="text-white font-bold text-lg">{{ $stats['total_participations'] }}</span>
                    <span class="text-white/70 text-sm ml-2">Participants</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Liste des quiz -->
<div class="max-w-7xl mx-auto px-4 py-8">
    
    @if($quizs->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-question-circle text-4xl text-primary-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun quiz disponible</h3>
            <p class="text-gray-500">De nouveaux quiz seront bientôt disponibles.</p>
        </div>
    @else
        <!-- Filtres rapides par niveau -->
        <div class="flex flex-wrap gap-3 mb-10 justify-center">
            <a href="#college" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-child mr-2"></i>Collège
            </a>
            <a href="#lycee" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i>Lycée
            </a>
        </div>

        <!-- Quiz par niveau -->
        @php
            $collegeQuizs = $quizs->filter(function($quiz) {
                return $quiz->classe && in_array($quiz->classe->cycle, ['college']);
            });
            $lyceeQuizs = $quizs->filter(function($quiz) {
                return $quiz->classe && in_array($quiz->classe->cycle, ['lycee']);
            });
        @endphp
        
        <!-- Collège -->
        @if($collegeQuizs->isNotEmpty())
        <div id="college" class="mb-16 scroll-mt-24">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-child text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Collège</h2>
                    <p class="text-gray-500">{{ $collegeQuizs->count() }} quiz disponibles</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">6ème à 3ème</span>
                </div>
            </div>
            
            <!-- Grille des quiz -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($collegeQuizs as $index => $quiz)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ $index * 50 }}">
                        
                        <!-- En-tête avec dégradé selon la classe -->
                        <div class="relative h-32 overflow-hidden" 
                             style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            
                            <!-- Pattern de fond -->
                            <div class="absolute inset-0 opacity-10" 
                                 style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                            </div>
                            
                            <!-- Cercles décoratifs -->
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                            <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                            
                            <!-- Badge nombre de questions -->
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary-600 px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                                <i class="fas fa-list mr-1"></i>{{ $quiz->questions_count }} questions
                            </div>
                            
                            <!-- Icône et titre -->
                            <div class="absolute bottom-4 left-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                        <i class="fas fa-question-circle text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg line-clamp-1">{{ $quiz->titre }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-white/80">
                                            <span>{{ $quiz->classe->nom }}</span>
                                            <span>•</span>
                                            <span>{{ $quiz->matiere->nom }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 h-10">
                                {{ $quiz->description ?? 'Testez vos connaissances sur ce thème.' }}
                            </p>
                            
                            <!-- Métriques -->
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->questions_count }}</div>
                                    <div class="text-xs text-gray-500">Questions</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->duree }}</div>
                                    <div class="text-xs text-gray-500">Minutes</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->score_passer }}%</div>
                                    <div class="text-xs text-gray-500">Minimum</div>
                                </div>
                            </div>
                            
                            <!-- Bouton -->
                            <a href="{{ url('quiz/' . $quiz->id) }}" 
                               class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-primary-600 border-2 border-primary-600 hover:bg-primary-600 hover:text-white">
                                <span>Commencer</span>
                                <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Lycée -->
        @if($lyceeQuizs->isNotEmpty())
        <div id="lycee" class="mb-16 scroll-mt-24">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Lycée</h2>
                    <p class="text-gray-500">{{ $lyceeQuizs->count() }} quiz disponibles</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">Seconde à Terminale</span>
                </div>
            </div>
            
            <!-- Grille des quiz -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($lyceeQuizs as $index => $quiz)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ $index * 50 }}">
                        
                        <!-- En-tête avec dégradé -->
                        <div class="relative h-32 overflow-hidden" 
                             style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                            
                            <!-- Pattern de fond -->
                            <div class="absolute inset-0 opacity-10" 
                                 style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                            </div>
                            
                            <!-- Cercles décoratifs -->
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                            <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                            
                            <!-- Badge nombre de questions -->
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary-600 px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                                <i class="fas fa-list mr-1"></i>{{ $quiz->questions_count }} questions
                            </div>
                            
                            <!-- Icône et titre -->
                            <div class="absolute bottom-4 left-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                        <i class="fas fa-question-circle text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg line-clamp-1">{{ $quiz->titre }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-white/80">
                                            <span>{{ $quiz->classe->nom }}</span>
                                            <span>•</span>
                                            <span>{{ $quiz->matiere->nom }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 h-10">
                                {{ $quiz->description ?? 'Testez vos connaissances sur ce thème.' }}
                            </p>
                            
                            <!-- Métriques -->
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->questions_count }}</div>
                                    <div class="text-xs text-gray-500">Questions</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->duree }}</div>
                                    <div class="text-xs text-gray-500">Minutes</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="font-bold text-gray-800 text-sm">{{ $quiz->score_passer }}%</div>
                                    <div class="text-xs text-gray-500">Minimum</div>
                                </div>
                            </div>
                            
                            <!-- Bouton -->
                            <a href="{{ url('quiz/' . $quiz->id) }}" 
                               class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-white"
                               style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <span>Commencer</span>
                                <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pagination -->
        @if($quizs->hasPages())
            <div class="mt-8">
                {{ $quizs->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
</div>

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

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.scroll-mt-24 {
    scroll-margin-top: 6rem;
}

/* Animation au scroll */
[data-aos] {
    opacity: 0;
    transition-property: opacity, transform;
    transition-duration: 0.6s;
    transition-timing-function: ease-out;
}

[data-aos].aos-animate {
    opacity: 1;
}

[data-aos="fade-up"] {
    transform: translateY(30px);
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
}
</style>

@push('scripts')
<script>
    // Animation au scroll simplifiée
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('[data-aos]');
        
        function checkVisibility() {
            animatedElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                
                if (rect.top < windowHeight * 0.85) {
                    element.classList.add('aos-animate');
                }
            });
        }
        
        // Initial check
        checkVisibility();
        
        // Check on scroll
        window.addEventListener('scroll', checkVisibility);
    });
</script>
@endpush
@endsection