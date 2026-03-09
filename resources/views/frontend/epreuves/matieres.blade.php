@extends('layouts.app')

@section('title', 'Matières - ' . $classeNom . ' - ' . $type->nom)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves') }}">Épreuves</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.classes') }}">Classes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.types', $classeNom) }}">{{ $classeNom }}</a></li>
            <li class="breadcrumb-item active">{{ $type->nom }}</li>
        </ol>
    </nav>

    <h1 class="mb-4">{{ $classeNom }} - {{ $type->nom }}</h1>
    <p class="lead mb-5">Choisissez la matière</p>

    <div class="row">
        @forelse($matieres as $matiere)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">
                            @switch($matiere->nom)
                                @case('Mathématiques')
                                    <i class="bi bi-calculator"></i>
                                    @break
                                @case('Français')
                                    <i class="bi bi-book"></i>
                                    @break
                                @case('Anglais')
                                    <i class="bi bi-chat"></i>
                                    @break
                                @case('Histoire-Géo')
                                    <i class="bi bi-globe"></i>
                                    @break
                                @case('Physique-Chimie')
                                    <i class="bi bi-flask"></i>
                                    @break
                                @case('SVT')
                                    <i class="bi bi-tree"></i>
                                    @break
                                @default
                                    <i class="bi bi-journal"></i>
                            @endswitch
                        </div>
                        <h3 class="h5 card-title">{{ $matiere->nom }}</h3>
                        <p class="text-muted small">
                            {{ $matiere->epreuves_count }} épreuve(s) disponible(s)
                        </p>
                        @if($matiere->epreuves_count > 0)
                            <a href="{{ route('epreuves.liste', [$classeNom, $typeId, $matiere->id]) }}" class="stretched-link"></a>
                        @else
                            <span class="text-muted">Bientôt disponible</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucune matière disponible pour ce type d'épreuve.
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}
</style>
@endsection