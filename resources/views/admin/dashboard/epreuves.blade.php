@extends('layouts.admin')

@section('title', 'Dashboard Épreuves - StudyHub')
@section('page-title', 'Tableau de bord des épreuves')
@section('breadcrumb', 'Statistiques')

@section('content')
<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-file-text fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['total'] }}</h2>
                        <p class="text-white-75 mb-0">Total épreuves</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-checkbox fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['avec_correction'] }}</h2>
                        <p class="text-white-75 mb-0">Avec correction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-alert-triangle fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['sans_correction'] }}</h2>
                        <p class="text-white-75 mb-0">Sans correction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="ti ti-eye fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="text-white mb-0">{{ $stats['publiees'] }} / {{ $stats['brouillons'] }}</h2>
                        <p class="text-white-75 mb-0">Publiées / Brouillons</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Graphique : Épreuves par classe -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Répartition par classe</h5>
            </div>
            <div class="card-body">
                @if($epreuves_par_classe->count() > 0)
                    @foreach($epreuves_par_classe as $classe)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>{{ $classe->nom }}</span>
                                <span class="badge bg-primary">{{ $classe->epreuves_count }} épreuves</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $pourcentage = $stats['total'] > 0 ? round(($classe->epreuves_count / $stats['total']) * 100) : 0;
                                @endphp
                                <div class="progress-bar bg-primary" style="width: {{ $pourcentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">Aucune donnée disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Graphique : Épreuves par matière -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Top 10 matières</h5>
            </div>
            <div class="card-body">
                @if($epreuves_par_matiere->count() > 0)
                    @foreach($epreuves_par_matiere as $matiere)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>{{ $matiere->nom }}</span>
                                <span class="badge bg-success">{{ $matiere->epreuves_count }} épreuves</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $pourcentage = $stats['total'] > 0 ? round(($matiere->epreuves_count / $stats['total']) * 100) : 0;
                                @endphp
                                <div class="progress-bar bg-success" style="width: {{ $pourcentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">Aucune donnée disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Graphique : Épreuves par type -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Types d'épreuves</h5>
            </div>
            <div class="card-body">
                @if($epreuves_par_type->count() > 0)
                    @foreach($epreuves_par_type as $type)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>
                                    <i class="ti {{ $type->icone ?? 'ti-file-text' }} me-1"></i>
                                    {{ $type->nom }}
                                </span>
                                <span class="badge bg-info">{{ $type->epreuves_count }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">Aucune donnée disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Graphique : Épreuves par année -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Répartition par année</h5>
            </div>
            <div class="card-body">
                @if($epreuves_par_annee->count() > 0)
                    @foreach($epreuves_par_annee as $annee)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Année {{ $annee->annee }}</span>
                                <span class="badge bg-warning">{{ $annee->total }} épreuves</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $pourcentage = $stats['total'] > 0 ? round(($annee->total / $stats['total']) * 100) : 0;
                                @endphp
                                <div class="progress-bar bg-warning" style="width: {{ $pourcentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">Aucune donnée disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Dernières épreuves ajoutées -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Dernières épreuves</h5>
                <a href="{{ route('admin.epreuves.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($dernieres_epreuves as $epreuve)
                        <div class="list-group-item border-0 d-flex align-items-center">
                            <div class="rounded-3 p-2 me-2" style="background-color: {{ $epreuve->typeEpreuve->couleur ?? '#6c5ce7' }}20;">
                                <i class="ti {{ $epreuve->typeEpreuve->icone ?? 'ti-file-text' }}" style="color: {{ $epreuve->typeEpreuve->couleur ?? '#6c5ce7' }};"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Str::limit($epreuve->titre, 30) }}</h6>
                                <small class="text-muted">{{ $epreuve->classe->nom }} • {{ $epreuve->matiere->nom }}</small>
                            </div>
                            <small class="text-muted">{{ $epreuve->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Aucune épreuve récente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liens rapides -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Actions rapides</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.epreuves.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Nouvelle épreuve
                    </a>
                    <a href="{{ route('admin.epreuves.index') }}" class="btn btn-outline-primary">
                        <i class="ti ti-list me-1"></i>Gérer les épreuves
                    </a>
                    <a href="{{ route('admin.types-epreuves.index') }}" class="btn btn-outline-primary">
                        <i class="ti ti-category me-1"></i>Types d'épreuves
                    </a>
                    <a href="{{ route('admin.corrections') }}" class="btn btn-outline-primary">
                        <i class="ti ti-file-text me-1"></i>Corrections
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%); }
    .avatar-sm {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .text-white-75 { color: rgba(255,255,255,0.75); }
    .list-group-item {
        padding: 1rem;
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush