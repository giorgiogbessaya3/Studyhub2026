@extends('layouts.admin')

@section('title', 'Gestion des Articles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestion des Articles</h1>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="ti ti-plus"></i> Nouvel Article
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" 
                                     class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <i class="ti ti-news text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="fw-medium">{{ Str::limit($blog->title, 50) }}</div>
                                    @if($blog->youtube_url)
                                    <small class="text-danger">
                                        <i class="ti ti-brand-youtube"></i> Vidéo
                                    </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $blog->author }}</td>
                        <td>
                            <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                                <i class="ti ti-{{ $blog->status === 'published' ? 'eye' : 'edit' }} me-1"></i>
                                {{ $blog->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $blog->created_at->format('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-sm btn-info" 
                                   data-bs-toggle="tooltip" title="Voir les détails">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-warning"
                                   data-bs-toggle="tooltip" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')"
                                            data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4">
                                <i class="ti ti-news-off fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Aucun article trouvé</h5>
                                <p class="text-muted mb-3">Commencez par créer votre premier article</p>
                                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                                    <i class="ti ti-plus me-2"></i>Créer un article
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination - Vérification sécurisée -->
        @if(method_exists($blogs, 'links') && $blogs->total() > $blogs->perPage())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Affichage de <strong>{{ $blogs->firstItem() ?? 0 }}</strong> à 
                    <strong>{{ $blogs->lastItem() ?? 0 }}</strong> sur 
                    <strong>{{ $blogs->total() }}</strong> article(s)
                </div>
                <nav>
                    {{ $blogs->links() }}
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
    .table th {
        font-weight: 600;
        color: #1a2942;
        border-bottom: 2px solid #1a2942;
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
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection