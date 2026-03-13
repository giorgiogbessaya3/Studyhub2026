@extends('layouts.app')

@section('title', $quiz->titre . ' - StudyHub')
@section('page-title', $quiz->titre)

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-900 to-primary-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ url('quiz') }}" class="text-white/80 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux quiz
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 text-primary-200 mb-4">
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">{{ $quiz->classe->nom }}</span>
                    <span>•</span>
                    <span>{{ $quiz->matiere->nom }}</span>
                    @if($quiz->chapitre)
                        <span>•</span>
                        <span>{{ $quiz->chapitre->titre }}</span>
                    @endif
                </div>
                
                <h1 class="text-4xl font-display font-bold mb-4">{{ $quiz->titre }}</h1>
                <p class="text-xl text-primary-100 mb-6">{{ $quiz->description }}</p>
                
                <!-- Tags -->
                <div class="flex flex-wrap gap-3">
                    <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                        <i class="far fa-clock mr-2"></i>{{ $quiz->duree_formatee }}
                    </span>
                    <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                        <i class="fas fa-list mr-2"></i>{{ $quiz->questions->count() }} questions
                    </span>
                    <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                        <i class="fas fa-trophy mr-2"></i>Score minimum : {{ $quiz->score_passer }}%
                    </span>
                </div>
            </div>
            
            <!-- Card de participation -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6">
                @auth
                    @if($dejaParticipe)
                        <div class="text-center mb-4">
                            <div class="text-3xl font-bold mb-2">{{ $dernierResultat->score }}/{{ $quiz->questions->sum('points') }}</div>
                            <p class="text-primary-200">Votre dernier score</p>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ url('quiz/' . $quiz->id . '/start') }}" class="block w-full text-center px-4 py-3 bg-white text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors">
                                <i class="fas fa-redo mr-2"></i>Refaire le quiz
                            </a>
                            <a href="{{ url('quiz/' . $quiz->id . '/result/' . $dernierResultat->id) }}" class="block w-full text-center px-4 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-400 transition-colors">
                                <i class="fas fa-chart-bar mr-2"></i>Voir mes résultats
                            </a>
                        </div>
                    @else
                        <h3 class="text-xl font-bold mb-4">Prêt à commencer ?</h3>
                        <ul class="space-y-3 mb-6 text-primary-100">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-white"></i>
                                <span>{{ $quiz->questions->count() }} questions à répondre</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-white"></i>
                                <span>Durée : {{ $quiz->duree_formatee }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-white"></i>
                                <span>Score minimum : {{ $quiz->score_passer }}%</span>
                            </li>
                        </ul>
                        <a href="{{ url('quiz/' . $quiz->id . '/start') }}" class="block w-full text-center px-4 py-3 bg-white text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors">
                            <i class="fas fa-play mr-2"></i>Commencer le quiz
                        </a>
                    @endif
                @else
                    <h3 class="text-xl font-bold mb-4">Connectez-vous pour participer</h3>
                    <p class="text-primary-100 mb-6">Créez un compte ou connectez-vous pour accéder aux quiz et suivre votre progression.</p>
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 bg-white text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors mb-3">
                        <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-400 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Aperçu des questions -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-display font-bold text-slate-800 mb-8">Aperçu des questions</h2>
        
        <div class="space-y-4">
            @foreach($quiz->questions->take(3) as $index => $question)
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <p class="text-slate-800 font-medium mb-2">{{ $question->titre }}</p>
                            <div class="flex items-center gap-3 text-sm">
                                <span class="px-2 py-1 bg-slate-100 rounded-full text-slate-600">
                                    <i class="fas fa-star mr-1"></i>{{ $question->points }} point(s)
                                </span>
                                <span class="px-2 py-1 bg-slate-100 rounded-full text-slate-600">
                                    <i class="fas fa-tag mr-1"></i>
                                    @if($question->type == 'qcm')
                                        QCM
                                    @elseif($question->type == 'vrai_faux')
                                        Vrai/Faux
                                    @else
                                        Question ouverte
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($quiz->questions->count() > 3)
                <div class="text-center pt-4">
                    <p class="text-slate-500">Et {{ $quiz->questions->count() - 3 }} autre(s) question(s)...</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection