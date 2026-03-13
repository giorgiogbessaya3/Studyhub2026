@extends('layouts.app')

@section('title', 'Résultats de recherche - StudyHub')
@section('page-title', 'Recherche')

@section('content')
<!-- Hero Section - Style moderne -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 py-12 overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Résultats de recherche</h1>
            
            @if(isset($q) && !empty($q) && strlen($q) >= 2)
                <p class="text-white/80 text-base">
                    <span class="font-semibold">{{ $stats['total_global'] ?? 0 }}</span> résultat(s) pour 
                    <span class="font-semibold text-primary-300">"{{ $q }}"</span>
                </p>
            @else
                <p class="text-white/80 text-base">Trouvez le contenu qui vous intéresse</p>
            @endif
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
    
    @if(isset($q) && !empty($q) && strlen($q) >= 2 && isset($stats) && $stats['total_global'] > 0)
        
        <!-- Filtres par catégorie - Design moderne -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 mb-6 border border-gray-100">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-600 mr-1 hidden sm:block">
                    <i class="fas fa-filter text-primary-500 mr-1"></i>Filtrer:
                </span>
                
                <button onclick="filterResults('all')" 
                        class="filter-btn active px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm rounded-full bg-primary-600 text-white font-medium shadow-sm hover:shadow transition-all" 
                        data-filter="all">
                    <i class="fas fa-th-large mr-1"></i> Tous ({{ $stats['total_global'] }})
                </button>
                
                @if(isset($chapitres) && $chapitres->total() > 0)
                <button onclick="filterResults('chapitres')" 
                        class="filter-btn px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-primary-100 hover:text-primary-700 transition-all" 
                        data-filter="chapitres">
                    <i class="fas fa-book-open mr-1"></i> Cours ({{ $chapitres->total() }})
                </button>
                @endif
                
                @if(isset($epreuves) && $epreuves->total() > 0)
                <button onclick="filterResults('epreuves')" 
                        class="filter-btn px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-all" 
                        data-filter="epreuves">
                    <i class="fas fa-file-alt mr-1"></i> Épreuves ({{ $epreuves->total() }})
                </button>
                @endif
                
                @if(isset($quizs) && $quizs->total() > 0)
                <button onclick="filterResults('quizs')" 
                        class="filter-btn px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-orange-100 hover:text-orange-700 transition-all" 
                        data-filter="quizs">
                    <i class="fas fa-question-circle mr-1"></i> Quiz ({{ $quizs->total() }})
                </button>
                @endif
                
                @if(isset($questions) && $questions->total() > 0)
                <button onclick="filterResults('questions')" 
                        class="filter-btn px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-purple-100 hover:text-purple-700 transition-all" 
                        data-filter="questions">
                    <i class="fas fa-headset mr-1"></i> Assistance ({{ $questions->total() }})
                </button>
                @endif
            </div>
        </div>

        <!-- Résultats par catégorie -->
        <div class="space-y-6 md:space-y-8">
            
            <!-- Cours / Chapitres -->
            @if(isset($chapitres) && $chapitres->total() > 0)
            <div class="result-section bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 overflow-hidden" data-category="chapitres">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base md:text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-book-open"></i>
                            Cours
                        </h2>
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $chapitres->total() }} résultat(s)</span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($chapitres as $chapitre)
                    <div class="p-4 md:p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs text-gray-500 mb-2">
                                    <span class="bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full">{{ $chapitre->classe->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span>{{ $chapitre->matiere->nom ?? 'N/A' }}</span>
                                </div>
                                
                                <a href="{{ url('/chapitre/' . ($chapitre->slug ?? $chapitre->id)) }}" class="text-base md:text-lg font-medium text-gray-800 hover:text-primary-600 transition-colors line-clamp-2">
                                    {{ $chapitre->titre }}
                                </a>
                                
                                @if($chapitre->description)
                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($chapitre->description, 120) }}</p>
                                @endif
                            </div>
                            
                            <a href="{{ url('/chapitre/' . ($chapitre->slug ?? $chapitre->id)) }}" 
                               class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-all hover:scale-110">
                                <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($chapitres->hasPages())
                <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-100">
                    {{ $chapitres->links() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Épreuves -->
            @if(isset($epreuves) && $epreuves->total() > 0)
            <div class="result-section bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 overflow-hidden" data-category="epreuves">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base md:text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Épreuves
                        </h2>
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $epreuves->total() }} résultat(s)</span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($epreuves as $epreuve)
                    <div class="p-4 md:p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs text-gray-500 mb-2">
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{ $epreuve->classe->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span>{{ $epreuve->matiere->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span class="text-green-600">{{ $epreuve->typeEpreuve->nom ?? 'Épreuve' }}</span>
                                    @if($epreuve->annee)
                                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $epreuve->annee }}</span>
                                    @endif
                                </div>
                                
                                <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" class="text-base md:text-lg font-medium text-gray-800 hover:text-green-600 transition-colors line-clamp-2">
                                    {{ $epreuve->titre }}
                                </a>
                                
                                @if($epreuve->description)
                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($epreuve->description, 120) }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($epreuve->correction)
                                <span class="hidden md:inline-flex text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Corrigé
                                </span>
                                @endif
                                <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" 
                                   class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-all hover:scale-110">
                                    <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($epreuves->hasPages())
                <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-100">
                    {{ $epreuves->links() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Quiz -->
            @if(isset($quizs) && $quizs->total() > 0)
            <div class="result-section bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 overflow-hidden" data-category="quizs">
                <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base md:text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-question-circle"></i>
                            Quiz
                        </h2>
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $quizs->total() }} résultat(s)</span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($quizs as $quiz)
                    <div class="p-4 md:p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs text-gray-500 mb-2">
                                    <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">{{ $quiz->classe->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span>{{ $quiz->matiere->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span><i class="far fa-clock mr-1"></i>{{ $quiz->duree ?? 30 }} min</span>
                                </div>
                                
                                <a href="{{ url('/quiz/' . $quiz->id) }}" class="text-base md:text-lg font-medium text-gray-800 hover:text-orange-600 transition-colors line-clamp-2">
                                    {{ $quiz->titre }}
                                </a>
                                
                                @if($quiz->description)
                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($quiz->description, 120) }}</p>
                                @endif
                                
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-list mr-1"></i> {{ $quiz->questions_count ?? 0 }} questions
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-trophy mr-1"></i> Score min: {{ $quiz->score_passer ?? 50 }}%
                                    </span>
                                </div>
                            </div>
                            
                            <a href="{{ url('/quiz/' . $quiz->id) }}" 
                               class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 hover:bg-orange-600 hover:text-white transition-all hover:scale-110">
                                <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($quizs->hasPages())
                <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-100">
                    {{ $quizs->links() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Questions d'assistance -->
            @if(isset($questions) && $questions->total() > 0)
            <div class="result-section bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 overflow-hidden" data-category="questions">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base md:text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-headset"></i>
                            Assistance
                        </h2>
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $questions->total() }} résultat(s)</span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($questions as $question)
                    <div class="p-4 md:p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs text-gray-500 mb-2">
                                    <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">{{ $question->classe->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span>{{ $question->matiere->nom ?? 'N/A' }}</span>
                                    <i class="fas fa-circle text-[3px] text-gray-300"></i>
                                    <span><i class="far fa-clock mr-1"></i>{{ $question->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <a href="{{ url('/assistance/question/' . $question->id) }}" class="text-base md:text-lg font-medium text-gray-800 hover:text-purple-600 transition-colors line-clamp-2">
                                    {{ $question->titre }}
                                </a>
                                
                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($question->contenu ?? $question->description, 120) }}</p>
                                
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-comment mr-1"></i> {{ $question->reponses_count ?? 0 }} réponse(s)
                                    </span>
                                    @if(($question->statut ?? '') == 'resolue')
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i> Résolue
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <a href="{{ url('/assistance/question/' . $question->id) }}" 
                               class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-all hover:scale-110">
                                <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($questions->hasPages())
                <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-100">
                    {{ $questions->links() }}
                </div>
                @endif
            </div>
            @endif
        </div>
    @endif

    <!-- Aucun résultat -->
    @if(isset($q) && !empty($q) && strlen($q) >= 2 && isset($stats) && $stats['total_global'] == 0)
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm p-8 md:p-12 text-center border border-gray-100">
        <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-3xl md:text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Aucun résultat trouvé</h3>
        <p class="text-sm md:text-base text-gray-600 mb-6 max-w-md mx-auto">
            Désolé, nous n'avons trouvé aucun contenu correspondant à 
            <span class="font-semibold text-primary-600">"{{ $q }}"</span>
        </p>
        
        <div class="bg-gray-50 rounded-xl p-5 md:p-6 max-w-md mx-auto mb-6">
            <p class="text-sm font-medium text-gray-700 mb-3">Suggestions :</p>
            <ul class="text-xs md:text-sm text-gray-600 space-y-2 text-left">
                <li class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500 text-xs"></i>
                    Vérifiez l'orthographe des mots
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500 text-xs"></i>
                    Essayez avec des termes plus généraux
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500 text-xs"></i>
                    Utilisez des mots-clés différents
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500 text-xs"></i>
                    Parcourez les catégories directement
                </li>
            </ul>
        </div>
        
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ url('/cours') }}" class="px-4 md:px-6 py-2 md:py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm md:text-base rounded-lg transition-colors shadow-sm hover:shadow flex items-center gap-2">
                <i class="fas fa-book-open"></i> Explorer les cours
            </a>
            <a href="{{ url('/epreuves') }}" class="px-4 md:px-6 py-2 md:py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm md:text-base rounded-lg transition-colors shadow-sm hover:shadow flex items-center gap-2">
                <i class="fas fa-file-alt"></i> Voir les épreuves
            </a>
        </div>
    </div>
    @endif

    <!-- Message si recherche trop courte -->
    @if(!isset($q) || empty($q) || strlen($q) < 2)
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm p-8 md:p-12 text-center border border-gray-100">
        <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-3xl md:text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">Recherchez du contenu</h3>
        <p class="text-sm md:text-base text-gray-600 mb-8 max-w-md mx-auto">
            Utilisez la barre de recherche ci-dessus pour trouver des cours, épreuves, quiz ou de l'aide.
        </p>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 max-w-2xl mx-auto">
            <a href="{{ url('/cours') }}" class="p-3 md:p-4 bg-gray-50 rounded-xl hover:bg-primary-50 transition-all group">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-book-open text-primary-600 text-lg md:text-xl"></i>
                </div>
                <h4 class="text-xs md:text-sm font-medium text-gray-700">Cours</h4>
                <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Maths, Physique...</p>
            </a>
            
            <a href="{{ url('/epreuves') }}" class="p-3 md:p-4 bg-gray-50 rounded-xl hover:bg-green-50 transition-all group">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-alt text-green-600 text-lg md:text-xl"></i>
                </div>
                <h4 class="text-xs md:text-sm font-medium text-gray-700">Épreuves</h4>
                <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Examens, Bac...</p>
            </a>
            
            <a href="{{ url('/quiz') }}" class="p-3 md:p-4 bg-gray-50 rounded-xl hover:bg-orange-50 transition-all group">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-question-circle text-orange-600 text-lg md:text-xl"></i>
                </div>
                <h4 class="text-xs md:text-sm font-medium text-gray-700">Quiz</h4>
                <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Tests interactifs</p>
            </a>
            
            <a href="{{ url('/assistance') }}" class="p-3 md:p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-all group">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-headset text-purple-600 text-lg md:text-xl"></i>
                </div>
                <h4 class="text-xs md:text-sm font-medium text-gray-700">Assistance</h4>
                <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Posez vos questions</p>
            </a>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Fonction de filtrage des résultats
    function filterResults(category) {
        const buttons = document.querySelectorAll('.filter-btn');
        const sections = document.querySelectorAll('.result-section');
        
        // Mettre à jour les boutons
        buttons.forEach(btn => {
            btn.classList.remove('bg-primary-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        const activeBtn = document.querySelector(`[data-filter="${category}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
            activeBtn.classList.add('bg-primary-600', 'text-white');
        }
        
        // Filtrer les sections avec animation
        sections.forEach(section => {
            if (category === 'all' || section.dataset.category === category) {
                section.style.display = 'block';
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 10);
            } else {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    section.style.display = 'none';
                }, 300);
            }
        });
    }

    // Animation au scroll
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.result-section').forEach(section => {
            section.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-700');
            observer.observe(section);
        });
    });

    // Initialiser le filtre "Tous" au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('categorie');
        if (category) {
            filterResults(category);
        }
    });
</script>
@endpush

@push('styles')
<style>
    .result-section {
        transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }
    .filter-btn {
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
    }
    .filter-btn:hover {
        transform: translateY(-1px);
    }
    .filter-btn:active {
        transform: translateY(0);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Améliorations responsives */
    @media (max-width: 640px) {
        .result-section {
            border-radius: 0.75rem;
        }
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    
    /* Animation de fadeInUp personnalisée */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    /* Style pour la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        flex-wrap: wrap;
    }
    .pagination .page-item {
        list-style: none;
    }
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.2rem;
        height: 2.2rem;
        padding: 0 0.5rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #4a5568;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .pagination .active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: white;
    }
</style>
@endpush
@endsection