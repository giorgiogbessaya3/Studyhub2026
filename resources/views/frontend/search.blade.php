@extends('layouts.app')

@section('title', 'Résultats de recherche - StudyHub')
@section('page-title', 'Recherche')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-800 mb-2">Résultats de recherche</h1>
            <p class="text-slate-600">
                @if(!isset($q) || empty($q) || strlen($q) < 2)
                    Veuillez entrer au moins 2 caractères pour effectuer une recherche
                @else
                    <span class="font-medium">{{ $stats['total_global'] ?? 0 }}</span> résultat(s) pour 
                    <span class="font-semibold text-primary-600">"{{ $q }}"</span>
                @endif
            </p>
        </div>

        @if(isset($q) && !empty($q) && strlen($q) >= 2 && isset($stats) && $stats['total_global'] > 0)
            <!-- Filtres par catégorie -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-slate-700 py-2">Filtrer :</span>
                    <button onclick="filterResults('all')" class="filter-btn active px-4 py-2 text-sm rounded-full bg-primary-600 text-white" data-filter="all">
                        Tous ({{ $stats['total_global'] }})
                    </button>
                    
                    @if(isset($chapitres) && $chapitres->total() > 0)
                    <button onclick="filterResults('chapitres')" class="filter-btn px-4 py-2 text-sm rounded-full bg-slate-100 text-slate-700 hover:bg-primary-100 transition-colors" data-filter="chapitres">
                        Cours ({{ $chapitres->total() }})
                    </button>
                    @endif
                    
                    @if(isset($epreuves) && $epreuves->total() > 0)
                    <button onclick="filterResults('epreuves')" class="filter-btn px-4 py-2 text-sm rounded-full bg-slate-100 text-slate-700 hover:bg-primary-100 transition-colors" data-filter="epreuves">
                        Épreuves ({{ $epreuves->total() }})
                    </button>
                    @endif
                    
                    @if(isset($quizs) && $quizs->total() > 0)
                    <button onclick="filterResults('quizs')" class="filter-btn px-4 py-2 text-sm rounded-full bg-slate-100 text-slate-700 hover:bg-primary-100 transition-colors" data-filter="quizs">
                        Quiz ({{ $quizs->total() }})
                    </button>
                    @endif
                    
                    @if(isset($questions) && $questions->total() > 0)
                    <button onclick="filterResults('questions')" class="filter-btn px-4 py-2 text-sm rounded-full bg-slate-100 text-slate-700 hover:bg-primary-100 transition-colors" data-filter="questions">
                        Assistance ({{ $questions->total() }})
                    </button>
                    @endif
                </div>
            </div>

            <!-- Résultats par catégorie -->
            <div class="space-y-8">
                
                <!-- Cours / Chapitres -->
                @if(isset($chapitres) && $chapitres->total() > 0)
                <div class="result-section bg-white rounded-2xl shadow-sm overflow-hidden" data-category="chapitres">
                    <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-book-open"></i>
                            Cours ({{ $chapitres->total() }})
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($chapitres as $chapitre)
                        <div class="p-6 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start justify-between flex-wrap gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2 flex-wrap">
                                        <span class="bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full">{{ $chapitre->classe->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $chapitre->matiere->nom ?? 'N/A' }}</span>
                                    </div>
                                    <a href="{{ url('/chapitre/' . ($chapitre->slug ?? $chapitre->id)) }}" class="text-lg font-medium text-slate-800 hover:text-primary-600 transition-colors line-clamp-2">
                                        {{ $chapitre->titre }}
                                    </a>
                                    @if($chapitre->description)
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ Str::limit($chapitre->description, 150) }}</p>
                                    @endif
                                </div>
                                <a href="{{ url('/chapitre/' . ($chapitre->slug ?? $chapitre->id)) }}" class="flex-shrink-0 w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($chapitres->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        {{ $chapitres->links() }}
                    </div>
                    @endif
                </div>
                @endif

                <!-- Épreuves -->
                @if(isset($epreuves) && $epreuves->total() > 0)
                <div class="result-section bg-white rounded-2xl shadow-sm overflow-hidden" data-category="epreuves">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Épreuves ({{ $epreuves->total() }})
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($epreuves as $epreuve)
                        <div class="p-6 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start justify-between flex-wrap gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2 flex-wrap">
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{ $epreuve->classe->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $epreuve->matiere->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span class="text-green-600">{{ $epreuve->typeEpreuve->nom ?? 'Épreuve' }}</span>
                                        @if($epreuve->annee)
                                        <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">{{ $epreuve->annee }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" class="text-lg font-medium text-slate-800 hover:text-green-600 transition-colors line-clamp-2">
                                        {{ $epreuve->titre }}
                                    </a>
                                    @if($epreuve->description)
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ Str::limit($epreuve->description, 150) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($epreuve->correction)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full" title="Correction disponible">
                                        <i class="fas fa-check-circle mr-1"></i>Corrigé
                                    </span>
                                    @endif
                                    <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-colors">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($epreuves->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        {{ $epreuves->links() }}
                    </div>
                    @endif
                </div>
                @endif

                <!-- Quiz -->
                @if(isset($quizs) && $quizs->total() > 0)
                <div class="result-section bg-white rounded-2xl shadow-sm overflow-hidden" data-category="quizs">
                    <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-question-circle"></i>
                            Quiz ({{ $quizs->total() }})
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($quizs as $quiz)
                        <div class="p-6 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start justify-between flex-wrap gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2 flex-wrap">
                                        <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">{{ $quiz->classe->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $quiz->matiere->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $quiz->questions_count ?? 0 }} questions</span>
                                        <span>•</span>
                                        <span>{{ $quiz->duree ?? 30 }} min</span>
                                    </div>
                                    <a href="{{ url('/quiz/' . $quiz->id) }}" class="text-lg font-medium text-slate-800 hover:text-orange-600 transition-colors line-clamp-2">
                                        {{ $quiz->titre }}
                                    </a>
                                    @if($quiz->description)
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ Str::limit($quiz->description, 150) }}</p>
                                    @endif
                                </div>
                                <a href="{{ url('/quiz/' . $quiz->id) }}" class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 hover:bg-orange-600 hover:text-white transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($quizs->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        {{ $quizs->links() }}
                    </div>
                    @endif
                </div>
                @endif

                <!-- Questions d'assistance -->
                @if(isset($questions) && $questions->total() > 0)
                <div class="result-section bg-white rounded-2xl shadow-sm overflow-hidden" data-category="questions">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-headset"></i>
                            Assistance ({{ $questions->total() }})
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($questions as $question)
                        <div class="p-6 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start justify-between flex-wrap gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2 flex-wrap">
                                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">{{ $question->classe->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $question->matiere->nom ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span>{{ $question->created_at->diffForHumans() }}</span>
                                    </div>
                                    <a href="{{ url('/assistance/question/' . $question->id) }}" class="text-lg font-medium text-slate-800 hover:text-purple-600 transition-colors line-clamp-2">
                                        {{ $question->titre }}
                                    </a>
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ Str::limit($question->description, 150) }}</p>
                                </div>
                                <a href="{{ url('/assistance/question/' . $question->id) }}" class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($questions->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        {{ $questions->links() }}
                    </div>
                    @endif
                </div>
                @endif
            </div>
        @endif

        <!-- Aucun résultat -->
        @if(isset($q) && !empty($q) && strlen($q) >= 2 && isset($stats) && $stats['total_global'] == 0)
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-2xl font-semibold text-slate-800 mb-3">Aucun résultat trouvé</h3>
            <p class="text-slate-600 mb-6 max-w-md mx-auto">
                Désolé, nous n'avons trouvé aucun contenu correspondant à 
                <span class="font-semibold text-primary-600">"{{ $q }}"</span>
            </p>
            <div class="bg-slate-50 rounded-xl p-6 max-w-md mx-auto">
                <p class="text-sm font-medium text-slate-700 mb-3">Suggestions :</p>
                <ul class="text-sm text-slate-600 space-y-2">
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
            <div class="mt-8 flex flex-wrap gap-3 justify-center">
                <a href="{{ url('/cours') }}" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-book-open mr-2"></i>Explorer les cours
                </a>
                <a href="{{ url('/epreuves') }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-file-alt mr-2"></i>Voir les épreuves
                </a>
            </div>
        </div>
        @endif

        <!-- Message si recherche trop courte -->
        @if(!isset($q) || empty($q) || strlen($q) < 2)
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">🔎</div>
            <h3 class="text-2xl font-semibold text-slate-800 mb-3">Recherchez du contenu</h3>
            <p class="text-slate-600 mb-6 max-w-md mx-auto">
                Utilisez la barre de recherche ci-dessus pour trouver des cours, épreuves, quiz ou de l'aide.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-lg mx-auto">
                <a href="{{ url('/cours') }}" class="p-4 bg-slate-50 rounded-xl hover:bg-primary-50 transition-colors">
                    <i class="fas fa-book-open text-2xl text-primary-600 mb-2"></i>
                    <h4 class="font-medium">Cours</h4>
                    <p class="text-xs text-slate-500">Maths, Physique, Français...</p>
                </a>
                <a href="{{ url('/epreuves') }}" class="p-4 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                    <i class="fas fa-file-alt text-2xl text-green-600 mb-2"></i>
                    <h4 class="font-medium">Épreuves</h4>
                    <p class="text-xs text-slate-500">Examens, Devoirs, Bac...</p>
                </a>
                <a href="{{ url('/quiz') }}" class="p-4 bg-slate-50 rounded-xl hover:bg-orange-50 transition-colors">
                    <i class="fas fa-question-circle text-2xl text-orange-600 mb-2"></i>
                    <h4 class="font-medium">Quiz</h4>
                    <p class="text-xs text-slate-500">Tests interactifs</p>
                </a>
                <a href="{{ url('/assistance') }}" class="p-4 bg-slate-50 rounded-xl hover:bg-purple-50 transition-colors">
                    <i class="fas fa-headset text-2xl text-purple-600 mb-2"></i>
                    <h4 class="font-medium">Assistance</h4>
                    <p class="text-xs text-slate-500">Posez vos questions</p>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fonction de filtrage des résultats
    function filterResults(category) {
        // Mettre à jour les boutons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-primary-600', 'text-white');
            btn.classList.add('bg-slate-100', 'text-slate-700');
        });
        
        const activeBtn = document.querySelector(`[data-filter="${category}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-slate-100', 'text-slate-700');
            activeBtn.classList.add('bg-primary-600', 'text-white');
        }
        
        // Filtrer les sections
        const sections = document.querySelectorAll('.result-section');
        
        if (category === 'all') {
            sections.forEach(section => {
                section.style.display = 'block';
            });
        } else {
            sections.forEach(section => {
                if (section.dataset.category === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
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
        }, { threshold: 0.1 });

        document.querySelectorAll('.result-section').forEach(section => {
            section.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-500');
            observer.observe(section);
        });
    });
</script>
@endpush

@push('styles')
<style>
    .result-section {
        transition: all 0.3s ease;
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
</style>
@endpush