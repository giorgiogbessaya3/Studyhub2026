@extends('layouts.admin')

@section('title', 'Gestion des corrections - StudyHub')
@section('page-title', 'Corrections')
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
                        <h2 class="text-white mb-0">{{ $corrections->total() }}</h2>
                        <p class="text-white-75 mb-0">Total corrections</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-gradient-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-book fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $corrections->count() }}</h2>
                        <p class="text-white-75 mb-0">Sur cette page</p>
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
                            <i class="ti ti-check fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $corrections->total() }}</h2>
                        <p class="text-white-75 mb-0">Corrections disponibles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- En-tête -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h5 class="text-muted fw-normal mb-0">
            <i class="ti ti-layers-difference me-2"></i>Liste des corrections disponibles
        </h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.epreuves.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="ti ti-arrow-left me-1"></i> Retour aux épreuves
        </a>
    </div>
</div>

<!-- Liste des corrections -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Épreuve</th>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Fichier</th>
                        <th>Date d'ajout</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($corrections as $correction)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark">{{ $correction->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 p-2 me-2" style="background-color: {{ $correction->epreuve->typeEpreuve->couleur ?? '#6c5ce7' }}20;">
                                    <i class="ti {{ $correction->epreuve->typeEpreuve->icone ?? 'ti-file-text' }}" style="color: {{ $correction->epreuve->typeEpreuve->couleur ?? '#6c5ce7' }};"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $correction->epreuve->titre }}</h6>
                                    <small class="text-muted">{{ $correction->epreuve->typeEpreuve->nom ?? 'Type inconnu' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="ti ti-users me-1"></i>{{ $correction->epreuve->classe->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="ti ti-book me-1"></i>{{ $correction->epreuve->matiere->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-file-text me-2 text-primary"></i>
                                <span class="small">{{ $correction->nom_fichier_original }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="small">
                                <i class="ti ti-calendar me-1"></i>{{ $correction->created_at->format('d/m/Y') }}
                                <br>
                                <i class="ti ti-clock me-1"></i>{{ $correction->created_at->format('H:i') }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ Storage::url($correction->fichier) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   target="_blank" 
                                   title="Visualiser">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ Storage::url($correction->fichier) }}" 
                                   class="btn btn-sm btn-outline-success" 
                                   download 
                                   title="Télécharger">
                                    <i class="ti ti-download"></i>
                                </a>
                                <a href="{{ route('admin.epreuves.show', $correction->epreuve) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="Voir l'épreuve">
                                    <i class="ti ti-file-text"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCorrectionModal{{ $correction->id }}"
                                        title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <form action="{{ route('admin.epreuves.correction.destroy', $correction->epreuve) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Supprimer cette correction ?')"
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

                    <!-- Modal Modifier Correction -->
                    <div class="modal fade" id="editCorrectionModal{{ $correction->id }}" tabindex="-1" aria-labelledby="editCorrectionModalLabel{{ $correction->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.epreuves.correction.update', $correction->epreuve) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCorrectionModalLabel{{ $correction->id }}">
                                            Modifier la correction
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Fichier actuel</label>
                                            <div class="p-2 border rounded bg-light">
                                                <i class="ti ti-file-text me-2"></i>
                                                <span>{{ $correction->nom_fichier_original }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fichier" class="form-label fw-semibold">Nouveau fichier (optionnel)</label>
                                            <input type="file" class="form-control" name="fichier" accept=".pdf,.doc,.docx">
                                            <small class="text-muted">Laissez vide pour conserver le fichier actuel</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-semibold">Description</label>
                                            <textarea class="form-control" name="description" rows="3">{{ $correction->description }}</textarea>
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
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="ti ti-file-unknown fs-1 text-muted mb-3"></i>
                            <h5>Aucune correction trouvée</h5>
                            <p class="text-muted">Les corrections ajoutées aux épreuves apparaîtront ici.</p>
                            <a href="{{ route('admin.epreuves.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="ti ti-arrow-left me-1"></i> Voir les épreuves
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    @if($corrections->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        <div class="d-flex justify-content-center">
            {{ $corrections->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .avatar-sm {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }
</style>
@endpush