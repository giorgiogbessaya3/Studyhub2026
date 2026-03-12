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
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizResultat::whereRaw('score >= (SELECT score_passer FROM quizzes WHERE quizzes.id = quiz_resultats.quiz_id)')->count() }}</h3>
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
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizResultat::whereRaw('score < (SELECT score_passer FROM quizzes WHERE quizzes.id = quiz_resultats.quiz_id)')->count() }}</h3>
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
                        <h3 class="mb-0 fw-bold">{{ App\Models\QuizResultat::distinct('user_id')->count('user_id') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ url('admin/quiz/resultats') }}" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-select">
                    <option value="">Tous les quiz</option>
                    @foreach(App\Models\Quiz::orderBy('titre')->get() as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ Str::limit($quiz->titre, 30) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Élève</label>
                <select name="user_id" class="form-select">
                    <option value="">Tous les élèves</option>
                    @foreach(App\Models\User::where('role', 'eleve')->orderBy('name')->get() as $user)
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
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des résultats -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des résultats</h5>
        <div>
            <a href="{{ url('admin/quiz/resultats/export') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn btn-sm btn-success">
                <i class="ti ti-download me-1"></i> Exporter
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
                        <th>Élève</th>
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
                        $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100) : 0;
                        $estReussi = $pourcentage >= $resultat->quiz->score_passer;
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
                        <td>{{ floor($resultat->temps_ecoule / 60) }}:{{ str_pad($resultat->temps_ecoule % 60, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $resultat->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('admin/quiz/resultats/' . $resultat->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
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
                            <p class="text-muted">Les résultats apparaîtront lorsque des élèves auront participé aux quiz.</p>
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
                {{ $resultats->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });

    function deleteResultat(id) {
        if (confirm('Supprimer ce résultat ?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/quiz/resultats") }}/' + id;
            form.submit();
        }
    }

    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            alert('Sélectionnez des résultats');
            return;
        }
        if (confirm(`Supprimer ${selected.length} résultat(s) ?`)) {
            // Implémenter la suppression groupée
        }
    }
</script>
@endpush