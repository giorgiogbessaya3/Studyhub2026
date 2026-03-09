@extends('layouts.admin')

@section('title', 'Nouveau Chapitre')

@section('page-title', 'Nouveau Chapitre')
@section('breadcrumb', 'Chapitres')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-book-2 me-2"></i>Créer un chapitre</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.chapitres.store') }}" method="POST" id="chapitreForm">
                    @csrf

                    <!-- Classe -->
                    <div class="mb-3">
                        <label class="form-label">Classe <span class="text-danger">*</span></label>
                        <select name="classe_id" id="classeSelect" class="form-select @error('classe_id') is-invalid @enderror" required>
                            <option value="">Choisir une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
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
                        <select name="matiere_id" id="matiereSelect" class="form-select @error('matiere_id') is-invalid @enderror" required disabled>
                            <option value="">D'abord choisir une classe</option>
                        </select>
                        @error('matiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre du chapitre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                               value="{{ old('titre') }}" required placeholder="Ex: Calcul littéral">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Brève description du chapitre...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Ordre -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ordre <span class="text-danger">*</span></label>
                            <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror" 
                                   value="{{ old('ordre', $ordreDefaut) }}" min="0" required>
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Statut</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="statut" value="1" 
                                       {{ old('statut', true) ? 'checked' : '' }}>
                                <label class="form-check-label">Actif</label>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.chapitres.index') }}" class="btn btn-danger">
                            <i class="ti ti-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Créer le chapitre
                        </button>
                    </div>
                </form>
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

document.getElementById('classeSelect').addEventListener('change', function() {
    const matiereSelect = document.getElementById('matiereSelect');
    const classeId = this.value;
    
    if (!classeId) {
        matiereSelect.innerHTML = '<option value="">D\'abord choisir une classe</option>';
        matiereSelect.disabled = true;
        return;
    }
    
    const matieres = classesData[classeId] || {};
    let options = '<option value="">Choisir une matière</option>';
    
    for (const [id, nom] of Object.entries(matieres)) {
        options += `<option value="${id}">${nom}</option>`;
    }
    
    matiereSelect.innerHTML = options;
    matiereSelect.disabled = false;
    
    // Sélectionner l'ancienne valeur si existe
    const oldMatiere = "{{ old('matiere_id') }}";
    if (oldMatiere) {
        matiereSelect.value = oldMatiere;
    }
});

// Déclencher au chargement si classe déjà sélectionnée
@if(old('classe_id'))
    document.getElementById('classeSelect').dispatchEvent(new Event('change'));
@endif
</script>
@endpush