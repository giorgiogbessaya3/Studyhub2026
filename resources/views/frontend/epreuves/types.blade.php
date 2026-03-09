@extends('layouts.app')

@section('title', 'Types d\'épreuves - ' . $classeNom)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves') }}">Épreuves</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves.classes') }}">Classes</a></li>
            <li class="breadcrumb-item active">{{ $classeNom }}</li>
        </ol>
    </nav>

    <h1 class="mb-4">{{ $classeNom }}</h1>
    <p class="lead mb-5">Choisissez le type d'épreuve</p>

    <div class="row">
        @forelse($types as $type)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">
                            @switch($type->nom)
                                @case('Devoir')
                                    <i class="bi bi-pencil-square"></i>
                                    @break
                                @case('Examen')
                                    <i class="bi bi-trophy"></i>
                                    @break
                                @case('Interrogation')
                                    <i class="bi bi-question-circle"></i>
                                    @break
                                @default
                                    <i class="bi bi-file-text"></i>
                            @endswitch
                        </div>
                        <h3 class="h5 card-title">{{ $type->nom }}</h3>
                        <p class="text-muted small">
                            {{ $type->epreuves_count }} épreuve(s) disponible(s)
                        </p>
                        @if($type->epreuves_count > 0)
                            <a href="{{ route('epreuves.matieres', [$classeNom, $type->id]) }}" class="stretched-link"></a>
                        @else
                            <span class="text-muted">Bientôt disponible</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun type d'épreuve disponible pour cette classe pour le moment.
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