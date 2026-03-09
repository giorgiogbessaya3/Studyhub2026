@extends('layouts.app')

@section('title', 'Soumettre un Ticket')

@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card border-0 shadow-lg">
                <!-- En-tête de la carte -->
                <div class="card-header bg-primary text-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">Soumettre un Nouveau Ticket</h3>
                            <p class="mb-0 opacity-75">Notre équipe est là pour vous aider</p>
                        </div>
                    </div>
                </div>
                
                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="ticketForm">
                        @csrf

                        <!-- Informations utilisateur pré-remplies si connecté -->
                        @auth
                        <div class="alert alert-info border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Utilisateur connecté :</strong> 
                                    {{ auth()->user()->name }} ({{ auth()->user()->email }})
                                </div>
                            </div>
                        </div>
                        @endauth

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="fas fa-user me-2"></i>
                                        Nom complet *
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control border-0 shadow-sm bg-light py-2 @error('name') is-invalid @enderror" 
                                        name="name" 
                                        value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" 
                                        placeholder="Votre nom complet"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="fas fa-envelope me-2"></i>
                                        Adresse email *
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control border-0 shadow-sm bg-light py-2 @error('email') is-invalid @enderror" 
                                        name="email" 
                                        value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                                        placeholder="votre.email@exemple.com"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="fas fa-tags me-2"></i>
                                        Catégorie *
                                    </label>
                                    <select 
                                        class="form-select border-0 shadow-sm bg-light py-2 @error('category') is-invalid @enderror" 
                                        name="category"
                                        required
                                        id="category"
                                    >
                                        <option value="">Sélectionnez une catégorie</option>
                                        <option value="technique" {{ old('category') == 'technique' ? 'selected' : '' }}>🔧 Problème technique</option>
                                        <option value="facturation" {{ old('category') == 'facturation' ? 'selected' : '' }}>💳 Facturation</option>
                                        <option value="compte" {{ old('category') == 'compte' ? 'selected' : '' }}>👤 Compte utilisateur</option>
                                        <option value="fonctionnalite" {{ old('category') == 'fonctionnalite' ? 'selected' : '' }}>✨ Demande de fonctionnalité</option>
                                        <option value="autre" {{ old('category') == 'autre' ? 'selected' : '' }}>📝 Autre</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Priorité *
                                    </label>
                                    <select 
                                        class="form-select border-0 shadow-sm bg-light py-2 @error('priority') is-invalid @enderror" 
                                        name="priority"
                                        required
                                        id="priority"
                                    >
                                        <option value="">Sélectionnez une priorité</option>
                                        <option value="basse" {{ old('priority') == 'basse' ? 'selected' : '' }}>🟢 Basse</option>
                                        <option value="moyenne" {{ old('priority') == 'moyenne' ? 'selected' : '' }}>🟡 Moyenne</option>
                                        <option value="haute" {{ old('priority') == 'haute' ? 'selected' : '' }}>🟠 Haute</option>
                                        <option value="urgente" {{ old('priority') == 'urgente' ? 'selected' : '' }}>🔴 Urgente</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">
                                <i class="fas fa-heading me-2"></i>
                                Sujet *
                            </label>
                            <input 
                                type="text" 
                                class="form-control border-0 shadow-sm bg-light py-2 @error('subject') is-invalid @enderror" 
                                name="subject" 
                                value="{{ old('subject') }}" 
                                placeholder="Décrivez brièvement votre problème..."
                                required
                                maxlength="200"
                                id="subject"
                            >
                            <div class="form-text text-muted d-flex justify-content-between">
                                <span><i class="fas fa-info-circle me-1"></i>Soyez concis et descriptif</span>
                                <span id="subjectCounter">0/200</span>
                            </div>
                            @error('subject')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-times-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">
                                <i class="fas fa-align-left me-2"></i>
                                Description détaillée *
                            </label>
                            <textarea 
                                class="form-control border-0 shadow-sm bg-light py-2 @error('message') is-invalid @enderror" 
                                name="message" 
                                rows="6" 
                                placeholder="Décrivez votre problème en détail. Plus vous serez précis, plus nous pourrons vous aider rapidement..."
                                required
                                maxlength="2000"
                                id="message"
                            >{{ old('message') }}</textarea>
                            <div class="form-text text-muted d-flex justify-content-between">
                                <span><i class="fas fa-info-circle me-1"></i>Incluez les étapes pour reproduire le problème, les messages d'erreur, etc.</span>
                                <span id="messageCounter">0/2000</span>
                            </div>
                            @error('message')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-times-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">
                                <i class="fas fa-paperclip me-2"></i>
                                Pièces jointes
                                <span class="badge bg-secondary ms-1">Optionnel</span>
                            </label>
                            <div class="file-upload-area border-dashed rounded-3 p-4 text-center bg-light">
                                <input 
                                    type="file" 
                                    class="form-control d-none" 
                                    name="attachments[]" 
                                    multiple
                                    id="attachments"
                                >
                                <div id="uploadTrigger" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Glissez-déposez vos fichiers ici</h5>
                                    <p class="text-muted small mb-3">ou cliquez pour parcourir</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-folder-open me-2"></i>Choisir des fichiers
                                    </button>
                                </div>
                            </div>
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Formats acceptés: JPG, PNG, GIF, PDF, DOC, DOCX, TXT. Max 5MB par fichier, 5 fichiers maximum.
                            </div>
                            
                            <div id="attachmentsPreview" class="mt-3"></div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="accept_emails" 
                                    id="accept_emails"
                                    {{ old('accept_emails', true) ? 'checked' : '' }}
                                >
                                <label class="form-check-label fw-semibold" for="accept_emails">
                                    <i class="fas fa-bell me-2"></i>
                                    J'accepte de recevoir des notifications par email concernant l'avancement de ce ticket
                                </label>
                            </div>
                        </div>

                        <!-- Résumé du ticket -->
                        <div class="card border-primary bg-light mb-4" id="ticketSummary" style="display: none;">
                            <div class="card-header bg-transparent border-primary">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    Aperçu de votre ticket
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row small">
                                    <div class="col-md-6">
                                        <strong>Catégorie :</strong> <span id="summaryCategory">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Priorité :</strong> <span id="summaryPriority">-</span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <strong>Sujet :</strong> <span id="summarySubject">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>
                                Réinitialiser
                            </button>
                            <button 
                                type="submit" 
                                class="btn btn-primary rounded-pill px-4 py-2 btn-hover border-0 fw-semibold"
                                id="submitBtn"
                            >
                                <i class="fas fa-paper-plane me-2"></i>
                                Soumettre le Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de succès -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>
                    Ticket soumis avec succès!
                </h5>
            </div>
            <div class="modal-body p-5 text-center">
                <div class="mb-4">
                    <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 class="text-success fw-bold mb-3">Merci pour votre soumission!</h2>
                    <p class="text-muted fs-5 mb-4">
                        Nous avons bien reçu votre ticket. Notre équipe va le traiter dans les plus brefs délais.
                    </p>
                    
                    <div class="bg-light rounded-3 p-4 mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Prochaines étapes
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mx-auto fs-5 fw-bold">
                                        1
                                    </div>
                                    <small class="text-muted">Examen par notre équipe</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mx-auto fs-5 fw-bold">
                                        2
                                    </div>
                                    <small class="text-muted">Notification par email</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mx-auto fs-5 fw-bold">
                                        3
                                    </div>
                                    <small class="text-muted">Résolution du problème</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 btn-hover" onclick="resetFormAndClose()">
                            <i class="fas fa-plus-circle me-2"></i>
                            Soumettre un autre ticket
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 btn-hover">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Tableau de bord
                        </a>
                        <a href="{{ route('tickets.list') }}" class="btn btn-outline-success rounded-pill px-4 py-2 btn-hover">
                            <i class="fas fa-list me-2"></i>
                            Voir mes tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    .btn-hover {
        transition: all 0.3s ease;
    }
    
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
        border-color: #3B82F6 !important;
    }
    
    .attachment-preview {
        transition: all 0.3s ease;
    }
    
    .attachment-preview:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .file-upload-area:hover {
        border-color: #3B82F6 !important;
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }
        25% {
            transform: translateX(-5px);
        }
        75% {
            transform: translateX(5px);
        }
    }
