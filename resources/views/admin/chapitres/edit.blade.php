@extends('layouts.admin')

@section('title', 'Modifier Chapitre')

@section('page-title', 'Modifier Chapitre')
@section('breadcrumb', 'Chapitres')

@section('content')

<div class="row">
    <!-- Formulaire -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-edit me-2"></i>Modifier le chapitre</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.chapitres.update', $chapitre) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Classe -->
                    <div class="mb-3">
                        <label class="form-label">Classe <span class="text-danger">*</span></label>
                        <select name="classe_id" id="classeSelect" class="form-select @error('classe_id') is-invalid @enderror" required>
                            <option value="">Choisir une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id', $chapitre->classe_id) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Matière -->
                    <div class="mb-3">
                        <label class="form-label">Matière <span class="text-danger">*</span></label>
                        <select name="matiere_id" id="matiereSelect" class="form-select @error('matiere_id') is-invalid @enderror" required>
                            <option value="">Choisir une matière</option>
                        </select>
                        @error('matiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre du chapitre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                               value="{{ old('titre', $chapitre->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $chapitre->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Ordre -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ordre <span class="text-danger">*</span></label>
                            <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror" 
                                   value="{{ old('ordre', $chapitre->ordre) }}" min="0" required>
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Statut</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="statut" value="1" 
                                       {{ old('statut', $chapitre->statut) ? 'checked' : '' }}>
                                <label class="form-check-label">Actif</label>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="alert alert-info">
                        <small>Slug: <code>{{ $chapitre->slug }}</code> | Créé le: {{ $chapitre->created_at->format('d/m/Y') }}</small>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.chapitres.index') }}" class="btn btn-danger">
                            <i class="ti ti-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar : Contenus -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-file-text me-2"></i>Contenus</h6>
                <a href="{{ route('admin.contenus.create', $chapitre) }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if($chapitre->contenus && $chapitre->contenus->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($chapitre->contenus as $contenu)
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <span class="badge bg-secondary me-1">#{{ $contenu->ordre }}</span>
                                    <strong class="small">{{ Str::limit($contenu->titre, 20) }}</strong>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.contenus.edit', $contenu) }}" class="btn btn-outline-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <small class="text-muted">
                                @if($contenu->images && count($contenu->images) > 0)
                                    <span class="me-2"><i class="ti ti-photo me-1"></i>{{ count($contenu->images) }}</span>
                                @endif
                                @if($contenu->exercices && count($contenu->exercices) > 0)
                                    <span><i class="ti ti-checklist me-1"></i>{{ count($contenu->exercices) }}</span>
                                @endif
                            </small>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-4">
                        <i class="ti ti-file-text-off fs-1 text-muted mb-2"></i>
                        <p class="text-muted small mb-3">Aucun contenu</p>
                        <a href="{{ route('admin.contenus.create', $chapitre) }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i>Ajouter
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats rapides -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body p-3">
                <small class="text-muted d-block mb-2">Résumé du chapitre</small>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Contenus:</span>
                    <strong>{{ $chapitre->contenus->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between small">
                    <span>Exercices:</span>
                    <strong>
                        {{ $chapitre->contenus->sum(function($c) { 
                            return $c->exercices ? count($c->exercices) : 0; 
                        }) }}
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Données des classes et leurs matières
const classesData = @json($classes->mapWithKeys(function($classe) {
    return [$classe->id => $classe->matieres->pluck('nom', 'id')];
}));

const currentMatiereId = "{{ old('matiere_id', $chapitre->matiere_id) }}";

function updateMatieres() {
    const classeSelect = document.getElementById('classeSelect');
    const matiereSelect = document.getElementById('matiereSelect');
    const classeId = classeSelect.value;
    
    if (!classeId) {
        matiereSelect.innerHTML = '<option value="">Choisir une classe d\'abord</option>';
        matiereSelect.disabled = true;
        return;
    }
    
    const matieres = classesData[classeId] || {};
    let options = '<option value="">Choisir une matière</option>';
    
    for (const [id, nom] of Object.entries(matieres)) {
        const selected = (id == currentMatiereId) ? 'selected' : '';
        options += `<option value="${id}" ${selected}>${nom}</option>`;
    }
    
    matiereSelect.innerHTML = options;
    matiereSelect.disabled = false;
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', updateMatieres);

// Mettre à jour quand la classe change
document.getElementById('classeSelect').addEventListener('change', updateMatieres);
</script>
@endpush