@extends('layouts.admin')

@section('title', 'Gestion des contacts - StudyHub Admin')
@section('page-title', 'Gestion des contacts')
@section('breadcrumb', 'Contacts')

@section('content')
<!-- Statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-primary bg-opacity-10">
                        <i class="ti ti-message text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-danger bg-opacity-10">
                        <i class="ti ti-alert-circle text-danger fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Nouveaux</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['new'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-info bg-opacity-10">
                        <i class="ti ti-eye text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Lus</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['read'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-success bg-opacity-10">
                        <i class="ti ti-check text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Répondus</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['replied'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3 bg-secondary bg-opacity-10">
                        <i class="ti ti-archive text-secondary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Archivés</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['archived'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-75 mb-1">Non lus</h6>
                    <h3 class="mb-0 fw-bold">{{ $stats['new'] }}</h3>
                </div>
                <i class="ti ti-mail fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et actions -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <!-- Filtres -->
            <div class="flex-grow-1">
                <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-2">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Nouveau</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lu</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Répondu</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-search"></i>
                            </button>
                            @if(request()->anyFilled(['status', 'search']))
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Actions groupées -->
            <div class="d-flex gap-2">
                <select id="bulkAction" class="form-select w-auto">
                    <option value="">Actions groupées</option>
                    <option value="mark_as_read">Marquer comme lu</option>
                    <option value="mark_as_new">Marquer comme nouveau</option>
                    <option value="mark_as_replied">Marquer comme répondu</option>
                    <option value="mark_as_archived">Archiver</option>
                    <option value="delete">Supprimer</option>
                </select>
                <button class="btn btn-outline-primary" onclick="bulkAction()">Appliquer</button>
            </div>
            
            <!-- Export -->
            <a href="{{ route('admin.contacts.export') }}?{{ http_build_query(request()->only(['status', 'search'])) }}" class="btn btn-outline-success">
                <i class="ti ti-download"></i> Exporter
            </a>
        </div>
    </div>
</div>

<!-- Liste des contacts -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Messages de contact</h5>
            <span class="badge bg-primary">{{ $contacts->total() }} message(s)</span>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="40">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Expéditeur</th>
                        <th>Sujet</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr class="{{ $contact->status == 'new' ? 'fw-bold bg-light' : '' }}">
                        <td>
                            <input type="checkbox" class="form-check-input select-item" value="{{ $contact->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                    <i class="ti ti-user text-primary"></i>
                                </div>
                                <div>
                                    <div>{{ $contact->full_name }}</div>
                                    <small class="text-muted">{{ $contact->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $contact->subject }}</div>
                            <small class="text-muted">{{ Str::limit($contact->message, 50) }}</small>
                        </td>
                        <td>
                            @if($contact->status == 'new')
                                <span class="badge bg-danger">Nouveau</span>
                            @elseif($contact->status == 'read')
                                <span class="badge bg-info">Lu</span>
                            @elseif($contact->status == 'replied')
                                <span class="badge bg-success">Répondu</span>
                            @else
                                <span class="badge bg-secondary">Archivé</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $contact->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $contact->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-sm btn-outline-success" title="Répondre">
                                    <i class="ti ti-mail-forward"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteContact({{ $contact->id }})" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="ti ti-message-off fs-1 text-muted mb-3"></i>
                            <h5>Aucun message trouvé</h5>
                            <p class="text-muted">Les messages de contact apparaîtront ici.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white py-3">
        {{ $contacts->appends(request()->query())->links() }}
    </div>
</div>

<!-- Formulaire caché pour les actions groupées -->
<form id="bulkForm" method="POST" action="{{ route('admin.contacts.bulk-actions') }}" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulkIds">
    <input type="hidden" name="action" id="bulkActionType">
</form>

<!-- Formulaire de suppression individuelle -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Select All
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    // Individual checkboxes
    document.querySelectorAll('.select-item').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });

    function updateSelectedCount() {
        const count = document.querySelectorAll('.select-item:checked').length;
        const selectAll = document.getElementById('selectAll');
        const total = document.querySelectorAll('.select-item').length;
        
        if (selectAll) {
            selectAll.checked = count > 0 && count === total;
            selectAll.indeterminate = count > 0 && count < total;
        }
    }

    function bulkAction() {
        const selected = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
        const action = document.getElementById('bulkAction').value;
        
        if (selected.length === 0) {
            Swal.fire('Aucune sélection', 'Veuillez sélectionner au moins un message.', 'warning');
            return;
        }
        
        if (!action) {
            Swal.fire('Action non sélectionnée', 'Veuillez choisir une action.', 'warning');
            return;
        }

        let confirmText = '';
        if (action === 'delete') {
            confirmText = `Supprimer ${selected.length} message(s) ? Cette action est irréversible.`;
        } else {
            confirmText = `Appliquer l'action à ${selected.length} message(s) ?`;
        }

        Swal.fire({
            title: 'Confirmation',
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: action === 'delete' ? '#d33' : '#3085d6',
            confirmButtonText: 'Confirmer'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkIds').value = selected.join(',');
                document.getElementById('bulkActionType').value = action;
                document.getElementById('bulkForm').submit();
            }
        });
    }

    function deleteContact(id) {
        Swal.fire({
            title: 'Supprimer le message ?',
            text: 'Cette action est irréversible.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Supprimer'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = '{{ url("admin/contacts") }}/' + id;
                form.submit();
            }
        });
    }

    // Notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            timer: 3000
        });
    @endif
</script>
@endpush