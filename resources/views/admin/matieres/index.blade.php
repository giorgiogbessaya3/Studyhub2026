@extends('layouts.admin')

@section('title', 'Gestion des Matières')
@section('page-title', 'Gestion des Matières')
@section('breadcrumb', 'Organisation pédagogique')

@section('content')

<!-- En-tête avec bouton d'ajout -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="text-muted mb-0">
            <i class="ti ti-books me-2"></i>Liste des matières
        </h5>
    </div>
    <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Nouvelle matière
    </a>
</div>

<!-- Cartes statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="ti ti-books fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total matières</h6>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="ti ti-check fs-3 text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Matières actives</h6>
                        <h3 class="mb-0">{{ $stats['actives'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres simples -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.matieres.index') }}" class="row g-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control bg-light border-0" 
                           name="search" 
                           placeholder="Rechercher une matière..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter me-1"></i>Filtrer
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.matieres.index') }}" class="btn btn-outline-muted w-100">
                    <i class="ti ti-refresh me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des matières en grille -->
<div class="row g-4">
    @forelse($matieres as $matiere)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm matiere-card">
            <!-- Badge statut -->
            <div class="position-absolute top-0 start-0 m-3">
                @if($matiere->statut)
                    <span class="badge bg-success">
                        <i class="ti ti-check me-1"></i>Active
                    </span>
                @else
                    <span class="badge bg-secondary">
                        <i class="ti ti-x me-1"></i>Inactive
                    </span>
                @endif
            </div>

            <!-- Icône de la matière -->
            <div class="text-center pt-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                     style="width: 80px; height: 80px; background-color: #f8f9fa;">
                    <i class="ti {{ $matiere->icone ?? 'ti-book' }}" style="font-size: 2.5rem; color: {{ $matiere->couleur ?? '#6c5ce7' }};"></i>
                </div>
                <h5 class="card-title mb-1">{{ $matiere->nom }}</h5>
                @if($matiere->code)
                    <small class="text-muted">{{ $matiere->code }}</small>
                @endif
            </div>

            <div class="card-body">
                @if($matiere->description)
                    <p class="text-muted small text-center mb-3">{{ Str::limit($matiere->description, 60) }}</p>
                @endif

                <!-- Classes associées -->
                <div class="mt-3">
                    <small class="text-muted d-block mb-2">Classes associées</small>
                    <div class="d-flex flex-wrap gap-1">
                        @forelse($matiere->classes->take(3) as $classe)
                            <span class="badge bg-light text-dark">
                                {{ $classe->nom }}
                            </span>
                        @empty
                            <span class="text-muted small">Aucune classe</span>
                        @endforelse
                        @if($matiere->classes->count() > 3)
                            <span class="badge bg-light text-dark">
                                +{{ $matiere->classes->count() - 3 }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card-footer bg-transparent border-0 pb-4 pt-0">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-outline-primary flex-fill btn-sm">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.matieres.destroy', $matiere) }}" method="POST" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm" onclick="return confirm('Supprimer cette matière ?')">
                            <i class="ti ti-trash me-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="ti ti-book-off fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Aucune matière trouvée</h5>
                <p class="text-muted mb-4">
                    @if(request('search'))
                        Aucun résultat pour "{{ request('search') }}"
                    @else
                        Commencez par ajouter votre première matière
                    @endif
                </p>
                <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Ajouter une matière
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if(method_exists($matieres, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $matieres->links() }}
    </div>
@endif

@endsection

@push('styles')
<style>
    .matiere-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    .matiere-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
</style>
@endpush