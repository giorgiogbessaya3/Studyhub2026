@extends('layouts.admin')

@section('title', 'Modération des réponses - StudyHub Admin')
@section('page-title', 'Modération des réponses')
@section('breadcrumb', 'Assistance / Réponses à modérer')

@section('content')

<!-- Statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3 bg-warning bg-opacity-10">
                        <i class="ti ti-clock text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">En attente</h6>
                        <h3 class="mb-0 text-warning">{{ $stats['en_attente'] ?? $reponses->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3 bg-success bg-opacity-10">
                        <i class="ti ti-check text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Approuvées</h6>
                        <h3 class="mb-0 text-success">{{ $stats['approuvees'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3 bg-danger bg-opacity-10">
                        <i class="ti ti-x text-danger fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Rejetées</h6>
                        <h3 class="mb-0 text-danger">{{ $stats['rejetees'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3 bg-info bg-opacity-10">
                        <i class="ti ti-message-circle text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total</h6>
                        <h3 class="mb-0 text-info">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.assistance.reponses') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_debut" class="form-control" placeholder="Date début" value="{{ request('date_debut') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_fin" class="form-control" placeholder="Date fin" value="{{ request('date_fin') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter"></i> Filtrer
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.assistance.reponses') }}" class="btn btn-light w-100">
                    <i class="ti ti-refresh"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des réponses -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Réponses en attente de modération</h5>
        <span class="badge bg-warning">{{ $reponses->total() }} réponse(s)</span>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="30">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Réponse</th>
                        <th>Auteur</th>
                        <th>Question</th>
                        <th>Date</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reponses as $reponse)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $reponse->id }}">
                        </td>
                        <td>
                            <div class="text-wrap" style="max-width: 300px;">
                                {{ Str::limit(strip_tags($reponse->contenu), 100) }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($reponse->user?->name ?? 'Anonyme') }}&background=3b82f6&color=fff" 
                                     alt="Avatar" 
                                     class="rounded-circle me-2"
                                     style="width: 32px; height: 32px;">
                                <div>
                                    <strong>{{ $reponse->user?->name ?? 'Anonyme' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $reponse->user?->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.assistance.questions.show', $reponse->question_id) }}" class="text-decoration-none">
                                <strong>{{ Str::limit($reponse->question?->titre ?? 'Question inconnue', 40) }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $reponse->question?->classe?->nom ?? '' }} - {{ $reponse->question?->matiere?->nom ?? '' }}
                                </small>
                            </a>
                        </td>
                        <td>
                            <div>{{ $reponse->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $reponse->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('admin.assistance.reponses.approve', $reponse) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Approuver cette réponse ?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-success" title="Approuver">
                                        <i class="ti ti-check"></i> Approuver
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.assistance.reponses.reject', $reponse) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Rejeter cette réponse ?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-warning" title="Rejeter">
                                        <i class="ti ti-x"></i> Rejeter
                                    </button>
                                </form>
                                
                                <button type="button" 
                                        class="btn btn-sm btn-primary dropdown-toggle" 
                                        data-bs-toggle="dropdown">
                                    <i class="ti ti-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('admin.assistance.questions.show', $reponse->question_id) }}" class="dropdown-item">
                                            <i class="ti ti-eye me-2"></i> Voir la question
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.assistance.reponses.destroy', $reponse) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Supprimer définitivement cette réponse ?')">
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
                        <td colspan="6" class="text-center py-5">
                            <i class="ti ti-check-circle text-success fs-1 mb-3"></i>
                            <h5>Aucune réponse en attente de modération</h5>
                            <p class="text-muted">Toutes les réponses ont été traitées.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($reponses->hasPages())
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                    <i class="ti ti-trash"></i> Supprimer la sélection
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="bulkApprove()">
                    <i class="ti ti-check"></i> Approuver la sélection
                </button>
            </div>
            <div>
                {{ $reponses->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Sélection multiple
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });
    
    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) return alert('Sélectionnez des réponses');
        
        if (confirm(`Supprimer ${selected.length} réponse(s) ?`)) {
            // Implémenter la suppression groupée via AJAX
            console.log('Supprimer:', selected);
        }
    }
    
    function bulkApprove() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) return alert('Sélectionnez des réponses');
        
        if (confirm(`Approuver ${selected.length} réponse(s) ?`)) {
            // Implémenter l'approbation groupée via AJAX
            console.log('Approuver:', selected);
        }
    }
</script>
@endpush