@extends('layouts.admin')

@section('title', 'Créer une question - StudyHub Admin')
@section('page-title', 'Créer une question')
@section('breadcrumb', 'Questions / Création')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Nouvelle question</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/questions') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Sélection du quiz -->
                    <div class="mb-4">
                        <label class="form-label">Quiz <span class="text-danger">*</span></label>
                        <select name="quiz_id" id="quiz_id" class="form-select @error('quiz_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un quiz</option>
                            @foreach($quizs as $quiz)
                                <option value="{{ $quiz->id }}" {{ old('quiz_id', $selectedQuiz->id ?? '') == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->titre }} ({{ $quiz->classe->nom }} - {{ $quiz->matiere->nom }})
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
                                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par matière</label>
                            <select id="filter_matiere" class="form-select" disabled>
                                <option value="">Sélectionnez d'abord une classe</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par chapitre</label>
                            <select id="filter_chapitre" class="form-select" disabled>
                                <option value="">Sélectionnez d'abord une matière</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Type de question -->
                    <div class="mb-4">
                        <label class="form-label">Type de question <span class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="type" id="type_qcm" value="qcm" {{ old('type', 'qcm') == 'qcm' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_qcm">
                                        <div class="card p-3 {{ old('type', 'qcm') == 'qcm' ? 'border-primary' : '' }}">
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
                                    <input class="form-check-input" type="radio" name="type" id="type_vrai_faux" value="vrai_faux" {{ old('type') == 'vrai_faux' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_vrai_faux">
                                        <div class="card p-3 {{ old('type') == 'vrai_faux' ? 'border-primary' : '' }}">
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
                                    <input class="form-check-input" type="radio" name="type" id="type_texte" value="texte" {{ old('type') == 'texte' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_texte">
                                        <div class="card p-3 {{ old('type') == 'texte' ? 'border-primary' : '' }}">
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
                                  placeholder="Écrivez votre question ici...">{{ old('titre') }}</textarea>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Options QCM -->
                    <div id="qcm-options" class="mb-3" style="{{ old('type', 'qcm') == 'qcm' ? '' : 'display: none;' }}">
                        <label class="form-label">Options de réponse <span class="text-danger">*</span></label>
                        <div id="options-container">
                            @php
                                $oldOptions = old('options', ['', '', '', '']);
                            @endphp
                            @foreach($oldOptions as $index => $option)
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

                    <!-- Bonne réponse -->
                    <div class="mb-3">
                        <label class="form-label">Bonne réponse <span class="text-danger">*</span></label>
                        <div id="reponse-container">
                            <div id="reponse-qcm" style="{{ old('type', 'qcm') == 'qcm' ? '' : 'display: none;' }}">
                                <select name="bonne_reponse" class="form-select @error('bonne_reponse') is-invalid @enderror">
                                    <option value="">Sélectionner la bonne réponse</option>
                                    @foreach(old('options', ['A', 'B', 'C', 'D']) as $index => $option)
                                        <option value="{{ chr(65 + $index) }}" {{ old('bonne_reponse') == chr(65 + $index) ? 'selected' : '' }}>
                                            Option {{ chr(65 + $index) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div id="reponse-vrai-faux" style="{{ old('type') == 'vrai_faux' ? '' : 'display: none;' }}">
                                <select name="bonne_reponse" class="form-select @error('bonne_reponse') is-invalid @enderror">
                                    <option value="">Sélectionner</option>
                                    <option value="vrai" {{ old('bonne_reponse') == 'vrai' ? 'selected' : '' }}>Vrai</option>
                                    <option value="faux" {{ old('bonne_reponse') == 'faux' ? 'selected' : '' }}>Faux</option>
                                </select>
                            </div>
                            
                            <div id="reponse-texte" style="{{ old('type') == 'texte' ? '' : 'display: none;' }}">
                                <input type="text" name="bonne_reponse" class="form-control @error('bonne_reponse') is-invalid @enderror" 
                                       placeholder="Entrez la réponse attendue" value="{{ old('bonne_reponse') }}">
                            </div>
                        </div>
                        @error('bonne_reponse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Points <span class="text-danger">*</span></label>
                            <input type="number" name="points" class="form-control @error('points') is-invalid @enderror" 
                                   value="{{ old('points', 1) }}" min="1" max="10">
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image (optionnelle)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Format: JPG, PNG, GIF - Max 2 Mo</small>
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
                                  placeholder="Expliquez pourquoi cette réponse est correcte...">{{ old('explication') }}</textarea>
                        @error('explication')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('admin/questions') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Enregistrer la question
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
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateQuestionType(this.value);
        });
    });

    function updateQuestionType(type) {
        document.querySelectorAll('.card-radio .card').forEach(card => {
            card.classList.remove('border-primary');
        });
        document.querySelector(`input[name="type"][value="${type}"]`).closest('.card-radio').querySelector('.card').classList.add('border-primary');

        document.getElementById('qcm-options').style.display = type === 'qcm' ? 'block' : 'none';
        document.getElementById('reponse-qcm').style.display = type === 'qcm' ? 'block' : 'none';
        document.getElementById('reponse-vrai-faux').style.display = type === 'vrai_faux' ? 'block' : 'none';
        document.getElementById('reponse-texte').style.display = type === 'texte' ? 'block' : 'none';
        
        if (type === 'qcm') {
            updateQcmSelect();
        }
    }

    function addOption() {
        const container = document.getElementById('options-container');
        const optionCount = container.children.length;
        const letter = String.fromCharCode(65 + optionCount);
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2 option-row';
        div.innerHTML = `
            <span class="input-group-text">${letter}</span>
            <input type="text" name="options[]" class="form-control" placeholder="Option ${letter}">
            <button type="button" class="btn btn-outline-danger remove-option" onclick="removeOption(this)">
                <i class="ti ti-trash"></i>
            </button>
        `;
        container.appendChild(div);
        
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
        const select = document.querySelector('#reponse-qcm select');
        const options = document.querySelectorAll('.option-row');
        
        select.innerHTML = '<option value="">Sélectionner la bonne réponse</option>';
        options.forEach((row, index) => {
            const letter = String.fromCharCode(65 + index);
            select.innerHTML += `<option value="${letter}">Option ${letter}</option>`;
        });
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
    document.getElementById('filter_classe').addEventListener('change', loadMatieres);
    document.getElementById('filter_matiere').addEventListener('change', loadChapitres);
    document.getElementById('filter_chapitre').addEventListener('change', filterQuizs);

    function loadMatieres() {
        const classeId = document.getElementById('filter_classe').value;
        const matiereSelect = document.getElementById('filter_matiere');
        
        matiereSelect.innerHTML = '<option value="">Chargement...</option>';
        matiereSelect.disabled = true;
        
        if (classeId) {
            fetch(`/admin/api/matieres?classe_id=${classeId}`)
                .then(response => response.json())
                .then(data => {
                    matiereSelect.innerHTML = '<option value="">Toutes les matières</option>';
                    data.forEach(matiere => {
                        matiereSelect.innerHTML += `<option value="${matiere.id}">${matiere.nom}</option>`;
                    });
                    matiereSelect.disabled = false;
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.innerHTML = '<option value="">Sélectionnez d\'abord une classe</option>';
            matiereSelect.disabled = true;
            document.getElementById('filter_chapitre').innerHTML = '<option value="">Sélectionnez d\'abord une matière</option>';
            document.getElementById('filter_chapitre').disabled = true;
        }
    }

    function loadChapitres() {
        const classeId = document.getElementById('filter_classe').value;
        const matiereId = document.getElementById('filter_matiere').value;
        const chapitreSelect = document.getElementById('filter_chapitre');
        
        chapitreSelect.innerHTML = '<option value="">Chargement...</option>';
        chapitreSelect.disabled = true;
        
        if (classeId && matiereId) {
            fetch(`/admin/api/chapitres?classe_id=${classeId}&matiere_id=${matiereId}`)
                .then(response => response.json())
                .then(data => {
                    chapitreSelect.innerHTML = '<option value="">Tous les chapitres</option>';
                    data.forEach(chapitre => {
                        chapitreSelect.innerHTML += `<option value="${chapitre.id}">${chapitre.nom}</option>`;
                    });
                    chapitreSelect.disabled = false;
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
        
        if (classeId && matiereId) {
            let url = `/admin/api/quizs?classe_id=${classeId}&matiere_id=${matiereId}`;
            if (chapitreId) {
                url += `&chapitre_id=${chapitreId}`;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    quizSelect.innerHTML = '<option value="">Sélectionner un quiz</option>';
                    data.forEach(quiz => {
                        quizSelect.innerHTML += `<option value="${quiz.id}">${quiz.titre}</option>`;
                    });
                });
        }
    }
</script>
@endpush