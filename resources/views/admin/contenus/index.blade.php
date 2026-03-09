@extends('layouts.admin')

@section('title', 'Gestion des Contenus')

@section('page-title', 'Gestion des Contenus')
@section('breadcrumb', 'Cours / Leçons')

@section('content')

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-3">
                <h3 class="text-primary mb-1">{{ $stats['total'] ?? 0 }}</h3>
                <small class="text-muted">Total contenus</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-3">
                <h3 class="text-info mb-1">{{ $stats['avec_images'] ?? 0 }}</h3>
                <small class="text-muted">Avec images</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-3">
                <h3 class="text-success mb-1">{{ $stats['avec_exercices'] ?? 0 }}</h3>
                <small class="text-muted">Avec exercices</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Classe</label>
                <select name="classe_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach($classes ?? [] as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Matière</label>
                <select name="matiere_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach($matieres ?? [] as $matiere)
                        <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Chapitre</label>
                <select name="chapitre_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    @foreach($chapitres ?? [] as $chapitre)
                        <option value="{{ $chapitre->id }}" {{ request('chapitre_id') == $chapitre->id ? 'selected' : '' }}>
                            {{ Str::limit($chapitre->titre, 30) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.chapitres.index') }}" class="btn btn-primary w-100">
                    <i class="ti ti-plus me-2"></i> Ajouter via chapitre
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des contenus -->
<div class="row g-4 mb-4">
    @forelse($contenus as $contenu)
    <div class="col-xl-4 col-lg-6">
        <div class="card border-0 shadow-sm h-100 contenu-card">
            <div class="card-body p-4">
                <!-- Fil d'ariane -->
                <div class="mb-3">
                    <div class="d-flex gap-1 flex-wrap align-items-center small mb-2">
                        <span class="badge bg-dark">{{ $contenu->chapitre->classe->nom ?? 'N/A' }}</span>
                        <i class="ti ti-chevron-right text-muted"></i>
                        <span class="badge bg-primary">{{ $contenu->chapitre->matiere->nom ?? 'N/A' }}</span>
                    </div>
                    <div class="small">
                        <i class="ti ti-book text-muted me-1"></i>
                        <span class="text-muted">{{ Str::limit($contenu->chapitre->titre ?? 'Chapitre inconnu', 25) }}</span>
                    </div>
                </div>

                <!-- Titre et ordre -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ $contenu->titre }}</h5>
                    <span class="badge bg-secondary">#{{ $contenu->ordre }}</span>
                </div>

                <!-- Résumé -->
                <p class="text-muted small mb-3" style="min-height: 3em;">
                    {{ Str::limit(strip_tags($contenu->resume), 100) ?: 'Aucun contenu' }}
                </p>

                <!-- Indicateurs -->
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    @if($contenu->images && count($contenu->images) > 0)
                        <span class="badge bg-info bg-opacity-10 text-info">
                            <i class="ti ti-photo me-1"></i>{{ count($contenu->images) }} image(s)
                        </span>
                    @endif
                    @if($contenu->exercices && count($contenu->exercices) > 0)
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="ti ti-checklist me-1"></i>{{ count($contenu->exercices) }} exercice(s)
                        </span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                    <small class="text-muted">
                        <i class="ti ti-calendar me-1"></i>
                        {{ $contenu->created_at->format('d/m/Y') }}
                    </small>
                    
                    <div class="btn-group">
                        <a href="{{ route('admin.contenus.show', $contenu) }}" class="btn btn-sm btn-outline-info" title="Voir détails">
                            <i class="ti ti-eye"></i>
                        </a>
                        <a href="{{ route('admin.contenus.edit', $contenu) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce contenu ?');">
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
            <div class="card-body text-center p-5">
                <i class="ti ti-file-text-off fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Aucun contenu trouvé</h5>
                <p class="text-muted small mb-3">
                    @if(request('classe_id') || request('matiere_id') || request('chapitre_id'))
                        Essayez de modifier vos filtres ou
                    @endif
                    ajoutez du contenu depuis un chapitre
                </p>
                <a href="{{ route('admin.chapitres.index') }}" class="btn btn-primary">
                    <i class="ti ti-arrow-left me-1"></i> Voir les chapitres
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($contenus->hasPages())
<div class="d-flex justify-content-center">
    {{ $contenus->appends(request()->query())->links() }}
</div>
@endif

@endsection

@push('styles')
<style>
    .contenu-card {
        transition: all 0.3s ease;
        border-top: 4px solid transparent;
    }
    .contenu-card:hover {
        transform: translateY(-5px);
        border-top-color: #2563eb;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush