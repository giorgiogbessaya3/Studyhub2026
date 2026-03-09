@extends('layouts.admin')

@section('title', 'Nouveau Contenu')

@section('page-title', 'Nouveau Contenu')
@section('breadcrumb', 'Contenus')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="ti ti-file-text me-2"></i>Nouveau contenu</h5>
                        <small class="text-muted">
                            <i class="ti ti-school me-1"></i> {{ $chapitre->classe->nom }}
                            <i class="ti ti-chevron-right mx-1"></i>
                            <i class="ti ti-book me-1"></i> {{ $chapitre->matiere->nom }}
                            <i class="ti ti-chevron-right mx-1"></i>
                            <strong>{{ $chapitre->titre }}</strong>
                        </small>
                    </div>
                    <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-danger btn-sm">
                        <i class="ti ti-arrow-left me-1"></i>Retour
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- FORMULAIRE -->
                <form action="{{ route('admin.contenus.store', $chapitre) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Champ caché : chapitre_id est dans l'URL, pas besoin ici -->

                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre de la leçon <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                               value="{{ old('titre') }}" required 
                               placeholder="Ex: Développer une expression">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contenu du cours (textarea) -->
                    <div class="mb-3">
                        <label class="form-label">Contenu du cours <span class="text-danger">*</span></label>
                        <textarea name="resume" class="form-control @error('resume') is-invalid @enderror" 
                                  rows="12" required placeholder="Écrivez le cours ici...">{{ old('resume') }}</textarea>
                        @error('resume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Tu peux utiliser Markdown : **gras**, *italique*, # Titre, ## Sous-titre, - liste
                        </small>
                    </div>

                    <div class="row">
                        <!-- Images -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Images explicatives</label>
                            <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" 
                                   multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Plusieurs images possibles (max 2Mo chacune)</small>
                        </div>

                        <!-- Ordre -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ordre <span class="text-danger">*</span></label>
                            <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror" 
                                   value="{{ old('ordre', $ordreDefaut) }}" min="0" required>
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Exercices dynamiques -->
                    <div class="mb-4">
                        <label class="form-label">Exercices d'application</label>
                        <div id="exercices-container">
                            <!-- Les exercices s'ajoutent ici dynamiquement -->
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="ajouterExercice()">
                            <i class="ti ti-plus me-1"></i>Ajouter un exercice
                        </button>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-danger">
                            <i class="ti ti-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Enregistrer le contenu
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
let exerciceCount = 0;

function ajouterExercice() {
    const container = document.getElementById('exercices-container');
    const index = exerciceCount++;
    
    const html = `
        <div class="exercice-row border rounded p-3 mb-2 bg-light">
            <div class="d-flex justify-content-between mb-2">
                <strong class="text-primary">Exercice ${index + 1}</strong>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.exercice-row').remove()">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
            <div class="mb-2">
                <input type="text" name="exercices[${index}][question]" 
                       class="form-control form-control-sm" 
                       placeholder="Question" required>
            </div>
            <div>
                <input type="text" name="exercices[${index}][reponse]" 
                       class="form-control form-control-sm" 
                       placeholder="Réponse (visible pour l'élève)" required>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

// Ajouter un exercice par défaut
document.addEventListener('DOMContentLoaded', function() {
    @if(old('exercices'))
        @foreach(old('exercices') as $index => $exercice)
            ajouterExercice();
            document.querySelector(`[name="exercices[{{ $index }}][question]"]`).value = "{{ $exercice['question'] }}";
            document.querySelector(`[name="exercices[{{ $index }}][reponse]"]`).value = "{{ $exercice['reponse'] }}";
        @endforeach
    @endif
});
</script>
@endpush