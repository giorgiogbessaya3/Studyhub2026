@extends('layouts.admin')

@section('title', 'Ajouter un Utilisateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Utilisateur</h1>
    <a href="{{ url('admin/users') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-2"></i>Retour
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i class="ti ti-user-plus me-2"></i>Nouvel Utilisateur
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

        <form action="{{ url('admin/users') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-medium">Nom complet <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" placeholder="Entrez le nom complet" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-medium">Adresse email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="Entrez l'adresse email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-medium">Mot de passe <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Créez un mot de passe sécurisé" required>
                    <div class="form-text">Minimum 8 caractères avec lettres et chiffres</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role_as" class="form-label fw-medium">Rôle <span class="text-danger">*</span></label>
                    <select name="role_as" class="form-select @error('role_as') is-invalid @enderror" required>
                        <option value="">Sélectionnez un rôle</option>
                        <option value="0" {{ old('role_as') == '0' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="1" {{ old('role_as') == '1' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role_as')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('admin/users') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-konde">
                            <i class="ti ti-check me-2"></i>Créer l'utilisateur
                        </button>
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
    .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
});
</script>
@endsection