@extends('layouts.admin')

@section('title', 'Tableau de bord - StudyHub Admin')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Vue d\'ensemble')

@section('content')
<!-- Stats Cards - Dynamiques -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="ti ti-file-text fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">{{ number_format($stats['epreuves']) }}</h3>
                    <p class="text-muted mb-0 small">Épreuves</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="ti ti-book fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">{{ number_format($stats['cours']) }}</h3>
                    <p class="text-muted mb-0 small">Cours</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="ti ti-users fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">{{ number_format($stats['utilisateurs']) }}</h3>
                    <p class="text-muted mb-0 small">Utilisateurs</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                        <i class="ti ti-help-circle fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">{{ number_format($stats['questions']) }}</h3>
                    <p class="text-muted mb-0 small">Questions en attente</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats supplémentaires (optionnel) -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-primary text-white rounded-3 p-3">
                        <i class="ti ti-question-mark fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold text-primary">{{ number_format($stats['quiz']) }}</h3>
                    <p class="text-muted mb-0 small">Quiz</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-info bg-opacity-10">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-info text-white rounded-3 p-3">
                        <i class="ti ti-mail fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold text-info">{{ number_format($stats['contacts_non_lus']) }}</h3>
                    <p class="text-muted mb-0 small">Messages non lus</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/admin/epreuves/create') }}" class="btn btn-primary btn-sm">
                <i class="ti ti-plus me-1"></i> Épreuve
            </a>
            <a href="{{ url('/admin/chapitres/create') }}" class="btn btn-success btn-sm">
                <i class="ti ti-plus me-1"></i> Cours
            </a>
            <a href="{{ url('/admin/quiz/create') }}" class="btn btn-warning btn-sm text-white">
                <i class="ti ti-plus me-1"></i> Quiz
            </a>
            <a href="{{ url('/admin/users/create') }}" class="btn btn-info btn-sm text-white">
                <i class="ti ti-plus me-1"></i> Utilisateur
            </a>
            <a href="{{ url('/admin/assistance/questions') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                <i class="ti ti-messages me-1"></i> Voir questions
            </a>
        </div>
    </div>
</div>

<!-- Contenu principal -->
<div class="row g-4">
    
    <!-- Dernières épreuves -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Dernières épreuves</h5>
                    <a href="{{ url('/admin/epreuves') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if($dernieresEpreuves->isEmpty())
                    <p class="text-muted text-center py-4">Aucune épreuve récente</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Épreuve</th>
                                    <th>Classe</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dernieresEpreuves as $epreuve)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                                <i class="ti ti-file-text"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">{{ Str::limit($epreuve->titre, 30) }}</div>
                                                <small class="text-muted">{{ $epreuve->matiere->nom ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $epreuve->classe->nom ?? 'N/A' }}</span></td>
                                    <td><span class="badge bg-warning">{{ $epreuve->typeEpreuve->nom ?? 'Épreuve' }}</span></td>
                                    <td class="text-muted small">{{ $epreuve->created_at->diffForHumans() }}</td>
                                    <td class="text-end">
                                        <a href="{{ url('/admin/epreuves/' . $epreuve->id . '/edit') }}" class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></a>
                                        <button class="btn btn-sm btn-light text-danger" onclick="deleteEpreuve({{ $epreuve->id }})"><i class="ti ti-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Derniers cours -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Derniers cours</h5>
                    <a href="{{ url('/admin/chapitres') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if($derniersCours->isEmpty())
                    <p class="text-muted text-center py-4">Aucun cours récent</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Cours</th>
                                    <th>Classe</th>
                                    <th>Matière</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($derniersCours as $cours)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                                <i class="ti ti-book"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">{{ Str::limit($cours->titre, 30) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $cours->classe->nom ?? 'N/A' }}</span></td>
                                    <td>{{ $cours->matiere->nom ?? 'N/A' }}</td>
                                    <td class="text-muted small">{{ $cours->created_at->diffForHumans() }}</td>
                                    <td class="text-end">
                                        <a href="{{ url('/admin/chapitres/' . $cours->id . '/edit') }}" class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></a>
                                        <button class="btn btn-sm btn-light text-danger"><i class="ti ti-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Questions en attente -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Questions en attente</h5>
                    <span class="badge bg-danger">{{ $stats['questions'] }} en attente</span>
                </div>
            </div>
            <div class="card-body p-4">
                @if($questionsEnAttente->isEmpty())
                    <p class="text-muted text-center py-4">Aucune question en attente</p>
                @else
                    @foreach($questionsEnAttente as $question)
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <img src="{{ $question->user->avatar_url ?? asset('admin/images/profile/default.jpg') }}" 
                             class="rounded-circle me-3" width="40" height="40" alt="">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold small">{{ $question->user->name ?? 'Anonyme' }}</div>
                                    <div class="text-muted small">{{ $question->classe->nom ?? 'N/A' }} • {{ $question->matiere->nom ?? 'N/A' }}</div>
                                </div>
                                <span class="badge bg-warning small">En attente</span>
                            </div>
                            <p class="small text-muted mb-0 mt-1">{{ Str::limit($question->titre, 50) }}</p>
                            <div class="mt-2">
                                <a href="{{ url('/admin/assistance/questions/' . $question->id) }}" class="btn btn-sm btn-outline-primary btn-sm">Répondre</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <a href="{{ url('/admin/assistance/questions') }}" class="btn btn-outline-primary w-100 mt-3 btn-sm">
                        Voir toutes les questions
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Derniers quiz -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Derniers quiz</h5>
                    <a href="{{ url('/admin/quiz') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if($derniersQuiz->isEmpty())
                    <p class="text-muted text-center py-4">Aucun quiz récent</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Quiz</th>
                                    <th>Classe</th>
                                    <th>Questions</th>
                                    <th>Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($derniersQuiz as $quiz)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3">
                                                <i class="ti ti-question-mark"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">{{ Str::limit($quiz->titre, 30) }}</div>
                                                <small class="text-muted">{{ $quiz->matiere->nom ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $quiz->classe->nom ?? 'N/A' }}</span></td>
                                    <td>{{ $quiz->questions_count ?? 0 }}</td>
                                    <td>
                                        @if($quiz->statut == 'publie')
                                            <span class="badge bg-success">Publié</span>
                                        @elseif($quiz->statut == 'brouillon')
                                            <span class="badge bg-secondary">Brouillon</span>
                                        @else
                                            <span class="badge bg-warning">Archivé</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/admin/quiz/' . $quiz->id . '/edit') }}" class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></a>
                                        <button class="btn btn-sm btn-light text-danger"><i class="ti ti-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Répartition par classe -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="card-title mb-0 fw-bold">Répartition des épreuves par classe</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    @foreach($classes as $classe)
                    <div class="col-md-3 mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $classe['nom'] }}</span>
                            <span class="fw-semibold">{{ round(($classe['total'] / $totalEpreuves) * 100) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ ($classe['total'] / $totalEpreuves) * 100 }}%"></div>
                        </div>
                        <small class="text-muted">{{ $classe['total'] }} épreuve(s)</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer simple -->
<div class="text-center text-muted small py-4 mt-4 border-top">
    <p class="mb-0">StudyHub © {{ date('Y') }} - Plateforme éducative</p>
</div>

@endsection

@push('scripts')
<script>
    function deleteEpreuve(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette épreuve ?')) {
            // Implémenter la suppression
            console.log('Supprimer épreuve ' + id);
        }
    }
</script>
@endpush