@extends('layouts.admin')

@section('title', 'Détail du Contenu')

@section('page-title', 'Détail du Contenu')
@section('breadcrumb', 'Contenus')

@section('content')

<!-- Navigation rapide -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.chapitres.edit', $contenu->chapitre) }}" class="btn btn-light btn-sm">
            <i class="ti ti-arrow-left me-1"></i>Retour au chapitre
        </a>
    </div>
    <div class="btn-group">
        @if($contenuPrecedent)
            <a href="{{ route('admin.contenus.show', $contenuPrecedent) }}" class="btn btn-outline-secondary btn-sm">
                <i class="ti ti-chevron-left me-1"></i>Précédent
            </a>
        @endif
        @if($contenuSuivant)
            <a href="{{ route('admin.contenus.show', $contenuSuivant) }}" class="btn btn-outline-secondary btn-sm">
                Suivant<i class="ti ti-chevron-right ms-1"></i>
            </a>
        @endif
    </div>
</div>

<!-- Fil d'ariane détaillé -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.classes.index') }}">{{ $contenu->chapitre->classe->nom }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.matieres.index') }}">{{ $contenu->chapitre->matiere->nom }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.chapitres.edit', $contenu->chapitre) }}">{{ Str::limit($contenu->chapitre->titre, 30) }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $contenu->titre }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Contenu principal -->
    <div class="col-lg-8">
        <!-- Carte du contenu -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ $contenu->titre }}</h5>
                    <small class="text-muted">Ordre #{{ $contenu->ordre }} • Créé le {{ $contenu->created_at->format('d/m/Y') }}</small>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.contenus.edit', $contenu) }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce contenu ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Contenu du cours -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3"><i class="ti ti-file-text me-2"></i>Contenu du cours</h6>
                    <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $contenu->resume }}</div>
                </div>

                <!-- Images -->
                @if($contenu->images && count($contenu->images) > 0)
                <div class="mb-4">
                    <h6 class="text-muted mb-3"><i class="ti ti-photo me-2"></i>Images explicatives ({{ count($contenu->images) }})</h6>
                    <div class="row g-2">
                        @foreach($contenu->images as $index => $image)
                        <div class="col-md-4 col-6">
                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="d-block position-relative">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Image {{ $index + 1 }}" 
                                     class="img-fluid rounded w-100" 
                                     style="height: 150px; object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 end-0 p-2 bg-dark bg-opacity-50 text-white text-center small rounded-bottom">
                                    Image {{ $index + 1 }}
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Exercices -->
                @if($contenu->exercices && count($contenu->exercices) > 0)
                <div class="mb-4">
                    <h6 class="text-muted mb-3"><i class="ti ti-checklist me-2"></i>Exercices d'application ({{ count($contenu->exercices) }})</h6>
                    <div class="accordion" id="accordionExercices">
                        @foreach($contenu->exercices as $index => $exercice)
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#exercice{{ $index }}">
                                    <span class="badge bg-primary me-2">#{{ $index + 1 }}</span>
                                    {{ Str::limit($exercice['question'], 50) }}
                                </button>
                            </h2>
                            <div id="exercice{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#accordionExercices">
                                <div class="accordion-body bg-light">
                                    <div class="mb-3">
                                        <strong class="text-primary">Question :</strong>
                                        <p class="mb-0">{{ $exercice['question'] }}</p>
                                    </div>
                                    <div class="border-top pt-3">
                                        <strong class="text-success">Réponse :</strong>
                                        <p class="mb-0">{{ $exercice['reponse'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar infos -->
    <div class="col-lg-4">
        <!-- Infos chapitre -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-book me-2"></i>Chapitre parent</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Classe</small>
                    <span class="badge bg-dark">{{ $contenu->chapitre->classe->nom }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Matière</small>
                    <span class="badge bg-primary">{{ $contenu->chapitre->matiere->nom }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Chapitre</small>
                    <strong>{{ $contenu->chapitre->titre }}</strong>
                </div>
                <a href="{{ route('admin.chapitres.edit', $contenu->chapitre) }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="ti ti-edit me-1"></i>Modifier le chapitre
                </a>
            </div>
        </div>

        <!-- Navigation dans le chapitre -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-list-numbers me-2"></i>Contenus du chapitre</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($contenu->chapitre->contenus as $item)
                    <a href="{{ route('admin.contenus.show', $item) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $item->id == $contenu->id ? 'active' : '' }}">
                        <div>
                            <span class="badge {{ $item->id == $contenu->id ? 'bg-white text-primary' : 'bg-secondary' }} me-2">#{{ $item->ordre }}</span>
                            <span class="{{ $item->id == $contenu->id ? 'fw-bold' : '' }}">{{ Str::limit($item->titre, 25) }}</span>
                        </div>
                        @if($item->id == $contenu->id)
                            <i class="ti ti-chevron-right"></i>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Stats rapides -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="ti ti-chart-bar me-2"></i>Statistiques</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Images</span>
                    <strong>{{ $contenu->images ? count($contenu->images) : 0 }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Exercices</span>
                    <strong>{{ $contenu->exercices ? count($contenu->exercices) : 0 }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Dernière modif</span>
                    <strong>{{ $contenu->updated_at->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .accordion-button:not(.collapsed) {
        background-color: #eff6ff;
        color: #2563eb;
    }
    .breadcrumb-item a {
        color: #2563eb;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    .list-group-item.active {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>
@endpush