@extends('layouts.admin')

@section('title', 'Gestion des Classes')
@section('page-title', 'Gestion des Classes')
@section('breadcrumb', 'Organisation pédagogique')

@section('content')

<!-- Statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="mb-1">{{ $stats['total'] }}</h3>
                <small class="text-muted">Total classes</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="mb-1">{{ $stats['total_lycee'] }}</h3>
                <small class="text-muted">Lycée</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="mb-1">{{ $stats['total_college'] }}</h3>
                <small class="text-muted">Collège</small>
            </div>
        </div>
    </div>
</div>

<!-- Bouton ajouter -->
<div class="mb-4 ">
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Ajouter une classe
    </a>
</div>

<!-- Liste des classes -->
<div class="row g-3">
    @forelse($classes as $classe)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="mb-0">{{ $classe->nom }}</h5>
                    <span class="badge bg-{{ $classe->statut ? 'success' : 'secondary' }}">
                        {{ $classe->statut ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                
                <p class="text-muted small mb-2">
                    <span class="text-capitalize">{{ $classe->cycle }}</span>
                </p>
                
                @if($classe->description)
                    <p class="small text-muted mb-3">{{ Str::limit($classe->description, 50) }}</p>
                @endif
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.classes.edit', $classe) }}" class="btn btn-sm btn-outline-primary">
                        Modifier
                    </a>
                    <form action="{{ route('admin.classes.destroy', $classe) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <p class="text-muted mb-0">Aucune classe trouvée</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection