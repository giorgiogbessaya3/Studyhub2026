@extends('layouts.admin')

@section('title', $blog->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="ti ti-news me-2"></i>{{ $blog->title }}
                </h4>
                <div>
                    <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }} me-2">
                        <i class="ti ti-{{ $blog->status === 'published' ? 'eye' : 'edit' }} me-1"></i>
                        {{ $blog->status === 'published' ? 'Publié' : 'Brouillon' }}
                    </span>
                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i>Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <!-- Section Médias -->
                <div class="row mb-4">
                    <!-- Image principale -->
                    @if($blog->image)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-photo me-2"></i>Image principale
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" 
                                     class="img-fluid rounded" style="max-height: 300px;">
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="ti ti-info-circle me-1"></i>
                                        Fichier: {{ basename($blog->image) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Vidéo YouTube -->
                    @if($blog->youtube_url)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-brand-youtube me-2 text-danger"></i>Vidéo YouTube
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    @if($blog->getYouTubeId())
                                    <div class="ratio ratio-16x9 mb-3">
                                        <iframe 
                                            src="https://www.youtube.com/embed/{{ $blog->getYouTubeId() }}?rel=0" 
                                            title="{{ $blog->title }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ $blog->youtube_url }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                            <i class="ti ti-external-link me-1"></i>Ouvrir sur YouTube
                                        </a>
                                        <small class="text-muted">
                                            ID: {{ $blog->getYouTubeId() }}
                                        </small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="ti ti-link me-1"></i>
                                        {{ Str::limit($blog->youtube_url, 50) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Message si aucun média -->
                    @if(!$blog->image && !$blog->youtube_url)
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Aucun média associé à cet article
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Informations principales -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-user me-2"></i>Informations de publication
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Auteur:</strong>
                                    <p class="mb-0 mt-1">
                                        <i class="ti ti-user-circle me-2 text-primary"></i>
                                        {{ $blog->author }}
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Statut:</strong>
                                    <p class="mb-0 mt-1">
                                        <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                                            <i class="ti ti-{{ $blog->status === 'published' ? 'eye' : 'edit' }} me-1"></i>
                                            {{ $blog->status === 'published' ? 'Publié' : 'Brouillon' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <strong>Date de création:</strong>
                                    <p class="mb-0 mt-1">
                                        <i class="ti ti-calendar me-2 text-success"></i>
                                        {{ $blog->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>

                                @if($blog->updated_at != $blog->created_at)
                                <div class="mb-3">
                                    <strong>Dernière modification:</strong>
                                    <p class="mb-0 mt-1">
                                        <i class="ti ti-edit me-2 text-warning"></i>
                                        {{ $blog->updated_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                                @endif

                                @if(isset($blog->views))
                                <div>
                                    <strong>Vues:</strong>
                                    <p class="mb-0 mt-1">
                                        <i class="ti ti-eye me-2 text-info"></i>
                                        {{ $blog->views }} vue(s)
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-file-text me-2"></i>Description
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $blog->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu de l'article -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="ti ti-notes me-2"></i>Contenu de l'article
                        </h6>
                        <small class="text-muted">
                            {{ Str::wordCount($blog->content) }} mots
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-4 rounded">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                </div>

                <!-- Métadonnées techniques -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="ti ti-info-circle me-2"></i>Métadonnées techniques
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="ti ti-id me-2 text-muted"></i>
                                        <strong>ID:</strong> 
                                        <span class="text-muted">{{ $blog->id }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-clock me-2 text-muted"></i>
                                        <strong>Créé il y a:</strong> 
                                        <span class="text-muted">{{ $blog->created_at->diffForHumans() }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-calendar me-2 text-muted"></i>
                                        <strong>Date de création:</strong> 
                                        <span class="text-muted">{{ $blog->created_at->format('d/m/Y H:i:s') }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    @if($blog->updated_at != $blog->created_at)
                                    <li class="mb-2">
                                        <i class="ti ti-refresh me-2 text-muted"></i>
                                        <strong>Modifié il y a:</strong> 
                                        <span class="text-muted">{{ $blog->updated_at->diffForHumans() }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ti ti-edit me-2 text-muted"></i>
                                        <strong>Dernière modification:</strong> 
                                        <span class="text-muted">{{ $blog->updated_at->format('d/m/Y H:i:s') }}</span>
                                    </li>
                                    @endif
                                    <li class="mb-2">
                                        <i class="ti ti-database me-2 text-muted"></i>
                                        <strong>Table:</strong> 
                                        <span class="text-muted">blogs</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i>Retour à la liste
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning">
                                    <i class="ti ti-edit me-1"></i>Modifier l'article
                                </a>
                            </div>
                            <div>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')">
                                        <i class="ti ti-trash me-1"></i>Supprimer l'article
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
    .card-header.bg-light {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e9ecef;
    }
    .bg-light.rounded {
        background-color: #f8f9fa !important;
        border-left: 4px solid #1a365d;
    }
</style>

@endsection