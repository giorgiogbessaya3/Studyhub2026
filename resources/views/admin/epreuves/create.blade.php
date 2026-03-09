@extends('layouts.admin')

@section('title', 'Ajouter une épreuve - StudyHub')
@section('page-title', 'Nouvelle épreuve')
@section('breadcrumb', 'Ajouter')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Informations de l'épreuve</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.epreuves.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Colonne gauche : fichier et métadonnées -->
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 bg-light">
                                <label class="form-label fw-semibold mb-3">Fichier de l'épreuve</label>
                                
                                <!-- Zone de fichier -->
                                <div class="mb-3">
                                    <input type="file" 
                                           class="form-control @error('fichier') is-invalid @enderror" 
                                           name="fichier" 
                                           id="fichier"
                                           accept=".pdf,.doc,.docx,.zip"
                                           required>
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle me-1"></i>Formats: PDF, DOC, DOCX, ZIP. Max 10 Mo
                                    </small>
                                    @error('fichier')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <!-- Année, durée, barème -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Année</label>
                                    <input type="number" 
                                           class="form-control @error('annee') is-invalid @enderror" 
                                           name="annee" 
                                           value="{{ old('annee', date('Y')) }}"
                                           min="2000" 
                                           max="{{ date('Y') }}">
                                    @error('annee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Durée (minutes)</label>
                                    <input type="number" 
                                           class="form-control @error('duree') is-invalid @enderror" 
                                           name="duree" 
                                           value="{{ old('duree') }}"
                                           min="0"
                                           placeholder="Ex: 120">
                                    @error('duree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Barème</label>
                                    <input type="number" 
                                           class="form-control @error('bareme') is-invalid @enderror" 
                                           name="bareme" 
                                           value="{{ old('bareme') }}"
                                           min="0"
                                           placeholder="Ex: 20">
                                    @error('bareme')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite : titre, description, sélections -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Titre -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('titre') is-invalid @enderror" 
                                           name="titre" 
                                           value="{{ old('titre') }}"
                                           required>
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              name="description" 
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Classe -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                                    <select class="form-select @error('classe_id') is-invalid @enderror" 
                                            name="classe_id" 
                                            id="classe_id"
                                            required>
                                        <option value="">Sélectionnez</option>
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
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                                    <select class="form-select @error('matiere_id') is-invalid @enderror" 
                                            name="matiere_id" 
                                            id="matiere_id"
                                            required>
                                        <option value="">Sélectionnez</option>
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

                                <!-- Type d'épreuve -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type_epreuve_id') is-invalid @enderror" 
                                            name="type_epreuve_id" 
                                            required>
                                        <option value="">Sélectionnez</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_epreuve_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type_epreuve_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="statut" id="statut" value="1" {{ old('statut', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="statut">
                                            <i class="ti ti-circle-check text-success me-1"></i>Épreuve active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.epreuves.index') }}" class="btn btn-light px-4">
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
    /* Optionnel : ajustements */
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush