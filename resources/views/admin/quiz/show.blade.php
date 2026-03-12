@extends('layouts.admin')

@section('title', $quiz->titre . ' - StudyHub Admin')
@section('page-title', 'Détail du quiz')
@section('breadcrumb', 'Quiz / Détail')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                @if($quiz->image)
                    <img src="{{ $quiz->image_url }}" alt="{{ $quiz->titre }}" class="img-fluid rounded mb-3" style="max-height: 150px; object-fit: cover;">
                @else
                    <div class="bg-primary bg-opacity-10 rounded p-4 mb-3">
                        <i class="ti ti-quiz text-primary" style="font-size: 4rem;"></i>
                    </div>
                @endif
                
                <h5 class="mb-1">{{ $quiz->titre }}</h5>
                <p class="text-muted small mb-3">{{ $quiz->description ?? 'Aucune description' }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @if($quiz->statut == 'publie')
                        <span class="badge bg-success">Publié</span>
                    @elseif($quiz->statut == 'brouillon')
                        <span class="badge bg-secondary">Brouillon</span>
                    @elseif($quiz->statut == 'archive')
                        <span class="badge bg-warning">Archivé</span>
                    @endif
                    <span class="badge bg-info">{{ $quiz->duree_formatee }}</span>
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ url('admin/quiz/' . $quiz->id . '/questions') }}" class="btn btn-primary">
                        <i class="ti ti-list me-2"></i>Gérer les questions ({{ $quiz->questions->count() }})
                    </a>
                    <a href="{{ url('admin/quiz/' . $quiz->id . '/statistiques') }}" class="btn btn-info">
                        <i class="ti ti-chart-bar me-2"></i>Voir les statistiques
                    </a>
                    <div class="btn-group">
                        <a href="{{ url('admin/quiz/' . $quiz->id . '/edit') }}" class="btn btn-warning">
                            <i class="ti ti-edit me-2"></i>Modifier
                        </a>
                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                            <span class="visually-hidden">Toggle dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ url('admin/quiz/' . $quiz->id . '/toggle-status') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="ti ti-toggle me-2"></i>
                                        Changer statut
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ url('admin/quiz/' . $quiz->id . '/duplicate') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="ti ti-copy me-2"></i>
                                        Dupliquer
                                    </button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ url('admin/quiz/' . $quiz->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Supprimer ce quiz ? Toutes les questions et résultats seront également supprimés.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="ti ti-trash me-2"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">Informations</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Classe:</th>
                        <td>{{ $quiz->classe->nom ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Matière:</th>
                        <td>{{ $quiz->matiere->nom ?? 'N/A' }}</td>
                    </tr>
                    @if($quiz->chapitre)
                    <tr>
                        <th>Chapitre:</th>
                        <td>{{ $quiz->chapitre->titre ?? 'N/A' }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Créé par:</th>
                        <td>{{ $quiz->createur->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Créé le:</th>
                        <td>{{ $quiz->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Dernière modif:</th>
                        <td>{{ $quiz->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Score minimum:</th>
                        <td>{{ $quiz->score_passer }}%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-1">{{ $stats['nombre_tentatives'] ?? 0 }}</h3>
                        <small class="text-muted">Tentatives</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-1">{{ $stats['participants_uniques'] ?? 0 }}</h3>
                        <small class="text-muted">Participants</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-1">{{ $stats['score_moyen'] ?? 0 }}/{{ $quiz->questions->count() }}</h3>
                        <small class="text-muted">Score moyen</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-1">{{ $stats['taux_reussite'] ?? 0 }}%</h3>
                        <small class="text-muted">Réussite</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Questions ({{ $quiz->questions->count() }})</h6>
                <a href="{{ url('admin/quiz/' . $quiz->id . '/questions') }}" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus me-1"></i> Gérer
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Question</th>
                                <th width="100">Type</th>
                                <th width="80">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quiz->questions->take(5) as $question)
                            <tr>
                                <td>{{ $question->ordre }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($question->image)
                                            <img src="{{ $question->image_url }}" alt="" class="rounded me-2" width="30" height="30" style="object-fit: cover;">
                                        @endif
                                        <span>{{ Str::limit($question->titre, 50) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="{{ $question->type_icon }} me-1"></i>
                                        {{ $question->type_libelle }}
                                    </span>
                                </td>
                                <td><span class="badge bg-success">{{ $question->points }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="ti ti-question-mark fs-4 text-muted mb-2"></i>
                                    <p class="text-muted">Aucune question</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($quiz->questions->count() > 5)
                <div class="card-footer bg-white text-center py-2">
                    <small class="text-muted">
                        Affichage de 5 questions sur {{ $quiz->questions->count() }}
                    </small>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Meilleurs scores</h6>
                @if($quiz->resultats->count() > 0)
                <a href="{{ url('admin/quiz/' . $quiz->id . '/statistiques') }}" class="btn btn-sm btn-outline-info">
                    <i class="ti ti-chart-bar me-1"></i> Voir tout
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Élève</th>
                                <th>Score</th>
                                <th>Temps</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meilleursScores as $resultat)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($resultat->user->name) }}&background=3b82f6&color=fff&size=32" 
                                             class="rounded-circle me-2" width="32" height="32" alt="{{ $resultat->user->name }}">
                                        {{ $resultat->user->name }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $totalQuestions = $quiz->questions->count();
                                        $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100) : 0;
                                    @endphp
                                    <span class="badge bg-{{ $pourcentage >= $quiz->score_passer ? 'success' : 'warning' }}">
                                        {{ $resultat->score }}/{{ $totalQuestions }} ({{ $pourcentage }}%)
                                    </span>
                                </td>
                                <td>{{ floor($resultat->temps_ecoule / 60) }}:{{ str_pad($resultat->temps_ecoule % 60, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $resultat->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="ti ti-users fs-4 text-muted mb-2"></i>
                                    <p class="text-muted">Aucune participation</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection