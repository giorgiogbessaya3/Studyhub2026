@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier l'Utilisateur</h1>
    <a href="{{ url('admin/users') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-2"></i>Retour
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i class="ti ti-user-edit me-2"></i>Modifier {{ $user->name }}
        </h4>
    </div>
    <div class="card-body">
        <!-- Messages de succès -->
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ url('admin/users/' . $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-medium">Nom complet <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" placeholder="Entrez le nom complet" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-medium">Adresse email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" readonly>
                    <div class="form-text text-muted">
                        <i class="ti ti-info-circle me-1"></i>L'adresse email ne peut pas être modifiée
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-medium">Nouveau mot de passe</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Laissez vide pour conserver l'actuel">
                    <div class="form-text text-muted">
                        <i class="ti ti-key me-1"></i>Remplissez uniquement si vous souhaitez changer le mot de passe
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label fw-medium">Rôle <span class="text-danger">*</span></label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">Sélectionnez un rôle</option>
                        <option value="eleve" {{ old('role', $user->role) == 'eleve' ? 'selected' : '' }}>
                            Élève
                        </option>
                        <option value="enseignant" {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}>
                            Enseignant
                        </option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Administrateur
                        </option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Informations de l'utilisateur -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-muted">
                                <i class="ti ti-info-circle me-2"></i>Informations de l'utilisateur
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">ID:</small>
                                    <p class="mb-0 fw-medium">#{{ $user->id }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Date de création:</small>
                                    <p class="mb-0 fw-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Dernière modification:</small>
                                    <p class="mb-0 fw-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('admin/users') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Annuler
                        </a>
                        <div>
                            <button type="submit" class="btn btn-konde">
                                <i class="ti ti-check me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label {
        color: #1a365d;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #e9ecef;
        padding: 10px 12px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1a365d;
        box-shadow: 0 0 0 0.2rem rgba(26, 54, 93, 0.25);
    }
    .form-control[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation en temps réel
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '' && this.hasAttribute('required')) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Auto-dismiss des alertes après 5 secondes
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Confirmation si changement de rôle
    const roleSelect = document.querySelector('select[name="role"]');
    const originalRole = "{{ $user->role }}";
    const roleLabels = { admin: 'Administrateur', enseignant: 'Enseignant', eleve: 'Élève' };

    roleSelect.addEventListener('change', function() {
        if (this.value !== originalRole) {
            const roleName = roleLabels[this.value] ?? this.value;
            if (!confirm(`Êtes-vous sûr de vouloir changer le rôle de cet utilisateur en "${roleName}" ?`)) {
                this.value = originalRole;
            }
        }
    });
});
</script>
@endsection