@extends('layouts.admin')

@section('title', 'Ajouter une matière - StudyHub')
@section('page-title', 'Nouvelle matière')
@section('breadcrumb', 'Ajouter')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <i class="ti ti-plus fs-5 me-2"></i>
                <h5 class="card-title mb-0">Créer une nouvelle matière</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.matieres.store') }}" method="POST" enctype="multipart/form-data" id="matiereForm">
                    @csrf

                    <div class="row g-4">
                        <!-- Colonne gauche : image et icône -->
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 text-center bg-light">
                                <label class="form-label fw-semibold mb-3">Image de la matière</label>
                                
                                <!-- Zone de preview -->
                                <div class="image-preview-container mb-3">
                                    <img id="preview" 
                                         src="{{ asset('admin/images/default-matiere.png') }}" 
                                         alt="Aperçu" 
                                         class="img-fluid rounded-3 border" 
                                         style="max-height: 160px; width: 100%; object-fit: cover;">
                                </div>

                                <!-- Upload bouton -->
                                <div class="mb-3">
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           name="image" 
                                           id="image" 
                                           accept="image/jpeg,image/png,image/gif,image/svg+xml"
                                           onchange="previewImage(this)">
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle me-1"></i>Formats: JPG, PNG, GIF, SVG. Max 2 Mo
                                    </small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-3">

                                <!-- Choix de l'icône avec visualisation -->
                                <label class="form-label fw-semibold mb-2">Icône représentative</label>
                                <select class="form-select" name="icone" id="iconeSelect">
                                    <option value="ti-book" data-icon="📘" selected>Livre (📘)</option>
                                    <option value="ti-calculator" data-icon="🧮">Calculatrice (🧮)</option>
                                    <option value="ti-flask" data-icon="⚗️">Flacon (⚗️)</option>
                                    <option value="ti-leaf" data-icon="🍃">Feuille (🍃)</option>
                                    <option value="ti-language" data-icon="🌐">Langue (🌐)</option>
                                    <option value="ti-globe" data-icon="🌍">Globe (🌍)</option>
                                    <option value="ti-bulb" data-icon="💡">Ampoule (💡)</option>
                                    <option value="ti-chart-bar" data-icon="📊">Graphique (📊)</option>
                                </select>
                                <div class="mt-2 text-center">
                                    <span class="badge bg-light p-2">
                                        <i class="ti" id="iconPreview"></i> Aperçu icône
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite : informations principales -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Nom -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nom de la matière <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-book"></i></span>
                                        <input type="text" 
                                               class="form-control @error('nom') is-invalid @enderror" 
                                               name="nom" 
                                               value="{{ old('nom') }}" 
                                               placeholder="Ex: Mathématiques, Français..."
                                               required>
                                    </div>
                                    @error('nom')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Code -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-hash"></i></span>
                                        <input type="text" 
                                               class="form-control @error('code') is-invalid @enderror" 
                                               name="code" 
                                               value="{{ old('code') }}" 
                                               placeholder="Ex: MATH, FR...">
                                    </div>
                                    @error('code')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Couleur -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Couleur thème</label>
                                    <div class="input-group">
                                        <span class="input-group-text p-0" style="width: 40px;">
                                            <input type="color" name="couleur" value="{{ old('couleur', '#2563eb') }}" class="form-control p-1 h-100 border-0">
                                        </span>
                                        <input type="text" class="form-control" value="{{ old('couleur', '#2563eb') }}" readonly>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Brève description de la matière...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="statut" id="statut" value="1" {{ old('statut', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="statut">
                                            <i class="ti ti-circle-check text-success me-1"></i>Matière active
                                        </label>
                                        <small class="text-muted d-block">Décochez pour désactiver temporairement cette matière.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Classes associées -->
                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label fw-semibold mb-3">
                            <i class="ti ti-users me-1"></i>Classes associées
                        </label>
                        <div class="row g-2">
                            @forelse($classes as $classe)
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="classes[]" 
                                           value="{{ $classe->id }}" 
                                           id="classe{{ $classe->id }}"
                                           {{ in_array($classe->id, old('classes', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center" for="classe{{ $classe->id }}">
                                        <span class="badge bg-light text-dark px-2 py-1">{{ $classe->niveau ?? '' }}</span>
                                        <span class="ms-2">{{ $classe->nom }}</span>
                                    </label>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-warning py-2">
                                    <i class="ti ti-alert-triangle me-2"></i>Aucune classe active trouvée. Veuillez d'abord créer des classes.
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.matieres.index') }}" class="btn btn-danger px-4">
                            <i class="ti ti-x me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="ti ti-check me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-checkbox .form-check-input:checked ~ .form-check-label .badge {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
    .image-preview-container {
        min-height: 160px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }
    #preview {
        transition: transform 0.2s;
    }
    #preview:hover {
        transform: scale(1.02);
    }
    .input-group-text input[type=color] {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    // Preview image avant upload
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "{{ asset('admin/images/default-matiere.png') }}";
        }
    }

    // Aperçu dynamique de l'icône sélectionnée
    document.addEventListener('DOMContentLoaded', function() {
        const iconSelect = document.getElementById('iconeSelect');
        const iconPreview = document.getElementById('iconPreview');
        
        function updateIconPreview() {
            const selectedOption = iconSelect.options[iconSelect.selectedIndex];
            iconPreview.className = `ti ${iconSelect.value}`;
        }
        
        iconSelect.addEventListener('change', updateIconPreview);
        updateIconPreview(); // initial
    });
</script>
@endpush