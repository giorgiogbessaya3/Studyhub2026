@extends('layouts.admin')

@section('title', 'Créer un quiz - StudyHub Admin')
@section('page-title', 'Créer un quiz')
@section('breadcrumb', 'Quiz / Création')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informations du quiz</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/quiz') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Titre du quiz <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                               value="{{ old('titre') }}" placeholder="ex: Quiz sur les équations du second degré">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Description du quiz...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Classe <span class="text-danger">*</span></label>
                            <select name="classe_id" id="classe_id" class="form-select @error('classe_id') is-invalid @enderror">
                                <option value="">Sélectionner une classe</option>
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
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Matière <span class="text-danger">*</span></label>
                            <select name="matiere_id" id="matiere_id" class="form-select @error('matiere_id') is-invalid @enderror">
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Chapitre</label>
                            <select name="chapitre_id" id="chapitre_id" class="form-select @error('chapitre_id') is-invalid @enderror">
                                <option value="">Sélectionnez d'abord une classe et une matière</option>
                            </select>
                            @error('chapitre_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durée (minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="duree" class="form-control @error('duree') is-invalid @enderror" 
                                   value="{{ old('duree', 30) }}" min="1" max="180">
                            @error('duree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Score minimum (%) <span class="text-danger">*</span></label>
                            <input type="number" name="score_passer" class="form-control @error('score_passer') is-invalid @enderror" 
                                   value="{{ old('score_passer', 50) }}" min="0" max="100">
                            @error('score_passer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Statut <span class="text-danger">*</span></label>
                            <select name="statut" class="form-select @error('statut') is-invalid @enderror">
                                <option value="brouillon" {{ old('statut', 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="publie" {{ old('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                                <option value="archive" {{ old('statut') == 'archive' ? 'selected' : '' }}>Archivé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Image du quiz</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*" onchange="previewImage(this)">
                        <small class="text-muted">Format: JPG, PNG, GIF - Max 2 Mo</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="mt-2 d-none">
                            <img src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('admin/quiz') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Créer le quiz
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
    document.addEventListener('DOMContentLoaded', function() {
        const classeSelect = document.getElementById('classe_id');
        const matiereSelect = document.getElementById('matiere_id');
        
        if (classeSelect) {
            classeSelect.addEventListener('change', loadChapitres);
        }
        if (matiereSelect) {
            matiereSelect.addEventListener('change', loadChapitres);
        }
        
        if (classeSelect.value && matiereSelect.value) {
            loadChapitres();
        }
    });
    
    function loadChapitres() {
        const classeId = document.getElementById('classe_id').value;
        const matiereId = document.getElementById('matiere_id').value;
        const chapitreSelect = document.getElementById('chapitre_id');
        
        chapitreSelect.innerHTML = '<option value="">Chargement...</option>';
        chapitreSelect.disabled = true;
        
        if (classeId && matiereId) {
            fetch(`/admin/api/chapitres?classe_id=${classeId}&matiere_id=${matiereId}`)
                .then(response => response.json())
                .then(data => {
                    chapitreSelect.innerHTML = '<option value="">Sélectionner un chapitre (optionnel)</option>';
                    
                    if (data.length > 0) {
                        data.forEach(chapitre => {
                            chapitreSelect.innerHTML += `<option value="${chapitre.id}">${chapitre.nom}</option>`;
                        });
                        chapitreSelect.disabled = false;
                    } else {
                        chapitreSelect.innerHTML = '<option value="">Aucun chapitre disponible</option>';
                        chapitreSelect.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    chapitreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    chapitreSelect.disabled = true;
                });
        } else {
            chapitreSelect.innerHTML = '<option value="">Sélectionnez d\'abord une classe et une matière</option>';
            chapitreSelect.disabled = true;
        }
    }
    
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('d-none');
            img.src = '';
        }
    }
</script>
@endpush