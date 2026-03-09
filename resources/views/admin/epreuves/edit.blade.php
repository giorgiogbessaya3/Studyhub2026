@extends('layouts.admin')

@section('title', 'Modifier une épreuve - StudyHub')
@section('page-title', 'Modifier l\'épreuve')
@section('breadcrumb', 'Banque d\'épreuves')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <i class="ti ti-edit fs-5 me-2"></i>
                <h5 class="card-title mb-0">Modifier : {{ $epreuve->titre }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.epreuves.update', $epreuve) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Colonne gauche : fichier actuel et upload -->
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 text-center bg-light">
                                <label class="form-label fw-semibold mb-3">Fichier de l'épreuve</label>
                                
                                <!-- Fichier actuel -->
                                @if($epreuve->fichier)
                                <div class="mb-3 p-2 border bg-white rounded">
                                    <i class="ti ti-file-text fs-1 text-primary d-block mb-2"></i>
                                    <p class="small text-truncate mb-1">{{ $epreuve->nom_fichier_original }}</p>
                                    {{-- Remplacement par URL directe --}}
                                    <a href="{{ url('admin/epreuves/' . $epreuve->id . '/download') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="ti ti-download me-1"></i>Télécharger
                                    </a>
                                </div>
                                @else
                                <div class="mb-3 p-3 border bg-white rounded">
                                    <i class="ti ti-file-unknown fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted small">Aucun fichier</p>
                                </div>
                                @endif

                                <!-- Upload nouveau fichier -->
                                <div class="mb-3">
                                    <label for="fichier" class="form-label fw-semibold">Remplacer le fichier</label>
                                    <input type="file" class="form-control @error('fichier') is-invalid @enderror" name="fichier" id="fichier" accept=".pdf,.doc,.docx,.zip">
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle me-1"></i>Formats: PDF, DOC, DOCX, ZIP. Max 10 Mo
                                    </small>
                                    @error('fichier')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite : informations principales -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Titre -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-heading"></i></span>
                                        <input type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre', $epreuve->titre) }}" required>
                                    </div>
                                    @error('titre')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $epreuve->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Classe, Matière, Type -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                                    <select class="form-select @error('classe_id') is-invalid @enderror" name="classe_id" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}" {{ old('classe_id', $epreuve->classe_id) == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('classe_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                                    <select class="form-select @error('matiere_id') is-invalid @enderror" name="matiere_id" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->id }}" {{ old('matiere_id', $epreuve->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                                {{ $matiere->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('matiere_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Type d'épreuve <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type_epreuve_id') is-invalid @enderror" name="type_epreuve_id" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_epreuve_id', $epreuve->type_epreuve_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type_epreuve_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Année, Durée, Barème -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Année</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                        <input type="number" class="form-control @error('annee') is-invalid @enderror" name="annee" value="{{ old('annee', $epreuve->annee) }}" min="2000" max="{{ date('Y') }}">
                                    </div>
                                    @error('annee')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Durée (minutes)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-clock"></i></span>
                                        <input type="number" class="form-control @error('duree') is-invalid @enderror" name="duree" value="{{ old('duree', $epreuve->duree) }}" min="0">
                                    </div>
                                    @error('duree')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Barème (points)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-star"></i></span>
                                        <input type="number" class="form-control @error('bareme') is-invalid @enderror" name="bareme" value="{{ old('bareme', $epreuve->bareme) }}" min="0">
                                    </div>
                                    @error('bareme')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="statut" id="statut" value="1" {{ old('statut', $epreuve->statut) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="statut">
                                            <i class="ti ti-circle-check text-success me-1"></i>Publier l'épreuve
                                        </label>
                                        <small class="text-muted d-block">Si activé, l'épreuve sera visible par les élèves.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.epreuves.index') }}" class="btn btn-light px-4">
                            <i class="ti ti-x me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="ti ti-check me-1"></i>Mettre à jour
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
    .input-group-text {
        background-color: #f8f9fa;
    }
    .border.rounded-3.p-3 {
        transition: all 0.2s;
    }
    .border.rounded-3.p-3:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush