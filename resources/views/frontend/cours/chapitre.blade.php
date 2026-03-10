@extends('layouts.app')

@section('title', $chapitre->titre . ' - StudyHub')

@section('head')
<!-- MathJax pour les formules mathématiques -->
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
<style>
    /* Reset et base */
    .math-inline { display: inline-block; }
    .prose { max-width: none; }
    .prose img { margin: 0 auto; }
    .hidden { display: none; }
    .scroll-mt-24 { scroll-margin-top: 6rem; }
    
    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    /* Glass effect */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        h1 {
            font-size: 1.5rem !important;
            line-height: 1.3 !important;
        }
        
        .text-lg {
            font-size: 0.95rem !important;
        }
        
        .gap-8 {
            gap: 1rem !important;
        }
        
        .p-5 {
            padding: 1rem !important;
        }
        
        .p-8 {
            padding: 1.25rem !important;
        }
        
        .px-4 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
    
    /* Animation au scroll */
    [data-aos] {
        opacity: 0;
        transition-property: opacity, transform;
        transition-duration: 0.6s;
        transition-timing-function: ease-out;
    }
    
    [data-aos].aos-animate {
        opacity: 1;
    }
    
    [data-aos="fade-up"] {
        transform: translateY(20px);
    }
    
    [data-aos="fade-up"].aos-animate {
        transform: translateY(0);
    }
    
    /* Bouton shine */
    .btn-shine {
        position: relative;
        overflow: hidden;
    }
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }
    .btn-shine:hover::after {
        left: 100%;
    }
</style>
@endsection

@section('content')
@php
    $matiereCouleur = $chapitre->matiere->couleur ?? '#3b82f6';
    $matiereIcone = $chapitre->matiere->icone ?? 'fas fa-book';
    $classeNom = $chapitre->classe->nom ?? '';
@endphp

