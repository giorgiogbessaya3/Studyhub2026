@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid py-4">
    <!-- Header avec bienvenue -->
    <div class="d-flex align-items-center mb-4">
        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
            @php
                $initials = substr(auth()->user()->name, 0, 2);
            @endphp
            {{ $initials }}
        </div>
        <div>
            <h1 class="text-primary fw-bold mb-1">Tableau de bord</h1>
            <p class="lead text-muted mb-0">
                Bonjour, <span class="text-primary fw-semibold">{{ auth()->user()->name }}</span> !
            </p>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg dashboard-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-primary mb-0">{{ $stats['total'] ?? 0 }}</h2>
                            <p class="text-muted mb-0">Total tickets</p>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-ticket-alt text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg dashboard-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-danger mb-0">{{ $stats['pending'] ?? 0 }}</h2>
                            <p class="text-muted mb-0">Tickets ouverts</p>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-exclamation-circle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg dashboard-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-warning mb-0">{{ $stats['in_progress'] ?? 0 }}</h2>
                            <p class="text-muted mb-0">En cours</p>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-clock text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg dashboard-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-success mb-0">{{ $stats['resolved'] ?? 0 }}</h2>
                            <p class="text-muted mb-0">Résolus</p>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Section principale - Tickets -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Mes tickets récents
                        </h5>
                        <a href="{{ route('tickets.create') }}" class="btn btn-light rounded-pill">
                            <i class="fas fa-plus-circle me-2"></i>
                            Nouveau ticket
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($tickets->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($tickets as $ticket)
                        <div class="list-group-item py-3 hover-lift" style="cursor: pointer;" onclick="showTicketModal({{ $ticket->id }})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i class="fas {{ $ticket->category === 'technique' ? 'fa-tools' : ($ticket->category === 'facturation' ? 'fa-credit-card' : ($ticket->category === 'compte' ? 'fa-user-cog' : ($ticket->category === 'fonctionnalite' ? 'fa-lightbulb' : 'fa-question-circle'))) }} fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold text-dark">{{ $ticket->subject }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Créé le {{ $ticket->created_at->format('d/m/Y') }} | 
                                            <i class="fas fa-clock ms-2 me-1"></i>
                                            @if($ticket->replies->count() > 0)
                                            Dernière réponse: {{ $ticket->replies->last()->created_at->format('d/m/Y') }}
                                            @else
                                            En attente de réponse
                                            @endif
                                        </small>
                                        <div class="mt-2">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-comments me-1"></i>
                                                {{ $ticket->replies->count() }} réponse(s)
                                            </span>
                                            @if($ticket->attachments->count() > 0)
                                            <span class="badge bg-light text-dark ms-2">
                                                <i class="fas fa-paperclip me-1"></i>
                                                {{ $ticket->attachments->count() }} fichier(s)
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2 text-end">
                                    @php
                                        $statusColor = $ticket->status === 'ouvert' ? 'danger' : ($ticket->status === 'en_cours' ? 'warning' : ($ticket->status === 'resolu' ? 'success' : 'secondary'));
                                        $priorityColor = $ticket->priority === 'urgente' ? 'danger' : ($ticket->priority === 'haute' ? 'warning' : ($ticket->priority === 'moyenne' ? 'info' : 'success'));
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                    <span class="badge bg-{{ $priorityColor }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun ticket trouvé</h5>
                        <p class="text-muted mb-4">Vous n'avez pas encore créé de ticket de support.</p>
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus-circle me-2"></i>
                            Créer votre premier ticket
                        </a>
                    </div>
                    @endif
                </div>
                @if($tickets->hasPages())
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de <strong>{{ $tickets->firstItem() }} à {{ $tickets->lastItem() }}</strong> 
                            sur <strong>{{ $tickets->total() }}</strong> tickets
                        </div>
                        {{ $tickets->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Graphique et informations -->
        <div class="col-lg-4">
            <!-- Graphique des tickets -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistiques des tickets
                    </h6>
                </div>
                <div class="card-body">
                    <div class="ticket-chart">
                        <div class="chart-bars">
                            @php
                                $total = max($stats['total'] ?? 1, 1);
                                $openHeight = (($stats['pending'] ?? 0) / $total) * 100;
                                $progressHeight = (($stats['in_progress'] ?? 0) / $total) * 100;
                                $resolvedHeight = (($stats['resolved'] ?? 0) / $total) * 100;
                            @endphp
                            <div class="chart-bar open" style="height: {{ max($openHeight, 10) }}%">
                                <span class="bar-label">{{ $stats['pending'] ?? 0 }}</span>
                            </div>
                            <div class="chart-bar pending" style="height: {{ max($progressHeight, 10) }}%">
                                <span class="bar-label">{{ $stats['in_progress'] ?? 0 }}</span>
                            </div>
                            <div class="chart-bar closed" style="height: {{ max($resolvedHeight, 10) }}%">
                                <span class="bar-label">{{ $stats['resolved'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color open"></div>
                                <span>Ouverts</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color pending"></div>
                                <span>En cours</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color closed"></div>
                                <span>Résolus</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary d-flex align-items-center justify-content-start text-decoration-none py-3">
                            <i class="fas fa-plus-circle fs-4 me-3"></i>
                            <div class="text-start">
                                <div class="fw-semibold">Nouveau Ticket</div>
                                <small class="opacity-75">Soumettre une demande</small>
                            </div>
                        </a>
                        <a href="{{ route('tickets.list') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start text-decoration-none py-3">
                            <i class="fas fa-list fs-4 me-3"></i>
                            <div class="text-start">
                                <div class="fw-semibold">Voir tous les tickets</div>
                                <small class="opacity-75">Historique complet</small>
                            </div>
                        </a>
                        <a href="{{ url('change-password') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-start text-decoration-none py-3">
                            <i class="fas fa-lock fs-4 me-3"></i>
                            <div class="text-start">
                                <div class="fw-semibold">Sécurité</div>
                                <small class="opacity-75">Changer mot de passe</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations système -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations système
                    </h6>
                </div>
                <div class="card-body">
                    <div class="system-info">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Dernière connexion:</span>
                            <span class="fw-semibold">
                                @if(auth()->user()->last_login_at)
                                    {{ auth()->user()->last_login_at->format('d/m/Y H:i') }}
                                @else
                                    Première connexion
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Compte créé:</span>
                            <span class="fw-semibold">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Statut:</span>
                            <span class="badge bg-success">Actif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de détail du ticket -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Détails du ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="ticketModalBody">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-stat-card {
        transition: all 0.3s ease;
        border-radius: 15px;
    }
    
    .dashboard-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15) !important;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        transition: all 0.3s ease;
    }
    
    .dashboard-stat-card:hover .stat-icon {
        transform: scale(1.1);
    }
    
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        background-color: #f8f9fa !important;
    }
    
    /* Styles pour le graphique */
    .ticket-chart {
        padding: 1rem 0;
    }
    
    .chart-bars {
        display: flex;
        align-items: end;
        justify-content: space-around;
        height: 120px;
        margin-bottom: 1rem;
        gap: 8px;
    }
    
    .chart-bar {
        position: relative;
        width: 30px;
        border-radius: 4px 4px 0 0;
        transition: all 0.3s ease;
        min-height: 20px;
    }
    
    .chart-bar:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }
    
    .chart-bar.open {
        background: linear-gradient(to top, #ef4444, #f87171);
    }
    
    .chart-bar.pending {
        background: linear-gradient(to top, #f59e0b, #fbbf24);
    }
    
    .chart-bar.closed {
        background: linear-gradient(to top, #10b981, #34d399);
    }
    
    .bar-label {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.75rem;
        font-weight: bold;
        color: #374151;
    }
    
    .chart-legend {
        display: flex;
        justify-content: space-around;
        font-size: 0.75rem;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }
    
    .legend-color.open {
        background-color: #ef4444;
    }
    
    .legend-color.pending {
        background-color: #f59e0b;
    }
    
    .legend-color.closed {
        background-color: #10b981;
    }

    .admin-response {
        border-left: 4px solid #3B82F6 !important;
    }

    .system-info {
        font-size: 0.9rem;
    }
</style>

<script>
    // Fonction pour afficher les détails d'un ticket
    async function showTicketModal(ticketId) {
        try {
            const response = await fetch(`/tickets/${ticketId}`);
            
            if (!response.ok) {
                throw new Error('Ticket non trouvé');
            }
            
            const ticket = await response.json();
            
            const modalBody = document.getElementById('ticketModalBody');
            modalBody.innerHTML = `
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-semibold mb-1">${ticket.subject}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Créé le ${new Date(ticket.created_at).toLocaleDateString('fr-FR')}
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-${getStatusBadgeColor(ticket.status)}">
                                ${ticket.status}
                            </span>
                            <span class="badge bg-${getPriorityBadgeColor(ticket.priority)}">
                                ${ticket.priority}
                            </span>
                        </div>
                    </div>
                    <div class="card bg-light border-0 p-3">
                        <p class="mb-0">${ticket.message}</p>
                    </div>
                </div>

                <hr />

                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-comments me-2"></i>
                        Historique des réponses
                        ${ticket.replies && ticket.replies.length > 0 ? 
                            '<span class="badge bg-primary ms-2">' + ticket.replies.length + '</span>' : 
                            ''}
                    </h6>
                    
                    ${ticket.replies && ticket.replies.length > 0 ? 
                        ticket.replies.map(response => `
                            <div class="admin-response card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                <i class="fas fa-user-check text-primary me-2"></i>
                                                ${response.user ? response.user.name : 'Administrateur'}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                ${new Date(response.created_at).toLocaleDateString('fr-FR')} 
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="response-content">
                                        <p class="mb-0">${response.message}</p>
                                    </div>
                                </div>
                            </div>
                        `).join('') : 
                        `
                        <div class="text-center py-4">
                            <i class="fas fa-clock fa-2x text-muted mb-3"></i>
                            <h6 class="text-muted">En attente de réponse</h6>
                            <p class="text-muted mb-0">L'administrateur traitera votre demande sous peu</p>
                        </div>
                        `}
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
            modal.show();
        } catch (error) {
            console.error('Erreur lors du chargement du ticket:', error);
            alert('Erreur lors du chargement des détails du ticket');
        }
    }

    // Fonctions utilitaires pour les couleurs
    function getStatusBadgeColor(status) {
        const colors = {
            'ouvert': 'danger',
            'en_cours': 'warning',
            'resolu': 'success',
            'ferme': 'secondary'
        };
        return colors[status] || 'secondary';
    }

    function getPriorityBadgeColor(priority) {
        const colors = {
            'urgente': 'danger',
            'haute': 'warning',
            'moyenne': 'info',
            'basse': 'success'
        };
        return colors[priority] || 'secondary';
    }
</script>
@endsection