@extends('layouts.admin')

@section('title', 'Tableau de bord - StudyHub')

@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Vue d\'ensemble')

@section('content')

<!-- Stats Cards - Simplifié -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="ti ti-file-text fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">1,247</h3>
                    <p class="text-muted mb-0 small">Épreuves</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="ti ti-book fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">486</h3>
                    <p class="text-muted mb-0 small">Cours</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="ti ti-users fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">3,842</h3>
                    <p class="text-muted mb-0 small">Utilisateurs</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                        <i class="ti ti-help-circle fs-4"></i>
                    </div>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">89</h3>
                    <p class="text-muted mb-0 small">Questions</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/admin/epreuves/create') }}" class="btn btn-primary btn-sm">
                <i class="ti ti-plus me-1"></i> Épreuve
            </a>
            <a href="{{ url('/admin/cours/create') }}" class="btn btn-success btn-sm">
                <i class="ti ti-plus me-1"></i> Cours
            </a>
            <a href="{{ url('/admin/quiz/create') }}" class="btn btn-warning btn-sm text-white">
                <i class="ti ti-plus me-1"></i> Quiz
            </a>
            <a href="{{ url('/admin/users/create') }}" class="btn btn-info btn-sm text-white">
                <i class="ti ti-plus me-1"></i> Utilisateur
            </a>
            <a href="{{ url('/admin/assistance/questions') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                <i class="ti ti-messages me-1"></i> Voir questions
            </a>
        </div>
    </div>
</div>

<!-- Contenu principal -->
<div class="row g-4">
    
    <!-- Dernières épreuves -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Dernières épreuves</h5>
                    <a href="{{ url('/admin/epreuves') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Épreuve</th>
                                <th>Classe</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                            <i class="ti ti-calculator"></i>
                                        </span>
                                        <div>
                                            <div class="fw-semibold">Mathématiques - Fonctions</div>
                                            <small class="text-muted">Terminale S</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark">Terminale</span></td>
                                <td><span class="badge bg-warning">Examen blanc</span></td>
                                <td class="text-muted small">Aujourd'hui</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                            <i class="ti ti-atom"></i>
                                        </span>
                                        <div>
                                            <div class="fw-semibold">Physique - Mécanique</div>
                                            <small class="text-muted">Première</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark">Première</span></td>
                                <td><span class="badge bg-success">Devoir</span></td>
                                <td class="text-muted small">Hier</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                                            <i class="ti ti-leaf"></i>
                                        </span>
                                        <div>
                                            <div class="fw-semibold">SVT - Photosynthèse</div>
                                            <small class="text-muted">Seconde</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark">Seconde</span></td>
                                <td><span class="badge bg-info">Interrogation</span></td>
                                <td class="text-muted small">Il y a 2 jours</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light me-1"><i class="ti ti-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar droite -->
    <div class="col-lg-4">
        
        <!-- Questions en attente -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="card-title mb-0 fw-bold">Questions en attente</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                    <img src="{{ asset('admin/images/profile/user-2.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold small">Marie Dupont</div>
                                <div class="text-muted small">Terminale • Maths</div>
                            </div>
                            <span class="badge bg-danger small">Urgent</span>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Problème d'intégration...</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                    <img src="{{ asset('admin/images/profile/user-3.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold small">Lucas Martin</div>
                                <div class="text-muted small">Première • Physique</div>
                            </div>
                            <span class="badge bg-warning small">En attente</span>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Équations différentielles...</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start">
                    <img src="{{ asset('admin/images/profile/user-4.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold small">Emma Bernard</div>
                                <div class="text-muted small">Seconde • SVT</div>
                            </div>
                            <span class="badge bg-info small">Nouveau</span>
                        </div>
                        <p class="small text-muted mb-0 mt-1">La cellule et son...</p>
                    </div>
                </div>
                
                <a href="{{ url('/admin/assistance/questions') }}" class="btn btn-outline-primary w-100 mt-3 btn-sm">
                    Voir toutes les questions
                </a>
            </div>
        </div>
        
        <!-- Répartition rapide -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="card-title mb-0 fw-bold">Répartition par classe</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Terminale</span>
                        <span class="fw-semibold">35%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 35%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Première</span>
                        <span class="fw-semibold">28%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 28%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Seconde</span>
                        <span class="fw-semibold">20%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Collège</span>
                        <span class="fw-semibold">17%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" style="width: 17%"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Footer simple -->
<div class="text-center text-muted small py-4 mt-4 border-top">
    <p class="mb-0">StudyHub © 2026 - Plateforme éducative</p>
</div>

@endsection