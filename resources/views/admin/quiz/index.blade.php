@extends('layouts.admin')

@section('title', 'Gestion des Quiz - StudyHub Admin')
@section('page-title', 'Gestion des Quiz')
@section('breadcrumb', 'Quiz')

@section('content')
<!-- Statistiques rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="ti ti-books text-white fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Quiz</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-success bg-opacity-10">
                        <i class="ti ti-check text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Publiés</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['publies'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-warning bg-opacity-10">
                        <i class="ti ti-clock text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Brouillons</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['brouillons'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-info bg-opacity-10">
                        <i class="ti ti-question-mark text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Questions</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['questions'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bouton ajouter -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Gérez tous les quiz de la plateforme</p>
    <a href="{{ url('admin/quiz/create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Nouveau quiz
    </a>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ url('admin/quiz') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="">Tous</option>
                    <option value="publie" {{ request('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                    <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="archive" {{ request('statut') == 'archive' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Classe</label>
                <select name="classe_id" class="form-select">
                    <option value="">Toutes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Matière</label>
                <select name="matiere_id" class="form-select">
                    <option value="">Toutes</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" class="form-control" placeholder="Titre..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des quiz -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des quiz</h5>
            <span class="badge bg-primary">{{ $quizzes->total() }} quiz</span>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Quiz</th>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Questions</th>
                        <th>Durée</th>
                        <th>Tentatives</th>
                        <th>Statut</th>
                        <th>Créé par</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $quiz->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($quiz->image)
                                    <img src="{{ $quiz->image_url }}" alt="" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="rounded me-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ti ti-article text-primary"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ url('admin/quiz/' . $quiz->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ Str::limit($quiz->titre, 40) }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $quiz->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $quiz->classe->nom }}</td>
                        <td>{{ $quiz->matiere->nom }}</td>
                        <td>
                            <span class="badge bg-info">{{ $quiz->questions_count }}</span>
                        </td>
                        <td>{{ $quiz->duree_formatee }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $quiz->nombre_tentatives }}</span>
                        </td>
                        <td>
                            @if($quiz->statut == 'publie')
                                <span class="badge bg-success">Publié</span>
                            @elseif($quiz->statut == 'brouillon')
                                <span class="badge bg-secondary">Brouillon</span>
                            @else
                                <span class="badge bg-warning">Archivé</span>
                            @endif
                        </td>
                        <td>{{ $quiz->createur->name ?? 'N/A' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('admin/quiz/' . $quiz->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ url('admin/quiz/' . $quiz->id . '/edit') }}" class="btn btn-sm btn-outline-info" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="{{ url('admin/quiz/' . $quiz->id . '/questions') }}" class="btn btn-sm btn-outline-success" title="Questions">
                                    <i class="ti ti-list"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots"></i>
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
                                    <li>
                                        <a href="{{ url('admin/quiz/' . $quiz->id . '/statistiques') }}" class="dropdown-item">
                                            <i class="ti ti-chart-bar me-2"></i>
                                            Statistiques
                                        </a>
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="ti ti-books fs-1 text-muted mb-3"></i>
                            <h5>Aucun quiz trouvé</h5>
                            <a href="{{ url('admin/quiz/create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i> Créer un quiz
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                    <i class="ti ti-trash"></i> Supprimer
                </button>
            </div>
            <div>
                {{ $quizzes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });

    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            alert('Sélectionnez des quiz');
            return;
        }
        if (confirm(`Supprimer ${selected.length} quiz ?`)) {
            // Implémenter la suppression groupée
        }
    }
</script>
@endpush