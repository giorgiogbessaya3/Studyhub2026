@extends('layouts.admin')

@section('title', 'Détails du Message - ' . $contact->full_name)

@section('content')
@php
    // Variables de navigation sécurisées
    $previousContact = $previousContact ?? null;
    $nextContact = $nextContact ?? null;
@endphp

<div class="container">
    <!-- En-tête avec navigation -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Détails du Message</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
                            <li class="breadcrumb-item active">Message #{{ $contact->id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Carte principale du message -->
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-mail text-primary me-2"></i>
                            {{ $contact->subject }}
                        </h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item status-change" href="#" 
                                       data-id="{{ $contact->id }}" data-status="read">
                                        <i class="ti ti-mail-opened me-2"></i>Marquer comme lu
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item status-change" href="#" 
                                       data-id="{{ $contact->id }}" data-status="replied">
                                        <i class="ti ti-mail-forward me-2"></i>Marquer comme répondu
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                            <i class="ti ti-trash me-2"></i>Supprimer
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- En-tête du message -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                        <div class="avatar-lg flex-shrink-0 me-3">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2">
                                {{ strtoupper(substr($contact->full_name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $contact->full_name }}</h6>
                            <div class="text-muted small">
                                <i class="ti ti-clock me-1"></i>
                                Reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge 
                                @if($contact->status == 'new') bg-warning
                                @elseif($contact->status == 'read') bg-info
                                @elseif($contact->status == 'replied') bg-success
                                @else bg-secondary @endif fs-6">
                                <i class="ti ti-@if($contact->status == 'new') mail @elseif($contact->status == 'read') mail-opened @elseif($contact->status == 'replied') mail-forward @else archive @endif me-1"></i>
                                @if($contact->status == 'new') Nouveau
                                @elseif($contact->status == 'read') Lu
                                @elseif($contact->status == 'replied') Répondu
                                @else Archivé @endif
                            </span>
                        </div>
                    </div>

                    <!-- Informations de contact -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ti ti-user-circle me-2"></i>Informations de contact
                                    </h6>
                                    <div class="mb-2">
                                        <i class="ti ti-mail text-primary me-2"></i>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            {{ $contact->email }}
                                        </a>
                                    </div>
                                    @if($contact->phone)
                                    <div class="mb-2">
                                        <i class="ti ti-phone text-success me-2"></i>
                                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                            {{ $contact->phone }}
                                        </a>
                                    </div>
                                    @endif
                                    @if($contact->company)
                                    <div>
                                        <i class="ti ti-building text-info me-2"></i>
                                        {{ $contact->company }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ti ti-info-circle me-2"></i>Informations techniques
                                    </h6>
                                    <div class="mb-2">
                                        <i class="ti ti-id me-2"></i>
                                        <strong>ID:</strong> #{{ $contact->id }}
                                    </div>
                                    <div class="mb-2">
                                        <i class="ti ti-calendar me-2"></i>
                                        <strong>Reçu:</strong> {{ $contact->created_at->format('d/m/Y') }}
                                    </div>
                                    <div>
                                        <i class="ti ti-clock me-2"></i>
                                        <strong>Heure:</strong> {{ $contact->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu du message -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="ti ti-message-circle me-2"></i>Contenu du message
                        </h6>
                        <div class="border rounded p-4 bg-white">
                            <div class="message-content">
                                {!! nl2br(e($contact->message)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <a href="mailto:{{ $contact->email }}?subject=RE: {{ $contact->subject }}" 
                               class="btn btn-primary">
                                <i class="ti ti-reply me-2"></i>Répondre par email
                            </a>
                            @if($contact->phone)
                            <a href="tel:{{ $contact->phone }}" class="btn btn-success">
                                <i class="ti ti-phone me-2"></i>Appeler
                            </a>
                            @endif
                        </div>
                        <div class="text-muted small">
                            <i class="ti ti-info-circle me-1"></i>
                            Message reçu il y a {{ $contact->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec actions rapides -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-bolt me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($contact->status != 'read')
                        <button class="btn btn-outline-info status-change" 
                                data-id="{{ $contact->id }}" data-status="read">
                            <i class="ti ti-mail-opened me-2"></i>Marquer comme lu
                        </button>
                        @endif
                        
                        @if($contact->status != 'replied')
                        <button class="btn btn-outline-success status-change" 
                                data-id="{{ $contact->id }}" data-status="replied">
                            <i class="ti ti-mail-forward me-2"></i>Marquer comme répondu
                        </button>
                        @endif
                        
                        <a href="mailto:{{ $contact->email }}?subject=RE: {{ $contact->subject }}&body=Bonjour {{ $contact->full_name }},%0D%0A%0D%0A" 
                           class="btn btn-outline-primary">
                            <i class="ti ti-mail me-2"></i>Répondre (modèle)
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statut du message -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-chart-bar me-2"></i>Statut du message
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="avatar-lg mx-auto mb-3">
                            <span class="avatar-title 
                                @if($contact->status == 'new') bg-warning
                                @elseif($contact->status == 'read') bg-info
                                @elseif($contact->status == 'replied') bg-success
                                @else bg-secondary @endif 
                                rounded-circle fs-2 text-white">
                                <i class="ti ti-@if($contact->status == 'new') mail @elseif($contact->status == 'read') mail-opened @elseif($contact->status == 'replied') mail-forward @else archive @endif"></i>
                            </span>
                        </div>
                        <h5 class="mb-1">
                            @if($contact->status == 'new') Nouveau message
                            @elseif($contact->status == 'read') Message lu
                            @elseif($contact->status == 'replied') Message répondu
                            @else Message archivé @endif
                        </h5>
                        <p class="text-muted mb-0">
                            @if($contact->status == 'new')
                            Ce message n'a pas encore été traité
                            @elseif($contact->status == 'read')
                            Message consulté mais pas encore répondu
                            @elseif($contact->status == 'replied')
                            Une réponse a été envoyée à l'expéditeur
                            @else
                            Ce message a été archivé
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation rapide -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-arrow-navigation me-2"></i>Navigation
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-list me-2"></i>Liste des messages
                        </a>
                        
                        <!-- Navigation sécurisée -->
                        @if($previousContact)
                        <a href="{{ route('admin.contacts.show', $previousContact) }}" class="btn btn-outline-primary">
                            <i class="ti ti-arrow-up me-2"></i>Message précédent
                        </a>
                        @else
                        <button class="btn btn-outline-primary" disabled>
                            <i class="ti ti-arrow-up me-2"></i>Message précédent
                        </button>
                        @endif
                        
                        @if($nextContact)
                        <a href="{{ route('admin.contacts.show', $nextContact) }}" class="btn btn-outline-primary">
                            <i class="ti ti-arrow-down me-2"></i>Message suivant
                        </a>
                        @else
                        <button class="btn btn-outline-primary" disabled>
                            <i class="ti ti-arrow-down me-2"></i>Message suivant
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation alternative sans variables -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-arrows-sort me-2"></i>Navigation rapide
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.contacts.index', ['status' => $contact->status]) }}" 
                           class="btn btn-outline-info">
                            <i class="ti ti-filter me-2"></i>Voir les {{ $contact->status == 'new' ? 'nouveaux' : ($contact->status == 'read' ? 'lus' : ($contact->status == 'replied' ? 'répondus' : 'archivés')) }} messages
                        </a>
                        <a href="{{ route('admin.contacts.index') }}?search={{ urlencode($contact->email) }}" 
                           class="btn btn-outline-warning">
                            <i class="ti ti-search me-2"></i>Voir tous les messages de {{ $contact->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-lg {
        width: 60px;
        height: 60px;
    }
    .message-content {
        line-height: 1.6;
        white-space: pre-wrap;
    }
    .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .btn-group .btn {
        border-radius: 6px;
    }
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Changement de statut
    const statusButtons = document.querySelectorAll('.status-change');
    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const contactId = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');
            
            updateContactStatus(contactId, status);
        });
    });

    function updateContactStatus(contactId, status) {
        fetch(`/admin/contacts/${contactId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du statut');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la mise à jour du statut');
        });
    }

    // Confirmation pour la suppression
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });

    // Navigation alternative si les variables ne sont pas disponibles
    function loadNavigationContacts() {
        // Cette fonction peut être utilisée pour charger la navigation via AJAX
        // si les variables previous/next ne sont pas disponibles depuis le contrôleur
        console.log('Navigation alternative activée');
    }

    // Charger la navigation alternative si nécessaire
    if (document.querySelector('.btn:disabled')) {
        loadNavigationContacts();
    }
});
</script>
@endpush