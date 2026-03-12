@extends('layouts.admin')

@section('title', 'Importer des questions - StudyHub Admin')
@section('page-title', 'Importer des questions')
@section('breadcrumb', 'Questions / Import')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Importer des questions depuis un fichier CSV</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/questions/import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Quiz de destination <span class="text-danger">*</span></label>
                        <select name="quiz_id" class="form-select @error('quiz_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un quiz</option>
                            @foreach($quizs as $quiz)
                                <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->titre }} ({{ $quiz->classe->nom }} - {{ $quiz->matiere->nom }})
                                </option>
                            @endforeach
                        </select>
                        @error('quiz_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fichier CSV <span class="text-danger">*</span></label>
                        <input type="file" name="fichier" class="form-control @error('fichier') is-invalid @enderror" 
                               accept=".csv, .txt" required>
                        <small class="text-muted d-block mt-1">
                            Format: CSV avec en-têtes (titre, type, options, bonne_reponse, points, explication)
                        </small>
                        @error('fichier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <h6 class="fw-bold mb-2">Format attendu :</h6>
                        <ul class="small mb-0">
                            <li><strong>titre</strong> : Le texte de la question</li>
                            <li><strong>type</strong> : qcm, texte, ou vrai_faux</li>
                            <li><strong>options</strong> : Pour les QCM, séparer les options par | (ex: "Option1|Option2|Option3|Option4")</li>
                            <li><strong>bonne_reponse</strong> : La lettre de la bonne réponse (A, B, C, D) pour QCM, "vrai"/"faux" pour Vrai/Faux, ou le texte pour les questions ouvertes</li>
                            <li><strong>points</strong> : Nombre de points (1-10)</li>
                            <li><strong>explication</strong> : Explication de la réponse (optionnel)</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('admin/questions') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload me-1"></i> Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Exemple de fichier -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">Exemple de fichier CSV</h6>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded"><code>titre,type,options, bonne_reponse,points,explication
"Quelle est la capitale de la France ?",qcm,"Paris|Londres|Berlin|Madrid",A,2,
"2 + 2 = 4 ?",vrai_faux,,vrai,1,
"Expliquez la photosynthèse",texte,,,3,"La photosynthèse est le processus par lequel les plantes..."</code></pre>
                
                <a href="#" class="btn btn-sm btn-outline-primary mt-2" onclick="downloadExample()">
                    <i class="ti ti-download me-1"></i> Télécharger l'exemple
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function downloadExample() {
        const content = `titre,type,options, bonne_reponse,points,explication
"Quelle est la capitale de la France ?",qcm,"Paris|Londres|Berlin|Madrid",A,2,
"2 + 2 = 4 ?",vrai_faux,,vrai,1,
"Expliquez la photosynthèse",texte,,,3,"La photosynthèse est le processus par lequel les plantes convertissent la lumière en énergie."`;

        const blob = new Blob([content], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'exemple_questions.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
@endpush