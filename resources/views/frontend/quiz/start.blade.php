@extends('layouts.app')

@section('title', $quiz->titre . ' - Quiz')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-6 md:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <!-- En-tête avec timer - Style carte -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-md mb-4 md:mb-6 overflow-hidden border border-gray-100">
            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Infos quiz -->
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $quiz->titre }}</h1>
                        <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm text-gray-500">
                            <span class="bg-primary-50 text-primary-700 px-2.5 py-1 rounded-full">{{ $quiz->classe->nom }}</span>
                            <span class="text-gray-300">•</span>
                            <span>{{ $quiz->matiere->nom }}</span>
                            <span class="text-gray-300 hidden xs:inline">•</span>
                            <span class="text-gray-600"><i class="far fa-clock mr-1"></i>{{ $quiz->duree }} min</span>
                        </div>
                    </div>
                    
                    <!-- Timer design amélioré -->
                    <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-5 py-3 rounded-xl border border-primary-200 shadow-sm self-start sm:self-auto">
                        <div class="text-xs font-medium text-primary-600 mb-1 text-center">Temps restant</div>
                        <div id="timer" class="text-2xl md:text-3xl font-bold text-primary-700 font-mono text-center" data-duree="{{ $quiz->duree * 60 }}">
                            {{ $quiz->duree }}:00
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Barre de progression améliorée -->
            <div class="px-4 md:px-6 pb-4 md:pb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Progression</span>
                    <span id="progress-text" class="text-sm font-medium text-primary-600 bg-primary-50 px-3 py-1 rounded-full">0/{{ $quiz->questions->count() }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div id="progress-bar" class="bg-gradient-to-r from-primary-500 to-primary-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>Début</span>
                    <span>Fin</span>
                </div>
            </div>
        </div>

        <!-- Formulaire du quiz -->
        <form id="quizForm" action="{{ url('quiz/' . $quiz->id . '/submit') }}" method="POST">
            @csrf
            
            <!-- Questions -->
            <div class="space-y-4 md:space-y-6">
                @foreach($quiz->questions as $index => $question)
                    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 question-card" data-question="{{ $index }}">
                        <!-- En-tête de question -->
                        <div class="bg-gray-50 px-4 md:px-6 py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm md:text-base">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-700 text-sm md:text-base">Question {{ $index + 1 }}/{{ $quiz->questions->count() }}</span>
                                <span class="ml-auto text-xs md:text-sm text-gray-500">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Corps de la question -->
                        <div class="p-4 md:p-6">
                            <p class="text-base md:text-lg font-medium text-gray-800 mb-4">{{ $question->titre }}</p>
                            
                            <!-- Image si présente -->
                            @if($question->image)
                                <div class="mb-4 rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question image" class="w-full h-auto max-h-64 object-cover">
                                </div>
                            @endif
                            
                            <!-- Options selon le type -->
                            @if($question->type == 'qcm' && $question->options)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($question->options as $lettre => $option)
                                        <label class="flex items-center p-3 md:p-4 border-2 border-gray-200 rounded-xl hover:border-primary-300 hover:bg-primary-50/30 transition-all cursor-pointer option-label group">
                                            <input type="radio" name="question_{{ $question->id }}" value="{{ chr(65 + $lettre) }}" class="w-4 h-4 text-primary-600 focus:ring-primary-500 mr-3">
                                            <span class="flex-1 text-sm md:text-base">{{ $option }}</span>
                                            <span class="text-xs md:text-sm font-medium text-gray-400 group-hover:text-primary-500 transition-colors">{{ chr(65 + $lettre) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif($question->type == 'vrai_faux')
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <label class="flex-1 p-4 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all cursor-pointer text-center option-label group">
                                        <input type="radio" name="question_{{ $question->id }}" value="vrai" class="hidden">
                                        <i class="fas fa-check-circle text-2xl text-gray-400 group-hover:text-green-500 mb-2 transition-colors"></i>
                                        <div class="font-medium text-gray-700 group-hover:text-green-600">Vrai</div>
                                    </label>
                                    <label class="flex-1 p-4 border-2 border-gray-200 rounded-xl hover:border-red-500 hover:bg-red-50 transition-all cursor-pointer text-center option-label group">
                                        <input type="radio" name="question_{{ $question->id }}" value="faux" class="hidden">
                                        <i class="fas fa-times-circle text-2xl text-gray-400 group-hover:text-red-500 mb-2 transition-colors"></i>
                                        <div class="font-medium text-gray-700 group-hover:text-red-600">Faux</div>
                                    </label>
                                </div>
                            @else
                                <textarea name="question_{{ $question->id }}" rows="4" class="w-full rounded-xl border-gray-200 focus:border-primary-500 focus:ring-primary-500 resize-none" placeholder="Écrivez votre réponse ici..."></textarea>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Bouton de soumission fixe sur mobile -->
            <div class="sticky bottom-0 mt-6 md:mt-8 bg-white border-t border-gray-200 p-4 md:p-0 md:bg-transparent md:border-0 md:static md:mt-8 md:text-center">
                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:scale-105 md:min-w-[300px]">
                    <i class="fas fa-check-circle mr-2"></i>
                    Soumettre mes réponses
                </button>
                <p class="text-xs md:text-sm text-gray-500 mt-3 text-center hidden md:block">
                    <i class="fas fa-info-circle mr-1"></i>
                    Vous pourrez voir vos résultats immédiatement après la soumission
                </p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Timer
    const dureeTotale = {{ $quiz->duree * 60 }};
    let tempsRestant = dureeTotale;
    const timerElement = document.getElementById('timer');
    
    function formatTemps(secondes) {
        const minutes = Math.floor(secondes / 60);
        const secs = secondes % 60;
        return `${minutes}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Mettre à jour le timer immédiatement
    timerElement.textContent = formatTemps(tempsRestant);
    
    const timer = setInterval(() => {
        tempsRestant--;
        timerElement.textContent = formatTemps(tempsRestant);
        
        // Alerte visuelle quand il reste peu de temps
        if (tempsRestant === 60) {
            timerElement.classList.add('text-red-600', 'animate-pulse');
        }
        
        if (tempsRestant <= 0) {
            clearInterval(timer);
            alert('Temps écoulé ! Vos réponses vont être soumises automatiquement.');
            document.getElementById('quizForm').submit();
        }
    }, 1000);
    
    // Progression
    const questions = document.querySelectorAll('.question-card');
    const totalQuestions = questions.length;
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    
    function updateProgress() {
        const repondues = Array.from(questions).filter(card => {
            const radioButtons = card.querySelectorAll('input[type="radio"]:checked');
            const textarea = card.querySelector('textarea');
            return radioButtons.length > 0 || (textarea && textarea.value.trim() !== '');
        }).length;
        
        const pourcentage = (repondues / totalQuestions) * 100;
        progressBar.style.width = pourcentage + '%';
        progressText.textContent = `${repondues}/${totalQuestions}`;
    }
    
    // Écouter les changements
    document.querySelectorAll('input[type="radio"], textarea').forEach(input => {
        input.addEventListener('change', updateProgress);
        input.addEventListener('keyup', updateProgress);
    });
    
    // Confirmation avant soumission
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        const repondues = Array.from(questions).filter(card => {
            const radioButtons = card.querySelectorAll('input[type="radio"]:checked');
            const textarea = card.querySelector('textarea');
            return radioButtons.length > 0 || (textarea && textarea.value.trim() !== '');
        }).length;
        
        if (repondues < totalQuestions) {
            if (!confirm(`Vous n'avez répondu qu'à ${repondues} questions sur ${totalQuestions}. Voulez-vous vraiment soumettre ?`)) {
                e.preventDefault();
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    .option-label:has(input:checked) {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .option-label:has(input:checked) span:last-child {
        color: #3b82f6;
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 480px) {
        .xs\:inline {
            display: inline;
        }
    }
</style>
@endpush
@endsection