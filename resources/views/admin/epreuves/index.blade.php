@extends('layouts.admin')

@section('title', 'Gestion des épreuves - StudyHub')
@section('page-title', 'Épreuves')
@section('breadcrumb', 'Banque d\'épreuves')

@section('content')
<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-gradient-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-file-text fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['total'] }}</h2>
                        <p class="text-white-75 mb-0">Total épreuves</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-gradient-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-checkbox fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['avec_correction'] }}</h2>
                        <p class="text-white-75 mb-0">Avec correction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-gradient-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-alert-triangle fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['sans_correction'] }}</h2>
                        <p class="text-white-75 mb-0">Sans correction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- En-tête avec bouton d'ajout -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h5 class="text-muted fw-normal mb-0">
            <i class="ti ti-layers-difference me-2"></i>Liste des épreuves
        </h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.epreuves.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="ti ti-plus me-1"></i> Nouvelle épreuve
        </a>
    </div>
</div>

<!-- Liste des épreuves -->
<div class="row g-4">
    @forelse($epreuves as $epreuve)
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
                <!-- Badge type et statut -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-info rounded-pill px-3 py-2">
                        {{ $epreuve->typeEpreuve->nom ?? 'Type inconnu' }}
                    </span>
                    <span class="badge bg-{{ $epreuve->statut ? 'success' : 'secondary' }} rounded-pill">
                        {{ $epreuve->statut ? 'Publiée' : 'Brouillon' }}
                    </span>
                </div>

                <!-- Titre et description -->
                <h5 class="card-title mb-1">{{ $epreuve->titre }}</h5>
                <p class="text-muted small mb-2">{{ Str::limit($epreuve->description ?? 'Aucune description', 80) }}</p>

                <!-- Métadonnées : classe, matière, année, durée, barème -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark">
                        <i class="ti ti-users me-1"></i>{{ $epreuve->classe->nom ?? 'N/A' }}
                    </span>
                    <span class="badge bg-light text-dark">
                        <i class="ti ti-book me-1"></i>{{ $epreuve->matiere->nom ?? 'N/A' }}
                    </span>
                    @if($epreuve->annee)
                    <span class="badge bg-light text-dark">
                        <i class="ti ti-calendar me-1"></i>{{ $epreuve->annee }}
                    </span>
                    @endif
                    @if($epreuve->duree)
                    <span class="badge bg-light text-dark">
                        <i class="ti ti-clock me-1"></i>{{ $epreuve->duree }} min
                    </span>
                    @endif
                    @if($epreuve->bareme)
                    <span class="badge bg-light text-dark">
                        <i class="ti ti-star me-1"></i>{{ $epreuve->bareme }} pts
                    </span>
                    @endif
                </div>

                <!-- Correction -->
                <div class="mb-3">
                    @if($epreuve->correction)
                        <span class="text-success small">
                            <i class="ti ti-check-circle me-1"></i>Correction disponible
                        </span>
                    @else
                        <span class="text-warning small">
                            <i class="ti ti-alert-circle me-1"></i>Pas de correction
                        </span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                    <a href="{{ route('admin.epreuves.show', $epreuve) }}" class="btn btn-sm btn-outline-info" title="Voir">
                        <i class="ti ti-eye"></i>
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.epreuves.edit', $epreuve) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.epreuves.destroy', $epreuve) }}" method="POST" onsubmit="return confirm('Supprimer cette épreuve ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.epreuves.download', $epreuve) }}">
                                        <i class="ti ti-download me-2"></i>Télécharger l'épreuve
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.epreuves.toggle', $epreuve) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="ti ti-{{ $epreuve->statut ? 'eye-off' : 'eye' }} me-2"></i>
                                            {{ $epreuve->statut ? 'Dépublier' : 'Publier' }}
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.epreuves.duplicate', $epreuve) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="ti ti-copy me-2"></i>Dupliquer
                                        </button>
                                    </form>
                                </li>
                                @if($epreuve->correction)
                                    <li>
                                        <a class="dropdown-item" href="{{ Storage::url($epreuve->correction->fichier) }}" target="_blank">
                                            <i class="ti ti-file-text me-2"></i>Voir la correction
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.epreuves.correction.destroy', $epreuve) }}" method="POST" onsubmit="return confirm('Supprimer la correction ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="ti ti-trash me-2"></i>Supprimer la correction
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addCorrectionModal{{ $epreuve->id }}">
                                            <i class="ti ti-plus me-2"></i>Ajouter une correction
                                        </button>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter une correction -->
    @if(!$epreuve->correction)
    <div class="modal fade" id="addCorrectionModal{{ $epreuve->id }}" tabindex="-1" aria-labelledby="addCorrectionModalLabel{{ $epreuve->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.epreuves.correction.store', $epreuve) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCorrectionModalLabel{{ $epreuve->id }}">Ajouter une correction pour "{{ $epreuve->titre }}"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fichier" class="form-label">Fichier de correction (PDF, DOC, DOCX) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="fichier" accept=".pdf,.doc,.docx" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optionnelle)</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="ti ti-file-unknown fs-1 text-muted mb-3"></i>
                <h5>Aucune épreuve trouvée</h5>
                <p class="text-muted mb-4">Commencez par créer votre première épreuve.</p>
                <a href="{{ route('admin.epreuves.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="ti ti-plus me-1"></i> Nouvelle épreuve
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if(method_exists($epreuves, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $epreuves->links() }}
    </div>
@endif
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .avatar-sm {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hover-lift {
        transition: all 0.2s ease-in-out;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
    }
    .text-white-75 {
        color: rgba(255,255,255,0.75);
    }
</style>
@endpush