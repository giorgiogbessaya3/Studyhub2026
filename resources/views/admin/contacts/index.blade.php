@extends('layouts.admin')

@section('title', 'Gestion des Contacts')

@section('content')
@php
    // Variables définies directement dans la vue pour éviter les erreurs
    $totalContacts = $contacts->total() ?? 0;
    $newContacts = $contacts->where('status', 'new')->count() ?? 0;
    $repliedContacts = $contacts->where('status', 'replied')->count() ?? 0;
    $thisMonth = $contacts->where('created_at', '>=', now()->startOfMonth())->count() ?? 0;
@endphp

<div class="container">
    <!-- Header avec statistiques -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Gestion des Contacts</h1>
                    <p class="text-muted mb-0">Gérez les messages reçus via le formulaire de contact</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" id="exportBtn">
                        <i class="ti ti-download me-2"></i>Exporter
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ti ti-filter me-2"></i>Filtrer
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-option" href="#" data-status="all">Tous les messages</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-status="new">Nouveaux messages</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-status="read">Messages lus</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-status="replied">Messages répondus</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ $totalContacts }}</h4>
                            <p class="text-muted mb-0">Total Messages</p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3 fs-3">
                                <i class="ti ti-inbox"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ $newContacts }}</h4>
                            <p class="text-muted mb-0">Nouveaux</p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3 fs-3">
                                <i class="ti ti-mail-opened"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ $repliedContacts }}</h4>
                            <p class="text-muted mb-0">Répondus</p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded-3 fs-3">
                                <i class="ti ti-mail-forward"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ $thisMonth }}</h4>
                            <p class="text-muted mb-0">Ce mois</p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-3 fs-3">
                                <i class="ti ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des contacts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>
                                        <a href="#" class="sort-link" data-sort="full_name">
                                            Expéditeur
                                            <i class="ti ti-arrow-narrow-down text-muted ms-1"></i>
                                        </a>
                                    </th>
                                    <th>Contact</th>
                                    <th>
                                        <a href="#" class="sort-link" data-sort="subject">
                                            Sujet
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sort-link" data-sort="created_at">
                                            Date
                                            <i class="ti ti-arrow-narrow-down text-muted ms-1"></i>
                                        </a>
                                    </th>
                                    <th>Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr class="contact-row @if($contact->status == 'new') table-warning @endif" 
                                    data-contact-id="{{ $contact->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input contact-checkbox" type="checkbox" 
                                                   value="{{ $contact->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-title bg-{{ $contact->status == 'new' ? 'warning' : 'primary' }}-subtle 
                                                    text-{{ $contact->status == 'new' ? 'warning' : 'primary' }} rounded-circle">
                                                    {{ strtoupper(substr($contact->full_name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $contact->full_name }}</h6>
                                                @if($contact->company)
                                                <small class="text-muted">{{ $contact->company }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="mb-1">
                                                <i class="ti ti-mail me-2 text-primary"></i>
                                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                    {{ $contact->email }}
                                                </a>
                                            </div>
                                            @if($contact->phone)
                                            <div>
                                                <i class="ti ti-phone me-2 text-success"></i>
                                                <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                                    {{ $contact->phone }}
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $contact->subject }}</span>
                                        @if($contact->message)
                                        <div class="text-muted small mt-1">
                                            {{ Str::limit(strip_tags($contact->message), 60) }}
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-nowrap">
                                            <div class="fw-medium">{{ $contact->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $contact->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($contact->status == 'new') bg-warning
                                            @elseif($contact->status == 'read') bg-info
                                            @elseif($contact->status == 'replied') bg-success
                                            @else bg-secondary @endif">
                                            <i class="ti ti-@if($contact->status == 'new') mail @elseif($contact->status == 'read') mail-opened @elseif($contact->status == 'replied') mail-forward @else archive @endif me-1"></i>
                                            @if($contact->status == 'new') Nouveau
                                            @elseif($contact->status == 'read') Lu
                                            @elseif($contact->status == 'replied') Répondu
                                            @else Archivé @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               data-bs-toggle="tooltip" title="Voir le message">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-bs-toggle="tooltip" title="Plus d'options">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if($contact->status != 'read')
                                                    <li>
                                                        <a class="dropdown-item status-change" href="#" 
                                                           data-id="{{ $contact->id }}" data-status="read">
                                                            <i class="ti ti-mail-opened me-2"></i>Marquer comme lu
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if($contact->status != 'replied')
                                                    <li>
                                                        <a class="dropdown-item status-change" href="#" 
                                                           data-id="{{ $contact->id }}" data-status="replied">
                                                            <i class="ti ti-mail-forward me-2"></i>Marquer comme répondu
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item" href="mailto:{{ $contact->email }}?subject=RE: {{ $contact->subject }}">
                                                            <i class="ti ti-reply me-2"></i>Répondre par email
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
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="ti ti-inbox-off fs-1 text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">Aucun message de contact</h5>
                                            <p class="text-muted mb-3">Les messages reçus via le formulaire de contact apparaîtront ici.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Actions groupées -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center gap-2" id="bulkActions" style="display: none !important;">
                            <span class="text-muted" id="selectedCount">0 message(s) sélectionné(s)</span>
                            <select class="form-select form-select-sm" style="width: auto;" id="bulkActionSelect">
                                <option value="">Actions groupées</option>
                                <option value="read">Marquer comme lu</option>
                                <option value="replied">Marquer comme répondu</option>
                                <option value="delete">Supprimer</option>
                            </select>
                            <button class="btn btn-sm btn-primary" id="applyBulkAction">Appliquer</button>
                        </div>

                        <!-- Pagination -->
                        @if($contacts->hasPages())
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de <strong>{{ $contacts->firstItem() ?? 0 }}</strong> à 
                                <strong>{{ $contacts->lastItem() ?? 0 }}</strong> sur 
                                <strong>{{ $contacts->total() }}</strong> message(s)
                            </div>
                            <nav>
                                {{ $contacts->links() }}
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'export -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporter les contacts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm" action="{{ route('admin.contacts.export') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <select class="form-select" name="format">
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Période</label>
                        <select class="form-select" name="period">
                            <option value="all">Tous les messages</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="exportForm" class="btn btn-primary">Exporter</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .contact-row:hover {
        background-color: #f8f9fa !important;
    }
    .sort-link {
        text-decoration: none;
        color: inherit;
    }
    .sort-link:hover {
        color: #1a365d;
    }
    .avatar-sm {
        width: 40px;
        height: 40px;
    }
    .table th {
        font-weight: 600;
        color: #1a365d;
        border-bottom: 2px solid #1a365d;
    }
    .stat-card {
        border-left: 4px solid #1a365d;
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Sélection multiple
    const selectAll = document.getElementById('selectAll');
    const contactCheckboxes = document.querySelectorAll('.contact-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActionSelect = document.getElementById('bulkActionSelect');
    const applyBulkAction = document.getElementById('applyBulkAction');

    // Sélection/désélection de tous les contacts
    selectAll.addEventListener('change', function() {
        contactCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Mise à jour des actions groupées
    contactCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const selectedCountValue = document.querySelectorAll('.contact-checkbox:checked').length;
        selectedCount.textContent = `${selectedCountValue} message(s) sélectionné(s)`;
        
        if (selectedCountValue > 0) {
            bulkActions.style.display = 'flex !important';
        } else {
            bulkActions.style.display = 'none !important';
        }
    }

    // Application des actions groupées
    applyBulkAction.addEventListener('click', function() {
        const action = bulkActionSelect.value;
        const selectedIds = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (!action) {
            alert('Veuillez sélectionner une action');
            return;
        }

        if (action === 'delete') {
            if (!confirm(`Êtes-vous sûr de vouloir supprimer ${selectedIds.length} message(s) ?`)) {
                return;
            }
        }

        // Envoi de la requête AJAX pour l'action groupée
        fetch('{{ route("admin.contacts.bulk-actions") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: action,
                ids: selectedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    });

    // Changement de statut individuel
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

    // Filtrage
    const filterOptions = document.querySelectorAll('.filter-option');
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.getAttribute('data-status');
            window.location.href = `{{ route('admin.contacts.index') }}${status !== 'all' ? '?status=' + status : ''}`;
        });
    });

    // Export modal
    const exportBtn = document.getElementById('exportBtn');
    const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
    
    exportBtn.addEventListener('click', function() {
        exportModal.show();
    });

    // Tri des colonnes
    const sortLinks = document.querySelectorAll('.sort-link');
    sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sortField = this.getAttribute('data-sort');
            // Implémentez la logique de tri ici
            console.log('Tri par:', sortField);
        });
    });
});
</script>
@endpush