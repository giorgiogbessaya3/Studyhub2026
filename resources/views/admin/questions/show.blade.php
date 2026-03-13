@extends('layouts.admin')

@section('title', 'Détail de la question - StudyHub Admin')
@section('page-title', 'Détail de la question')
@section('breadcrumb', 'Questions / Détail')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- En-tête avec actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-question-mark me-2 text-primary"></i>
                    Détail de la question #{{ $question->id }}
                </h5>
                <div class="btn-group">
                    <a href="{{ url('admin/questions/' . $question->id . '/edit') }}" class="btn btn-sm btn-outline-info">
                        <i class="ti ti-edit me-1"></i> Modifier
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ url('admin/questions/' . $question->id . '/duplicate') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti ti-copy me-2"></i> Dupliquer
                                </button>
                            </form>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ url('admin/questions/' . $question->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="ti ti-trash me-2"></i> Supprimer
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Informations générales -->
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted mb-2">Question</h6>
                            <div class="bg-light p-4 rounded">
                                <p class="fs-5 mb-0">{{ $question->titre }}</p>
                            </div>
                        </div>

                        <!-- Type spécifique -->
                        @if($question->type == 'qcm' && $question->options)
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted mb-2">Options de réponse</h6>
                            <div class="row g-2">
                                @foreach($question->options as $index => $option)
                                <div class="col-md-6">
                                    <div class="card border-0 {{ chr(65 + $index) == $question->bonne_reponse ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ chr(65 + $index) == $question->bonne_reponse ? 'bg-success' : 'bg-secondary' }} me-2">
                                                    {{ chr(65 + $index) }}
                                                </span>
                                                <span class="flex-grow-1">{{ $option }}</span>
                                                @if(chr(65 + $index) == $question->bonne_reponse)
                                                    <i class="ti ti-check text-success ms-2" title="Bonne réponse"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($question->type == 'vrai_faux')
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted mb-2">Options de réponse</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="card border-0 {{ $question->bonne_reponse == 'vrai' ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $question->bonne_reponse == 'vrai' ? 'bg-success' : 'bg-secondary' }} me-2">V</span>
                                                <span class="flex-grow-1">Vrai</span>
                                                @if($question->bonne_reponse == 'vrai')
                                                    <i class="ti ti-check text-success ms-2"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 {{ $question->bonne_reponse == 'faux' ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $question->bonne_reponse == 'faux' ? 'bg-success' : 'bg-secondary' }} me-2">F</span>
                                                <span class="flex-grow-1">Faux</span>
                                                @if($question->bonne_reponse == 'faux')
                                                    <i class="ti ti-check text-success ms-2"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($question->type == 'texte')
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted mb-2">Réponse attendue</h6>
                            <div class="bg-success bg-opacity-10 p-4 rounded">
                                <p class="mb-0"><i class="ti ti-quote me-2"></i>{{ $question->bonne_reponse }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Explication -->
                        @if($question->explication)
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted mb-2">Explication</h6>
                            <div class="bg-info bg-opacity-10 p-4 rounded">
                                <p class="mb-0">{{ $question->explication }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Informations secondaires -->
                    <div class="col-md-4">
                        <!-- Image -->
                        @if($question->image)
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body text-center">
                                <h6 class="fw-bold text-muted mb-3">Image associée</h6>
                                <img src="{{ Storage::url($question->image) }}" alt="Question image" class="img-fluid rounded" style="max-height: 200px;">
                                <div class="mt-2">
                                    <a href="{{ Storage::url($question->image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-external-link me-1"></i> Voir en grand
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Informations du quiz -->
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-muted mb-3">Informations du quiz</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Quiz:</strong> 
                                        <a href="{{ url('admin/quiz/' . $question->quiz_id) }}" class="text-decoration-none">
                                            {{ $question->quiz->titre }}
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Classe:</strong> {{ $question->quiz->classe->nom ?? 'N/A' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Matière:</strong> {{ $question->quiz->matiere->nom ?? 'N/A' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Chapitre:</strong> {{ $question->quiz->chapitre->titre ?? 'N/A' }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Métadonnées -->
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-muted mb-3">Métadonnées</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Type:</strong> 
                                        <span class="badge {{ $question->type == 'qcm' ? 'bg-primary' : ($question->type == 'vrai_faux' ? 'bg-warning' : 'bg-info') }}">
                                            <i class="{{ $question->type_icon }} me-1"></i>
                                            {{ $question->type_libelle }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Points:</strong> 
                                        <span class="badge bg-success">{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Ordre:</strong> 
                                        <span class="badge bg-secondary">{{ $question->ordre }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Créée le:</strong> {{ $question->created_at->format('d/m/Y à H:i') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-chevron-right text-primary me-1"></i>
                                        <strong>Dernière modification:</strong> {{ $question->updated_at->format('d/m/Y à H:i') }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Statut du quiz -->
                        <div class="card border-0 {{ $question->quiz->statut == 'publie' ? 'bg-warning' : 'bg-success' }} bg-opacity-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-info-circle fs-4 me-2 {{ $question->quiz->statut == 'publie' ? 'text-warning' : 'text-success' }}"></i>
                                    <div>
                                        <small class="text-muted d-block">Statut du quiz</small>
                                        <strong>{!! $question->quiz->statut_badge !!}</strong>
                                    </div>
                                </div>
                                @if($question->quiz->statut == 'publie')
                                <p class="small text-warning mt-2 mb-0">
                                    <i class="ti ti-alert-triangle me-1"></i>
                                    Attention : Ce quiz est publié. Les modifications sont limitées.
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques d'utilisation -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-chart-bar me-2"></i>Statistiques d'utilisation</h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="display-6 fw-bold text-primary">{{ $stats['total_reponses'] ?? 0 }}</div>
                            <small class="text-muted">Réponses reçues</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="display-6 fw-bold text-success">{{ $stats['bonnes_reponses'] ?? 0 }}</div>
                            <small class="text-muted">Bonnes réponses</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="display-6 fw-bold text-danger">{{ $stats['mauvaises_reponses'] ?? 0 }}</div>
                            <small class="text-muted">Mauvaises réponses</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="display-6 fw-bold text-info">{{ $stats['taux_reussite'] ?? 0 }}%</div>
                            <small class="text-muted">Taux de réussite</small>
                        </div>
                    </div>
                </div>

                @if(($stats['total_reponses'] ?? 0) > 0)
                <div class="mt-4">
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $stats['taux_reussite'] ?? 0 }}%;" 
                             aria-valuenow="{{ $stats['taux_reussite'] ?? 0 }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            {{ $stats['taux_reussite'] ?? 0 }}% réussite
                        </div>
                        <div class="progress-bar bg-danger" role="progressbar" 
                             style="width: {{ 100 - ($stats['taux_reussite'] ?? 0) }}%;" 
                             aria-valuenow="{{ 100 - ($stats['taux_reussite'] ?? 0) }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            {{ 100 - ($stats['taux_reussite'] ?? 0) }}% échec
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Dernières réponses -->
        @if(isset($dernieresReponses) && $dernieresReponses->isNotEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-history me-2"></i>Dernières réponses</h6>
                <a href="{{ url('admin/quiz/resultats?question_id=' . $question->id) }}" class="btn btn-sm btn-outline-primary">
                    Voir toutes les réponses
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Élève</th>
                                <th>Réponse</th>
                                <th>Résultat</th>
                                <th>Date</th>
                                <th>Quiz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dernieresReponses as $reponse)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reponse->user->name) }}&size=32&background=3b82f6&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32" alt="">
                                        <div>
                                            <strong>{{ $reponse->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $reponse->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($question->type == 'qcm' && isset($reponse->reponses[$question->id]))
                                        <span class="badge bg-secondary me-1">{{ $reponse->reponses[$question->id] }}</span>
                                        {{ $question->options[ord($reponse->reponses[$question->id]) - 65] ?? '' }}
                                    @elseif($question->type == 'vrai_faux')
                                        <span class="badge {{ $reponse->reponses[$question->id] == 'vrai' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $reponse->reponses[$question->id] == 'vrai' ? 'Vrai' : 'Faux' }}
                                        </span>
                                    @else
                                        {{ $reponse->reponses[$question->id] ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($reponse->reponses[$question->id]) && $reponse->reponses[$question->id] == $question->bonne_reponse)
                                        <span class="badge bg-success">Correct</span>
                                    @else
                                        <span class="badge bg-danger">Incorrect</span>
                                    @endif
                                </td>
                                <td>{{ $reponse->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ url('admin/quiz/' . $reponse->quiz_id) }}" class="text-decoration-none">
                                        {{ Str::limit($reponse->quiz->titre, 20) }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Navigation et actions -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ url('admin/questions') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> Retour à la liste
            </a>
            <div>
                @if(isset($questionPrecedent) && $questionPrecedent)
                <a href="{{ url('admin/questions/' . $questionPrecedent->id) }}" class="btn btn-outline-primary me-2">
                    <i class="ti ti-arrow-left me-1"></i> Question précédente
                </a>
                @endif
                @if(isset($questionSuivant) && $questionSuivant)
                <a href="{{ url('admin/questions/' . $questionSuivant->id) }}" class="btn btn-outline-primary">
                    Question suivante <i class="ti ti-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@push('styles')
<style>
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    .display-6 {
        font-size: 2.5rem;
        font-weight: 600;
        line-height: 1.2;
    }
    .progress {
        border-radius: 10px;
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function deleteQuestion() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/questions/" . $question->id) }}';
            form.submit();
        }
    }

    // Notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur !',
            text: '{{ session('error') }}',
            timer: 5000,
            showConfirmButton: true
        });
    @endif
</script>
@endpush