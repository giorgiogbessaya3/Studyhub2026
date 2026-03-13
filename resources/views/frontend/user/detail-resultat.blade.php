@extends('layouts.app')

@section('title', 'Détail du résultat - StudyHub')
@section('page-title', 'Détail du résultat')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-6 md:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        <!-- En-tête avec retour -->
        <div class="mb-6">
            <a href="{{ url('/mes-resultats') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600 transition-colors gap-2 text-sm">
                <i class="fas fa-arrow-left"></i>
                Retour à mes résultats
            </a>
        </div>

        <!-- Carte de résumé -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg mb-6 overflow-hidden border border-gray-100">
            <!-- En-tête avec dégradé -->
            <div class="h-2 {{ $estReussi ? 'bg-gradient-to-r from-green-700 to-green-600' : 'bg-gradient-to-r from-red-500 to-red-600' }}"></div>
            
            <div class="p-6 md:p-8">
                <!-- Infos du quiz -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $resultat->quiz->titre }}</h1>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                            <span class="bg-primary-50 text-primary-700 px-3 py-1 rounded-full">{{ $resultat->quiz->classe->nom }}</span>
                            <span class="text-gray-400">•</span>
                            <span>{{ $resultat->quiz->matiere->nom }}</span>
                        </div>
                    </div>
                    
                    <!-- Badge résultat -->
                    <div class="flex items-center gap-2">
                        @if($estReussi)
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                Réussi
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-medium flex items-center gap-2">
                                <i class="fas fa-times-circle"></i>
                                Échoué
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Cartes de scores -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 text-center">
                        <i class="fas fa-check-circle text-primary-600 text-xl mb-2"></i>
                        <div class="text-2xl font-bold text-primary-600">{{ $resultat->score }}/{{ $totalPoints }}</div>
                        <div class="text-xs text-gray-600">Score obtenu</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 text-center">
                        <i class="fas fa-percent text-primary-600 text-xl mb-2"></i>
                        <div class="text-2xl font-bold text-primary-600">{{ $pourcentage }}%</div>
                        <div class="text-xs text-gray-600">Pourcentage</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 text-center">
                        <i class="fas fa-clock text-primary-600 text-xl mb-2"></i>
                        <div class="text-2xl font-bold text-primary-600 font-mono">
                            @php
                                $minutes = floor($resultat->temps_ecoule / 60);
                                $secondes = $resultat->temps_ecoule % 60;
                            @endphp
                            {{ $minutes }}:{{ str_pad($secondes, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="text-xs text-gray-600">Temps</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 text-center">
                        <i class="fas fa-calendar text-primary-600 text-xl mb-2"></i>
                        <div class="text-2xl font-bold text-primary-600">{{ $resultat->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-600">Date</div>
                    </div>
                </div>
                
                <!-- Barre de progression -->
                <div class="max-w-2xl mx-auto">
                    <div class="flex justify-between text-xs md:text-sm mb-2">
                        <span class="text-gray-600"><i class="fas fa-flag text-gray-400 mr-1"></i>Score minimum: <span class="font-bold">{{ $resultat->quiz->score_passer }}%</span></span>
                        <span class="text-gray-600"><i class="fas {{ $estReussi ? 'fa-check-circle text-green-700' : 'fa-times-circle text-red-500' }} mr-1"></i>Votre score: <span class="font-bold {{ $estReussi ? 'text-green-700' : 'text-red-600' }}">{{ $pourcentage }}%</span></span>
                    </div>
                    <div class="relative w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <!-- Barre du score minimum (repère) -->
                        <div class="absolute top-0 bottom-0 w-0.5 bg-gray-800 z-10" style="left: {{ $resultat->quiz->score_passer }}%"></div>
                        <!-- Barre du score utilisateur -->
                        <div class="h-4 rounded-full {{ $estReussi ? 'bg-gradient-to-r from-green-700 to-green-600' : 'bg-gradient-to-r from-red-500 to-red-600' }}" 
                             style="width: {{ $pourcentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détail des réponses -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg mb-6 overflow-hidden border border-gray-100">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list-check text-primary-600"></i>
                    Détail des réponses
                </h2>
            </div>
            
            <div class="p-4 md:p-6">
                <div class="space-y-4">
                    @foreach($details as $index => $detail)
                        <div class="border rounded-xl overflow-hidden {{ $detail['est_correct'] ? 'border-green-700' : 'border-red-200' }}">
                            <!-- En-tête de la question -->
                            <div class="{{ $detail['est_correct'] ? 'bg-green-100' : 'bg-red-50' }} px-4 py-3 flex items-center gap-3">
                                <span class="flex-shrink-0 w-7 h-7 {{ $detail['est_correct'] ? 'bg-green-700' : 'bg-red-600' }} text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-700 text-sm md:text-base line-clamp-1">{{ $detail['question']->titre }}</span>
                                <div class="ml-auto flex items-center gap-2">
                                    @if($detail['est_correct'])
                                        <i class="fas fa-check-circle text-green-700 text-sm"></i>
                                    @else
                                        <i class="fas fa-times-circle text-red-600 text-sm"></i>
                                    @endif
                                    <span class="text-xs {{ $detail['est_correct'] ? 'text-green-700' : 'text-red-600' }} font-medium">
                                        {{ $detail['points_obtenus'] }}/{{ $detail['question']->points }} pts
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Corps de la réponse -->
                            <div class="p-4 bg-white">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Réponse utilisateur -->
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 mb-2 flex items-center gap-1">
                                            <i class="fas fa-user"></i> Votre réponse
                                        </p>
                                        <div class="p-3 rounded-lg {{ $detail['est_correct'] ? 'bg-green-100 border border-green-700' : 'bg-red-50 border border-red-200' }}">
                                            @if($detail['question']->type == 'qcm' && $detail['question']->options)
                                                @php
                                                    $lettreReponse = $detail['reponse_utilisateur'];
                                                    $texteReponse = $lettreReponse && isset($detail['question']->options[ord($lettreReponse) - 65]) 
                                                        ? $detail['question']->options[ord($lettreReponse) - 65] 
                                                        : 'Non répondue';
                                                @endphp
                                                <span class="inline-block w-5 h-5 rounded-full {{ $detail['est_correct'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-700' }} text-xs font-bold text-center leading-5 mr-2">
                                                    {{ $lettreReponse ?? '-' }}
                                                </span>
                                                <span class="text-sm">{{ $texteReponse }}</span>
                                            @else
                                                <span class="text-sm">{{ $detail['reponse_utilisateur'] ?? 'Non répondue' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if(!$detail['est_correct'])
                                        <!-- Bonne réponse -->
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-2 flex items-center gap-1">
                                                <i class="fas fa-check-circle text-green-700"></i> Réponse correcte
                                            </p>
                                            <div class="p-3 rounded-lg bg-green-100 border border-green-700">
                                                @if($detail['question']->type == 'qcm' && $detail['question']->options)
                                                    @php
                                                        $lettreBonne = $detail['question']->bonne_reponse;
                                                        $texteBonne = isset($detail['question']->options[ord($lettreBonne) - 65]) 
                                                            ? $detail['question']->options[ord($lettreBonne) - 65] 
                                                            : '';
                                                    @endphp
                                                    <span class="inline-block w-5 h-5 rounded-full bg-green-200 text-green-800 text-xs font-bold text-center leading-5 mr-2">
                                                        {{ $lettreBonne }}
                                                    </span>
                                                    <span class="text-sm">{{ $texteBonne }}</span>
                                                @else
                                                    <span class="text-sm">{{ $detail['question']->bonne_reponse }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Explication -->
                                @if($detail['question']->explication)
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <p class="text-xs font-medium text-blue-700 mb-1 flex items-center gap-1">
                                            <i class="fas fa-lightbulb"></i> Explication
                                        </p>
                                        <p class="text-sm text-blue-800">{{ $detail['question']->explication }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <a href="{{ url('quiz/' . $resultat->quiz_id) }}" 
               class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium rounded-xl transition-all shadow-lg hover:shadow-xl text-center flex items-center justify-center gap-2">
                <i class="fas fa-redo-alt"></i> Refaire ce quiz
            </a>
            <a href="{{ url('/mes-resultats') }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all text-center flex items-center justify-center gap-2">
                <i class="fas fa-chart-simple"></i> Voir tous mes résultats
            </a>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection