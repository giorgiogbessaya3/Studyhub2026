@extends('layouts.admin')

@section('title', 'Modifier une question - StudyHub Admin')
@section('page-title', 'Modifier une question')
@section('breadcrumb', 'Questions / Modification')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Modifier la question</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Sélection du quiz -->
                    <div class="mb-4">
                        <label class="form-label">Quiz <span class="text-danger">*</span></label>
                        <select name="quiz_id" id="quiz_id" class="form-select @error('quiz_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un quiz</option>
                            @foreach($quizs as $quiz)
                                <option value="{{ $quiz->id }}" {{ old('quiz_id', $question->quiz_id) == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->titre }} ({{ $quiz->classe->nom ?? 'N/A' }} - {{ $quiz->matiere->nom ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('quiz_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Filtres rapides pour trouver un quiz -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par classe</label>
                            <select id="filter_classe" class="form-select">
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ $classe->id == $question->quiz->classe_id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par matière</label>
                            <select id="filter_matiere" class="form-select" {{ $question->quiz->classe_id ? '' : 'disabled' }}>
                                <option value="">Toutes les matières</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ $matiere->id == $question->quiz->matiere_id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par chapitre</label>
                            <select id="filter_chapitre" class="form-select" {{ $question->quiz->matiere_id ? '' : 'disabled' }}>
                                <option value="">Tous les chapitres</option>
                                @foreach($chapitres as $chapitre)
                                    <option value="{{ $chapitre->id }}" {{ $chapitre->id == $question->quiz->chapitre_id ? 'selected' : '' }}>
                                        {{ $chapitre->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Type de question -->
                    <div class="mb-4">
                        <label class="form-label">Type de question <span class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="type" id="type_qcm" value="qcm" {{ old('type', $question->type) == 'qcm' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_qcm">
                                        <div class="card p-3 {{ old('type', $question->type) == 'qcm' ? 'border-primary' : '' }}">
                                            <div class="text-center">
                                                <i class="ti ti-list-check fs-1 mb-2 text-primary"></i>
                                                <h6 class="mb-0">QCM</h6>
                                                <small class="text-muted">Choix multiples</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="type" id="type_vrai_faux" value="vrai_faux" {{ old('type', $question->type) == 'vrai_faux' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_vrai_faux">
                                        <div class="card p-3 {{ old('type', $question->type) == 'vrai_faux' ? 'border-primary' : '' }}">
                                            <div class="text-center">
                                                <i class="ti ti-toggle fs-1 mb-2 text-success"></i>
                                                <h6 class="mb-0">Vrai/Faux</h6>
                                                <small class="text-muted">Deux options</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="type" id="type_texte" value="texte" {{ old('type', $question->type) == 'texte' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_texte">
                                        <div class="card p-3 {{ old('type', $question->type) == 'texte' ? 'border-primary' : '' }}">
                                            <div class="text-center">
                                                <i class="ti ti-text fs-1 mb-2 text-warning"></i>
                                                <h6 class="mb-0">Question ouverte</h6>
                                                <small class="text-muted">Réponse texte</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('type')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Titre de la question -->
                    <div class="mb-3">
                        <label class="form-label">Question <span class="text-danger">*</span></label>
                        <textarea name="titre" rows="2" class="form-control @error('titre') is-invalid @enderror" 
                                  placeholder="Écrivez votre question ici...">{{ old('titre', $question->titre) }}</textarea>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Options QCM -->
                    <div id="qcm-options" class="mb-3" style="{{ old('type', $question->type) == 'qcm' ? '' : 'display: none;' }}">
                        <label class="form-label">Options de réponse <span class="text-danger">*</span></label>
                        <div id="options-container">
                            @php
                                $options = old('options', $question->options ?? ['', '', '', '']);
                                if (!is_array($options)) {
                                    $options = ['', '', '', ''];
                                }
                            @endphp
                            @foreach($options as $index => $option)
                            <div class="input-group mb-2 option-row">
                                <span class="input-group-text">{{ chr(65 + $index) }}</span>
                                <input type="text" name="options[]" class="form-control" placeholder="Option {{ chr(65 + $index) }}" value="{{ $option }}">
                                <button type="button" class="btn btn-outline-danger remove-option" onclick="removeOption(this)" {{ $loop->first ? 'disabled' : '' }}>
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption()">
                            <i class="ti ti-plus me-1"></i> Ajouter une option
                        </button>
                    </div>

                    <!-- Bonne réponse - CHAMP UNIQUE avec gestion dynamique -->
                    <div class="mb-3">
                        <label class="form-label">Bonne réponse <span class="text-danger">*</span></label>
                        
                        <!-- Champ caché qui contiendra la valeur réelle -->
                        <input type="hidden" name="bonne_reponse" id="bonne_reponse_value" value="{{ old('bonne_reponse', $question->bonne_reponse) }}">
                        
                        <!-- Interface QCM -->
                        <div id="reponse-qcm" style="{{ old('type', $question->type) == 'qcm' ? '' : 'display: none;' }}">
                            <select id="bonne_reponse_qcm" class="form-select @error('bonne_reponse') is-invalid @enderror" onchange="document.getElementById('bonne_reponse_value').value = this.value">
                                <option value="">Sélectionner la bonne réponse</option>
                                @if($question->type == 'qcm' && $question->options)
                                    @foreach($question->options as $index => $option)
                                        <option value="{{ chr(65 + $index) }}" 
                                            {{ old('bonne_reponse', $question->bonne_reponse) == chr(65 + $index) ? 'selected' : '' }}>
                                            Option {{ chr(65 + $index) }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach(old('options', ['', '', '', '']) as $index => $option)
                                        @if(!empty($option))
                                            <option value="{{ chr(65 + $index) }}">Option {{ chr(65 + $index) }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <!-- Interface Vrai/Faux -->
                        <div id="reponse-vrai-faux" style="{{ old('type', $question->type) == 'vrai_faux' ? '' : 'display: none;' }}">
                            <select id="bonne_reponse_vf" class="form-select @error('bonne_reponse') is-invalid @enderror" onchange="document.getElementById('bonne_reponse_value').value = this.value">
                                <option value="">Sélectionner</option>
                                <option value="vrai" {{ old('bonne_reponse', $question->bonne_reponse) == 'vrai' ? 'selected' : '' }}>Vrai</option>
                                <option value="faux" {{ old('bonne_reponse', $question->bonne_reponse) == 'faux' ? 'selected' : '' }}>Faux</option>
                            </select>
                        </div>
                        
                        <!-- Interface Texte -->
                        <div id="reponse-texte" style="{{ old('type', $question->type) == 'texte' ? '' : 'display: none;' }}">
                            <input type="text" id="bonne_reponse_text" class="form-control @error('bonne_reponse') is-invalid @enderror" 
                                   placeholder="Entrez la réponse attendue" value="{{ old('bonne_reponse', $question->bonne_reponse) }}"
                                   oninput="document.getElementById('bonne_reponse_value').value = this.value">
                        </div>
                        
                        @error('bonne_reponse')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Points <span class="text-danger">*</span></label>
                            <input type="number" name="points" class="form-control @error('points') is-invalid @enderror" 
                                   value="{{ old('points', $question->points) }}" min="1" max="10">
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            @if($question->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($question->image) }}" alt="" class="img-fluid rounded" style="max-height: 80px;">
                                    <small class="text-muted d-block">Image actuelle</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2 d-none">
                                <img src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 100px;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Explication (optionnelle)</label>
                        <textarea name="explication" rows="3" class="form-control @error('explication') is-invalid @enderror" 
                                  placeholder="Expliquez pourquoi cette réponse est correcte...">{{ old('explication', $question->explication) }}</textarea>
                        @error('explication')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Mettre à jour
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
    .card-radio .form-check-input {
        position: absolute;
        opacity: 0;
    }
    .card-radio .form-check-input:checked + .form-check-label .card {
        border: 2px solid var(--primary);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }
    .card-radio .card {
        cursor: pointer;
        transition: all 0.2s;
    }
    .card-radio .card:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le type de question
        const checkedType = document.querySelector('input[name="type"]:checked');
        if (checkedType) {
            updateQuestionType(checkedType.value);
        }
        
        // Initialiser les filtres
        const filterClasse = document.getElementById('filter_classe');
        if (filterClasse.value) {
            loadMatieres(false);
        }
        
        const filterMatiere = document.getElementById('filter_matiere');
        if (filterMatiere.value && filterMatiere.value !== '') {
            loadChapitres(false);
        }

        // Synchroniser les valeurs initiales
        syncBonneReponse();
    });

    // Gestion du changement de type de question
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateQuestionType(this.value);
        });
    });

    function updateQuestionType(type) {
        // Mettre à jour les styles des cartes
        document.querySelectorAll('.card-radio .card').forEach(card => {
            card.classList.remove('border-primary');
        });
        document.querySelector(`input[name="type"][value="${type}"]`).closest('.card-radio').querySelector('.card').classList.add('border-primary');

        // Afficher/masquer les sections appropriées
        document.getElementById('qcm-options').style.display = type === 'qcm' ? 'block' : 'none';
        document.getElementById('reponse-qcm').style.display = type === 'qcm' ? 'block' : 'none';
        document.getElementById('reponse-vrai-faux').style.display = type === 'vrai_faux' ? 'block' : 'none';
        document.getElementById('reponse-texte').style.display = type === 'texte' ? 'block' : 'none';
        
        // Mettre à jour le champ caché avec la valeur appropriée
        syncBonneReponse();
        
        // Mettre à jour le select QCM si nécessaire
        if (type === 'qcm') {
            updateQcmSelect();
        }
    }

    function syncBonneReponse() {
        const type = document.querySelector('input[name="type"]:checked')?.value;
        const hiddenField = document.getElementById('bonne_reponse_value');
        
        if (type === 'qcm') {
            const select = document.getElementById('bonne_reponse_qcm');
            if (select.value) hiddenField.value = select.value;
        } else if (type === 'vrai_faux') {
            const select = document.getElementById('bonne_reponse_vf');
            if (select.value) hiddenField.value = select.value;
        } else if (type === 'texte') {
            const input = document.getElementById('bonne_reponse_text');
            if (input.value) hiddenField.value = input.value;
        }
    }

    function addOption() {
        const container = document.getElementById('options-container');
        const optionCount = container.children.length;
        
        if (optionCount >= 6) {
            alert('Vous ne pouvez pas ajouter plus de 6 options');
            return;
        }
        
        const letter = String.fromCharCode(65 + optionCount);
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2 option-row';
        div.innerHTML = `
            <span class="input-group-text">${letter}</span>
            <input type="text" name="options[]" class="form-control" placeholder="Option ${letter}" value="">
            <button type="button" class="btn btn-outline-danger remove-option" onclick="removeOption(this)">
                <i class="ti ti-trash"></i>
            </button>
        `;
        container.appendChild(div);
        
        updateOptionLetters();
        updateQcmSelect();
    }

    function removeOption(button) {
        if (document.querySelectorAll('.option-row').length <= 2) {
            alert('Vous devez garder au moins 2 options');
            return;
        }
        button.closest('.option-row').remove();
        updateOptionLetters();
        updateQcmSelect();
    }

    function updateOptionLetters() {
        document.querySelectorAll('.option-row').forEach((row, index) => {
            const letter = String.fromCharCode(65 + index);
            row.querySelector('.input-group-text').textContent = letter;
            row.querySelector('input').placeholder = `Option ${letter}`;
        });
    }

    function updateQcmSelect() {
        const select = document.getElementById('bonne_reponse_qcm');
        const options = document.querySelectorAll('.option-row');
        
        select.innerHTML = '<option value="">Sélectionner la bonne réponse</option>';
        options.forEach((row, index) => {
            const letter = String.fromCharCode(65 + index);
            select.innerHTML += `<option value="${letter}">Option ${letter}</option>`;
        });
        
        // Restaurer la valeur sélectionnée si elle existe
        const hiddenValue = document.getElementById('bonne_reponse_value').value;
        if (hiddenValue && hiddenValue.match(/^[A-F]$/)) {
            select.value = hiddenValue;
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

    // Filtres pour les quiz
    document.getElementById('filter_classe').addEventListener('change', function() {
        loadMatieres(true);
    });
    
    document.getElementById('filter_matiere').addEventListener('change', function() {
        loadChapitres(true);
    });
    
    document.getElementById('filter_chapitre').addEventListener('change', filterQuizs);

    function loadMatieres(resetQuiz = true) {
        const classeId = document.getElementById('filter_classe').value;
        const matiereSelect = document.getElementById('filter_matiere');
        
        matiereSelect.innerHTML = '<option value="">Chargement...</option>';
        matiereSelect.disabled = true;
        document.getElementById('filter_chapitre').innerHTML = '<option value="">Sélectionnez d\'abord une matière</option>';
        document.getElementById('filter_chapitre').disabled = true;
        
        if (classeId) {
            fetch(`/admin/api/matieres?classe_id=${classeId}`)
                .then(response => response.json())
                .then(data => {
                    matiereSelect.innerHTML = '<option value="">Toutes les matières</option>';
                    data.forEach(matiere => {
                        const selected = (matiere.id == '{{ $question->quiz->matiere_id }}') ? 'selected' : '';
                        matiereSelect.innerHTML += `<option value="${matiere.id}" ${selected}>${matiere.nom}</option>`;
                    });
                    matiereSelect.disabled = false;
                    
                    if (resetQuiz) {
                        document.getElementById('quiz_id').innerHTML = '<option value="">Sélectionner un quiz</option>';
                    }
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.innerHTML = '<option value="">Sélectionnez d\'abord une classe</option>';
            matiereSelect.disabled = true;
        }
    }

    function loadChapitres(resetQuiz = true) {
        const classeId = document.getElementById('filter_classe').value;
        const matiereId = document.getElementById('filter_matiere').value;
        const chapitreSelect = document.getElementById('filter_chapitre');
        
        chapitreSelect.innerHTML = '<option value="">Chargement...</option>';
        chapitreSelect.disabled = true;
        
        if (classeId && matiereId && matiereId !== '') {
            fetch(`/admin/api/chapitres?classe_id=${classeId}&matiere_id=${matiereId}`)
                .then(response => response.json())
                .then(data => {
                    chapitreSelect.innerHTML = '<option value="">Tous les chapitres</option>';
                    data.forEach(chapitre => {
                        const selected = (chapitre.id == '{{ $question->quiz->chapitre_id }}') ? 'selected' : '';
                        chapitreSelect.innerHTML += `<option value="${chapitre.id}" ${selected}>${chapitre.nom}</option>`;
                    });
                    chapitreSelect.disabled = false;
                    
                    if (resetQuiz) {
                        document.getElementById('quiz_id').innerHTML = '<option value="">Sélectionner un quiz</option>';
                    }
                })
                .catch(() => {
                    chapitreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            chapitreSelect.innerHTML = '<option value="">Sélectionnez d\'abord une matière</option>';
            chapitreSelect.disabled = true;
        }
    }

    function filterQuizs() {
        const classeId = document.getElementById('filter_classe').value;
        const matiereId = document.getElementById('filter_matiere').value;
        const chapitreId = document.getElementById('filter_chapitre').value;
        const quizSelect = document.getElementById('quiz_id');
        
        if (classeId && matiereId && matiereId !== '') {
            let url = `/admin/api/quizs?classe_id=${classeId}&matiere_id=${matiereId}`;
            if (chapitreId && chapitreId !== '') {
                url += `&chapitre_id=${chapitreId}`;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    quizSelect.innerHTML = '<option value="">Sélectionner un quiz</option>';
                    data.forEach(quiz => {
                        const selected = (quiz.id == '{{ $question->quiz_id }}') ? 'selected' : '';
                        quizSelect.innerHTML += `<option value="${quiz.id}" ${selected}>${quiz.titre}</option>`;
                    });
                });
        }
    }
</script>
@endpush