</style>

<script>
    // Compteurs de caractères
    document.getElementById('subject').addEventListener('input', function() {
        const counter = document.getElementById('subjectCounter');
        counter.textContent = this.value.length + '/200';
    });

    document.getElementById('message').addEventListener('input', function() {
        const counter = document.getElementById('messageCounter');
        counter.textContent = this.value.length + '/2000';
    });

    // Mise à jour de l'aperçu du ticket
    function updateTicketSummary() {
        const category = document.getElementById('category');
        const priority = document.getElementById('priority');
        const subject = document.getElementById('subject');
        const summary = document.getElementById('ticketSummary');
        
        if (category.value || priority.value || subject.value) {
            summary.style.display = 'block';
            document.getElementById('summaryCategory').textContent = category.options[category.selectedIndex]?.text || '-';
            document.getElementById('summaryPriority').textContent = priority.options[priority.selectedIndex]?.text || '-';
            document.getElementById('summarySubject').textContent = subject.value || '-';
        } else {
            summary.style.display = 'none';
        }
    }

    // Écouteurs pour la mise à jour de l'aperçu
    document.getElementById('category').addEventListener('change', updateTicketSummary);
    document.getElementById('priority').addEventListener('change', updateTicketSummary);
    document.getElementById('subject').addEventListener('input', updateTicketSummary);

    // Upload de fichiers amélioré
    const fileInput = document.getElementById('attachments');
    const uploadTrigger = document.getElementById('uploadTrigger');
    const preview = document.getElementById('attachmentsPreview');

    uploadTrigger.addEventListener('click', () => fileInput.click());
    
    // Drag and drop
    uploadTrigger.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadTrigger.style.borderColor = '#3B82F6';
        uploadTrigger.style.backgroundColor = 'rgba(59, 130, 246, 0.1)';
    });

    uploadTrigger.addEventListener('dragleave', () => {
        uploadTrigger.style.borderColor = '#dee2e6';
        uploadTrigger.style.backgroundColor = '#f8f9fa';
    });

    uploadTrigger.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadTrigger.style.borderColor = '#dee2e6';
        uploadTrigger.style.backgroundColor = '#f8f9fa';
        
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelection();
        }
    });

    fileInput.addEventListener('change', handleFileSelection);

    function handleFileSelection() {
        preview.innerHTML = '';
        const files = Array.from(fileInput.files);
        
        if (files.length > 5) {
            alert('Maximum 5 fichiers autorisés');
            fileInput.value = '';
            return;
        }
        
        let totalSize = 0;
        files.forEach((file, index) => {
            totalSize += file.size;
            if (file.size > 5 * 1024 * 1024) {
                alert(`Le fichier "${file.name}" dépasse la taille maximale de 5MB`);
                return;
            }
            
            const fileElement = document.createElement('div');
            fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-3 mb-2 attachment-preview';
            fileElement.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${getFileIcon(file.type)} text-primary me-3 fa-lg"></i>
                    <div>
                        <div class="fw-semibold">${file.name}</div>
                        <small class="text-muted">${formatFileSize(file.size)} • ${file.type || 'Type inconnu'}</small>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeAttachment(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            preview.appendChild(fileElement);
        });

        // Afficher le total
        if (files.length > 0) {
            const totalElement = document.createElement('div');
            totalElement.className = 'text-center text-muted small mt-2';
            totalElement.innerHTML = `<i class="fas fa-info-circle me-1"></i> ${files.length} fichier(s) sélectionné(s) • Total: ${formatFileSize(totalSize)}`;
            preview.appendChild(totalElement);
        }
    }

    function getFileIcon(mimeType) {
        if (mimeType.startsWith('image/')) return 'fa-file-image';
        if (mimeType.includes('pdf')) return 'fa-file-pdf';
        if (mimeType.includes('word') || mimeType.includes('document')) return 'fa-file-word';
        if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) return 'fa-file-excel';
        return 'fa-file';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function removeAttachment(index) {
        const dt = new DataTransfer();
        const files = Array.from(fileInput.files);
        
        files.splice(index, 1);
        files.forEach(file => dt.items.add(file));
        
        fileInput.files = dt.files;
        handleFileSelection();
    }

    // Gestion de la soumission du formulaire
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            Envoi en cours...
        `;
        
        // Laisser le formulaire s'envoyer normalement
        // Le modal sera affiché via la redirection après succès
    });

    function resetForm() {
        if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les données seront perdues.')) {
            document.getElementById('ticketForm').reset();
            document.getElementById('attachmentsPreview').innerHTML = '';
            document.getElementById('ticketSummary').style.display = 'none';
            document.getElementById('subjectCounter').textContent = '0/200';
            document.getElementById('messageCounter').textContent = '0/2000';
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <i class="fas fa-paper-plane me-2"></i>
                Soumettre le Ticket
            `;
        }
    }

    function resetFormAndClose() {
        resetForm();
        const modal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
        modal.hide();
    }

    // Afficher le modal si succès dans la session
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.card');
        card.classList.add('animate-fadeIn');
        
        // Initialiser les compteurs
        document.getElementById('subjectCounter').textContent = document.getElementById('subject').value.length + '/200';
        document.getElementById('messageCounter').textContent = document.getElementById('message').value.length + '/2000';
        
        // Afficher le modal si succès
        @if(session('success'))
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        @endif
    });
</script>
@endsection