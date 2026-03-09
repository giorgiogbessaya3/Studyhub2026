@extends('layouts.app')

@section('title', $chapitre->titre . ' - StudyHub')

@section('head')
<!-- MathJax pour les formules mathématiques -->
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
<style>
    .math-inline { display: inline-block; }
    .prose { max-width: none; }
    .prose img { margin: 0 auto; }
    .hidden { display: none; }
    .scroll-mt-24 { scroll-margin-top: 6rem; }
</style>
@endsection

@section('content')
<!-- Hero Section avec la couleur de la matière -->
@php
    $matiereCouleur = $chapitre->matiere->couleur ?? '#3b82f6';
    $matiereIcone = $chapitre->matiere->icone ?? 'fas fa-book';
@endphp

<section class="relative py-16 overflow-hidden" 
         style="background: linear-gradient(135deg, {{ $matiereCouleur }} 0%, {{ $matiereCouleur }}dd 100%);">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10" aria-hidden="true">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Fil d'Ariane -->
        <nav class="mb-8 text-sm text-white/80" aria-label="Fil d'Ariane">
            <ol class="flex items-center flex-wrap gap-2">
                <li><a href="/" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-xs" aria-hidden="true"></i> Accueil
                </a></li>
                <li><span class="mx-1" aria-hidden="true">/</span></li>
                <li><a href="/cours" class="hover:text-white transition-colors">Cours</a></li>
                <li><span class="mx-1" aria-hidden="true">/</span></li>
                <li><a href="/cours/classe/{{ $chapitre->classe->nom }}" class="hover:text-white transition-colors">{{ $chapitre->classe->nom }}</a></li>
                <li><span class="mx-1" aria-hidden="true">/</span></li>
                <li><a href="/cours/classe/{{ $chapitre->classe->nom }}/matiere/{{ $chapitre->matiere->nom }}" class="hover:text-white transition-colors">{{ $chapitre->matiere->nom }}</a></li>
                <li><span class="mx-1" aria-hidden="true">/</span></li>
                <li class="text-white font-medium truncate max-w-xs" aria-current="page">{{ $chapitre->titre }}</li>
            </ol>
        </nav>
        
        <!-- En-tête du chapitre -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur rounded-full px-4 py-2 mb-6">
                    <i class="{{ $matiereIcone }} text-sm" aria-hidden="true"></i>
                    <span class="text-sm font-medium">{{ $chapitre->matiere->nom }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">{{ $chapitre->titre }}</h1>
                
                @if($chapitre->description)
                    <p class="text-lg text-white/90 max-w-2xl leading-relaxed">
                        {{ $chapitre->description }}
                    </p>
                @endif
                
                <!-- Métadonnées -->
                <div class="flex flex-wrap gap-4 mt-6 justify-center md:justify-start">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-2">
                        <i class="fas fa-layer-group text-white/80" aria-hidden="true"></i>
                        <span class="text-white">{{ $chapitre->contenus->count() }} contenus</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-2">
                        <i class="fas fa-clock text-white/80" aria-hidden="true"></i>
                        <span class="text-white">{{ $chapitre->contenus->count() * 15 }} min de lecture</span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation cards -->
            <div class="flex gap-4">
                @if(isset($chapitrePrecedent) && $chapitrePrecedent)
                <a href="/cours/chapitre/{{ $chapitrePrecedent->slug }}" 
                   class="bg-white/10 backdrop-blur hover:bg-white/20 rounded-2xl p-5 text-white transition-all group w-40">
                    <i class="fas fa-arrow-left text-sm mb-2 opacity-60" aria-hidden="true"></i>
                    <p class="text-xs opacity-60 mb-1">Précédent</p>
                    <p class="font-medium truncate">{{ $chapitrePrecedent->titre }}</p>
                </a>
                @endif
                
                @if(isset($chapitreSuivant) && $chapitreSuivant)
                <a href="/cours/chapitre/{{ $chapitreSuivant->slug }}" 
                   class="bg-white/10 backdrop-blur hover:bg-white/20 rounded-2xl p-5 text-white transition-all group w-40 text-right">
                    <i class="fas fa-arrow-right text-sm mb-2 opacity-60" aria-hidden="true"></i>
                    <p class="text-xs opacity-60 mb-1">Suivant</p>
                    <p class="font-medium truncate">{{ $chapitreSuivant->titre }}</p>
                </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0" aria-hidden="true">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
            <path d="M0 120L60 112.5C120 105 240 90 360 82.5C480 75 600 75 720 78.75C840 82.5 960 90 1080 93.75C1200 97.5 1320 97.5 1380 97.5L1440 97.5V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.2"/>
        </svg>
    </div>
</section>

<!-- Contenu principal -->
<main class="container mx-auto px-4 py-12">
    
    @if($chapitre->contenus->isEmpty())
        <div class="text-center py-20 bg-gray-50 rounded-3xl">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-hourglass-half text-gray-400 text-4xl" aria-hidden="true"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Aucun contenu disponible</h2>
            <p class="text-gray-500 max-w-md mx-auto">
                Les contenus de ce chapitre sont en cours de préparation. Revenez bientôt !
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-3 space-y-8">
                @foreach($chapitre->contenus as $index => $contenu)
                    <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all scroll-mt-24" 
                             id="contenu-{{ $contenu->id }}">
                        
                        <!-- En-tête du contenu -->
                        <header class="px-8 py-5 border-b border-gray-100 flex items-center gap-4 flex-wrap"
                                style="background: linear-gradient(to right, {{ $matiereCouleur }}10, transparent);">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white flex-shrink-0"
                                 style="background: linear-gradient(135deg, {{ $matiereCouleur }} 0%, {{ $matiereCouleur }}dd 100%);">
                                {{ $index + 1 }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 flex-1">
                                {{ $contenu->titre }}
                            </h3>
                            @if($contenu->exercices)
                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1.5 rounded-full flex items-center gap-1">
                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                Exercices inclus
                            </span>
                            @endif
                        </header>
                        
                        <div class="p-8">
                            <!-- Résumé du contenu -->
                            @if($contenu->resume)
                                <section class="mb-8">
                                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <i class="fas fa-align-left" style="color: {{ $matiereCouleur }};" aria-hidden="true"></i>
                                        Résumé
                                    </h4>
                                    <div class="bg-gray-50 rounded-xl p-6 text-gray-700 leading-relaxed border-l-4 prose prose-lg max-w-none" 
                                         style="border-left-color: {{ $matiereCouleur }};">
                                        {!! $contenu->resume !!}
                                    </div>
                                </section>
                            @endif
                            
                            <!-- Images du contenu -->
                            @if($contenu->images && count($contenu->images) > 0)
                                <section class="mb-8">
                                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <i class="fas fa-images" style="color: {{ $matiereCouleur }};" aria-hidden="true"></i>
                                        Illustrations
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($contenu->images as $image)
                                            <figure class="group relative rounded-xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition-all"
                                                    onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500" 
                                                     alt="Illustration du cours"
                                                     loading="lazy">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <i class="fas fa-search-plus text-white text-2xl" aria-hidden="true"></i>
                                                </div>
                                            </figure>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                            
                            <!-- Exercices -->
                            @if($contenu->exercices && count($contenu->exercices) > 0)
                                <section class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <i class="fas fa-puzzle-piece" style="color: {{ $matiereCouleur }};" aria-hidden="true"></i>
                                        Exercices
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($contenu->exercices as $exIndex => $exercice)
                                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white hover:shadow-md transition-shadow">
                                                <div class="px-6 py-4 flex justify-between items-center cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors" 
                                                     onclick="toggleExercice({{ $contenu->id }}, {{ $exIndex }})">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                                              style="background-color: {{ $matiereCouleur }};">
                                                            {{ $exIndex + 1 }}
                                                        </span>
                                                        <span class="font-medium text-gray-700">Exercice {{ $exIndex + 1 }}</span>
                                                    </div>
                                                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" 
                                                       id="exercice-chevron-{{ $contenu->id }}-{{ $exIndex }}"
                                                       aria-hidden="true"></i>
                                                </div>
                                                <div class="hidden p-6 border-t border-gray-200 bg-white" 
                                                     id="exercice-{{ $contenu->id }}-{{ $exIndex }}">
                                                    <div class="mb-4">
                                                        <p class="text-sm font-medium text-gray-700 mb-2">Question :</p>
                                                        <div class="bg-gray-50 p-4 rounded-lg text-gray-700 prose prose-sm max-w-none">
                                                            {!! $exercice['question'] ?? '' !!}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700 mb-2">Réponse :</p>
                                                        <div class="bg-green-50 p-4 rounded-lg text-gray-700 border-l-4 border-green-500 prose prose-sm max-w-none">
                                                            {!! $exercice['reponse'] ?? '' !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 sticky top-24 overflow-hidden">
                    <!-- En-tête -->
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3"
                         style="background: linear-gradient(to right, {{ $matiereCouleur }}10, transparent);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white"
                             style="background-color: {{ $matiereCouleur }};">
                            <i class="fas fa-list-ul text-sm" aria-hidden="true"></i>
                        </div>
                        <h5 class="font-bold text-gray-800">Contenus du chapitre</h5>
                    </div>
                    
                    <!-- Liste des contenus -->
                    <nav class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                        @foreach($chapitre->contenus as $index => $contenu)
                            <a href="#contenu-{{ $contenu->id }}" 
                               class="flex items-start gap-3 px-5 py-4 hover:bg-gray-50 transition-colors group">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                      style="background-color: {{ $matiereCouleur }};">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900 truncate">
                                        {{ $contenu->titre }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        @if($contenu->exercices)
                                            <i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i> Exercices
                                        @endif
                                        @if($contenu->images)
                                            @if($contenu->exercices) · @endif
                                            <i class="fas fa-image mr-1" aria-hidden="true"></i> {{ count($contenu->images) }} image(s)
                                        @endif
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-300 group-hover:text-gray-500 transition-colors mt-1" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </nav>
                </div>
                
                <!-- Ressources supplémentaires -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mt-6">
                    <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-link" style="color: {{ $matiereCouleur }};" aria-hidden="true"></i>
                        Ressources liées
                    </h5>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary-600 transition-colors"
                               onclick="alert('Fonctionnalité à venir')">
                                <i class="fas fa-file-pdf text-red-500" aria-hidden="true"></i>
                                Fiche de révision PDF
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary-600 transition-colors"
                               onclick="alert('Fonctionnalité à venir')">
                                <i class="fas fa-video text-blue-500" aria-hidden="true"></i>
                                Vidéo explicative
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary-600 transition-colors"
                               onclick="alert('Fonctionnalité à venir')">
                                <i class="fas fa-question-circle text-green-500" aria-hidden="true"></i>
                                Quiz d'évaluation
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        
        <!-- Navigation entre chapitres (bas de page) -->
        <nav class="flex justify-between items-center mt-12 pt-6 border-t border-gray-200">
            @if(isset($chapitrePrecedent) && $chapitrePrecedent)
            <a href="/cours/chapitre/{{ $chapitrePrecedent->slug }}" 
               class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left text-gray-600" aria-hidden="true"></i>
                </div>
                <div class="hidden sm:block">
                    <p class="text-xs text-gray-400 mb-1">Chapitre précédent</p>
                    <p class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors">{{ $chapitrePrecedent->titre }}</p>
                </div>
            </a>
            @else
            <div></div>
            @endif
            
            <a href="/cours/classe/{{ $chapitre->classe->nom }}/matiere/{{ $chapitre->matiere->nom }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-th-large" aria-hidden="true"></i>
                Retour à la liste
            </a>
            
            @if(isset($chapitreSuivant) && $chapitreSuivant)
            <a href="/cours/chapitre/{{ $chapitreSuivant->slug }}" 
               class="flex items-center gap-3 group text-right">
                <div class="hidden sm:block">
                    <p class="text-xs text-gray-400 mb-1">Chapitre suivant</p>
                    <p class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors">{{ $chapitreSuivant->titre }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-right text-gray-600" aria-hidden="true"></i>
                </div>
            </a>
            @else
            <div></div>
            @endif
        </nav>
    @endif
</main>

<!-- Modal pour les images -->
<div id="imageModal" 
     class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center backdrop-blur-sm" 
     onclick="closeImageModal()">
    
    <button class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white text-xl flex items-center justify-center transition-all"
            onclick="closeImageModal()">
        <i class="fas fa-times" aria-hidden="true"></i>
    </button>
    
    <button class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all"
            onclick="prevImage()">
        <i class="fas fa-chevron-left" aria-hidden="true"></i>
    </button>
    
    <img id="modalImage" src="" alt="Image agrandie" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl">
    
    <button class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all"
            onclick="nextImage()">
        <i class="fas fa-chevron-right" aria-hidden="true"></i>
    </button>
    
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-white/20 backdrop-blur px-4 py-2 rounded-full text-white text-sm">
        Image <span id="currentImageIndex">1</span>/<span id="totalImages">1</span>
    </div>
</div>

<script>
// Variables pour la navigation des images
let currentImages = [];
let currentImageIndex = 0;

// Smooth scroll pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Fonction pour ouvrir l'image en grand
function openImageModal(imageUrl, images = null) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (images) {
        currentImages = images;
        currentImageIndex = images.indexOf(imageUrl);
        updateImageModal();
    } else {
        modalImage.src = imageUrl;
        document.getElementById('currentImageIndex').textContent = '1';
        document.getElementById('totalImages').textContent = '1';
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

// Mettre à jour l'image dans le modal
function updateImageModal() {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = currentImages[currentImageIndex];
    document.getElementById('currentImageIndex').textContent = currentImageIndex + 1;
    document.getElementById('totalImages').textContent = currentImages.length;
}

// Image précédente
function prevImage() {
    if (currentImages.length > 0) {
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        updateImageModal();
    }
}

// Image suivante
function nextImage() {
    if (currentImages.length > 0) {
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        updateImageModal();
    }
}

// Fonction pour fermer le modal
function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Fonction pour basculer l'affichage des exercices
function toggleExercice(contenuId, exIndex) {
    const exercice = document.getElementById(`exercice-${contenuId}-${exIndex}`);
    const chevron = document.getElementById(`exercice-chevron-${contenuId}-${exIndex}`);
    
    exercice.classList.toggle('hidden');
    
    if (exercice.classList.contains('hidden')) {
        chevron.style.transform = 'rotate(0deg)';
    } else {
        chevron.style.transform = 'rotate(180deg)';
    }
}

// Fermer le modal avec la touche Echap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    } else if (e.key === 'ArrowLeft') {
        prevImage();
    } else if (e.key === 'ArrowRight') {
        nextImage();
    }
});

// Initialiser les images pour la navigation
document.addEventListener('DOMContentLoaded', function() {
    @foreach($chapitre->contenus as $contenu)
        @if($contenu->images && count($contenu->images) > 0)
            const images{{ $contenu->id }} = [
                @foreach($contenu->images as $image)
                    '{{ asset('storage/' . $image) }}',
                @endforeach
            ];
            
            document.querySelectorAll('#contenu-{{ $contenu->id }} img').forEach((img, index) => {
                img.parentElement.addEventListener('click', () => openImageModal(images{{ $contenu->id }}[index], images{{ $contenu->id }}));
            });
        @endif
    @endforeach
    
    // Initialiser MathJax
    if (window.MathJax) {
        MathJax.typesetPromise();
    }
});
</script>

<style>
.hidden {
    display: none;
}
.scroll-mt-24 {
    scroll-margin-top: 6rem;
}
.prose {
    max-width: none;
}
.prose img {
    margin: 1rem auto;
    max-width: 100%;
    height: auto;
}
</style>
@endsection