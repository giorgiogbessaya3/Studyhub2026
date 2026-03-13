@extends('layouts.app')

@section('title', 'Tableau de bord - StudyHub')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-800">Bonjour, {{ $user->name }} !</h1>
            <p class="text-slate-600">Voici un aperçu de votre activité sur StudyHub</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-primary-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-primary-600">{{ $stats['total_quiz'] }}</span>
                </div>
                <h3 class="font-medium text-slate-700">Quiz tentés</h3>
                <p class="text-sm text-slate-500">{{ $stats['quiz_reussis'] }} réussis</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-green-600">{{ $stats['total_questions'] }}</span>
                </div>
                <h3 class="font-medium text-slate-700">Questions posées</h3>
                <p class="text-sm text-slate-500">dans l'assistance</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-reply text-orange-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-orange-600">{{ $stats['total_reponses'] }}</span>
                </div>
                <h3 class="font-medium text-slate-700">Réponses reçues</h3>
                <p class="text-sm text-slate-500">à vos questions</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-purple-600">{{ round($stats['quiz_reussis'] / max($stats['total_quiz'], 1) * 100) }}%</span>
                </div>
                <h3 class="font-medium text-slate-700">Taux de réussite</h3>
                <p class="text-sm text-slate-500">aux quiz</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Derniers résultats de quiz -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-800">Derniers résultats de quiz</h2>
                    <a href="{{ url('/mes-resultats') }}" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
                        Voir tout <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                @if($derniersResultats->isEmpty())
                    <p class="text-center text-slate-500 py-8">
                        <i class="fas fa-chart-bar text-4xl mb-3 block text-slate-300"></i>
                        Aucun résultat pour le moment
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach($derniersResultats as $resultat)
                            @php
                                $totalQuestions = $resultat->quiz->questions->count();
                                $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100) : 0;
                                $estReussi = $pourcentage >= ($resultat->quiz->score_passer ?? 50);
                            @endphp
                            <a href="{{ url('/mes-resultats/' . $resultat->id) }}" class="block p-3 border border-slate-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-slate-800">{{ $resultat->quiz->titre }}</h3>
                                        <p class="text-xs text-slate-500">{{ $resultat->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 text-sm rounded-full {{ $estReussi ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $resultat->score }}/{{ $totalQuestions }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Dernières questions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-800">Mes dernières questions</h2>
                    <a href="{{ url('/mes-questions') }}" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
                        Voir tout <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                @if($dernieresQuestions->isEmpty())
                    <p class="text-center text-slate-500 py-8">
                        <i class="fas fa-question-circle text-4xl mb-3 block text-slate-300"></i>
                        Aucune question posée
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach($dernieresQuestions as $question)
                            <a href="{{ url('/assistance/question/' . $question->id) }}" class="block p-3 border border-slate-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-slate-800">{{ Str::limit($question->titre, 50) }}</h3>
                                        <p class="text-xs text-slate-500">
                                            {{ $question->created_at->format('d/m/Y H:i') }}
                                            <span class="mx-1">•</span>
                                            {{ $question->reponses->count() }} réponse(s)
                                        </p>
                                    </div>
                                    @if($question->est_resolu)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Résolu</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Actions rapides</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ url('/quiz') }}" class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-play text-primary-600"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Nouveau quiz</span>
                </a>
                
                <a href="{{ url('/cours') }}" class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-book-open text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Explorer les cours</span>
                </a>
                
                <a href="{{ url('/epreuves') }}" class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-file-alt text-orange-600"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Voir les épreuves</span>
                </a>
                
                <a href="{{ url('/assistance/poser') }}" class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-question text-purple-600"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Poser une question</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection