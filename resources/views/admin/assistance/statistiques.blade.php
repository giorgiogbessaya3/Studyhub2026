@extends('layouts.admin')

@section('title', 'Statistiques assistance - StudyHub Admin')
@section('page-title', 'Statistiques de l\'assistance')
@section('breadcrumb', 'Assistance / Statistiques')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total questions</h6>
                <h2>{{ $stats['total_questions'] }}</h2>
                <small class="text-success">{{ $stats['questions_resolues'] }} résolues</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total réponses</h6>
                <h2>{{ $stats['total_reponses'] }}</h2>
                <small>{{ $stats['reponses_en_attente'] }} en attente</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Questions en attente</h6>
                <h2 class="text-warning">{{ $stats['questions_en_attente'] }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Questions publiées</h6>
                <h2 class="text-success">{{ $stats['questions_publiees'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Par classe -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Questions par classe</h5>
            </div>
            <div class="card-body">
                <canvas id="chartClasses" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Par matière -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Questions par matière</h5>
            </div>
            <div class="card-body">
                <canvas id="chartMatieres" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top contributeurs -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Top contributeurs</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Utilisateur</th>
                                <th class="text-center">Réponses approuvées</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['top_contributeurs'] as $contrib)
                            <tr>
                                <td>{{ $contrib->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $contrib->total_reponses }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Évolution -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Évolution (30 derniers jours)</h5>
            </div>
            <div class="card-body">
                <canvas id="chartEvolution" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique par classe
    const ctxClasses = document.getElementById('chartClasses').getContext('2d');
    new Chart(ctxClasses, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stats['par_classe']->pluck('classe')) !!},
            datasets: [{
                label: 'Nombre de questions',
                data: {!! json_encode($stats['par_classe']->pluck('total')) !!},
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    
    // Graphique par matière
    const ctxMatieres = document.getElementById('chartMatieres').getContext('2d');
    new Chart(ctxMatieres, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stats['par_matiere']->pluck('matiere')) !!},
            datasets: [{
                label: 'Nombre de questions',
                data: {!! json_encode($stats['par_matiere']->pluck('total')) !!},
                backgroundColor: '#10b981',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    
    // Graphique d'évolution
    const ctxEvolution = document.getElementById('chartEvolution').getContext('2d');
    new Chart(ctxEvolution, {
        type: 'line',
        data: {
            labels: {!! json_encode($stats['evolution']->pluck('date')) !!},
            datasets: [{
                label: 'Questions',
                data: {!! json_encode($stats['evolution']->pluck('total')) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush