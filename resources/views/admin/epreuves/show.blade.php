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
                <!-- Type -->
                <div class="mb-4">
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-info fs-6">{{ $epreuve->typeEpreuve->nom ?? 'Non défini' }}</span>
                    </div>
                </div>

                <!-- Classes associées -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">
                        <i class="ti ti-users me-1"></i> Classes concernées
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        @forelse($epreuve->classes as $classe)
                            <span class="badge bg-primary fs-6">
                                {{ $classe->nom }}
                            </span>
                        @empty
                            <span class="text-muted">Aucune classe associée</span>
                        @endforelse
                    </div>
                </div>

                <!-- Matières associées -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">
                        <i class="ti ti-book me-1"></i> Matières concernées
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        @forelse($epreuve->matieres as $matiere)
                            <span class="badge bg-success fs-6">
                                {{ $matiere->nom }}
                            </span>
                        @empty
                            <span class="text-muted">Aucune matière associée</span>
                        @endforelse
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
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewFileModal" onclick="loadPdfPreview()">
                                    <i class="ti ti-eye"></i> Voir
                                </button>
                                <a href="{{ route('admin.epreuves.download', $epreuve) }}" class="btn btn-sm btn-success">
                                    <i class="ti ti-download"></i>
                                </a>
                            </div>
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
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewCorrectionModal" onclick="loadCorrectionPreview()">
                                <i class="ti ti-eye"></i>
                            </button>
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
                <form action="{{ route('admin.epreuves.duplicate', $epreuve) }}" method="POST" onsubmit="return confirm('Dupliquer cette épreuve ?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-info px-4">
                        <i class="ti ti-copy me-1"></i> Dupliquer
                    </button>
                </form>
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

<!-- Modal Voir Épreuve -->
<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFileModalLabel">
                    <i class="ti ti-file-text me-2"></i>
                    Aperçu : {{ $epreuve->titre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height: 500px;">
                <div id="pdfPreviewContainer" class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3">Chargement du fichier...</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.epreuves.download', $epreuve) }}" class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Télécharger
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Voir Correction -->
<div class="modal fade" id="viewCorrectionModal" tabindex="-1" aria-labelledby="viewCorrectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCorrectionModalLabel">
                    <i class="ti ti-file-text me-2"></i>
                    Aperçu de la correction
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height: 500px;">
                <div id="pdfCorrectionContainer" class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3">Chargement de la correction...</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ Storage::url($epreuve->correction->fichier ?? '#') }}" class="btn btn-success" download>
                    <i class="ti ti-download me-1"></i> Télécharger
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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
    .modal-xl {
        max-width: 1140px;
    }
    iframe {
        width: 100%;
        height: 70vh;
        border: none;
    }
    .embed-responsive {
        position: relative;
        display: block;
        width: 100%;
        padding: 0;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    function loadPdfPreview() {
        const url = "{{ route('admin.epreuves.download', $epreuve) }}";
        const container = document.getElementById('pdfPreviewContainer');
        
        // Vérifier si c'est un PDF via l'extension
        const fileName = "{{ strtolower($epreuve->nom_fichier_original ?? '') }}";
        
        if (fileName.endsWith('.pdf')) {
            container.innerHTML = `
                <div class="embed-responsive">
                    <iframe src="${url}#toolbar=0&navpanes=0&scrollbar=0" 
                            frameborder="0"
                            allowfullscreen>
                    </iframe>
                </div>
            `;
        } else {
            container.innerHTML = `
                <div class="text-center p-5">
                    <i class="ti ti-file fs-1 text-muted mb-3 d-block"></i>
                    <p>Ce type de fichier (${fileName.split('.').pop()}) ne peut pas être prévisualisé directement.</p>
                    <a href="${url}" class="btn btn-primary">
                        <i class="ti ti-download me-1"></i> Télécharger le fichier
                    </a>
                </div>
            `;
        }
    }
    
    function loadCorrectionPreview() {
        @if($epreuve->correction)
            const url = "{{ Storage::url($epreuve->correction->fichier) }}";
            const container = document.getElementById('pdfCorrectionContainer');
            const fileName = "{{ strtolower($epreuve->correction->nom_fichier_original ?? '') }}";
            
            if (fileName.endsWith('.pdf')) {
                container.innerHTML = `
                    <div class="embed-responsive">
                        <iframe src="${url}#toolbar=0&navpanes=0&scrollbar=0" 
                                frameborder="0"
                                allowfullscreen>
                        </iframe>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="text-center p-5">
                        <i class="ti ti-file fs-1 text-muted mb-3 d-block"></i>
                        <p>Ce type de fichier (${fileName.split('.').pop()}) ne peut pas être prévisualisé directement.</p>
                        <a href="${url}" class="btn btn-primary">
                            <i class="ti ti-download me-1"></i> Télécharger le fichier
                        </a>
                    </div>
                `;
            }
        @endif
    }
    
    // Réinitialiser le container quand le modal se ferme
    document.getElementById('viewFileModal')?.addEventListener('hidden.bs.modal', function () {
        const container = document.getElementById('pdfPreviewContainer');
        if (container) {
            container.innerHTML = `
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3">Chargement du fichier...</p>
                </div>
            `;
        }
    });
    
    document.getElementById('viewCorrectionModal')?.addEventListener('hidden.bs.modal', function () {
        const container = document.getElementById('pdfCorrectionContainer');
        if (container) {
            container.innerHTML = `
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3">Chargement de la correction...</p>
                </div>
            `;
        }
    });
</script>
@endpush