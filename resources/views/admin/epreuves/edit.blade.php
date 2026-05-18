@extends('layouts.admin')

@section('title', 'Modifier une épreuve - StudyHub')
@section('page-title', 'Modifier l\'épreuve')
@section('breadcrumb', 'Modifier')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Modifier l'épreuve : {{ $epreuve->titre }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.epreuves.update', $epreuve) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Colonne gauche : fichier et métadonnées -->
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 bg-light">
                                <label class="form-label fw-semibold mb-3">Fichier de l'épreuve</label>
                                
                                @if($epreuve->fichier)
                                    <div class="alert alert-info mb-3">
                                        <i class="ti ti-file me-2"></i>
                                        Fichier actuel: {{ $epreuve->nom_fichier_original ?? 'fichier_' . $epreuve->id }}
                                        <a href="{{ route('admin.epreuves.download', $epreuve) }}" class="btn btn-sm btn-link" target="_blank">
                                            <i class="ti ti-download"></i> Télécharger
                                        </a>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <input type="file" 
                                           class="form-control @error('fichier') is-invalid @enderror" 
                                           name="fichier" 
                                           id="fichier"
                                           accept=".pdf,.doc,.docx,.zip">
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle me-1"></i>Laissez vide pour garder le fichier actuel. Formats: PDF, DOC, DOCX, ZIP. Max 10 Mo
                                    </small>
                                    @error('fichier')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Année</label>
                                    <input type="number" 
                                           class="form-control @error('annee') is-invalid @enderror" 
                                           name="annee" 
                                           value="{{ old('annee', $epreuve->annee ?? date('Y')) }}"
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
                                           value="{{ old('duree', $epreuve->duree) }}"
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
                                           value="{{ old('bareme', $epreuve->bareme) }}"
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
                                           value="{{ old('titre', $epreuve->titre) }}"
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
                                              rows="3">{{ old('description', $epreuve->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Classes avec checkboxes -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Classes <span class="text-danger">*</span></label>
                                    <div class="border rounded-3 p-3 @error('classes') is-invalid @enderror" style="max-height: 200px; overflow-y: auto;">
                                        <div class="row">
                                            @php
                                                $oldClasses = old('classes', $epreuve->classes->pluck('id')->toArray());
                                            @endphp
                                            @foreach($classes as $classe)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               name="classes[]" 
                                                               value="{{ $classe->id }}"
                                                               id="classe_{{ $classe->id }}"
                                                               {{ in_array($classe->id, $oldClasses) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="classe_{{ $classe->id }}">
                                                            {{ $classe->nom }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('classes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Cochez une ou plusieurs classes</small>
                                </div>

                                <!-- Matières avec checkboxes -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Matières <span class="text-danger">*</span></label>
                                    <div class="border rounded-3 p-3 @error('matieres') is-invalid @enderror" style="max-height: 200px; overflow-y: auto;">
                                        <div class="row">
                                            @php
                                                $oldMatieres = old('matieres', $epreuve->matieres->pluck('id')->toArray());
                                            @endphp
                                            @foreach($matieres as $matiere)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               name="matieres[]" 
                                                               value="{{ $matiere->id }}"
                                                               id="matiere_{{ $matiere->id }}"
                                                               {{ in_array($matiere->id, $oldMatieres) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="matiere_{{ $matiere->id }}">
                                                            {{ $matiere->nom }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('matieres')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Cochez une ou plusieurs matières</small>
                                </div>

                                <!-- Type d'épreuve -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type_epreuve_id') is-invalid @enderror" 
                                            name="type_epreuve_id" 
                                            required>
                                        <option value="">Sélectionnez</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_epreuve_id', $epreuve->type_epreuve_id) == $type->id ? 'selected' : '' }}>
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
                                        <input class="form-check-input" type="checkbox" name="statut" id="statut" value="1" {{ old('statut', $epreuve->statut) ? 'checked' : '' }}>
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
                            <i class="ti ti-check me-1"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection