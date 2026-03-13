@extends('layouts.admin')

@section('title', 'Importer des questions - StudyHub Admin')
@section('page-title', 'Importer des questions')
@section('breadcrumb', 'Questions / Import')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Importer des questions depuis un fichier CSV</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin.questions.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    
                    <!-- Filtres rapides pour trouver un quiz -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Filtrer par classe</label>
                            <select id="filter_classe" class="form-select">
                                <option value="">Toutes les classes</option>
                                @foreach($classes ?? [] as $classe)
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
                    
                    <div class="mb-4">
                        <label class="form-label">Quiz de destination <span class="text-danger">*</span></label>
                        <select name="quiz_id" id="quiz_id" class="form-select @error('quiz_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un quiz</option>
                            @foreach($quizs as $quiz)
                                <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->titre }} ({{ $quiz->classe->nom ?? 'N/A' }} - {{ $quiz->matiere->nom ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('quiz_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Fichier CSV <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="fichier" id="fichier" class="form-control @error('fichier') is-invalid @enderror" 
                                   accept=".csv, .txt, text/csv, text/plain" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('fichier').value = ''">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Format: CSV avec en-têtes (titre, type, options, bonne_reponse, points, explication)
                        </small>
                        @error('fichier')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Options d'import -->
                    <div class="mb-4">
                        <label class="form-label">Options d'import</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ecraser_existant" id="ecraser_existant" value="1">
                            <label class="form-check-label" for="ecraser_existant">
                                Remplacer les questions existantes du quiz
                            </label>
                            <small class="text-muted d-block">Si coché, toutes les questions actuelles seront supprimées avant l'import</small>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="ignorer_erreurs" id="ignorer_erreurs" value="1" checked>
                            <label class="form-check-label" for="ignorer_erreurs">
                                Ignorer les lignes en erreur
                            </label>
                            <small class="text-muted d-block">Continue l'import même si certaines lignes sont invalides</small>
                        </div>
                    </div>

                    <!-- Zone de prévisualisation -->
                    <div id="previewSection" class="mb-4 d-none">
                        <div class="alert alert-info">
                            <h6 class="fw-bold mb-2"><i class="ti ti-eye me-1"></i> Aperçu du fichier</h6>
                            <div id="previewContent" class="small"></div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="fw-bold mb-2"><i class="ti ti-info-circle me-1"></i> Format attendu :</h6>
                        <ul class="small mb-0">
                            <li><strong>titre</strong> : Le texte de la question (obligatoire)</li>
                            <li><strong>type</strong> : qcm, texte, ou vrai_faux (obligatoire)</li>
                            <li><strong>options</strong> : Pour les QCM, séparer les options par | (ex: "Option1|Option2|Option3|Option4")</li>
                            <li><strong>bonne_reponse</strong> : 
                                <ul class="mt-1">
                                    <li>Pour QCM : Lettre de la bonne réponse (A, B, C, D...)</li>
                                    <li>Pour Vrai/Faux : "vrai" ou "faux"</li>
                                    <li>Pour texte : La réponse attendue</li>
                                </ul>
                            </li>
                            <li><strong>points</strong> : Nombre de points (1-10, défaut: 1)</li>
                            <li><strong>explication</strong> : Explication de la réponse (optionnel)</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="fw-bold mb-2"><i class="ti ti-alert-triangle me-1"></i> Important :</h6>
                        <ul class="small mb-0">
                            <li>Le quiz doit être en mode "brouillon" pour pouvoir importer des questions</li>
                            <li>La première ligne doit contenir les en-têtes des colonnes</li>
                            <li>Utilisez le format UTF-8 pour éviter les problèmes d'encodage</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="ti ti-upload me-1"></i> Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Exemple de fichier -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Exemple de fichier CSV</h6>
                <button class="btn btn-sm btn-outline-primary" onclick="downloadExample()">
                    <i class="ti ti-download me-1"></i> Télécharger l'exemple
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>titre</th>
                                <th>type</th>
                                <th>options</th>
                                <th>bonne_reponse</th>
                                <th>points</th>
                                <th>explication</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>"Quelle est la capitale de la France ?"</td>
                                <td>qcm</td>
                                <td>"Paris|Londres|Berlin|Madrid"</td>
                                <td>A</td>
                                <td>2</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>"2 + 2 = 4 ?"</td>
                                <td>vrai_faux</td>
                                <td></td>
                                <td>vrai</td>
                                <td>1</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>"Expliquez la photosynthèse"</td>
                                <td>texte</td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                                <td>"La photosynthèse est le processus..."</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Guide d'import -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-book me-1"></i> Guide d'import</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Étape 1 : Préparation</h6>
                        <ol class="small">
                            <li>Créez votre fichier CSV avec Excel, LibreOffice ou un éditeur de texte</li>
                            <li>Assurez-vous que la première ligne contient les en-têtes</li>
                            <li>Sauvegardez au format CSV (séparateur: virgule)</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Étape 2 : Validation</h6>
                        <ol class="small">
                            <li>Vérifiez que le quiz cible est en mode "brouillon"</li>
                            <li>Pour les QCM, les options doivent être séparées par |</li>
                            <li>Les points doivent être entre 1 et 10</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-sm td, .table-sm th {
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .preview-row {
        font-size: 0.85rem;
    }
    .preview-row.invalid {
        background-color: rgba(220, 53, 69, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les filtres
        const filterClasse = document.getElementById('filter_classe');
        if (filterClasse.value) {
            loadMatieres();
        }

        // Prévisualisation du fichier
        document.getElementById('fichier').addEventListener('change', previewFile);
    });

    // Filtres pour les quiz
    document.getElementById('filter_classe').addEventListener('change', loadMatieres);
    document.getElementById('filter_matiere').addEventListener('change', loadChapitres);
    document.getElementById('filter_chapitre').addEventListener('change', filterQuizs);

    function loadMatieres() {
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
                        matiereSelect.innerHTML += `<option value="${matiere.id}">${matiere.nom}</option>`;
                    });
                    matiereSelect.disabled = false;
                    
                    // Réinitialiser la liste des quiz
                    document.getElementById('quiz_id').innerHTML = '<option value="">Sélectionner un quiz</option>';
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.innerHTML = '<option value="">Sélectionnez d\'abord une classe</option>';
            matiereSelect.disabled = true;
        }
    }

    function loadChapitres() {
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
                        chapitreSelect.innerHTML += `<option value="${chapitre.id}">${chapitre.nom}</option>`;
                    });
                    chapitreSelect.disabled = false;
                    
                    // Réinitialiser la liste des quiz
                    document.getElementById('quiz_id').innerHTML = '<option value="">Sélectionner un quiz</option>';
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
                        quizSelect.innerHTML += `<option value="${quiz.id}">${quiz.titre}</option>`;
                    });
                });
        }
    }

    function previewFile() {
        const file = document.getElementById('fichier').files[0];
        if (!file) return;

        const previewSection = document.getElementById('previewSection');
        const previewContent = document.getElementById('previewContent');
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = e.target.result;
            const lines = content.split('\n').filter(line => line.trim() !== '');
            
            if (lines.length > 0) {
                let html = '<div class="mb-2"><strong>Premières lignes :</strong></div>';
                html += '<div style="max-height: 200px; overflow-y: auto;">';
                
                // Afficher l'en-tête
                const header = lines[0].split(',').map(h => h.trim());
                html += '<div class="preview-row fw-bold border-bottom mb-1">';
                html += header.join(' | ');
                html += '</div>';
                
                // Afficher les 5 premières lignes de données
                for (let i = 1; i < Math.min(lines.length, 6); i++) {
                    const cells = lines[i].split(',').map(c => c.trim());
                    html += `<div class="preview-row small ${cells.length < 4 ? 'invalid' : ''}">`;
                    html += cells.join(' | ');
                    if (cells.length < 4) {
                        html += ' <span class="text-danger">(Format invalide)</span>';
                    }
                    html += '</div>';
                }
                
                if (lines.length > 6) {
                    html += `<div class="text-muted small mt-1">... et ${lines.length - 6} autres lignes</div>`;
                }
                
                html += '</div>';
                previewContent.innerHTML = html;
                previewSection.classList.remove('d-none');
            }
        };
        
        reader.readAsText(file);
    }

    function downloadExample() {
        const content = `titre,type,options, bonne_reponse,points,explication
"Quelle est la capitale de la France ?",qcm,"Paris|Londres|Berlin|Madrid",A,2,
"2 + 2 = 4 ?",vrai_faux,,vrai,1,
"Expliquez la photosynthèse",texte,,,3,"La photosynthèse est le processus par lequel les plantes convertissent la lumière en énergie."
"Quel est le symbole chimique de l'eau ?",qcm,"H2O|CO2|O2|NaCl",A,1,
"La Terre est ronde ?",vrai_faux,,vrai,1,`;

        const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'exemple_questions.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    // Confirmation avant import
    document.getElementById('importForm').addEventListener('submit', function(e) {
        const quizSelected = document.getElementById('quiz_id').value;
        const fileSelected = document.getElementById('fichier').files.length > 0;
        
        if (!quizSelected || !fileSelected) {
            e.preventDefault();
            alert('Veuillez sélectionner un quiz et un fichier');
            return;
        }
        
        if (document.getElementById('ecraser_existant').checked) {
            if (!confirm('Attention ! Cette action va supprimer toutes les questions existantes du quiz. Continuer ?')) {
                e.preventDefault();
            }
        }
    });
</script>
@endpush