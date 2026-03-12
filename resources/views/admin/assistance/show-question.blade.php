@extends('layouts.admin')

@section('title', 'Détail de la question - StudyHub Admin')
@section('page-title', 'Question #' . $question->id)
@section('breadcrumb', 'Assistance / Questions')

@section('content')

<div class="row">
    <!-- Question principale -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $question->titre }}</h5>
                    <div>
                        {!! $question->statut_badge !!}
                        @if($question->statut == 'en_attente')
                            <form action="{{ route('admin.assistance.questions.toggle-publish', $question) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="ti ti-check"></i> Publier
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Métadonnées -->
                <div class="d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom">
                    <div>
                        <i class="ti ti-user text-muted me-1"></i>
                        <strong>{{ $question->user?->name ?? 'Anonyme' }}</strong>
                        <small class="text-muted">({{ $question->user?->email ?? '' }})</small>
                    </div>
                    <div>
                        <i class="ti ti-calendar text-muted me-1"></i>
                        {{ $question->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div>
                        <i class="ti ti-school text-muted me-1"></i>
                        {{ $question->classe?->nom ?? 'N/A' }}
                    </div>
                    <div>
                        <i class="ti ti-book text-muted me-1"></i>
                        {{ $question->matiere?->nom ?? 'N/A' }}
                    </div>
                    <div>
                        <i class="ti ti-eye text-muted me-1"></i>
                        {{ $question->views }} vues
                    </div>
                </div>
                
                <!-- Contenu de la question -->
                <div class="mb-4">
                    <h6 class="fw-bold">Question :</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($question->contenu)) !!}
                    </div>
                </div>
                
                <!-- Image jointe -->
                @if($question->image)
                <div class="mb-4">
                    <h6 class="fw-bold">Image jointe :</h6>
                    <img src="{{ $question->image_url }}" alt="Image jointe" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                @endif
                
                <!-- Formulaire de réponse rapide -->
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Ajouter une réponse :</h6>
                    <form action="{{ route('admin.assistance.questions.reply', $question) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="contenu" rows="4" class="form-control" placeholder="Votre réponse..." required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="est_solution" id="est_solution" class="form-check-input">
                            <label for="est_solution" class="form-check-label">
                                Marquer comme solution (question résolue)
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-send me-1"></i> Publier la réponse
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Réponses -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Réponses ({{ $question->reponses->count() }})</h5>
            </div>
            <div class="card-body">
                @forelse($question->reponses as $reponse)
                <div class="mb-4 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}" id="reponse-{{ $reponse->id }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px;">
                                <i class="ti ti-user text-secondary"></i>
                            </div>
                            <div>
                                <strong>{{ $reponse->user?->name ?? 'Anonyme' }}</strong>
                                @if($reponse->est_solution)
                                    <span class="badge bg-success ms-2">Solution</span>
                                @endif
                                <div>
                                    <small class="text-muted">
                                        {{ $reponse->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            @if(!$reponse->est_solution && $reponse->statut == 'approuvee')
                                <form action="{{ route('admin.assistance.reponses.solution', $reponse) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Marquer comme solution">
                                        <i class="ti ti-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                            
                            @if($reponse->statut == 'en_attente')
                                <form action="{{ route('admin.assistance.reponses.approve', $reponse) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approuver">
                                        <i class="ti ti-check"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.assistance.reponses.reject', $reponse) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Rejeter">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.assistance.reponses.destroy', $reponse) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Supprimer cette réponse ?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="ps-5">
                        @if($reponse->statut == 'rejetee')
                            <div class="text-danger fst-italic mb-2">
                                <i class="ti ti-alert-triangle"></i> Réponse rejetée
                            </div>
                        @elseif($reponse->statut == 'en_attente')
                            <div class="text-warning fst-italic mb-2">
                                <i class="ti ti-clock"></i> En attente de modération
                            </div>
                        @endif
                        
                        <div class="p-3 rounded {{ $reponse->statut == 'rejetee' ? 'bg-light text-muted' : 'bg-light' }}">
                            {!! nl2br(e($reponse->contenu)) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="ti ti-message-off fs-1 text-muted mb-2"></i>
                    <p class="text-muted">Aucune réponse pour le moment</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Sidebar : Questions similaires -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Questions similaires</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($questionsSimilaires as $similaire)
                    <a href="{{ route('admin.assistance.questions.show', $similaire) }}" 
                       class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ Str::limit($similaire->titre, 40) }}</h6>
                            <small>{{ $similaire->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge bg-light text-dark">{{ $similaire->classe?->nom }}</span>
                            <span class="badge bg-light text-dark">{{ $similaire->matiere?->nom }}</span>
                            <span class="badge bg-secondary">{{ $similaire->reponses_count }} réponses</span>
                        </div>
                    </a>
                    @empty
                    <div class="list-group-item text-center text-muted py-4">
                        <i class="ti ti-search fs-1 mb-2"></i>
                        <p>Aucune question similaire</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Actions supplémentaires -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-outline-primary w-100 mb-2" onclick="window.print()">
                    <i class="ti ti-printer"></i> Imprimer
                </button>
                
                <form action="{{ route('admin.assistance.questions.destroy', $question) }}" 
                      method="POST" 
                      onsubmit="return confirm('Supprimer définitivement cette question ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="ti ti-trash"></i> Supprimer la question
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection