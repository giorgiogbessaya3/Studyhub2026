@extends('layouts.app')

@section('title', $quiz->titre . ' - Quiz')
@section('page-title', $quiz->titre)

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-display font-bold text-slate-800 mb-2">{{ $quiz->titre }}</h1>
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <span>{{ $quiz->classe->nom }}</span>
                        <span>•</span>
                        <span>{{ $quiz->matiere->nom }}</span>
                        <span>•</span>
                        <span><i class="far fa-clock mr-1"></i>{{ $quiz->duree_formatee }}</span>
                    </div>
                </div>
                
                <!-- Timer -->
                <div class="bg-primary-50 text-primary-700 px-6 py-3 rounded-xl">
                    <div class="text-sm font-medium mb-1">Temps restant</div>
                    <div id="timer" class="text-2xl font-bold font-mono" data-duree="{{ $quiz->duree * 60 }}">
                        {{ $quiz->duree }}:00
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire du quiz -->
        <form id="quizForm" action="{{ url('quiz/' . $quiz->id . '/submit') }}" method="POST">
            @csrf
            
            <!-- Progression -->
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-slate-600">Progression</span>
                    <span id="progress-text" class="text-sm text-primary-600">0/{{ $quiz->questions->count() }} questions</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>
            
            <!-- Questions -->
            <div class="space-y-6">
                @foreach($quiz->questions as $index => $question)
                    <div class="bg-white rounded-2xl shadow-sm p-6 question-card" data-question="{{ $index }}">
                        <div class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <p class="text-lg font-medium text-slate-800 mb-4">{{ $question->titre }}</p>
                                
                                <!-- Image si présente -->
                                @if($question->image)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question image" class="rounded-lg max-h-64">
                                    </div>
                                @endif
                                
                                <!-- Options selon le type -->
                                @if($question->type == 'qcm' && $question->options)
                                    <div class="space-y-3">
                                        @foreach($question->options as $lettre => $option)
                                            <label class="flex items-center p-4 border-2 border-slate-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-all cursor-pointer option-label">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ chr(65 + $lettre) }}" class="w-4 h-4 text-primary-600 focus:ring-primary-500 mr-3">
                                                <span class="flex-1">{{ $option }}</span>
                                                <span class="text-sm text-slate-400">{{ chr(65 + $lettre) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($question->type == 'vrai_faux')
                                    <div class="flex gap-4">
                                        <label class="flex-1 p-4 border-2 border-slate-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all cursor-pointer text-center option-label">
                                            <input type="radio" name="question_{{ $question->id }}" value="vrai" class="hidden">
                                            <i class="fas fa-check-circle text-2xl text-green-500 mb-2"></i>
                                            <div class="font-medium">Vrai</div>
                                        </label>
                                        <label class="flex-1 p-4 border-2 border-slate-200 rounded-xl hover:border-red-500 hover:bg-red-50 transition-all cursor-pointer text-center option-label">
                                            <input type="radio" name="question_{{ $question->id }}" value="faux" class="hidden">
                                            <i class="fas fa-times-circle text-2xl text-red-500 mb-2"></i>
                                            <div class="font-medium">Faux</div>
                                        </label>
                                    </div>
                                @else
                                    <textarea name="question_{{ $question->id }}" rows="3" class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="Votre réponse..."></textarea>
                                @endif
                                
                                <!-- Points -->
                                <div class="mt-3 text-sm text-slate-500">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>{{ $question->points }} point(s)
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Bouton de soumission -->
            <div class="mt-8 text-center">
                <button type="submit" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:scale-105">
                    <i class="fas fa-check-circle mr-2"></i>
                    Soumettre mes réponses
                </button>
                <p class="text-sm text-slate-500 mt-3">
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
    
    const timer = setInterval(() => {
        tempsRestant--;
        timerElement.textContent = formatTemps(tempsRestant);
        
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
        progressText.textContent = `${repondues}/${totalQuestions} questions`;
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
</style>
@endpush
@endsection