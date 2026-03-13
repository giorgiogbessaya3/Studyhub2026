@extends('layouts.admin')

@section('title', 'Résultats des quiz - StudyHub Admin')
@section('page-title', 'Résultats des quiz')
@section('breadcrumb', 'Quiz / Résultats')

@section('content')
<!-- Statistiques rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-primary bg-opacity-10">
                        <i class="ti ti-chart-bar text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total participations</h6>
                        <h3 class="mb-0 fw-bold">{{ $resultats->total() }}</h3>
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
                        <h6 class="text-muted mb-1">Réussites</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['reussites'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-danger bg-opacity-10">
                        <i class="ti ti-x text-danger fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Échecs</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['echecs'] ?? 0 }}</h3>
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
                        <i class="ti ti-users text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Participants</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['participants_uniques'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ url('admin/resultats') }}" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-select">
                    <option value="">Tous les quiz</option>
                    @foreach($quizs ?? [] as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ Str::limit($quiz->titre, 30) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Utilisateur</label>
                <select name="user_id" class="form-select">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="">Tous</option>
                    <option value="reussi" {{ request('statut') == 'reussi' ? 'selected' : '' }}>Réussi</option>
                    <option value="echoue" {{ request('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date début</label>
                <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date fin</label>
                <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i> Filtrer
                </button>
                @if(request()->anyFilled(['quiz_id', 'user_id', 'statut', 'date_debut', 'date_fin']))
                    <a href="{{ url('admin/resultats') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-x"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Liste des résultats -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des résultats</h5>
        <div>
            <a href="{{ url('admin/resultats/export/all') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn btn-sm btn-success">
                <i class="ti ti-download me-1"></i> Exporter tous
            </a>
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
                        <th>Utilisateur</th>
                        <th>Quiz</th>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Score</th>
                        <th>Réussite</th>
                        <th>Temps</th>
                        <th>Date</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resultats as $resultat)
                    @php
                        $totalQuestions = $resultat->quiz->questions->count();
                        $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
                        $seuilReussite = $resultat->quiz->score_passer ?? 50;
                        $estReussi = $pourcentage >= $seuilReussite;
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $resultat->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($resultat->user->name) }}&background=3b82f6&color=fff&size=32" 
                                     class="rounded-circle me-2" width="32" height="32" alt="">
                                <div>
                                    <span class="fw-medium">{{ $resultat->user->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $resultat->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ url('admin/quiz/' . $resultat->quiz_id) }}" class="text-decoration-none">
                                {{ Str::limit($resultat->quiz->titre, 30) }}
                            </a>
                        </td>
                        <td>{{ $resultat->quiz->classe->nom ?? 'N/A' }}</td>
                        <td>{{ $resultat->quiz->matiere->nom ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $resultat->score }}/{{ $totalQuestions }}</span>
                            <br>
                            <small class="text-muted">{{ $pourcentage }}%</small>
                        </td>
                        <td>
                            @if($estReussi)
                                <span class="badge bg-success">
                                    <i class="ti ti-check me-1"></i> Réussi
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="ti ti-x me-1"></i> Échoué
                                </span>
                            @endif
                        </td>
                        <td>{{ $resultat->temps_formate ?? floor($resultat->temps_ecoule / 60) . ':' . str_pad($resultat->temps_ecoule % 60, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $resultat->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('admin/resultats/' . $resultat->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteResultat({{ $resultat->id }})" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="ti ti-chart-bar fs-1 text-muted mb-3"></i>
                            <h5>Aucun résultat trouvé</h5>
                            <p class="text-muted">Les résultats apparaîtront lorsque des utilisateurs auront participé aux quiz.</p>
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
                <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()" id="bulkDeleteBtn" disabled>
                    <i class="ti ti-trash me-1"></i> Supprimer la sélection (<span id="selectedCount">0</span>)
                </button>
            </div>
            <div>
                {{ $resultats->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression individuelle caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Formulaire de suppression groupée caché -->
<form id="bulkDeleteForm" method="POST" action="{{ url('admin/resultats/bulk-delete') }}" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulkDeleteIds">
</form>
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

        // Initial update
        updateBulkActions();
    });

    function deleteResultat(id) {
        if (confirm('Supprimer ce résultat ?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/resultats") }}/' + id;
            form.submit();
        }
    }

    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        
        if (selected.length === 0) {
            alert('Veuillez sélectionner au moins un résultat.');
            return;
        }

        if (confirm(`Êtes-vous sûr de vouloir supprimer ${selected.length} résultat(s) ?`)) {
            document.getElementById('bulkDeleteIds').value = selected.join(',');
            document.getElementById('bulkDeleteForm').submit();
        }
    }
</script>
@endpush

@push('styles')
<style>
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem;
    }
    .form-check-input:indeterminate {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
</style>
@endpush