<!-- Hero Section compacte et responsive -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[250px] sm:min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 30px 30px sm:40px 40px;">
    </div>
    
    <!-- Blobs décoratifs (masqués sur mobile) -->
    <div class="hidden sm:block absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="hidden sm:block absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10 py-4 sm:py-5">
        <!-- Fil d'Ariane compact -->
        <nav class="mb-3 sm:mb-4 text-xs sm:text-sm text-white/80 overflow-x-auto whitespace-nowrap pb-1 hide-scrollbar" data-aos="fade-down">
            <ol class="flex items-center">
                <li><a href="/" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-[10px] sm:text-xs"></i>
                    <span class="hidden sm:inline">Accueil</span>
                </a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/cours" class="hover:text-white transition-colors whitespace-nowrap">Cours</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/cours/classe/{{ $chapitre->classe->nom }}" class="hover:text-white transition-colors whitespace-nowrap">{{ $chapitre->classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/cours/classe/{{ $chapitre->classe->nom }}/matiere/{{ $chapitre->matiere->nom }}" class="hover:text-white transition-colors whitespace-nowrap">{{ $chapitre->matiere->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium truncate max-w-[100px] sm:max-w-xs">{{ $chapitre->titre }}</li>
            </ol>
        </nav>
        
        <!-- En-tête compact -->
        <div class="flex flex-col gap-3 sm:gap-4" data-aos="fade-right">
            <!-- Badge matière -->
            <span class="inline-flex self-start bg-white/10 backdrop-blur-sm text-white/90 text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full">
                <i class="{{ $matiereIcone }} mr-2 text-xs sm:text-sm"></i>
                {{ $chapitre->matiere->nom }}
            </span>
            
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight">
                {{ $chapitre->titre }}
            </h1>
            
            @if($chapitre->description)
                <p class="text-white/80 text-sm sm:text-base max-w-2xl line-clamp-2 sm:line-clamp-none">
                    {{ $chapitre->description }}
                </p>
            @endif
            
            <!-- Métadonnées compactes -->
            <div class="flex flex-wrap gap-2 sm:gap-3 mt-1 sm:mt-2">
                <span class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 sm:px-4 sm:py-1.5">
                    <i class="fas fa-layer-group text-white/80 text-xs"></i>
                    <span class="text-white text-xs sm:text-sm">{{ $chapitre->contenus->count() }} contenus</span>
                </span>
                <span class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 sm:px-4 sm:py-1.5">
                    <i class="fas fa-clock text-white/80 text-xs"></i>
                    <span class="text-white text-xs sm:text-sm">{{ $chapitre->contenus->count() * 10 }} min</span>
                </span>
                @if($chapitre->contenus->sum(function($c) { return count($c->exercices ?? []); }) > 0)
                <span class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 sm:px-4 sm:py-1.5">
                    <i class="fas fa-pencil-alt text-white/80 text-xs"></i>
                    <span class="text-white text-xs sm:text-sm">{{ $chapitre->contenus->sum(function($c) { return count($c->exercices ?? []); }) }} ex</span>
                </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Wave Separator simplifié -->
    <div class="absolute bottom-0 left-0 right-0 h-6 sm:h-12 overflow-hidden">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
        </svg>
    </div>
</section>

<!-- Contenu principal -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-5">
    
    @if($chapitre->contenus->isEmpty())
        <div class="text-center py-12 sm:py-16 bg-gray-50 rounded-2xl sm:rounded-3xl" data-aos="fade-up">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 rounded-2xl sm:rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-hourglass-half text-2xl sm:text-3xl text-primary-600"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Aucun contenu disponible</h3>
            <p class="text-sm sm:text-base text-gray-500 max-w-md mx-auto px-4">
                Les contenus de ce chapitre sont en cours de préparation. Revenez bientôt !
            </p>
            <a href="/cours/classe/{{ $chapitre->classe->nom }}/matiere/{{ $chapitre->matiere->nom }}" 
               class="inline-flex items-center gap-2 text-primary-600 text-sm sm:text-base font-medium mt-4 hover:underline">
                <i class="fas fa-arrow-left"></i>
                Retour à la matière
            </a>
        </div>
    @else
        <!-- Layout responsive : stack sur mobile, grid sur desktop -->
        <div class="flex flex-col lg:grid lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Contenu principal (passe en premier sur mobile) -->
            <div class="lg:col-span-3 space-y-3 sm:space-y-4 order-1">
                @foreach($chapitre->contenus as $index => $contenu)
                    <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all scroll-mt-24" 
                             id="contenu-{{ $contenu->id }}"
                             data-aos="fade-up"
                             data-aos-delay="{{ $index * 50 }}">
                        
                        <!-- En-tête compact -->
                        <div class="relative h-12 sm:h-14 overflow-hidden" 
                             style="background: linear-gradient(135deg, {{ $matiereCouleur }} 0%, {{ $matiereCouleur }}dd 100%);">
                            
                            <div class="absolute inset-0 opacity-10" 
                                 style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                            </div>
                            
                            <div class="absolute bottom-2 left-3 sm:bottom-3 sm:left-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div class="w-6 h-6 sm:w-7 sm:h-7 bg-white/30 backdrop-blur rounded-lg flex items-center justify-center font-bold text-white text-xs sm:text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <h3 class="font-bold text-white text-sm sm:text-base line-clamp-1">{{ $contenu->titre }}</h3>
                                </div>
                            </div>
                            
                            @if($contenu->exercices && count($contenu->exercices) > 0)
                            <div class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-white/30 backdrop-blur-sm text-white px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] sm:text-xs font-medium flex items-center gap-1">
                                <i class="fas fa-pencil-alt text-[8px] sm:text-xs"></i>
                                <span class="hidden xs:inline">{{ count($contenu->exercices) }} ex</span>
                                <span class="xs:hidden">{{ count($contenu->exercices) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-3 sm:p-4 md:p-5">
                            <!-- Résumé -->
                            @if($contenu->resume)
                                <section class="mb-3 sm:mb-4">
                                    <div class="bg-gray-50 rounded-lg sm:rounded-xl p-3 sm:p-4 text-gray-700 text-xs sm:text-sm leading-relaxed border-l-3 sm:border-l-4 prose prose-xs sm:prose-sm max-w-none" 
                                         style="border-left-color: {{ $matiereCouleur }};">
                                        {!! $contenu->resume !!}
                                    </div>
                                </section>
                            @endif
                            
                            <!-- Images (stack sur mobile, grid sur desktop) -->
                            @if($contenu->images && count($contenu->images) > 0)
                                <section class="mb-3 sm:mb-4">
                                    <h4 class="text-xs sm:text-sm font-semibold text-gray-500 mb-2 sm:mb-3 flex items-center gap-1.5 sm:gap-2">
                                        <i class="fas fa-images text-sm" style="color: {{ $matiereCouleur }};"></i>
                                        <span>Illustrations</span>
                                    </h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-2 sm:gap-3">
                                        @foreach($contenu->images as $image)
                                            <figure class="group relative rounded-lg sm:rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all aspect-video"
                                                    onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                                     alt="Illustration"
                                                     loading="lazy">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <i class="fas fa-search-plus text-white text-lg sm:text-xl"></i>
                                                </div>
                                            </figure>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                            
                            <!-- Exercices -->
                            @if($contenu->exercices && count($contenu->exercices) > 0)
                                <section>
                                    <h4 class="text-xs sm:text-sm font-semibold text-gray-500 mb-2 sm:mb-3 flex items-center gap-1.5 sm:gap-2">
                                        <i class="fas fa-puzzle-piece text-sm" style="color: {{ $matiereCouleur }};"></i>
                                        <span>Exercices corrigés</span>
                                    </h4>
                                    <div class="space-y-2 sm:space-y-3">
                                        @foreach($contenu->exercices as $exIndex => $exercice)
                                            <div class="border border-gray-200 rounded-lg sm:rounded-xl overflow-hidden bg-white hover:shadow-sm transition-shadow">
                                                <div class="px-3 sm:px-4 py-2 sm:py-3 flex justify-between items-center cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors" 
                                                     onclick="toggleExercice({{ $contenu->id }}, {{ $exIndex }})">
                                                    <div class="flex items-center gap-2 sm:gap-3">
                                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-[10px] sm:text-xs font-bold text-white"
                                                              style="background-color: {{ $matiereCouleur }};">
                                                            {{ $exIndex + 1 }}
                                                        </span>
                                                        <span class="text-xs sm:text-sm font-medium text-gray-700">Exercice {{ $exIndex + 1 }}</span>
                                                    </div>
                                                    <i class="fas fa-chevron-down text-gray-400 text-xs sm:text-sm transition-transform duration-300" 
                                                       id="exercice-chevron-{{ $contenu->id }}-{{ $exIndex }}"></i>
                                                </div>
                                                <div class="hidden p-3 sm:p-4 border-t border-gray-200 bg-white" 
                                                     id="exercice-{{ $contenu->id }}-{{ $exIndex }}">
                                                    <div class="mb-3 sm:mb-4">
                                                        <p class="text-[11px] sm:text-xs font-medium text-gray-700 mb-1 sm:mb-2 flex items-center gap-1 sm:gap-2">
                                                            <i class="fas fa-question-circle text-primary-500 text-xs"></i>
                                                            Question :
                                                        </p>
                                                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg text-gray-700 text-xs sm:text-sm prose prose-xs max-w-none">
                                                            {!! $exercice['question'] ?? '' !!}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="text-[11px] sm:text-xs font-medium text-gray-700 mb-1 sm:mb-2 flex items-center gap-1 sm:gap-2">
                                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                                            Correction :
                                                        </p>
                                                        <div class="bg-green-50 p-3 sm:p-4 rounded-lg text-gray-700 text-xs sm:text-sm border-l-3 sm:border-l-4 border-green-500 prose prose-xs max-w-none">
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
            
            <!-- Sidebar (passe en second sur mobile) -->
            <aside class="lg:col-span-1 space-y-3 sm:space-y-4 order-2 mt-4 lg:mt-0">
                <!-- Table des matières compacte -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 sticky top-20 sm:top-24 overflow-hidden" data-aos="fade-left">
                    <div class="relative h-10 sm:h-12 overflow-hidden" style="background: linear-gradient(135deg, {{ $matiereCouleur }} 0%, {{ $matiereCouleur }}dd 100%);">
                        <div class="absolute inset-0 opacity-10" 
                             style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                        </div>
                        <div class="absolute bottom-1.5 left-3 sm:bottom-2 sm:left-4">
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <i class="fas fa-list-ul text-white text-xs sm:text-sm"></i>
                                <h5 class="font-medium text-white text-xs sm:text-sm">Contenus</h5>
                            </div>
                        </div>
                    </div>
                    
                    <nav class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                        @foreach($chapitre->contenus as $index => $contenu)
                            <a href="#contenu-{{ $contenu->id }}" 
                               class="flex items-start gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-3 hover:bg-gray-50 transition-colors group">
                                <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-[10px] sm:text-xs font-bold text-white flex-shrink-0"
                                      style="background-color: {{ $matiereCouleur }};">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-gray-900 truncate">
                                        {{ $contenu->titre }}
                                    </p>
                                    <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">
                                        @if($contenu->exercices)
                                            <i class="fas fa-pencil-alt mr-0.5"></i>{{ count($contenu->exercices) }} ex
                                        @endif
                                        @if($contenu->images)
                                            @if($contenu->exercices) · @endif
                                            <i class="fas fa-image mr-0.5"></i>{{ count($contenu->images) }} img
                                        @endif
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] sm:text-xs text-gray-300 group-hover:text-gray-500 transition-colors mt-1"></i>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>
        </div>
        
        <!-- Navigation entre chapitres compacte -->
        <nav class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
            @if(isset($chapitrePrecedent) && $chapitrePrecedent)
            <a href="/cours/chapitre/{{ $chapitrePrecedent->slug }}" 
               class="flex items-center gap-2 sm:gap-3 group w-full sm:w-auto">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors flex-shrink-0">
                    <i class="fas fa-arrow-left text-gray-600 text-xs sm:text-sm"></i>
                </div>
                <div class="flex-1 sm:flex-none">
                    <p class="text-[10px] sm:text-xs text-gray-400 mb-0.5">Précédent</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors line-clamp-1">{{ $chapitrePrecedent->titre }}</p>
                </div>
            </a>
            @else
            <div class="hidden sm:block"></div>
            @endif
            
            <a href="/cours/classe/{{ $chapitre->classe->nom }}/matiere/{{ $chapitre->matiere->nom }}" 
               class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-100 rounded-full text-xs sm:text-sm font-medium hover:bg-gray-200 transition-colors whitespace-nowrap">
                <i class="fas fa-th-large text-xs"></i>
                <span>Retour</span>
            </a>
            
            @if(isset($chapitreSuivant) && $chapitreSuivant)
            <a href="/cours/chapitre/{{ $chapitreSuivant->slug }}" 
               class="flex items-center gap-2 sm:gap-3 group text-right w-full sm:w-auto justify-end">
                <div class="flex-1 sm:flex-none order-2 sm:order-1">
                    <p class="text-[10px] sm:text-xs text-gray-400 mb-0.5">Suivant</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors line-clamp-1">{{ $chapitreSuivant->titre }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors flex-shrink-0 order-1 sm:order-2">
                    <i class="fas fa-arrow-right text-gray-600 text-xs sm:text-sm"></i>
                </div>
            </a>
            @else
            <div class="hidden sm:block"></div>
            @endif
        </nav>
    @endif
</main>

<!-- Modal pour les images -->
<div id="imageModal" 
     class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center backdrop-blur-sm p-4" 
     onclick="closeImageModal()">
    
    <button class="absolute top-3 right-3 sm:top-6 sm:right-6 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/20 text-white text-base sm:text-xl flex items-center justify-center transition-all z-10"
            onclick="closeImageModal()">
        <i class="fas fa-times"></i>
    </button>
    
    <button class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10"
            onclick="prevImage()">
        <i class="fas fa-chevron-left text-sm sm:text-base"></i>
    </button>
    
    <img id="modalImage" src="" alt="Image agrandie" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
    
    <button class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10"
            onclick="nextImage()">
        <i class="fas fa-chevron-right text-sm sm:text-base"></i>
    </button>
    
    <div class="absolute bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 bg-white/20 backdrop-blur px-3 sm:px-4 py-1 sm:py-2 rounded-full text-white text-xs sm:text-sm">
        <span id="currentImageIndex">1</span>/<span id="totalImages">1</span>
    </div>
</div>

<style>
/* Hide scrollbar for breadcrumb */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Line clamp utilities */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Extra small devices (xs) */
@media (min-width: 480px) {
    .xs\:inline {
        display: inline;
    }
    .xs\:hidden {
        display: none;
    }
}

/* Prose adjustments */
.prose-xs {
    font-size: 0.75rem;
    line-height: 1.25;
}
.prose-xs p {
    margin-bottom: 0.5rem;
}
.prose-xs p:last-child {
    margin-bottom: 0;
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Sticky sidebar adjustment */
@media (min-width: 1024px) {
    .lg\:sticky {
        position: sticky;
        top: 6rem;
    }
}
</style>

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
    chevron.style.transform = exercice.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
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

// Initialisation
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
    
    // Animation au scroll
    const animatedElements = document.querySelectorAll('[data-aos]');
    
    function checkVisibility() {
        animatedElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            if (rect.top < windowHeight * 0.85) {
                element.classList.add('aos-animate');
            }
        });
    }
    
    checkVisibility();
    window.addEventListener('scroll', checkVisibility);
});
</script>
@endsection