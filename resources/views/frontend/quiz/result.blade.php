@extends('layouts.app')

@section('title', 'Résultats - ' . $quiz->titre)
@section('page-title', 'Résultats')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-6 text-center">
            @if($estReussi)
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-4">
                    <i class="fas fa-trophy text-3xl"></i>
                </div>
                <h1 class="text-3xl font-display font-bold text-green-600 mb-2">Félicitations !</h1>
                <p class="text-slate-600 mb-6">Vous avez réussi le quiz !</p>
            @else
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 text-red-600 rounded-full mb-4">
                    <i class="fas fa-times text-3xl"></i>
                </div>
                <h1 class="text-3xl font-display font-bold text-red-600 mb-2">Dommage...</h1>
                <p class="text-slate-600 mb-6">Vous n'avez pas atteint le score minimum requis.</p>
            @endif
            
            <!-- Scores -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-1">{{ $resultat->score }}/{{ $totalPoints }}</div>
                    <div class="text-sm text-slate-500">Score obtenu</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-1">{{ $pourcentage }}%</div>
                    <div class="text-sm text-slate-500">Pourcentage</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-1">{{ floor($resultat->temps_ecoule / 60) }}:{{ str_pad($resultat->temps_ecoule % 60, 2, '0') }}</div>
                    <div class="text-sm text-slate-500">Temps</div>
                </div>
            </div>
            
            <!-- Barre de progression -->
            <div class="max-w-md mx-auto mt-6">
                <div class="flex justify-between text-sm mb-2">
                    <span>Score minimum: {{ $quiz->score_passer }}%</span>
                    <span>Votre score: {{ $pourcentage }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-4">
                    <div class="h-4 rounded-full {{ $estReussi ? 'bg-green-600' : 'bg-red-600' }}" style="width: {{ $pourcentage }}%"></div>
                </div>
            </div>
        </div>
        
        <!-- Détail des réponses -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-display font-bold text-slate-800 mb-6">Détail des réponses</h2>
            
            <div class="space-y-4">
                @foreach($details as $index => $detail)
                    <div class="border rounded-xl p-4 {{ $detail['est_correct'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                        <div class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-8 h-8 {{ $detail['est_correct'] ? 'bg-green-600' : 'bg-red-600' }} text-white rounded-full flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-slate-800 mb-2">{{ $detail['question']->titre }}</p>
                                
                                <!-- Réponse de l'utilisateur -->
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-slate-600 block mb-1">Votre réponse :</span>
                                    <div class="p-3 bg-white rounded-lg border {{ $detail['est_correct'] ? 'border-green-300' : 'border-red-300' }}">
                                        @if($detail['question']->type == 'qcm' && $detail['question']->options)
                                            @php
                                                $lettreReponse = $detail['reponse_utilisateur'];
                                                $texteReponse = $lettreReponse && isset($detail['question']->options[ord($lettreReponse) - 65]) 
                                                    ? $detail['question']->options[ord($lettreReponse) - 65] 
                                                    : 'Non répondue';
                                            @endphp
                                            <span class="font-mono mr-2">{{ $lettreReponse ?? '-' }}</span>
                                            {{ $texteReponse }}
                                        @else
                                            {{ $detail['reponse_utilisateur'] ?? 'Non répondue' }}
                                        @endif
                                    </div>
                                </div>
                                
                                @if(!$detail['est_correct'])
                                    <!-- Bonne réponse -->
                                    <div>
                                        <span class="text-sm font-medium text-green-600 block mb-1">Réponse correcte :</span>
                                        <div class="p-3 bg-white rounded-lg border border-green-300">
                                            @if($detail['question']->type == 'qcm' && $detail['question']->options)
                                                @php
                                                    $lettreBonne = $detail['question']->bonne_reponse;
                                                    $texteBonne = isset($detail['question']->options[ord($lettreBonne) - 65]) 
                                                        ? $detail['question']->options[ord($lettreBonne) - 65] 
                                                        : '';
                                                @endphp
                                                <span class="font-mono mr-2">{{ $lettreBonne }}</span>
                                                {{ $texteBonne }}
                                            @else
                                                {{ $detail['question']->bonne_reponse }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Points -->
                                <div class="mt-2 text-sm">
                                    <span class="font-medium">Points :</span>
                                    <span class="{{ $detail['est_correct'] ? 'text-green-600' : 'text-red-600' }} ml-2">
                                        {{ $detail['points_obtenus'] }}/{{ $detail['question']->points }}
                                    </span>
                                </div>
                                
                                <!-- Explication -->
                                @if($detail['question']->explication)
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                        <span class="text-sm font-medium text-blue-700 block mb-1">Explication :</span>
                                        <p class="text-sm text-blue-600">{{ $detail['question']->explication }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-center gap-4">
            <a href="{{ url('quiz/' . $quiz->id) }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-redo mr-2"></i>Refaire le quiz
            </a>
            <a href="{{ url('quiz') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i>Autres quiz
            </a>
        </div>
    </div>
</div>
@endsection