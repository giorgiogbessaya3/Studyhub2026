@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestion des Utilisateurs</h1>
    <a href="{{ url('admin/users/create') }}" class="btn btn-konde">
        <i class="ti ti-plus"></i> Nouvel Utilisateur
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <span class="fw-medium text-muted">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <i class="ti ti-user text-muted"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role_as == '1')
                                <span class="badge bg-warning">
                                    <i class="ti ti-shield me-1"></i>Admin
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    <i class="ti ti-user me-1"></i>Utilisateur
                                </span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $user->created_at->format('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ url('admin/users/'.$user->id.'/edit') }}" 
                                   class="btn btn-sm btn-warning"
                                   data-bs-toggle="tooltip" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="{{ url('admin/users/'.$user->id.'/delete') }}" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                   class="btn btn-sm btn-danger"
                                   data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="ti ti-users-off fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                                <p class="text-muted mb-3">Commencez par créer votre premier utilisateur</p>
                                <a href="{{ url('admin/users/create') }}" class="btn btn-konde">
                                    <i class="ti ti-plus me-2"></i>Créer un utilisateur
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Affichage de <strong>{{ $users->firstItem() ?? 0 }}</strong> à 
                    <strong>{{ $users->lastItem() ?? 0 }}</strong> sur 
                    <strong>{{ $users->total() }}</strong> utilisateur(s)
                </div>
                <nav>
                    {{ $users->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 6px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Confirmation améliorée pour la suppression
    const deleteLinks = document.querySelectorAll('a[href*="/delete"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection