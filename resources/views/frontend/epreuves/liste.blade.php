@extends('layouts.app')

@section('title', 'Épreuves - ' . $classeNom . ' - ' . $matiere->nom)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves') }}">Épreuves</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.classes') }}">Classes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.types', $classeNom) }}">{{ $classeNom }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.matieres', [$classeNom, $typeId]) }}">{{ $type->nom }}</a></li>
            <li class="breadcrumb-item active">{{ $matiere->nom }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $matiere->nom }} - {{ $type->nom }}</h1>
        <div>
            <form method="GET" class="d-flex">
                <select name="sort" class="form-select me-2" onchange="this.form.submit()">
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Plus récent</option>
                    <option value="ancien" {{ request('sort') == 'ancien' ? 'selected' : '' }}>Plus ancien</option>
                    <option value="titre" {{ request('sort') == 'titre' ? 'selected' : '' }}>Titre</option>
                </select>
                
                @if($annees->isNotEmpty())
                    <select name="annee" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes années</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}" {{ request('annee') == $annee ? 'selected' : '' }}>
                                {{ $annee }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($epreuves as $epreuve)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $epreuve->titre }}</h5>
                        <p class="card-text text-muted small mb-2">
                            {{ $epreuve->description ?? 'Aucune description' }}
                        </p>
                        <div class="mb-3">
                            <span class="badge bg-primary me-1">{{ $epreuve->typeEpreuve->nom }}</span>
                            @if($epreuve->annee)
                                <span class="badge bg-secondary">{{ $epreuve->annee }}</span>
                            @endif
                            @if($epreuve->correction)
                                <span class="badge bg-success">Corrigé</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-download"></i> {{ $epreuve->downloads ?? 0 }} téléchargements
                            </small>
                            <div>
                                <a href="{{ route('epreuve.detail', $epreuve->slug ?? $epreuve->id) }}" class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                                <a href="{{ route('epreuve.download', $epreuve) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucune épreuve disponible pour cette sélection.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $epreuves->links() }}
    </div>
</div>
@endsection