@extends('layouts.admin')

@section('title', 'Gestion des questions - StudyHub Admin')
@section('page-title', 'Gestion des questions')
@section('breadcrumb', 'Questions')

@section('content')
<!-- Statistiques rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-primary bg-opacity-10">
                        <i class="ti ti-question-mark text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total questions</h6>
                        <h3 class="mb-0 fw-bold">{{ $questions->total() }}</h3>
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
                        <i class="ti ti-list-check text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">QCM</h6>
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizQuestion::where('type', 'qcm')->count() }}</h3>
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
                        <i class="ti ti-toggle text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Vrai/Faux</h6>
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizQuestion::where('type', 'vrai_faux')->count() }}</h3>
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
                        <i class="ti ti-text text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Questions ouvertes</h6>
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizQuestion::where('type', 'texte')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Boutons d'action -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Gérez toutes les questions des quiz</p>
    <div>
        <a href="{{ url('admin/questions/import') }}" class="btn btn-outline-primary me-2">
            <i class="ti ti-upload me-1"></i> Importer
        </a>
        <a href="{{ url('admin/questions/export') }}" class="btn btn-outline-success me-2">
            <i class="ti ti-download me-1"></i> Exporter
        </a>
        <a href="{{ url('admin/questions/create') }}" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i> Nouvelle question
        </a>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ url('admin/questions') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-select">
                    <option value="">Tous les quiz</option>
                    @foreach($quizs as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ $quiz->titre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">Tous</option>
                    @foreach($types as $value => $label)
                        <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" class="form-control" placeholder="Titre de la question..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des questions -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des questions</h5>
            <span class="badge bg-primary">{{ $questions->total() }} question(s)</span>
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
                        <th>Question</th>
                        <th>Quiz</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Ordre</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $question)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $question->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($question->image)
                                    <img src="{{ $question->image_url }}" alt="" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                @endif
                                <div>
                                    <a href="{{ url('admin/questions/' . $question->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ Str::limit($question->titre, 50) }}
                                    </a>
                                    <br>
                                    <small class="text-muted">Créée le {{ $question->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ url('admin/quiz/' . $question->quiz_id) }}" class="text-decoration-none">
                                {{ Str::limit($question->quiz->titre, 30) }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                <i class="{{ $question->type_icon }} me-1"></i>
                                {{ $question->type_libelle }}
                            </span>
                        </td>
                        <td><span class="badge bg-success">{{ $question->points }}</span></td>
                        <td><span class="badge bg-secondary">{{ $question->ordre }}</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('admin/questions/' . $question->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ url('admin/questions/' . $question->id . '/edit') }}" class="btn btn-sm btn-outline-info" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ url('admin/questions/' . $question->id . '/duplicate') }}" method="POST">
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
                                              onsubmit="return confirm('Supprimer cette question ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="ti ti-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="ti ti-question-mark fs-1 text-muted mb-3"></i>
                            <h5>Aucune question trouvée</h5>
                            <a href="{{ url('admin/questions/create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i> Créer une question
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
                    <i class="ti ti-trash"></i> Supprimer la sélection
                </button>
            </div>
            <div>
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });

    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            alert('Sélectionnez des questions');
            return;
        }
        if (confirm(`Supprimer ${selected.length} question(s) ?`)) {
            // Implémenter la suppression groupée
        }
    }
</script>
@endpush