@extends('layouts.admin')

@section('title', 'Détail de l\'épreuve - StudyHub')
@section('page-title', $epreuve->titre)
@section('breadcrumb', 'Banque d\'épreuves')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Carte principale -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Informations générales</h5>
                <span class="badge bg-{{ $epreuve->statut ? 'success' : 'secondary' }} fs-6">
                    {{ $epreuve->statut ? 'Publiée' : 'Brouillon' }}
                </span>
            </div>
            <div class="card-body">
                <!-- Type et classe/matière -->
                <div class="mb-4">
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge bg-info fs-6">{{ $epreuve->typeEpreuve->nom ?? 'Non défini' }}</span>
                        <span class="badge bg-light text-dark fs-6">
                            <i class="ti ti-users me-1"></i>{{ $epreuve->classe->nom ?? 'N/A' }}
                        </span>
                        <span class="badge bg-light text-dark fs-6">
                            <i class="ti ti-book me-1"></i>{{ $epreuve->matiere->nom ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                @if($epreuve->description)
                <div class="mb-4">
                    <h6 class="fw-semibold">Description</h6>
                    <p class="text-muted">{{ $epreuve->description }}</p>
                </div>
                @endif

                <!-- Métadonnées -->
                <div class="row g-3 mb-4">
                    @if($epreuve->annee)
                    <div class="col-md-3 col-6">
                        <div class="border rounded p-2 text-center">
                            <small class="text-muted d-block">Année</small>
                            <strong>{{ $epreuve->annee }}</strong>
                        </div>
                    </div>
                    @endif
                    @if($epreuve->duree)
                    <div class="col-md-3 col-6">
                        <div class="border rounded p-2 text-center">
                            <small class="text-muted d-block">Durée</small>
                            <strong>{{ $epreuve->duree }} min</strong>
                        </div>
                    </div>
                    @endif
                    @if($epreuve->bareme)
                    <div class="col-md-3 col-6">
                        <div class="border rounded p-2 text-center">
                            <small class="text-muted d-block">Barème</small>
                            <strong>{{ $epreuve->bareme }} pts</strong>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3 col-6">
                        <div class="border rounded p-2 text-center">
                            <small class="text-muted d-block">Fichier</small>
                            <strong>
                                {{-- Utilisation d'une URL directe au lieu de route() --}}
                                <a href="{{ url('admin/epreuves/' . $epreuve->id . '/download') }}" class="text-decoration-none">
                                    <i class="ti ti-download"></i> Télécharger
                                </a>
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- Nom du fichier original -->
                @if($epreuve->nom_fichier_original)
                <div class="alert alert-light py-2 mb-0">
                    <i class="ti ti-file-text me-2"></i>
                    Fichier : <strong>{{ $epreuve->nom_fichier_original }}</strong>
                </div>
                @endif
            </div>
        </div>

        <!-- Carte Correction -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Correction</h5>
                @if($epreuve->correction)
                    <span class="badge bg-success">Disponible</span>
                @else
                    <span class="badge bg-warning">Absente</span>
                @endif
            </div>
            <div class="card-body">
                @if($epreuve->correction)
                    <!-- Afficher la correction existante -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-grow-1">
                            <p class="mb-2">
                                <i class="ti ti-file-text me-1"></i>
                                <strong>{{ $epreuve->correction->nom_fichier_original ?? 'Correction' }}</strong>
                            </p>
                            @if($epreuve->correction->description)
                                <p class="text-muted small">{{ $epreuve->correction->description }}</p>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ Storage::url($epreuve->correction->fichier) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Visualiser">
                                <i class="ti ti-eye"></i>
                            </a>
                            <a href="{{ Storage::url($epreuve->correction->fichier) }}" class="btn btn-sm btn-outline-success" download title="Télécharger">
                                <i class="ti ti-download"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCorrectionModal" title="Modifier">
                                <i class="ti ti-edit"></i>
                            </button>
                            <form action="{{ route('admin.epreuves.correction.destroy', $epreuve) }}" method="POST" onsubmit="return confirm('Supprimer cette correction ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Pas de correction : bouton pour en ajouter -->
                    <div class="text-center py-3">
                        <i class="ti ti-file-unknown fs-1 text-muted mb-3"></i>
                        <p>Aucune correction n'est associée à cette épreuve.</p>
                        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCorrectionModal">
                            <i class="ti ti-plus me-1"></i> Ajouter une correction
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Boutons d'action globaux -->
        <div class="d-flex justify-content-between gap-2">
            <a href="{{ route('admin.epreuves.index') }}" class="btn btn-light px-4">
                <i class="ti ti-arrow-left me-1"></i> Retour à la liste
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.epreuves.edit', $epreuve) }}" class="btn btn-outline-primary px-4">
                    <i class="ti ti-edit me-1"></i> Modifier
                </a>
                <form action="{{ route('admin.epreuves.destroy', $epreuve) }}" method="POST" onsubmit="return confirm('Supprimer cette épreuve ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger px-4">
                        <i class="ti ti-trash me-1"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Correction -->
@if(!$epreuve->correction)
<div class="modal fade" id="addCorrectionModal" tabindex="-1" aria-labelledby="addCorrectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.epreuves.correction.store', $epreuve) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCorrectionModalLabel">Ajouter une correction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fichier" class="form-label">Fichier (PDF, DOC, DOCX) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="fichier" accept=".pdf,.doc,.docx" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optionnelle)</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
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

<!-- Modal Modifier Correction -->
@if($epreuve->correction)
<div class="modal fade" id="editCorrectionModal" tabindex="-1" aria-labelledby="editCorrectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.epreuves.correction.update', $epreuve) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCorrectionModalLabel">Modifier la correction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fichier" class="form-label">Nouveau fichier (laissez vide pour conserver l'actuel)</label>
                        <input type="file" class="form-control" name="fichier" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Fichier actuel : {{ $epreuve->correction->nom_fichier_original }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ $epreuve->correction->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    .border.rounded.p-2 {
        background-color: #f8f9fa;
    }
</style>
@endpush