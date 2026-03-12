@extends('layouts.admin')

@section('title', 'Gestion des questions - StudyHub Admin')
@section('page-title', 'Assistance pédagogique')
@section('breadcrumb', 'Questions des élèves')

@section('content')

<!-- Statistiques rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3" style="background-color: #e9ecef;">
                        <i class="ti ti-message-circle text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total questions</h6>
                        <h3 class="mb-0">{{ $statistiques['en_attente'] + $statistiques['questions_publiees'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3" style="background-color: #fff3cd;">
                        <i class="ti ti-clock text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">En attente</h6>
                        <h3 class="mb-0 text-warning">{{ $statistiques['en_attente'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3" style="background-color: #d1e7dd;">
                        <i class="ti ti-check text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Taux de réponse</h6>
                        <h3 class="mb-0 text-success">{{ $statistiques['taux_reponse'] ?? 0 }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded p-3 me-3" style="background-color: #cfe2ff;">
                        <i class="ti ti-hourglass text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Tps moyen réponse</h6>
                        <h3 class="mb-0 text-info">{{ $statistiques['temps_moyen_reponse'] ?? 'N/A' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.assistance.questions') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="publiee" {{ request('statut') == 'publiee' ? 'selected' : '' }}>Publiée</option>
                    <option value="resolue" {{ request('statut') == 'resolue' ? 'selected' : '' }}>Résolue</option>
                    <option value="fermee" {{ request('statut') == 'fermee' ? 'selected' : '' }}>Fermée</option>
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
                <input type="text" name="search" class="form-control" placeholder="Titre, contenu..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i> Filtrer
                </button>
            </div>
            
            <div class="col-12">
                <a href="{{ route('admin.assistance.questions') }}" class="btn btn-sm btn-light">
                    <i class="ti ti-x"></i> Réinitialiser
                </a>
                <a href="{{ route('admin.assistance.statistiques') }}" class="btn btn-sm btn-info">
                    <i class="ti ti-chart-bar"></i> Statistiques détaillées
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des questions -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des questions</h5>
            <span class="badge bg-primary">{{ $questions->total() }} questions</span>
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
                        <th>Auteur</th>
                        <th>Classe/Matière</th>
                        <th>Réponses</th>
                        <th>Vues</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $question)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $question->id }}">
                        </td>
                        <td>
                            <div>
                                <a href="{{ route('admin.assistance.questions.show', $question) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ Str::limit($question->titre, 50) }}
                                </a>
                                @if($question->image)
                                    <i class="ti ti-photo text-muted ms-1" title="Image jointe"></i>
                                @endif
                            </div>
                            <small class="text-muted">{{ Str::limit(strip_tags($question->contenu), 80) }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="ti ti-user text-secondary"></i>
                                </div>
                                <div>
                                    <div>{{ $question->user?->name ?? 'Anonyme' }}</div>
                                    <small class="text-muted">{{ $question->user?->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $question->classe?->nom ?? 'N/A' }}</span>
                            <br>
                            <small>{{ $question->matiere?->nom ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $question->reponses_count > 0 ? 'success' : 'secondary' }}">
                                {{ $question->reponses_count }}
                            </span>
                        </td>
                        <td>{{ $question->views }}</td>
                        <td>
                            {!! $question->statut_badge !!}
                            @if($question->statut == 'resolue')
                                <i class="ti ti-check-circle text-success ms-1" title="Résolue"></i>
                            @endif
                        </td>
                        <td>
                            <div>{{ $question->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $question->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.assistance.questions.show', $question) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                
                                @if($question->statut == 'en_attente')
                                <form action="{{ route('admin.assistance.questions.toggle-publish', $question) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Publier">
                                        <i class="ti ti-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.assistance.questions.destroy', $question) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Supprimer cette question ?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="ti ti-message-circle fs-1 text-muted mb-3"></i>
                            <h5>Aucune question trouvée</h5>
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
                <button class="btn btn-sm btn-outline-success" onclick="bulkPublish()">
                    <i class="ti ti-check"></i> Publier
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
    // Sélection multiple
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });
    
    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) return alert('Sélectionnez des questions');
        
        if (confirm(`Supprimer ${selected.length} question(s) ?`)) {
            // Implémenter la suppression groupée via AJAX
            console.log('Supprimer:', selected);
        }
    }
    
    function bulkPublish() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        if (selected.length === 0) return alert('Sélectionnez des questions');
        
        if (confirm(`Publier ${selected.length} question(s) ?`)) {
            // Implémenter la publication groupée via AJAX
            console.log('Publier:', selected);
        }
    }
</script>
@endpush