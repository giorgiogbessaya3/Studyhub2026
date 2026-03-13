@extends('layouts.admin')

@section('title', 'Détail du résultat - StudyHub Admin')
@section('page-title', 'Détail du résultat')
@section('breadcrumb', 'Quiz / Résultats / Détail')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- En-tête -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-chart-bar me-2 text-primary"></i>
                    Résultat de {{ $resultat->user->name }}
                </h5>
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
                                <h6 class="mb-1 fw-bold">{{ $resultat->user->name }}</h6>
                                <p class="text-muted mb-1">{{ $resultat->user->email }}</p>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i> Inscrit le {{ $resultat->user->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <h6 class="mb-2 fw-bold">{{ $resultat->quiz->titre }}</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">
                                        <i class="ti ti-school me-1"></i> {{ $resultat->quiz->classe->nom ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">
                                        <i class="ti ti-book me-1"></i> {{ $resultat->quiz->matiere->nom ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted mb-0 small">
                                        <i class="ti ti-clock me-1"></i> Durée: {{ $resultat->quiz->duree_formatee ?? $resultat->quiz->duree . ' min' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @php
                    $totalQuestions = $resultat->quiz->questions->count();
                    $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
                    $seuilReussite = $resultat->quiz->score_passer ?? 50;
                    $estReussi = $pourcentage >= $seuilReussite;
                @endphp
                
                <!-- Cartes de statistiques -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 bg-primary bg-opacity-10">
                            <div class="card-body text-center">
                                <i class="ti ti-checklist fs-1 text-primary mb-2"></i>
                                <h3 class="text-primary mb-1">{{ $resultat->score }}/{{ $totalQuestions }}</h3>
                                <small class="text-muted">Score obtenu</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 bg-info bg-opacity-10">
                            <div class="card-body text-center">
                                <i class="ti ti-percent fs-1 text-info mb-2"></i>
                                <h3 class="text-info mb-1">{{ $pourcentage }}%</h3>
                                <small class="text-muted">Pourcentage</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 bg-warning bg-opacity-10">
                            <div class="card-body text-center">
                                <i class="ti ti-clock fs-1 text-warning mb-2"></i>
                                <h3 class="text-warning mb-1">{{ floor($resultat->temps_ecoule / 60) }}:{{ str_pad($resultat->temps_ecoule % 60, 2, '0', STR_PAD_LEFT) }}</h3>
                                <small class="text-muted">Temps écoulé</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 {{ $estReussi ? 'bg-success' : 'bg-danger' }} bg-opacity-10">
                            <div class="card-body text-center">
                                <i class="ti ti-{{ $estReussi ? 'check' : 'x' }} fs-1 {{ $estReussi ? 'text-success' : 'text-danger' }} mb-2"></i>
                                <h3 class="{{ $estReussi ? 'text-success' : 'text-danger' }} mb-1">
                                    {{ $estReussi ? 'Réussi' : 'Échoué' }}
                                </h3>
                                <small class="text-muted">Résultat</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barre de progression -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Score minimum requis: {{ $resultat->quiz->score_passer ?? 50 }}%</span>
                        <span class="small {{ $estReussi ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ $estReussi ? 'Seuil atteint' : 'Seuil non atteint' }}
                        </span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar {{ $estReussi ? 'bg-success' : 'bg-danger' }}" 
                             role="progressbar" 
                             style="width: {{ $pourcentage }}%;" 
                             aria-valuenow="{{ $pourcentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-secondary" 
                             role="progressbar" 
                             style="width: {{ $resultat->quiz->score_passer ?? 50 }}%; opacity: 0.3;">
                        </div>
                    </div>
                </div>
                
                <!-- Détail des questions -->
                <h6 class="fw-bold mb-3">
                    <i class="ti ti-questions me-1"></i>
                    Détail des réponses ({{ $totalQuestions }} questions)
                </h6>
                
                @if($totalQuestions > 0)
                <div class="accordion" id="questionsAccordion">
                    @foreach($resultat->quiz->questions as $index => $question)
                        @php
                            $reponseUtilisateur = isset($resultat->reponses[$index]) ? $resultat->reponses[$index] : null;
                            $estCorrect = $reponseUtilisateur == $question->bonne_reponse;
                            
                            // Formatage des réponses selon le type
                            if ($question->type == 'qcm' && $question->options) {
                                $optionsArray = is_array($question->options) ? $question->options : json_decode($question->options, true);
                                $lettreReponse = $reponseUtilisateur;
                                $texteReponse = isset($optionsArray[ord($lettreReponse) - 65]) ? $optionsArray[ord($lettreReponse) - 65] : 'Non répondue';
                                $bonneLettre = $question->bonne_reponse;
                                $texteBonne = isset($optionsArray[ord($bonneLettre) - 65]) ? $optionsArray[ord($bonneLettre) - 65] : '';
                            } elseif ($question->type == 'vrai_faux') {
                                $texteReponse = $reponseUtilisateur == 'vrai' ? 'Vrai' : ($reponseUtilisateur == 'faux' ? 'Faux' : 'Non répondue');
                                $texteBonne = $question->bonne_reponse == 'vrai' ? 'Vrai' : 'Faux';
                            } else {
                                $texteReponse = $reponseUtilisateur ?: 'Non répondue';
                                $texteBonne = $question->bonne_reponse;
                            }
                        @endphp
                        
                        <div class="accordion-item mb-3 border-0">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }} shadow-sm" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $index }}">
                                    <div class="d-flex align-items-center w-100">
                                        <span class="badge bg-secondary me-3">{{ $index + 1 }}</span>
                                        <span class="flex-grow-1">{{ Str::limit($question->titre, 80) }}</span>
                                        <div class="me-3">
                                            @if($estCorrect)
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check"></i> Correct
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="ti ti-x"></i> Incorrect
                                                </span>
                                            @endif
                                        </div>
                                        <span class="badge bg-secondary">{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                                 data-bs-parent="#questionsAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong class="d-block mb-2">Question :</strong>
                                                <p class="p-3 bg-light rounded">{{ $question->titre }}</p>
                                            </div>
                                            
                                            @if($question->type == 'qcm' && !empty($question->options))
                                                <div class="mb-3">
                                                    <strong class="d-block mb-2">Options proposées :</strong>
                                                    <div class="list-group">
                                                        @foreach($question->options as $lettre => $option)
                                                            @php
                                                                $lettreOption = chr(65 + $lettre);
                                                                $estBonneReponse = $lettreOption == $question->bonne_reponse;
                                                                $estReponseUtilisateur = $lettreOption == $reponseUtilisateur;
                                                            @endphp
                                                            <div class="list-group-item d-flex align-items-center">
                                                                <span class="badge bg-secondary me-2">{{ $lettreOption }}</span>
                                                                <span class="flex-grow-1">{{ $option }}</span>
                                                                @if($estBonneReponse)
                                                                    <span class="badge bg-success ms-2">
                                                                        <i class="ti ti-check"></i> Bonne réponse
                                                                    </span>
                                                                @endif
                                                                @if($estReponseUtilisateur)
                                                                    <span class="badge {{ $estCorrect ? 'bg-info' : 'bg-warning' }} ms-2">
                                                                        <i class="ti ti-user"></i> Réponse élève
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-3">Réponse de l'élève</h6>
                                                    
                                                    <div class="p-3 rounded {{ $estCorrect ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10' }} mb-3">
                                                        @if($question->type == 'qcm')
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge bg-secondary me-2">{{ $reponseUtilisateur ?? '-' }}</span>
                                                                <span>{{ $texteReponse }}</span>
                                                            </div>
                                                        @else
                                                            <p class="mb-0">{{ $texteReponse }}</p>
                                                        @endif
                                                    </div>
                                                    
                                                    @if(!$estCorrect)
                                                        <h6 class="card-title mb-3 mt-4">Réponse correcte</h6>
                                                        <div class="p-3 rounded bg-success bg-opacity-10">
                                                            @if($question->type == 'qcm')
                                                                <div class="d-flex align-items-center">
                                                                    <span class="badge bg-secondary me-2">{{ $question->bonne_reponse }}</span>
                                                                    <span>{{ $texteBonne }}</span>
                                                                </div>
                                                            @else
                                                                <p class="mb-0">{{ $texteBonne }}</p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    
                                                    @if($question->explication)
                                                        <div class="mt-4">
                                                            <h6 class="card-title mb-3">Explication</h6>
                                                            <div class="p-3 rounded bg-info bg-opacity-10">
                                                                <p class="mb-0">{{ $question->explication }}</p>
                                                            </div>
                                                        </div>
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
                @else
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    Aucune question trouvée pour ce quiz.
                </div>
                @endif
            </div>
            
            <!-- Pied de carte avec date -->
            <div class="card-footer bg-white py-3 text-muted">
                <small>
                    <i class="ti ti-calendar me-1"></i>
                    Terminé le {{ $resultat->termine_le ? \Carbon\Carbon::parse($resultat->termine_le)->format('d/m/Y à H:i') : $resultat->created_at->format('d/m/Y à H:i') }}
                </small>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ url('admin/resultats') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> Retour à la liste
            </a>
            <div>
                <a href="{{ url('admin/quiz/' . $resultat->quiz_id . '/statistiques') }}" class="btn btn-outline-info me-2">
                    <i class="ti ti-chart-bar me-1"></i> Statistiques du quiz
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="deleteResultat()">
                    <i class="ti ti-trash me-1"></i> Supprimer ce résultat
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

@push('scripts')
<script>
    function deleteResultat() {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce résultat ?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/resultats/" . $resultat->id) }}';
            form.submit();
        }
    }
</script>
@endpush