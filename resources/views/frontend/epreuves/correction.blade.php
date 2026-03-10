@extends('layouts.app')

@section('title', 'Correction - ' . $epreuve->titre . ' - StudyHub')

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
                <li><a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" class="hover:text-white transition-colors whitespace-nowrap">{{ Str::limit($epreuve->titre, 20) }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium truncate max-w-[100px] sm:max-w-xs">Correction</li>
            </ol>
        </nav>
        
        <!-- En-tête compact -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4" data-aos="fade-right">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/20 backdrop-blur rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-white text-2xl sm:text-3xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-1 truncate">
                    Correction
                </h1>
                <p class="text-white/80 text-xs sm:text-sm truncate">
                    {{ $epreuve->titre }}
                </p>
                <!-- Métadonnées de l'épreuve -->
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-graduation-cap"></i> {{ $epreuve->classe->nom }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-book"></i> {{ $epreuve->matiere->nom }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs bg-white/20 text-white/90 rounded-full px-2 py-0.5">
                        <i class="fas fa-tag"></i> {{ $epreuve->typeEpreuve->nom }}
                    </span>
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
    <div class="max-w-4xl mx-auto">
        
        @if(!$epreuve->correction)
        <!-- Message si pas de correction -->
        <div class="text-center py-12 sm:py-16 bg-gray-50 rounded-2xl sm:rounded-3xl" data-aos="fade-up">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-red-50 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-2xl sm:text-3xl text-red-500"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Correction non disponible</h3>
            <p class="text-sm sm:text-base text-gray-500 max-w-md mx-auto px-4 mb-6">
                La correction pour cette épreuve n'est pas encore disponible. Veuillez réessayer ultérieurement.
            </p>
            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Retour à l'épreuve
            </a>
        </div>
        @else
        <!-- Carte de la correction -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg border border-gray-200 overflow-hidden" data-aos="fade-up">
            <!-- En-tête avec dégradé -->
            <div class="relative h-24 sm:h-32 overflow-hidden" 
                 style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                
                <!-- Pattern de fond -->
                <div class="absolute inset-0 opacity-10" 
                     style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                </div>
                
                <!-- Cercles décoratifs -->
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                
                <!-- Icône et titre -->
                <div class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-white text-xl sm:text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-lg sm:text-xl">Correction disponible</h2>
                            <p class="text-white/80 text-xs sm:text-sm">{{ $epreuve->classe->nom }} • {{ $epreuve->matiere->nom }} • {{ $epreuve->typeEpreuve->nom }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Badge statut -->
                <div class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-lg">
                    <i class="fas fa-lock-open"></i>
                    <span>Accès libre</span>
                </div>
            </div>
            
            <div class="p-5 sm:p-8">
                
                <!-- Description de la correction -->
                @if($epreuve->correction->description)
                <div class="mb-6 sm:mb-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary-600"></i>
                        À propos de cette correction
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-4 sm:p-6 text-gray-700 text-sm sm:text-base border-l-4 border-primary-600">
                        {{ $epreuve->correction->description }}
                    </div>
                </div>
                @endif
                
                <!-- Informations complémentaires -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 sm:mb-8">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-pdf text-blue-600"></i>
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-800">Format PDF</div>
                        <div class="text-xs text-gray-500">Haute qualité</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check-double text-green-600"></i>
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-800">Corrigé détaillé</div>
                        <div class="text-xs text-gray-500">Explications pas à pas</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-star text-purple-600"></i>
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-800">Officiel</div>
                        <div class="text-xs text-gray-500">Correction académique</div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}/correction/download" 
                       class="flex-1 px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold hover:shadow-lg transition-all flex items-center justify-center gap-2 group btn-shine">
                        <i class="fas fa-download"></i>
                        <span>Télécharger la correction</span>
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
                       class="flex-1 px-6 py-4 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all flex items-center justify-center gap-2 group">
                        <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                        <span>Retour à l'épreuve</span>
                    </a>
                </div>
                
                <!-- Aperçu du fichier -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center gap-3 text-sm text-gray-500 bg-gray-50 rounded-lg p-4">
                        <i class="fas fa-info-circle text-primary-600 text-lg"></i>
                        <p class="text-xs sm:text-sm">
                            Le fichier de correction au format PDF sera téléchargé automatiquement après avoir cliqué sur le bouton ci-dessus. 
                            Vous pourrez le consulter hors ligne et l'imprimer si nécessaire.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6 sm:mt-8" data-aos="fade-up">
            <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" 
               class="w-full sm:w-auto text-center px-4 py-2 text-gray-600 hover:text-primary-600 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fas fa-arrow-left"></i>
                Retour à l'épreuve
            </a>
            
            <a href="/epreuves/classe/{{ $epreuve->classe->nom }}/type/{{ $epreuve->typeEpreuve->slug }}/matiere/{{ $epreuve->matiere->nom }}" 
               class="w-full sm:w-auto text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fas fa-th-large"></i>
                Voir toutes les épreuves
            </a>
            
            <a href="/epreuves" 
               class="w-full sm:w-auto text-center px-4 py-2 text-gray-600 hover:text-primary-600 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fas fa-home"></i>
                Accueil épreuves
            </a>
        </div>
        
        <!-- Navigation épreuves précédente/suivante -->
        @if(isset($epreuvePrecedente) || isset($epreuveSuivante))
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
            @if(isset($epreuvePrecedente) && $epreuvePrecedente)
            <a href="/epreuves/{{ $epreuvePrecedente->slug ?? $epreuvePrecedente->id }}/correction" 
               class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors group">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 mb-1">Correction précédente</p>
                    <p class="text-sm font-medium text-gray-700 group-hover:text-primary-600 truncate">{{ $epreuvePrecedente->titre }}</p>
                </div>
            </a>
            @else
            <div></div>
            @endif
            
            @if(isset($epreuveSuivante) && $epreuveSuivante)
            <a href="/epreuves/{{ $epreuveSuivante->slug ?? $epreuveSuivante->id }}/correction" 
               class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors group text-right">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 mb-1">Correction suivante</p>
                    <p class="text-sm font-medium text-gray-700 group-hover:text-primary-600 truncate">{{ $epreuveSuivante->titre }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300">
                    <i class="fas fa-arrow-right text-gray-600"></i>
                </div>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

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

/* Améliorations responsives */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .text-3xl {
        font-size: 1.5rem !important;
    }
    
    .gap-4 {
        gap: 0.75rem !important;
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