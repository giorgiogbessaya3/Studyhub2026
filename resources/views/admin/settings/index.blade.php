@extends('layouts.admin')

@section('title', 'Paramètres du Site')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Paramètres du Site</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Paramètres</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" href="#v-pills-general" role="tab">
                            <i class="fas fa-cog me-2"></i> Général
                        </a>
                        <a class="nav-link" id="v-pills-contact-tab" data-bs-toggle="pill" href="#v-pills-contact" role="tab">
                            <i class="fas fa-address-book me-2"></i> Contact
                        </a>
                        <a class="nav-link" id="v-pills-social-tab" data-bs-toggle="pill" href="#v-pills-social" role="tab">
                            <i class="fas fa-share-alt me-2"></i> Réseaux Sociaux
                        </a>
                        <a class="nav-link" id="v-pills-seo-tab" data-bs-toggle="pill" href="#v-pills-seo" role="tab">
                            <i class="fas fa-search me-2"></i> SEO
                        </a>
                        <a class="nav-link" id="v-pills-footer-tab" data-bs-toggle="pill" href="#v-pills-footer" role="tab">
                            <i class="fas fa-shoe-prints me-2"></i> Footer
                        </a>
                        <a class="nav-link" id="v-pills-media-tab" data-bs-toggle="pill" href="#v-pills-media" role="tab">
                            <i class="fas fa-image me-2"></i> Médias
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                
                <!-- Onglet Général -->
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cog text-primary me-2"></i>
                                Paramètres Généraux
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.general.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Nom du site <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                                   id="site_name" name="site_name" 
                                                   value="{{ old('site_name', $settings->site_name ?? 'Kounde Avocats') }}" required>
                                            @error('site_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="site_email" class="form-label">Email du site <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('site_email') is-invalid @enderror" 
                                                   id="site_email" name="site_email" 
                                                   value="{{ old('site_email', $settings->site_email ?? '') }}" required>
                                            @error('site_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Description du site</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                              id="site_description" name="site_description" 
                                              rows="3">{{ old('site_description', $settings->site_description ?? '') }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="site_phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('site_phone') is-invalid @enderror" 
                                                   id="site_phone" name="site_phone" 
                                                   value="{{ old('site_phone', $settings->site_phone ?? '') }}" required>
                                            @error('site_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="working_hours" class="form-label">Heures d'ouverture <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('working_hours') is-invalid @enderror" 
                                                   id="working_hours" name="working_hours" 
                                                   value="{{ old('working_hours', $settings->working_hours ?? 'Lun - Sam: 9h - 18h') }}" required>
                                            @error('working_hours')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('site_address') is-invalid @enderror" 
                                              id="site_address" name="site_address" 
                                              rows="2" required>{{ old('site_address', $settings->site_address ?? '') }}</textarea>
                                    @error('site_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Contact -->
                <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-address-book text-primary me-2"></i>
                                Informations de Contact
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_email" class="form-label">Email de contact <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                                   id="contact_email" name="contact_email" 
                                                   value="{{ old('contact_email', $settings->contact_email ?? '') }}" required>
                                            @error('contact_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_phone" class="form-label">Téléphone de contact <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                                   id="contact_phone" name="contact_phone" 
                                                   value="{{ old('contact_phone', $settings->contact_phone ?? '') }}" required>
                                            @error('contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Adresse de contact <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('contact_address') is-invalid @enderror" 
                                              id="contact_address" name="contact_address" 
                                              rows="3" required>{{ old('contact_address', $settings->contact_address ?? '') }}</textarea>
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_map_url" class="form-label">URL Google Maps</label>
                                    <input type="url" class="form-control @error('contact_map_url') is-invalid @enderror" 
                                           id="contact_map_url" name="contact_map_url" 
                                           value="{{ old('contact_map_url', $settings->contact_map_url ?? '') }}">
                                    @error('contact_map_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lien vers votre localisation sur Google Maps</div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Réseaux Sociaux -->
                <div class="tab-pane fade" id="v-pills-social" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-share-alt text-primary me-2"></i>
                                Réseaux Sociaux
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.social.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="facebook_url" class="form-label">
                                                <i class="fab fa-facebook text-primary me-2"></i>Facebook
                                            </label>
                                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                                   id="facebook_url" name="facebook_url" 
                                                   value="{{ old('facebook_url', $settings->facebook_url ?? '') }}">
                                            @error('facebook_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="twitter_url" class="form-label">
                                                <i class="fab fa-twitter text-info me-2"></i>Twitter
                                            </label>
                                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                                   id="twitter_url" name="twitter_url" 
                                                   value="{{ old('twitter_url', $settings->twitter_url ?? '') }}">
                                            @error('twitter_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="instagram_url" class="form-label">
                                                <i class="fab fa-instagram text-danger me-2"></i>Instagram
                                            </label>
                                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                                   id="instagram_url" name="instagram_url" 
                                                   value="{{ old('instagram_url', $settings->instagram_url ?? '') }}">
                                            @error('instagram_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="linkedin_url" class="form-label">
                                                <i class="fab fa-linkedin text-primary me-2"></i>LinkedIn
                                            </label>
                                            <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                                   id="linkedin_url" name="linkedin_url" 
                                                   value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}">
                                            @error('linkedin_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">
                                        <i class="fab fa-youtube text-danger me-2"></i>YouTube
                                    </label>
                                    <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                           id="youtube_url" name="youtube_url" 
                                           value="{{ old('youtube_url', $settings->youtube_url ?? '') }}">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet SEO -->
                <div class="tab-pane fade" id="v-pills-seo" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-search text-primary me-2"></i>
                                Paramètres SEO
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.seo.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           id="meta_title" name="meta_title" 
                                           value="{{ old('meta_title', $settings->meta_title ?? '') }}"
                                           placeholder="Titre pour les moteurs de recherche (50-60 caractères)">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="meta_title_count">0</span>/60 caractères
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" name="meta_description" 
                                              rows="3"
                                              placeholder="Description pour les moteurs de recherche (150-160 caractères)">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="meta_description_count">0</span>/160 caractères
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <textarea class="form-control @error('meta_keywords') is-invalid @enderror" 
                                              id="meta_keywords" name="meta_keywords" 
                                              rows="2"
                                              placeholder="Mots-clés séparés par des virgules">{{ old('meta_keywords', $settings->meta_keywords ?? '') }}</textarea>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>

                                <div class="mb-3">
                                    <label for="google_analytics" class="form-label">Google Analytics</label>
                                    <textarea class="form-control @error('google_analytics') is-invalid @enderror" 
                                              id="google_analytics" name="google_analytics" 
                                              rows="4"
                                              placeholder="Code de suivi Google Analytics">{{ old('google_analytics', $settings->google_analytics ?? '') }}</textarea>
                                    @error('google_analytics')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Footer -->
                <div class="tab-pane fade" id="v-pills-footer" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shoe-prints text-primary me-2"></i>
                                Paramètres du Footer
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.footer.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="footer_description" class="form-label">Description du Footer</label>
                                    <textarea class="form-control @error('footer_description') is-invalid @enderror" 
                                              id="footer_description" name="footer_description" 
                                              rows="3">{{ old('footer_description', $settings->footer_description ?? '') }}</textarea>
                                    @error('footer_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="footer_copyright" class="form-label">Texte de Copyright <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('footer_copyright') is-invalid @enderror" 
                                           id="footer_copyright" name="footer_copyright" 
                                           value="{{ old('footer_copyright', $settings->footer_copyright ?? '© 2025 Kounde Avocats - Tous droits réservés') }}" required>
                                    @error('footer_copyright')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="newsletter_enabled" 
                                               name="newsletter_enabled" value="1" 
                                               {{ old('newsletter_enabled', $settings->newsletter_enabled ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newsletter_enabled">
                                            Activer la newsletter dans le footer
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Médias -->
                <div class="tab-pane fade" id="v-pills-media" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image text-primary me-2"></i>
                                Gestion des Médias
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="mb-4">
                                <h6 class="mb-3">Logo du site</h6>
                                <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            @if($settings->site_logo ?? false)
                                                <div class="mb-3">
                                                    <img src="{{ Storage::url($settings->site_logo) }}" 
                                                         alt="Logo actuel" 
                                                         class="img-fluid rounded border" 
                                                         style="max-height: 150px;">
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <small>Aucun logo défini</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="site_logo" class="form-label">Nouveau logo</label>
                                                <input type="file" class="form-control @error('site_logo') is-invalid @enderror" 
                                                       id="site_logo" name="site_logo" 
                                                       accept="image/jpeg,image/png,image/gif,image/svg+xml">
                                                @error('site_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    Formats acceptés: JPG, PNG, GIF, SVG. Taille max: 2MB
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload me-1"></i> Uploader le logo
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Favicon -->
                            <div class="mb-4">
                                <h6 class="mb-3">Favicon</h6>
                                <form action="{{ route('admin.settings.favicon.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            @if($settings->site_favicon ?? false)
                                                <div class="mb-3">
                                                    <img src="{{ Storage::url($settings->site_favicon) }}" 
                                                         alt="Favicon actuel" 
                                                         class="img-fluid rounded border" 
                                                         style="max-height: 64px;">
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <small>Aucun favicon défini</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="site_favicon" class="form-label">Nouveau favicon</label>
                                                <input type="file" class="form-control @error('site_favicon') is-invalid @enderror" 
                                                       id="site_favicon" name="site_favicon" 
                                                       accept=".ico,image/png">
                                                @error('site_favicon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    Formats acceptés: ICO, PNG. Taille recommandée: 32x32 ou 16x16 pixels
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload me-1"></i> Uploader le favicon
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour le SEO
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta_title_count');
    const metaDescription = document.getElementById('meta_description');
    const metaDescriptionCount = document.getElementById('meta_description_count');

    function updateCount(element, counter) {
        const length = element.value.length;
        counter.textContent = length;
        
        if (length > 60 && element === metaTitle) {
            counter.classList.add('text-danger');
        } else if (length > 160 && element === metaDescription) {
            counter.classList.add('text-danger');
        } else {
            counter.classList.remove('text-danger');
        }
    }

    if (metaTitle && metaTitleCount) {
        metaTitle.addEventListener('input', () => updateCount(metaTitle, metaTitleCount));
        updateCount(metaTitle, metaTitleCount);
    }

    if (metaDescription && metaDescriptionCount) {
        metaDescription.addEventListener('input', () => updateCount(metaDescription, metaDescriptionCount));
        updateCount(metaDescription, metaDescriptionCount);
    }

    // Prévisualisation des images
    const logoInput = document.getElementById('site_logo');
    const faviconInput = document.getElementById('site_favicon');

    function previewImage(input, previewSelector) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector(previewSelector);
                if (preview) {
                    preview.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    if (logoInput) {
        logoInput.addEventListener('change', function() {
            previewImage(this, '.logo-preview');
        });
    }

    if (faviconInput) {
        faviconInput.addEventListener('change', function() {
            previewImage(this, '.favicon-preview');
        });
    }
});
</script>
@endpush