@extends('layouts.admin')

@section('title', 'Modifier le Contenu')

@section('page-title', 'Modifier le Contenu')
@section('breadcrumb', 'Contenus')

@section('content')

<style>
.ck-editor__editable {
    min-height: 400px;
    max-height: 600px;
}
.ck-editor__editable.exercice-question {
    min-height: 150px;
    max-height: 300px;
}
.ck-editor__editable.exercice-reponse {
    min-height: 150px;
    max-height: 300px;
    background-color: #f9f9f9;
}
.ck-content {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
}
.ck-content h1 {
    font-size: 2em;
    font-weight: bold;
    margin: 0.67em 0;
}
.ck-content h2 {
    font-size: 1.5em;
    font-weight: bold;
    margin: 0.83em 0;
}
.ck-content h3 {
    font-size: 1.17em;
    font-weight: bold;
    margin: 1em 0;
}
.ck-content p {
    margin: 1em 0;
}
.ck-content .math-tex {
    background: #f3f4f6;
    padding: 0.5em;
    border-radius: 4px;
    font-family: monospace;
}
.ck-content table {
    width: 100%;
    border-collapse: collapse;
}
.ck-content td, .ck-content th {
    border: 1px solid #ddd;
    padding: 8px;
}
.exercice-row {
    transition: all 0.3s ease;
    border-left: 4px solid #0d6efd;
    margin-bottom: 1rem;
    background-color: #f8f9fa;
}
.exercice-row:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.image-preview {
    position: relative;
    display: inline-block;
    margin: 5px;
}
.image-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #ddd;
}
.image-preview .delete-image {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 24px;
    height: 24px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    border: 2px solid white;
}
.image-preview .delete-image:hover {
    background: #bb2d3b;
}
</style>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="ti ti-edit me-2"></i>Modifier le contenu</h5>
                        <small class="text-muted">
                            <i class="ti ti-school me-1"></i> {{ $contenu->chapitre->classe->nom }}
                            <i class="ti ti-chevron-right mx-1"></i>
                            <i class="ti ti-book me-1"></i> {{ $contenu->chapitre->matiere->nom }}
                            <i class="ti ti-chevron-right mx-1"></i>
                            <strong>{{ $contenu->chapitre->titre }}</strong>
                        </small>
                    </div>
                    <div>
                        <a href="{{ route('admin.contenus.show', $contenu) }}" class="btn btn-info btn-sm me-2">
                            <i class="ti ti-eye me-1"></i>Voir
                        </a>
                        <a href="{{ route('admin.chapitres.edit', $contenu->chapitre) }}" class="btn btn-danger btn-sm">
                            <i class="ti ti-arrow-left me-1"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.contenus.update', $contenu) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      id="contenuForm"
                      novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre de la leçon <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                               value="{{ old('titre', $contenu->titre) }}" required 
                               placeholder="Ex: Les logarithmes népériens">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contenu du cours avec CKEditor -->
                    <div class="mb-3">
                        <label class="form-label">Contenu du cours <span class="text-danger">*</span></label>
                        <textarea name="resume" 
                                  id="editor-contenu" 
                                  class="form-control @error('resume') is-invalid @enderror" 
                                  rows="12" 
                                  placeholder="Écrivez votre cours ici...">{{ old('resume', $contenu->resume) }}</textarea>
                        @error('resume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i> 
                            Vous pouvez copier directement depuis Word, utiliser les formules mathématiques (√, ∫, ∑, etc.), 
                            et mettre en forme votre texte (gras, italique, titres, couleurs...)
                        </small>
                    </div>

                    <div class="row">
                        <!-- Images existantes -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Images existantes</label>
                            <div id="existing-images" class="d-flex flex-wrap gap-2 mb-3">
                                @if($contenu->images && is_array($contenu->images) && count($contenu->images) > 0)
                                    @foreach($contenu->images as $index => $image)
                                        <div class="image-preview" id="image-{{ $index }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Image {{ $index + 1 }}">
                                            <div class="delete-image" onclick="supprimerImageExistante('{{ $image }}', {{ $index }})">
                                                <i class="ti ti-x"></i>
                                            </div>
                                            <input type="hidden" name="existing_images[]" value="{{ $image }}" id="hidden-image-{{ $index }}">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">Aucune image existante</p>
                                @endif
                            </div>
                            
                            <label class="form-label">Ajouter de nouvelles images</label>
                            <input type="file" name="new_images[]" class="form-control @error('new_images.*') is-invalid @enderror" 
                                   multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('new_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Plusieurs images possibles (max 2Mo chacune)</small>
                            
                            <!-- Champ caché pour les images à supprimer -->
                            <input type="hidden" name="delete_images" id="delete_images" value="">
                        </div>

                        <!-- Ordre -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ordre <span class="text-danger">*</span></label>
                            <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror" 
                                   value="{{ old('ordre', $contenu->ordre) }}" min="0" required>
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Exercices dynamiques avec éditeurs -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0">Exercices d'application</label>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="ajouterExercice()">
                                <i class="ti ti-plus me-1"></i>Ajouter un exercice
                            </button>
                        </div>
                        
                        <div id="exercices-container">
                            <!-- Les exercices seront chargés ici via JavaScript -->
                        </div>
                        
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Chaque exercice peut contenir du texte formaté, des formules mathématiques et des images.
                        </small>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.chapitres.edit', $contenu->chapitre) }}" class="btn btn-danger">
                            <i class="ti ti-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="ti ti-check me-1"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/fr.js"></script>

<script>
// Configuration commune pour tous les éditeurs
const editorConfig = {
    language: 'fr',
    toolbar: {
        items: [
            'heading',
            '|',
            'bold', 'italic', 'underline', 'strikethrough',
            'subscript', 'superscript',
            '|',
            'bulletedList', 'numberedList',
            '|',
            'alignment', 'outdent', 'indent',
            '|',
            'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
            'highlight',
            '|',
            'link', 'blockQuote', 'insertTable',
            '|',
            'undo', 'redo',
            '|',
            'horizontalLine', 'specialCharacters', 'removeFormat'
        ]
    },
    fontSize: {
        options: [9, 10, 11, 12, 13, 14, 16, 18, 20, 22, 24, 26, 28, 36, 48],
        supportAllValues: true
    },
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Times New Roman, Times, serif',
            'Verdana, Geneva, sans-serif'
        ]
    },
    table: {
        contentToolbar: [
            'tableColumn', 'tableRow', 'mergeTableCells',
            'tableProperties', 'tableCellProperties'
        ]
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' }
        ]
    },
    htmlSupport: {
        allow: [
            { name: /.*/, attributes: true, classes: true, styles: true }
        ]
    }
};

