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
                        <h3 class="mb-0 fw-bold">{{ $stats['qcm'] ?? 0 }}</h3>
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
                        <h3 class="mb-0 fw-bold">{{ $stats['vrai_faux'] ?? 0 }}</h3>
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
                        <h3 class="mb-0 fw-bold">{{ $stats['texte'] ?? 0 }}</h3>
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
        <a href="{{ url('admin/questions/export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-outline-success me-2">
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
        <form method="GET" action="{{ url('admin/questions') }}" class="row g-3" id="filterForm">
            <div class="col-md-3">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-select" onchange="this.form.submit()">
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
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">Tous les types</option>
                    @foreach($types as $value => $label)
                        <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Recherche</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Titre de la question..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-search"></i>
                    </button>
                    @if(request()->anyFilled(['quiz_id', 'type', 'search']))
                        <a href="{{ url('admin/questions') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x"></i> Réinitialiser
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="dropdown w-100">
                    <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="ti ti-sort-ascending me-1"></i> Trier par
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request('order_by', 'created_at') == 'created_at' ? 'active' : '' }}" 
                               href="{{ url('admin/questions?' . http_build_query(array_merge(request()->all(), ['order_by' => 'created_at', 'order_dir' => request('order_dir') == 'asc' ? 'desc' : 'asc']))) }}">
                                Date de création
                                @if(request('order_by') == 'created_at')
                                    <i class="ti ti-chevron-{{ request('order_dir', 'desc') == 'asc' ? 'up' : 'down' }} float-end"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('order_by') == 'points' ? 'active' : '' }}" 
                               href="{{ url('admin/questions?' . http_build_query(array_merge(request()->all(), ['order_by' => 'points', 'order_dir' => request('order_dir') == 'asc' ? 'desc' : 'asc']))) }}">
                                Points
                                @if(request('order_by') == 'points')
                                    <i class="ti ti-chevron-{{ request('order_dir', 'desc') == 'asc' ? 'up' : 'down' }} float-end"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('order_by') == 'ordre' ? 'active' : '' }}" 
                               href="{{ url('admin/questions?' . http_build_query(array_merge(request()->all(), ['order_by' => 'ordre', 'order_dir' => request('order_dir') == 'asc' ? 'desc' : 'asc']))) }}">
                                Ordre
                                @if(request('order_by') == 'ordre')
                                    <i class="ti ti-chevron-{{ request('order_dir', 'desc') == 'asc' ? 'up' : 'down' }} float-end"></i>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
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
                        <th width="180">Actions</th>
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
                                    <img src="{{ Storage::url($question->image) }}" alt="" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ti ti-photo text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ url('admin/questions/' . $question->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ Str::limit($question->titre, 60) }}
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        <i class="ti ti-calendar me-1"></i> {{ $question->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ url('admin/quiz/' . $question->quiz_id) }}" class="text-decoration-none">
                                <span class="badge bg-info bg-opacity-10 text-info p-2">
                                    {{ Str::limit($question->quiz->titre, 30) }}
                                </span>
                            </a>
                            @if($question->quiz->statut == 'publie')
                                <span class="badge bg-success ms-1">Publié</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $question->type == 'qcm' ? 'bg-primary' : ($question->type == 'vrai_faux' ? 'bg-warning' : 'bg-info') }}">
                                <i class="{{ $question->type_icon }} me-1"></i>
                                {{ $question->type_libelle }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $question->ordre }}</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('admin/questions/' . $question->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ url('admin/questions/' . $question->id . '/edit') }}" class="btn btn-sm btn-outline-info" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                    <span class="visually-hidden">Toggle Dropdown</span>
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
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ? Cette action est irréversible.')">
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
                            <div class="py-4">
                                <i class="ti ti-questions fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted mb-3">Aucune question trouvée</h5>
                                @if(request()->anyFilled(['quiz_id', 'type', 'search']))
                                    <p class="text-muted mb-3">Aucune question ne correspond à vos critères de recherche.</p>
                                    <a href="{{ url('admin/questions') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-x me-1"></i> Effacer les filtres
                                    </a>
                                @else
                                    <a href="{{ url('admin/questions/create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> Créer votre première question
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($questions->hasPages())
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Affichage de {{ $questions->firstItem() }} à {{ $questions->lastItem() }} sur {{ $questions->total() }} questions
            </div>
            <div>
                {{ $questions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    @endif
    
    @if($questions->isNotEmpty())
    <div class="card-footer bg-white py-3 border-top">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()" id="bulkDeleteBtn" disabled>
                    <i class="ti ti-trash me-1"></i> Supprimer la sélection (<span id="selectedCount">0</span>)
                </button>
            </div>
        </div>
    </div>
    
    <!-- Formulaire de suppression groupée caché - sans route -->
    <form id="bulkDeleteForm" method="POST" action="{{ url('admin/questions/bulk-delete') }}" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="bulkDeleteIds">
    </form>
    @endif
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.select-item');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');

        function updateBulkActions() {
            const checked = document.querySelectorAll('.select-item:checked');
            const count = checked.length;
            
            if (selectedCountSpan) {
                selectedCountSpan.textContent = count;
            }
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = count === 0;
            }
            
            if (selectAll) {
                selectAll.checked = checkboxes.length > 0 && count === checkboxes.length;
                selectAll.indeterminate = count > 0 && count < checkboxes.length;
            }
        }

        // Select All
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateBulkActions();
            });
        }

        // Individual checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        // Bulk Delete
        window.bulkDelete = function() {
            const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
            
            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aucune sélection',
                    text: 'Veuillez sélectionner au moins une question.'
                });
                return;
            }

            Swal.fire({
                title: 'Confirmation',
                text: `Êtes-vous sûr de vouloir supprimer ${selected.length} question(s) ? Cette action est irréversible.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bulkDeleteIds').value = selected.join(',');
                    document.getElementById('bulkDeleteForm').submit();
                }
            });
        };
    });

    // Notifications avec SweetAlert
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

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .dropdown-toggle-split {
        padding: 0.375rem 0.5rem;
    }
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .form-check-input:indeterminate {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
</style>
@endpush