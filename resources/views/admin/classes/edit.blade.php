@extends('layouts.admin')

@section('title', 'Modifier la Classe - StudyHub')

@section('page-title', 'Modifier la Classe')
@section('breadcrumb', 'Édition')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Modifier : {{ $classe->nom }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.classes.update', $classe) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom de la classe <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               name="nom" value="{{ old('nom', $classe->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cycle <span class="text-danger">*</span></label>
                        <select class="form-select @error('cycle') is-invalid @enderror" name="cycle" required>
                            <option value="">Sélectionner...</option>
                            <option value="college" {{ old('cycle', $classe->cycle) == 'college' ? 'selected' : '' }}>Collège</option>
                            <option value="lycee" {{ old('cycle', $classe->cycle) == 'lycee' ? 'selected' : '' }}>Lycée</option>
                        </select>
                        @error('cycle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="3">{{ old('description', $classe->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ordre d'affichage</label>
                        <input type="number" class="form-control @error('ordre') is-invalid @enderror" 
                               name="ordre" value="{{ old('ordre', $classe->ordre) }}" min="0">
                        @error('ordre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="statut" value="1" 
                               {{ old('statut', $classe->statut) ? 'checked' : '' }}>
                        <label class="form-check-label">Classe active</label>
                    </div>
                    
                    <div class="d-flex gap-2 float-end">
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-danger">
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
</div>

@endsection