let exerciceCount = 0;
let editorInstances = {
    contenu: null,
    exercices: {}
};
let imagesToDelete = [];

// Fonction pour ajouter un exercice
function ajouterExercice(question = '', reponse = '') {
    const container = document.getElementById('exercices-container');
    const index = exerciceCount++;
    
    // Échapper les guillemets pour éviter les erreurs JavaScript
    question = question.replace(/"/g, '&quot;');
    reponse = reponse.replace(/"/g, '&quot;');
    
    const html = `
        <div class="exercice-row border rounded p-3 bg-light" id="exercice-${index}" data-index="${index}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-primary mb-0">
                    <i class="ti ti-puzzle me-1"></i>Exercice ${index + 1}
                </h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="supprimerExercice(${index})">
                    <i class="ti ti-trash me-1"></i>Supprimer
                </button>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-sm fw-bold">Question</label>
                    <textarea name="exercices[${index}][question]" 
                              id="exercice-question-${index}"
                              class="form-control exercice-question-editor"
                              rows="4">${question}</textarea>
                    <small class="text-muted">Énoncé de l'exercice</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-sm fw-bold">Réponse</label>
                    <textarea name="exercices[${index}][reponse]" 
                              id="exercice-reponse-${index}"
                              class="form-control exercice-reponse-editor"
                              rows="4">${reponse}</textarea>
                    <small class="text-muted">Correction détaillée</small>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    
    // Initialiser les éditeurs pour ce nouvel exercice
    setTimeout(() => {
        initialiserEditeurExercice(index);
    }, 200);
}

// Fonction pour supprimer un exercice
function supprimerExercice(index) {
    const element = document.getElementById(`exercice-${index}`);
    if (element) {
        // Détruire les instances d'éditeurs
        if (editorInstances.exercices[index]) {
            if (editorInstances.exercices[index].question) {
                editorInstances.exercices[index].question.destroy()
                    .catch(error => console.warn('Erreur lors de la destruction:', error));
            }
            if (editorInstances.exercices[index].reponse) {
                editorInstances.exercices[index].reponse.destroy()
                    .catch(error => console.warn('Erreur lors de la destruction:', error));
            }
            delete editorInstances.exercices[index];
        }
        element.remove();
    }
}

// Fonction pour initialiser l'éditeur d'un exercice
function initialiserEditeurExercice(index) {
    const questionElement = document.getElementById(`exercice-question-${index}`);
    const reponseElement = document.getElementById(`exercice-reponse-${index}`);
    
    if (questionElement && !editorInstances.exercices[index]?.question) {
        ClassicEditor
            .create(questionElement, {
                ...editorConfig,
                placeholder: 'Saisissez la question...'
            })
            .then(editor => {
                if (!editorInstances.exercices[index]) {
                    editorInstances.exercices[index] = {};
                }
                editorInstances.exercices[index].question = editor;
                console.log(`Éditeur question ${index} initialisé`);
            })
            .catch(error => {
                console.error(`Erreur éditeur question ${index}:`, error);
            });
    }
    
    if (reponseElement && !editorInstances.exercices[index]?.reponse) {
        ClassicEditor
            .create(reponseElement, {
                ...editorConfig,
                placeholder: 'Saisissez la réponse...'
            })
            .then(editor => {
                if (!editorInstances.exercices[index]) {
                    editorInstances.exercices[index] = {};
                }
                editorInstances.exercices[index].reponse = editor;
                console.log(`Éditeur réponse ${index} initialisé`);
            })
            .catch(error => {
                console.error(`Erreur éditeur réponse ${index}:`, error);
            });
    }
}

// Fonction pour supprimer une image existante
function supprimerImageExistante(imagePath, index) {
    if (confirm('Voulez-vous vraiment supprimer cette image ?')) {
        // Ajouter l'image à la liste des images à supprimer
        imagesToDelete.push(imagePath);
        document.getElementById('delete_images').value = JSON.stringify(imagesToDelete);
        
        // Masquer l'image
        document.getElementById(`image-${index}`).style.display = 'none';
    }
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page chargée, initialisation des éditeurs...');
    
    // Initialiser l'éditeur principal
    const contenuElement = document.querySelector('#editor-contenu');
    
    if (contenuElement) {
        ClassicEditor
            .create(contenuElement, {
                ...editorConfig,
                placeholder: 'Écrivez votre cours ici...'
            })
            .then(editor => {
                editorInstances.contenu = editor;
                console.log('Éditeur contenu initialisé');
            })
            .catch(error => {
                console.error('Erreur éditeur contenu:', error);
            });
    }

    // Charger les exercices existants
    @php
        $exercices = $contenu->exercices ?? [];
        $hasExercices = is_array($exercices) && count($exercices) > 0;
    @endphp

    @if($hasExercices)
        @foreach($exercices as $exercice)
            ajouterExercice(
                '{!! str_replace(["\r", "\n", "'"], ["", "", "\\'"], addslashes($exercice['question'] ?? '')) !!}',
                '{!! str_replace(["\r", "\n", "'"], ["", "", "\\'"], addslashes($exercice['reponse'] ?? '')) !!}'
            );
        @endforeach
    @else
        // Ajouter un exercice vide par défaut
        ajouterExercice();
    @endif
    
    // Gestion de la soumission du formulaire
    const form = document.getElementById('contenuForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Tentative de soumission du formulaire');
            
            // Empêcher la double soumission
            if (form.dataset.submitting === 'true') {
                e.preventDefault();
                return;
            }
            
            // Vérifier que le contenu n'est pas vide
            if (editorInstances.contenu && !editorInstances.contenu.getData().trim()) {
                alert('Le contenu du cours est requis');
                e.preventDefault();
                return;
            }
            
            form.dataset.submitting = 'true';
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mise à jour...';
            
            // Mettre à jour les valeurs des textarea avec le contenu des éditeurs
            if (editorInstances.contenu) {
                document.querySelector('#editor-contenu').value = editorInstances.contenu.getData();
            }
            
            // Mettre à jour les valeurs des exercices
            Object.keys(editorInstances.exercices).forEach(index => {
                const exercice = editorInstances.exercices[index];
                if (exercice.question) {
                    const questionField = document.querySelector(`#exercice-question-${index}`);
                    if (questionField) {
                        questionField.value = exercice.question.getData();
                    }
                }
                if (exercice.reponse) {
                    const reponseField = document.querySelector(`#exercice-reponse-${index}`);
                    if (reponseField) {
                        reponseField.value = exercice.reponse.getData();
                    }
                }
            });
            
            console.log('Données mises à jour, soumission...');
            return true;
        });
    }
});
</script>
@endpush