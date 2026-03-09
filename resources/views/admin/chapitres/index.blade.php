@extends('layouts.admin')

@section('title', 'Gestion des Chapitres')
@section('page-title', 'Gestion des Chapitres')
@section('breadcrumb', 'Organisation pédagogique')

@section('content')

<!-- En-tête avec actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="text-muted mb-0">
            <i class="ti ti-books me-2"></i>Liste des chapitres
        </h5>
    </div>
    <a href="{{ route('admin.chapitres.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Nouveau chapitre
    </a>
</div>

<!-- Statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm bg-gradient-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                        <i class="ti ti-books fs-3 text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-1">Total chapitres</h6>
                        <h3 class="text-white mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm bg-gradient-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                        <i class="ti ti-check fs-3 text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-1">Chapitres actifs</h6>
                        <h3 class="text-white mb-0">{{ $stats['actifs'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm bg-gradient-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                        <i class="ti ti-school fs-3 text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-1">Classes</h6>
                        <h3 class="text-white mb-0">{{ $classes->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm bg-gradient-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                        <i class="ti ti-book fs-3 text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-1">Matières</h6>
                        <h3 class="text-white mb-0">{{ $matieres->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres avancés -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <i class="ti ti-filter me-2 text-primary"></i>
            <h6 class="mb-0">Filtres de recherche</h6>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.chapitres.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">
                    <i class="ti ti-school me-1"></i>Filtrer par classe
                </label>
                <select name="classe_id" class="form-select">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">
                    <i class="ti ti-book me-1"></i>Filtrer par matière
                </label>
                <select name="matiere_id" class="form-select">
                    <option value="">Toutes les matières</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="ti ti-filter me-1"></i>Filtrer
                </button>
                <a href="{{ route('admin.chapitres.index') }}" class="btn btn-outline-muted">
                    <i class="ti ti-x me-1"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Barre d'information des filtres actifs -->
@if(request('classe_id') || request('matiere_id'))
<div class="alert alert-info alert-dismissible fade show py-2 mb-4" role="alert">
    <i class="ti ti-info-circle me-2"></i>
    Filtres actifs : 
    @if(request('classe_id'))
        <span class="badge bg-info text-white me-2">
            Classe: {{ $classes->find(request('classe_id'))?->nom ?? 'N/A' }}
        </span>
    @endif
    @if(request('matiere_id'))
        <span class="badge bg-info text-white me-2">
            Matière: {{ $matieres->find(request('matiere_id'))?->nom ?? 'N/A' }}
        </span>
    @endif
    <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Résultats et compteur -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">
        <i class="ti ti-list me-1"></i>
        {{ $chapitres->total() }} chapitre(s) trouvé(s)
    </p>
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-outline-secondary active" data-view="grid">
            <i class="ti ti-layout-grid"></i>
        </button>
        <button type="button" class="btn btn-outline-secondary" data-view="list">
            <i class="ti ti-layout-list"></i>
        </button>
    </div>
</div>

<!-- Liste des chapitres (Vue Grid) -->
<div class="row g-4 mb-4" id="grid-view">
    @forelse($chapitres as $chapitre)
    <div class="col-xl-4 col-lg-6">
        <div class="card border-0 shadow-sm h-100 chapitre-card">
            <!-- En-tête avec image placeholder -->
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-dark">
                            <i class="ti ti-school me-1"></i>{{ $chapitre->classe->nom }}
                        </span>
                        <span class="badge bg-primary">
                            <i class="ti ti-book me-1"></i>{{ $chapitre->matiere->nom }}
                        </span>
                    </div>
                    <span class="badge bg-secondary rounded-pill">
                        <i class="ti ti-hash me-1"></i>{{ $chapitre->ordre }}
                    </span>
                </div>
            </div>
            
            <div class="card-body p-4 pt-2">
                <!-- Titre et statut -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if($chapitre->statut)
                        <span class="badge bg-success bg-opacity-10 text-success p-2" title="Actif">
                            <i class="ti ti-check"></i>
                        </span>
                    @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary p-2" title="Inactif">
                            <i class="ti ti-x"></i>
                        </span>
                    @endif
                    <h5 class="card-title mb-0 text-truncate">{{ $chapitre->titre }}</h5>
                </div>

                <!-- Description -->
                <p class="text-muted small mb-3" style="min-height: 3em;">
                    {{ Str::limit($chapitre->description, 100) ?: 'Aucune description' }}
                </p>

                <!-- Métadonnées -->
                <div class="d-flex gap-3 mb-3">
                    <small class="text-muted">
                        <i class="ti ti-file-text me-1"></i>
                        {{ $chapitre->contenus_count ?? 0 }} contenu(s)
                    </small>
                    <small class="text-muted">
                        <i class="ti ti-clock me-1"></i>
                        {{ $chapitre->created_at->diffForHumans() }}
                    </small>
                </div>

                <!-- Slug -->
                <div class="bg-light rounded p-2 mb-3">
                    <small class="text-muted d-block text-truncate">
                        <i class="ti ti-link me-1"></i>{{ $chapitre->slug }}
                    </small>
                </div>
            </div>

            <!-- Actions -->
            <div class="card-footer bg-white border-0 pb-4 px-4">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.chapitres.show', $chapitre) }}" 
                       class="btn btn-sm btn-info flex-fill" 
                       title="Voir les détails">
                        <i class="ti ti-eye me-1"></i>Voir
                    </a>
                    <a href="{{ route('admin.chapitres.edit', $chapitre) }}" 
                       class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.chapitres.destroy', $chapitre) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chapitre ? Cette action est irréversible.')">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <i class="ti ti-books fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted mb-3">Aucun chapitre trouvé</h5>
                <p class="text-muted small mb-4">
                    @if(request('classe_id') || request('matiere_id'))
                        Aucun chapitre ne correspond aux filtres sélectionnés.<br>
                        Essayez de modifier vos critères de recherche ou
                    @else
                        Commencez par créer votre premier chapitre pour organiser vos contenus pédagogiques.
                    @endif
                </p>
                <a href="{{ route('admin.chapitres.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Créer un chapitre
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Vue Liste (cachée par défaut) -->
<div class="card border-0 shadow-sm mb-4 d-none" id="list-view">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Ordre</th>
                        <th>Titre</th>
                        <th>Classe</th>
                        <th>matière</th>
                        <th>Statut</th>
                        <th>Contenus</th>
                        <th>Créé le</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapitres as $chapitre)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-secondary">#{{ $chapitre->ordre }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $chapitre->titre }}</div>
                            <small class="text-muted">{{ Str::limit($chapitre->description, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark">
                                <i class="ti ti-school me-1"></i>{{ $chapitre->classe->nom }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                <i class="ti ti-book me-1"></i>{{ $chapitre->matiere->nom }}
                            </span>
                        </td>
                        <td>
                            @if($chapitre->statut)
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="ti ti-check me-1"></i>Actif
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="ti ti-x me-1"></i>Inactif
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $chapitre->contenus_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <small>{{ $chapitre->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.chapitres.show', $chapitre) }}" 
                                   class="btn btn-info" 
                                   title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('admin.chapitres.edit', $chapitre) }}" 
                                   class="btn btn-outline-primary" 
                                   title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('admin.chapitres.destroy', $chapitre) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger" 
                                            title="Supprimer"
                                            onclick="return confirm('Supprimer ce chapitre ?')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="ti ti-books fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">Aucun chapitre trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($chapitres->hasPages())
<div class="d-flex justify-content-between align-items-center">
    <div class="text-muted small">
        Affichage de {{ $chapitres->firstItem() }} à {{ $chapitres->lastItem() }} sur {{ $chapitres->total() }} chapitres
    </div>
    <div>
        {{ $chapitres->appends(request()->query())->links() }}
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    /* Styles pour les cartes de chapitres */
    .chapitre-card {
        transition: all 0.3s ease;
        border-top: 4px solid transparent;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .chapitre-card:hover {
        transform: translateY(-5px);
        border-top-color: #2563eb;
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.1) !important;
    }
    
    /* Badges et boutons */
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
    
    .btn-group .btn {
        transition: all 0.2s;
    }
    
    /* Cartes de statistiques */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6b868 0%, #ee6b2e 100%);
    }
    
    /* Animation pour les alertes */
    .alert {
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Gestionnaire pour le changement de vue (Grid/Liste)
    document.addEventListener('DOMContentLoaded', function() {
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const viewButtons = document.querySelectorAll('[data-view]');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const view = this.dataset.view;
                
                // Mise à jour des boutons
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Changement de vue
                if (view === 'grid') {
                    gridView.classList.remove('d-none');
                    listView.classList.add('d-none');
                } else {
                    gridView.classList.add('d-none');
                    listView.classList.remove('d-none');
                }
                
                // Sauvegarde de la préférence
                localStorage.setItem('chapitres_view_preference', view);
            });
        });
        
        // Chargement de la préférence sauvegardée
        const savedView = localStorage.getItem('chapitres_view_preference');
        if (savedView) {
            const button = document.querySelector(`[data-view="${savedView}"]`);
            if (button) {
                button.click();
            }
        }
    });
    
    // Animation de suppression
    function confirmDelete(event, form) {
        event.preventDefault();
        
        if (confirm('Êtes-vous sûr de vouloir supprimer ce chapitre ? Cette action est irréversible.')) {
            const button = event.target.closest('button');
            button.disabled = true;
            button.innerHTML = '<i class="ti ti-loader animate-spin"></i>';
            
            form.submit();
        }
        
        return false;
    }
</script>
@endpush