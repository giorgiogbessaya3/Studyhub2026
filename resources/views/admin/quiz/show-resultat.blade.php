@extends('layouts.admin')

@section('title', 'Détail du résultat - StudyHub Admin')
@section('page-title', 'Détail du résultat')
@section('breadcrumb', 'Quiz / Résultats / Détail')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- En-tête -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Résultat de {{ $resultat->user->name }}</h5>
                <div class="btn-group">
                    <a href="{{ url('admin/quiz/' . $resultat->quiz_id) }}" class="btn btn-sm btn-outline-info">
                        <i class="ti ti-eye me-1"></i> Voir le quiz
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteResultat()">
                        <i class="ti ti-trash me-1"></i> Supprimer
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Informations principales -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($resultat->user->name) }}&background=3b82f6&color=fff&size=64" 
                                 class="rounded-circle me-3" width="64" height="64" alt="">
                            <div>
                                <h6 class="mb-1">{{ $resultat->user->name }}</h6>
                                <p class="text-muted mb-0">{{ $resultat->user->email }}</p>
                                <small class="text-muted">Inscrit le {{ $resultat->user->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <h6 class="mb-2">Quiz : {{ $resultat->quiz->titre }}</h6>
                            <p class="text-muted mb-1">
                                <i class="ti ti-school me-1"></i> {{ $resultat->quiz->classe->nom }} - 
                                <i class="ti ti-book me-1"></i> {{ $resultat->quiz->matiere->nom }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="ti ti-clock me-1"></i> Durée: {{ $resultat->quiz->duree_formatee }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Statistiques du résultat -->
                <div class="row g-3 mb-4">
                    @php
                        $totalQuestions = $resultat->quiz->questions->count();
                        $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100) : 0;
                        $estReussi = $pourcentage >= $resultat->quiz->score_passer;
                    @endphp
                    
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h3 class="text-primary mb-1">{{ $resultat->score }}/{{ $totalQuestions }}</h3>
                                <small class="text-muted">Score</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h3 class="text-info mb-1">{{ $pourcentage }}%</h3>
                                <small class="text-muted">Pourcentage</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h3 class="text-warning mb-1">{{ floor($resultat->temps_ecoule / 60) }}:{{ str_pad($resultat->temps_ecoule % 60, 2, '0', STR_PAD_LEFT) }}</h3>
                                <small class="text-muted">Temps</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                @if($estReussi)
                                    <h3 class="text-success mb-1">
                                        <i class="ti ti-check"></i> Réussi
                                    </h3>
                                @else
                                    <h3 class="text-danger mb-1">
                                        <i class="ti ti-x"></i> Échoué
                                    </h3>
                                @endif
                                <small class="text-muted">Résultat</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Détail des questions -->
                <h6 class="fw-bold mb-3">Détail des réponses</h6>
                <div class="accordion" id="questionsAccordion">
                    @foreach($resultat->quiz->questions as $index => $question)
                        @php
                            $reponseUtilisateur = $resultat->reponses[$index] ?? null;
                            $estCorrect = $reponseUtilisateur == $question->bonne_reponse;
                            
                            if ($question->type == 'qcm') {
                                $lettreReponse = $reponseUtilisateur;
                                $texteReponse = isset($question->options[ord($lettreReponse) - 65]) ? $question->options[ord($lettreReponse) - 65] : 'Non répondue';
                                $bonneLettre = $question->bonne_reponse;
                                $texteBonne = isset($question->options[ord($bonneLettre) - 65]) ? $question->options[ord($bonneLettre) - 65] : '';
                            } elseif ($question->type == 'vrai_faux') {
                                $texteReponse = $reponseUtilisateur == 'vrai' ? 'Vrai' : ($reponseUtilisateur == 'faux' ? 'Faux' : 'Non répondue');
                                $texteBonne = $question->bonne_reponse == 'vrai' ? 'Vrai' : 'Faux';
                            } else {
                                $texteReponse = $reponseUtilisateur ?: 'Non répondue';
                                $texteBonne = $question->bonne_reponse;
                            }
                        @endphp
                        
                        <div class="accordion-item mb-2 border-0">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                    <div class="d-flex align-items-center w-100">
                                        <span class="me-3">{{ $index + 1 }}.</span>
                                        <span class="flex-grow-1">{{ Str::limit($question->titre, 60) }}</span>
                                        @if($estCorrect)
                                            <span class="badge bg-success me-2">
                                                <i class="ti ti-check"></i> Correct
                                            </span>
                                        @else
                                            <span class="badge bg-danger me-2">
                                                <i class="ti ti-x"></i> Incorrect
                                            </span>
                                        @endif
                                        <span class="badge bg-secondary">{{ $question->points }} pt(s)</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                                 data-bs-parent="#questionsAccordion">
                                <div class="accordion-body bg-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Question :</strong></p>
                                            <p class="text-muted">{{ $question->titre }}</p>
                                            
                                            @if($question->type == 'qcm' && $question->options)
                                                <p class="mb-2"><strong>Options :</strong></p>
                                                <ul class="list-unstyled">
                                                    @foreach($question->options as $lettre => $option)
                                                        <li class="mb-1">
                                                            <span class="badge bg-secondary me-2">{{ chr(65 + $lettre) }}</span>
                                                            {{ $option }}
                                                            @if(chr(65 + $lettre) == $question->bonne_reponse)
                                                                <span class="badge bg-success ms-2">Bonne réponse</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <p class="mb-2"><strong>Réponse de l'élève :</strong></p>
                                                    <p class="p-2 rounded {{ $estCorrect ? 'bg-success-light' : 'bg-danger-light' }}">
                                                        @if($question->type == 'qcm')
                                                            <span class="badge bg-secondary me-2">{{ $lettreReponse ?? '-' }}</span>
                                                        @endif
                                                        {{ $texteReponse }}
                                                    </p>
                                                    
                                                    @if(!$estCorrect)
                                                        <p class="mb-2 mt-3"><strong>Réponse correcte :</strong></p>
                                                        <p class="p-2 rounded bg-success-light">
                                                            @if($question->type == 'qcm')
                                                                <span class="badge bg-secondary me-2">{{ $question->bonne_reponse }}</span>
                                                            @endif
                                                            {{ $texteBonne }}
                                                        </p>
                                                    @endif
                                                    
                                                    @if($question->explication)
                                                        <p class="mb-2 mt-3"><strong>Explication :</strong></p>
                                                        <p class="p-2 rounded bg-info-light">
                                                            {{ $question->explication }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="d-flex justify-content-between">
            <a href="{{ url('admin/quiz/resultats') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> Retour à la liste
            </a>
            <div>
                <a href="{{ url('admin/quiz/' . $resultat->quiz_id) }}" class="btn btn-outline-info me-2">
                    <i class="ti ti-eye me-1"></i> Voir le quiz
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="deleteResultat()">
                    <i class="ti ti-trash me-1"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .bg-success-light {
        background-color: rgba(16, 185, 129, 0.1);
    }
    .bg-danger-light {
        background-color: rgba(239, 68, 68, 0.1);
    }
    .bg-info-light {
        background-color: rgba(59, 130, 246, 0.1);
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8fafc;
        color: #1e293b;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,0.125);
    }
</style>
@endpush

@push('scripts')
<script>
    function deleteResultat() {
        if (confirm('Supprimer ce résultat ?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/quiz/resultats/" . $resultat->id) }}';
            form.submit();
        }
    }
</script>
@endpush