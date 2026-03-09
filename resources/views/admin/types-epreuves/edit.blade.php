@extends('layouts.admin')

@section('title', 'Modifier un type d\'épreuve - StudyHub')
@section('page-title', 'Modifier le type')
@section('breadcrumb', 'Édition')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Modifier : {{ $typeEpreuve->nom }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.types-epreuves.update', $typeEpreuve) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $typeEpreuve->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $typeEpreuve->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icône (optionnelle)</label>
                        <select class="form-select @error('icone') is-invalid @enderror" name="icone">
                            <option value="">-- Sélectionnez une icône --</option>
                            <option value="ti-file-text" {{ old('icone', $typeEpreuve->icone) == 'ti-file-text' ? 'selected' : '' }}>Document (ti-file-text)</option>
                            <option value="ti-file-description" {{ old('icone', $typeEpreuve->icone) == 'ti-file-description' ? 'selected' : '' }}>Description (ti-file-description)</option>
                            <option value="ti-checklist" {{ old('icone', $typeEpreuve->icone) == 'ti-checklist' ? 'selected' : '' }}>Checklist (ti-checklist)</option>
                            <option value="ti-edit" {{ old('icone', $typeEpreuve->icone) == 'ti-edit' ? 'selected' : '' }}>Édition (ti-edit)</option>
                            <option value="ti-book" {{ old('icone', $typeEpreuve->icone) == 'ti-book' ? 'selected' : '' }}>Livre (ti-book)</option>
                        </select>
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="statut" id="statut" value="1" {{ old('statut', $typeEpreuve->statut) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="statut">
                            Actif
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.types-epreuves.index') }}" class="btn btn-light px-4">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection