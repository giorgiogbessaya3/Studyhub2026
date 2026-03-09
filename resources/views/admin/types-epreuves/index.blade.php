@extends('layouts.admin')

@section('title', 'Gestion des types d\'épreuves - StudyHub')
@section('page-title', 'Types d\'épreuves')
@section('breadcrumb', 'Organisation pédagogique')

@section('content')
<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-gradient-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-category fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['total'] }}</h2>
                        <p class="text-white-75 mb-0">Total types</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-gradient-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-checkbox fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['actifs'] }}</h2>
                        <p class="text-white-75 mb-0">Types actifs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- En-tête -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h5 class="text-muted fw-normal mb-0">
            <i class="ti ti-layers-difference me-2"></i>Gérez les types d'épreuves (devoir, interrogation, examen blanc, révision...)
        </h5>
    </div>
    <a href="{{ route('admin.types-epreuves.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="ti ti-plus me-1"></i> Nouveau type
    </a>
</div>

<!-- Liste des types -->
<div class="row g-4">
    @forelse($types as $type)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-2 me-2" style="background-color: {{ $type->couleur ?? '#6c5ce7' }}20;">
                        <i class="ti {{ $type->icone ?? 'ti-file-text' }}" style="color: {{ $type->couleur ?? '#6c5ce7' }};"></i>
                    </div>
                    <h6 class="card-title mb-0">{{ $type->nom }}</h6>
                </div>
                @if($type->description)
                    <p class="text-muted small mb-3">{{ Str::limit($type->description, 80) }}</p>
                @endif
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="badge bg-{{ $type->statut ? 'success' : 'secondary' }} rounded-pill">
                        {{ $type->statut ? 'Actif' : 'Inactif' }}
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.types-epreuves.edit', $type) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.types-epreuves.destroy', $type) }}" method="POST" onsubmit="return confirm('Supprimer ce type d\'épreuve ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="ti ti-file-unknown fs-1 text-muted mb-3"></i>
                <h5>Aucun type d'épreuve</h5>
                <a href="{{ route('admin.types-epreuves.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="ti ti-plus me-1"></i> Ajouter un type
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .avatar-sm {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hover-lift {
        transition: all 0.2s ease-in-out;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
    }
    .text-white-75 {
        color: rgba(255,255,255,0.75);
    }
</style>
@endpush