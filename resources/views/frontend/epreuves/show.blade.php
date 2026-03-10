@extends('layouts.app')

@section('title', $epreuve->titre . ' - StudyHub')

@section('content')
<!-- Hero Section - Style unifié -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[250px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs (masqués sur mobile) -->
    <div class="hidden sm:block absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="hidden sm:block absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-4 sm:py-5">
        <!-- Fil d'Ariane compact -->
        <nav class="mb-3 sm:mb-4 text-xs sm:text-sm text-white/80 overflow-x-auto whitespace-nowrap pb-1 hide-scrollbar" data-aos="fade-down">
            <ol class="flex items-center">
                <li><a href="/" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-[10px] sm:text-xs"></i>
                    <span class="hidden sm:inline">Accueil</span>
                </a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves" class="hover:text-white transition-colors whitespace-nowrap">Épreuves</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/types" class="hover:text-white transition-colors whitespace-nowrap">{{ $epreuve->classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matieres" class="hover:text-white transition-colors whitespace-nowrap">{{ $epreuve->typeEpreuve->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matiere/{{ $epreuve->matiere->nom }}" class="hover:text-white transition-colors whitespace-nowrap">{{ $epreuve->matiere->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium truncate max-w-[100px] sm:max-w-xs">{{ $epreuve->titre }}</li>
            </ol>
        </nav>
        
        <!-- En-tête compact -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4" data-aos="fade-right">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/20 backdrop-blur rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-file-pdf text-white text-2xl sm:text-3xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-1 truncate">
                    {{ $epreuve->titre }}
                </h1>
                <p class="text-white/80 text-xs sm:text-sm truncate">
                    {{ $epreuve->classe->nom }} • {{ $epreuve->matiere->nom }} • {{ $epreuve->typeEpreuve->nom }}
                </p>
                <!-- Métadonnées rapides -->
                <div class="flex flex-wrap gap-2 mt-2">
                    @if($epreuve->annee)
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-calendar"></i> {{ $epreuve->annee }}
                    </span>
                    @endif
                    @if($epreuve->duree)
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-clock"></i> {{ $epreuve->duree }} min
                    </span>
                    @endif
                    @if($epreuve->bareme)
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-star"></i> {{ $epreuve->bareme }} pts
                    </span>
                    @endif
                </div>
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
<div class="max-w-7xl mx-auto px-4 py-5">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Carte principale -->
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg border border-gray-200 overflow-hidden" data-aos="fade-up">
                <!-- En-tête avec dégradé -->
                <div class="relative h-20 sm:h-24 overflow-hidden" 
                     style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    
                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                    </div>
                    
                    <!-- Cercles décoratifs -->
                    <div class="absolute -right-8 -top-8 w-24 h-24 bg-white/20 rounded-full"></div>
                    <div class="absolute -left-8 -bottom-8 w-24 h-24 bg-white/20 rounded-full"></div>
                    
                    <!-- Titre de section -->
                    <div class="absolute bottom-3 left-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/30 backdrop-blur rounded-lg flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            <h2 class="text-white font-bold text-sm sm:text-base">Détails de l'épreuve</h2>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 sm:p-8">
                    <!-- Description -->
                    @if($epreuve->description)
                    <div class="mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-align-left text-primary-600"></i>
                            Description
                        </h3>
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-6 text-gray-700 text-sm sm:text-base border-l-4 border-primary-600">
                            {{ $epreuve->description }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Informations détaillées en cartes -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8">
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-calendar text-blue-600 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500">Année</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $epreuve->annee ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-clock text-green-600 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500">Durée</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $epreuve->duree ? $epreuve->duree . ' min' : 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500">Barème</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $epreuve->bareme ? $epreuve->bareme . ' pts' : 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-download text-purple-600 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500">Téléchargements</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $epreuve->downloads ?? 0 }}</p>
                        </div>
                    </div>
                    
                    <!-- Actions principales -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/download" 
                           class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold hover:shadow-lg transition-all flex items-center justify-center gap-2 group btn-shine">
                            <i class="fas fa-download"></i>
                            <span class="text-sm sm:text-base">Télécharger l'épreuve</span>
                            <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        
                        @if($epreuve->correction)
                            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction" 
                               class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:shadow-lg transition-all flex items-center justify-center gap-2 group btn-shine">
                                <i class="fas fa-check-circle"></i>
                                <span class="text-sm sm:text-base">Voir la correction</span>
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Aperçu du fichier (optionnel) -->
            @if($epreuve->has_preview)
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="relative h-20 sm:h-24 overflow-hidden" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                    </div>
                    <div class="absolute bottom-3 left-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/30 backdrop-blur rounded-lg flex items-center justify-center">
                                <i class="fas fa-eye text-white text-sm"></i>
                            </div>
                            <h2 class="text-white font-bold text-sm sm:text-base">Aperçu</h2>
                        </div>
                    </div>
                </div>
                <div class="p-5 sm:p-8">
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <i class="fas fa-file-pdf text-primary-600 text-4xl mb-3"></i>
                        <p class="text-gray-600 mb-4">Aperçu non disponible</p>
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/preview" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Cliquez ici pour voir l'aperçu
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Informations complémentaires -->
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg border border-gray-200 overflow-hidden sticky top-24" data-aos="fade-left">
                <div class="relative h-16 sm:h-20 overflow-hidden" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                    </div>
                    <div class="absolute bottom-2 left-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-white/30 backdrop-blur rounded-lg flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-xs"></i>
                            </div>
                            <h3 class="text-white font-bold text-xs sm:text-sm">Informations</h3>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 sm:p-6">
                    <ul class="space-y-4 mb-6">
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <i class="fas fa-school text-sm sm:text-base"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Classe</p>
                                <p class="font-medium text-sm sm:text-base truncate">{{ $epreuve->classe->nom }}</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                <i class="fas fa-book text-sm sm:text-base"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Matière</p>
                                <p class="font-medium text-sm sm:text-base truncate">{{ $epreuve->matiere->nom }}</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                <i class="fas fa-tag text-sm sm:text-base"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Type d'épreuve</p>
                                <p class="font-medium text-sm sm:text-base truncate">{{ $epreuve->typeEpreuve->nom }}</p>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- État de la correction -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            @if($epreuve->correction)
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-green-600 text-sm">Correction disponible</span>
                                    <p class="text-xs text-gray-500">Téléchargez la correction</p>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-times-circle text-gray-400"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 text-sm">Correction non disponible</span>
                                    <p class="text-xs text-gray-400">Revenez plus tard</p>
                                </div>
                            @endif
                        </div>
                        @if($epreuve->correction)
                            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction/download" 
                               class="text-sm text-green-600 hover:text-green-700 flex items-center gap-1 mt-2 pt-2 border-t border-gray-200">
                                <i class="fas fa-download"></i>
                                Télécharger la correction
                            </a>
                        @endif
                    </div>
                    
                    <!-- Bouton de partage -->
                    <button onclick="partagerEpreuve()" 
                            class="w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors flex items-center justify-center gap-2 text-sm group">
                        <i class="fas fa-share-alt"></i>
                        <span>Partager cette épreuve</span>
                    </button>
                    
                    <!-- Statistiques supplémentaires -->
                    <div class="mt-4 pt-4 border-t border-gray-200 grid grid-cols-2 gap-2 text-center">
                        <div>
                            <p class="text-lg font-bold text-primary-600">{{ $epreuve->vues ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Vues</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-green-600">{{ $epreuve->downloads ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Téléchargements</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Épreuves similaires -->
    @if($similaires->isNotEmpty())
    <section class="mt-12 sm:mt-16" data-aos="fade-up">
        <div class="flex items-center gap-4 mb-6 sm:mb-8">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-layer-group text-white text-sm sm:text-base"></i>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Épreuves similaires</h2>
                <p class="text-xs sm:text-sm text-gray-500">{{ $similaires->count() }} épreuve{{ $similaires->count() > 1 ? 's' : '' }} recommandée{{ $similaires->count() > 1 ? 's' : '' }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($similaires as $index => $similaire)
            <a href="/epreuves/{{ $similaire->slug ?? $similaire->id }}" 
               class="group bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-200 p-4 sm:p-5 hover:shadow-xl transition-all hover:-translate-y-1"
               data-aos="fade-up" 
               data-aos-delay="{{ $index * 50 }}">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-alt text-primary-600 text-sm sm:text-base"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-800 group-hover:text-primary-600 transition-colors text-sm sm:text-base truncate">
                            {{ $similaire->titre }}
                        </h3>
                        <p class="text-xs text-gray-500 truncate">{{ $similaire->typeEpreuve->nom }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2 truncate">{{ $similaire->classe->nom }} • {{ $similaire->matiere->nom }}</p>
                @if($similaire->correction)
                <span class="text-xs text-green-600 flex items-center gap-1">
                    <i class="fas fa-check-circle"></i> Corrigé disponible
                </span>
                @endif
            </a>
            @endforeach
        </div>
    </section>
    @endif
    
    <!-- Navigation retour -->
    <div class="text-center mt-8 sm:mt-10" data-aos="fade-up">
        <a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matiere/{{ $epreuve->matiere->nom }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-primary-600 transition-colors text-sm sm:text-base">
            <i class="fas fa-arrow-left"></i>
            Retour à la liste des épreuves
        </a>
    </div>
</div>

<script>
function partagerEpreuve() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $epreuve->titre }}',
            text: '{{ Str::limit($epreuve->description ?? "Épreuve disponible sur StudyHub", 100) }}',
            url: window.location.href
        })
        .catch(() => {
            alert('Lien copié dans le presse-papier !');
            navigator.clipboard.writeText(window.location.href);
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papier !');
    }
}
</script>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

/* Hide scrollbar for breadcrumb */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
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

[data-aos="fade-left"] {
    transform: translateX(20px);
}

[data-aos="fade-left"].aos-animate {
    transform: translateX(0);
}

/* Bouton shine effect */
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

/* Line clamp */
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

/* Sticky sidebar adjustment */
@media (min-width: 1024px) {
    .sticky {
        position: sticky;
        top: 6rem;
    }
}

/* Améliorations responsives */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .text-3xl {
        font-size: 1.5rem !important;
    }
    
    .gap-8 {
        gap: 1rem !important;
    }
    
    .p-8 {
        padding: 1.25rem !important;
    }
}
</style>

@push('scripts')
<script>
    // Animation au scroll
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Initial check
        checkVisibility();
        
        // Check on scroll
        window.addEventListener('scroll', checkVisibility);
    });
</script>
@endpush
@endsection