@extends('layouts.app')

@section('title', 'Quiz interactifs - StudyHub')
@section('page-title', 'Quiz interactifs')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-900 to-primary-700 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')">
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-display font-bold mb-6" data-aos="fade-up">
                Quiz interactifs
            </h1>
            <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                Testez vos connaissances avec nos quiz adaptés à votre niveau
            </p>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total'] }}</div>
                    <div class="text-primary-200">Quiz disponibles</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_questions'] }}</div>
                    <div class="text-primary-200">Questions</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_participations'] }}</div>
                    <div class="text-primary-200">Participations</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-8 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url('quiz') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Classe</label>
                <select name="classe_id" class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Matière</label>
                <select name="matiere_id" class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Toutes les matières</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Recherche</label>
                <input type="text" name="search" placeholder="Titre du quiz..." value="{{ request('search') }}"
                       class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Filtrer
                </button>
                @if(request()->anyFilled(['classe_id', 'matiere_id', 'search']))
                    <a href="{{ url('quiz') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                        <i class="fas fa-times mr-2"></i>Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Liste des quiz -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($quizs->isEmpty())
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-2xl font-bold text-slate-700 mb-2">Aucun quiz trouvé</h3>
                <p class="text-slate-500">Aucun quiz ne correspond à vos critères.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizs as $quiz)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group" data-aos="fade-up">
                        <!-- Image ou icône -->
                        <div class="h-48 bg-gradient-to-br from-primary-500 to-primary-600 relative overflow-hidden">
                            @if($quiz->image)
                                <img src="{{ asset('storage/' . $quiz->image) }}" alt="{{ $quiz->titre }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="fas fa-question-circle text-white/30 text-8xl"></i>
                                </div>
                            @endif
                            
                            <!-- Badge nombre de questions -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-primary-600 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-list mr-1"></i>{{ $quiz->questions_count }} questions
                            </div>
                            
                            <!-- Badge temps -->
                            <div class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm">
                                <i class="far fa-clock mr-1"></i>{{ $quiz->duree_formatee }}
                            </div>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                                <span class="bg-primary-50 text-primary-600 px-2 py-0.5 rounded-full">{{ $quiz->classe->nom }}</span>
                                <span>•</span>
                                <span>{{ $quiz->matiere->nom }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2">{{ $quiz->titre }}</h3>
                            <p class="text-slate-600 mb-4 line-clamp-2">{{ $quiz->description ?? 'Aucune description' }}</p>
                            
                            <!-- Score minimum -->
                            <div class="flex items-center justify-between text-sm mb-4">
                                <span class="text-slate-500">Score minimum :</span>
                                <span class="font-medium text-primary-600">{{ $quiz->score_passer }}%</span>
                            </div>
                            
                            <!-- Bouton -->
                            <a href="{{ url('quiz/' . $quiz->id) }}" class="block w-full text-center px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                                Voir le quiz
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $quizs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</section>
@endsection