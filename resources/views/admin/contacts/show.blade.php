@extends('layouts.admin')

@section('title', 'Détail du message - StudyHub Admin')
@section('page-title', 'Détail du message')
@section('breadcrumb', 'Contacts / Détail')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Message -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $contact->subject }}</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-sm btn-success">
                        <i class="ti ti-mail-forward me-1"></i> Répondre
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteContact()">
                        <i class="ti ti-trash me-1"></i> Supprimer
                    </button>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- En-tête du message -->
                <div class="d-flex align-items-start mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="ti ti-user text-primary fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $contact->full_name }}</h5>
                                <p class="text-muted mb-1">{{ $contact->email }}</p>
                                @if($contact->phone)
                                    <p class="text-muted mb-0">{{ $contact->phone }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="mb-2">
                                    @if($contact->status == 'new')
                                        <span class="badge bg-danger">Nouveau</span>
                                    @elseif($contact->status == 'read')
                                        <span class="badge bg-info">Lu</span>
                                    @elseif($contact->status == 'replied')
                                        <span class="badge bg-success">Répondu</span>
                                    @else
                                        <span class="badge bg-secondary">Archivé</span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>
                                    {{ $contact->created_at->format('d/m/Y à H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contenu du message -->
                <div class="border-top pt-4">
                    <h6 class="fw-bold mb-3">Message :</h6>
                    <div class="bg-light p-4 rounded-3">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Retour
                    </a>
                    <div class="d-flex gap-2">
                        <select class="form-select w-auto" id="statusSelect">
                            <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>Nouveau</option>
                            <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Lu</option>
                            <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Répondu</option>
                            <option value="archived" {{ $contact->status == 'archived' ? 'selected' : '' }}>Archivé</option>
                        </select>
                        <button class="btn btn-outline-primary" onclick="updateStatus()">
                            <i class="ti ti-check"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    function deleteContact() {
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
                form.action = '{{ route("admin.contacts.destroy", $contact->id) }}';
                form.submit();
            }
        });
    }

    function updateStatus() {
        const status = document.getElementById('statusSelect').value;
        
        fetch('{{ route("admin.contacts.update-status", $contact->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Statut mis à jour',
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>
@endpush