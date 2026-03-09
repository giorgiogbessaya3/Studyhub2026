@extends('layouts.app')

@section('title', 'Classes - StudyHub')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('epreuves') }}">Épreuves</a></li>
            <li class="breadcrumb-item active">Classes</li>
        </ol>
    </nav>

    <h1 class="mb-4">Banque d'épreuves</h1>
    <p class="lead mb-5">Choisissez votre classe pour commencer</p>

    @if(isset($classesByCycle['college']) && $classesByCycle['college']->count() > 0)
        <h2 class="h3 mb-4">Collège</h2>
        <div class="row mb-5">
            @foreach($classesByCycle['college'] as $classe)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body text-center">
                            <div class="display-4 mb-3">
                                <i class="bi bi-backpack"></i>
                            </div>
                            <h3 class="h5 card-title">{{ $classe->nom }}</h3>
                            <p class="text-muted small">{{ $classe->description ?? 'Toutes les épreuves de ' . $classe->nom }}</p>
                            <a href="{{ route('epreuves.types', $classe->nom) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($classesByCycle['lycee']) && $classesByCycle['lycee']->count() > 0)
        <h2 class="h3 mb-4">Lycée</h2>
        <div class="row">
            @foreach($classesByCycle['lycee'] as $classe)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body text-center">
                            <div class="display-4 mb-3">
                                <i class="bi bi-book"></i>
                            </div>
                            <h3 class="h5 card-title">{{ $classe->nom }}</h3>
                            <p class="text-muted small">{{ $classe->description ?? 'Toutes les épreuves de ' . $classe->nom }}</p>
                            <a href="{{ route('epreuves.types', $classe->nom) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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