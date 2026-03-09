@extends('layouts.admin')

@section('title', 'Détail du Chapitre')
@section('page-title', 'Détail du Chapitre')
@section('breadcrumb', 'Chapitres')

@section('content')

<!-- Navigation rapide -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.chapitres.index') }}" class="btn btn-light btn-sm">
            <i class="ti ti-arrow-left me-1"></i>Retour à la liste
        </a>
    </div>
    <div class="btn-group">
        @if($chapitrePrecedent)
            <a href="{{ route('admin.chapitres.show', $chapitrePrecedent) }}" class="btn btn-outline-secondary btn-sm">
                <i class="ti ti-chevron-left me-1"></i>Précédent
            </a>
        @endif
        @if($chapitreSuivant)
            <a href="{{ route('admin.chapitres.show', $chapitreSuivant) }}" class="btn btn-outline-secondary btn-sm">
                Suivant<i class="ti ti-chevron-right ms-1"></i>
            </a>
        @endif
    </div>
</div>

<!-- Fil d'ariane -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.classes.index') }}">{{ $chapitre->classe->nom }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.matieres.index') }}">{{ $chapitre->matiere->nom }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $chapitre->titre }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Informations principales -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ $chapitre->titre }}</h5>
                    <small class="text-muted">Ordre #{{ $chapitre->ordre }} • Slug: <code>{{ $chapitre->slug }}</code></small>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Description -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3"><i class="ti ti-align-left me-2"></i>Description</h6>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">{{ $chapitre->description ?: 'Aucune description fournie pour ce chapitre.' }}</p>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <small class="text-muted d-block">Statut</small>
                            @if($chapitre->statut)
                                <span class="badge bg-success mt-1">
                                    <i class="ti ti-check me-1"></i>Actif
                                </span>
                            @else
                                <span class="badge bg-secondary mt-1">
                                    <i class="ti ti-x me-1"></i>Inactif
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <small class="text-muted d-block">Créé le</small>
                            <strong class="small">{{ $chapitre->created_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <small class="text-muted d-block">Modifié le</small>
                            <strong class="small">{{ $chapitre->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des contenus -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0"><i class="ti ti-file-text me-2"></i>Contenus du chapitre</h6>
                    <small class="text-muted">{{ $chapitre->contenus->count() }} élément(s)</small>
                </div>
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus me-1"></i>Ajouter un contenu
                </a>
            </div>
            <div class="card-body p-0">
                @if($chapitre->contenus->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($chapitre->contenus as $contenu)
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-secondary">#{{ $contenu->ordre }}</span>
                                        <strong>{{ $contenu->titre }}</strong>
                                        @if(!$contenu->statut)
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </div>
                                    <p class="text-muted small mb-2">{{ Str::limit(strip_tags($contenu->contenu), 150) }}</p>
                                    <div class="d-flex gap-3">
                                        <small class="text-muted">
                                            <i class="ti ti-clock me-1"></i>{{ $contenu->duree_estimee ?? 'Durée non définie' }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="ti ti-video me-1"></i>{{ $contenu->videos_count ?? 0 }} vidéo(s)
                                        </small>
                                        <small class="text-muted">
                                            <i class="ti ti-file me-1"></i>{{ $contenu->documents_count ?? 0 }} document(s)
                                        </small>
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm ms-2">
                                    <a href="#" class="btn btn-outline-info" title="Voir">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary" title="Modifier">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-5">
                        <i class="ti ti-file-text-off fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-3">Aucun contenu dans ce chapitre</p>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i>Ajouter le premier contenu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Colonne latérale -->
    <div class="col-lg-4">
        <!-- Carte Classe (sans route show) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-school me-2"></i>Classe</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="ti ti-users fs-4 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $chapitre->classe->nom }}</h6>
                        <small class="text-muted">{{ $chapitre->classe->description ?? 'Aucune description' }}</small>
                    </div>
                </div>
                <a href="{{ route('admin.chapitres.index', ['classe_id' => $chapitre->classe_id]) }}" class="btn btn-light btn-sm w-100">
                    <i class="ti ti-filter me-1"></i>Voir tous les chapitres de cette classe
                </a>
            </div>
        </div>

        <!-- Carte Matière (sans route show) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-book me-2"></i>Matière</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="ti ti-book fs-4 text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $chapitre->matiere->nom }}</h6>
                        <small class="text-muted">{{ $chapitre->matiere->description ?? 'Aucune description' }}</small>
                    </div>
                </div>
                <a href="{{ route('admin.chapitres.index', ['matiere_id' => $chapitre->matiere_id]) }}" class="btn btn-light btn-sm w-100">
                    <i class="ti ti-filter me-1"></i>Voir tous les chapitres de cette matière
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-chart-bar me-2"></i>Statistiques</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">Progression</small>
                        <small class="text-muted">0%</small>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 0%"></div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="ti ti-file-text me-2 text-primary"></i>Contenus</span>
                        <span class="badge bg-primary rounded-pill">{{ $chapitre->contenus->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="ti ti-video me-2 text-info"></i>Vidéos</span>
                        <span class="badge bg-info rounded-pill">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="ti ti-file me-2 text-warning"></i>Documents</span>
                        <span class="badge bg-warning rounded-pill">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="ti ti-checklist me-2 text-success"></i>Exercices</span>
                        <span class="badge bg-success rounded-pill">0</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-info-circle me-2"></i>Métadonnées</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Slug</dt>
                    <dd class="col-sm-8"><code>{{ $chapitre->slug }}</code></dd>
                    
                    <dt class="col-sm-4">Ordre</dt>
                    <dd class="col-sm-8">#{{ $chapitre->ordre }}</dd>
                    
                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8">{{ $chapitre->id }}</dd>
                    
                    <dt class="col-sm-4">Créé par</dt>
                    <dd class="col-sm-8">Système</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le chapitre <strong>{{ $chapitre->titre }}</strong> ?</p>
                <p class="text-danger mb-0"><small>Cette action est irréversible et supprimera également tous les contenus associés.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.chapitres.destroy', $chapitre) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection