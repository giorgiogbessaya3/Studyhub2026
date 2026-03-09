@extends('layouts.admin')

@section('title', 'Nouvel Article - Blog')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Créer un nouvel article</h4>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-2"></i>Retour
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre de l'article *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" 
                                       placeholder="Entrez le titre de l'article" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Brève description de l'article" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenu de l'article *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="12" 
                                          placeholder="Contenu détaillé de l'article" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Paramètres</h5>
                                    
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Auteur *</label>
                                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                               id="author" name="author" value="{{ old('author') }}" 
                                               placeholder="Nom de l'auteur" required>
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Statut *</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image principale</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        <div class="form-text">Formats acceptés: JPEG, PNG, JPG, GIF. Max: 2MB</div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="youtube_url" class="form-label">URL YouTube</label>
                                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                               id="youtube_url" name="youtube_url" 
                                               value="{{ old('youtube_url') }}"
                                               placeholder="https://www.youtube.com/watch?v=...">
                                        <div class="form-text">Lien optionnel vers une vidéo YouTube</div>
                                        @error('youtube_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-konde">
                                <i class="ti ti-check me-2"></i>Créer l'article
                            </button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prévisualisation de l'image
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Vous pouvez ajouter une prévisualisation ici si besoin
                    console.log('Image sélectionnée:', file.name);
                }
            });
        }
    });
</script>
@endpush