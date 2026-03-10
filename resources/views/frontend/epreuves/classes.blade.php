@extends('layouts.app')

@section('title', 'Classes - StudyHub')

@section('content')
<!-- Hero Section - Même style que les autres pages -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[250px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-5">
        <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
            <!-- Badge -->
            <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                <i class="fas fa-file-alt mr-2"></i>
                Banque d'épreuves
            </span>
            
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">
                Choisissez votre classe
            </h1>
            
            <p class="text-white/80 text-base md:text-lg max-w-2xl mx-auto">
                Sélectionnez votre niveau pour accéder à toutes les épreuves, annales et sujets corrigés
            </p>
            
            <!-- Fil d'Ariane intégré -->
            <nav class="flex justify-center mt-6 text-sm text-white/80" aria-label="Fil d'Ariane">
                <ol class="flex items-center flex-wrap gap-1">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1">
                        <i class="fas fa-home text-xs"></i> Accueil
                    </a></li>
                    <li><span class="mx-1">/</span></li>
                    <li><a href="{{ route('epreuves') }}" class="hover:text-white transition-colors">Épreuves</a></li>
                    <li><span class="mx-1">/</span></li>
                    <li class="text-white font-medium">Classes</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
            <path d="M0 120L60 112.5C120 105 240 90 360 82.5C480 75 600 75 720 78.75C840 82.5 960 90 1080 93.75C1200 97.5 1320 97.5 1380 97.5L1440 97.5V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.2"/>
        </svg>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-5">
    
    @if(!isset($classesByCycle) || (empty($classesByCycle['college']) && empty($classesByCycle['lycee'])))
        <div class="text-center py-16 bg-gray-50 rounded-3xl" data-aos="fade-up">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-file-alt text-4xl text-primary-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune classe disponible</h3>
            <p class="text-gray-500">Les épreuves seront bientôt disponibles pour toutes les classes.</p>
        </div>
    @else
        <!-- Filtres rapides -->
        <div class="flex flex-wrap gap-3 mb-10 justify-center" data-aos="fade-up">
            @if(isset($classesByCycle['college']) && $classesByCycle['college']->count() > 0)
            <a href="#college" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-child mr-2"></i>Collège
            </a>
            @endif
            @if(isset($classesByCycle['lycee']) && $classesByCycle['lycee']->count() > 0)
            <a href="#lycee" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i>Lycée
            </a>
            @endif
            <a href="#brevet" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-fire mr-2"></i>Brevet
            </a>
            <a href="#bac" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-star mr-2"></i>Bac
            </a>
        </div>

        <!-- Collège -->
        @if(isset($classesByCycle['college']) && $classesByCycle['college']->count() > 0)
        <div id="college" class="mb-16 scroll-mt-24" data-aos="fade-up">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-child text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Collège</h2>
                    <p class="text-gray-500">{{ $classesByCycle['college']->count() }} classes disponibles</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">Épreuves de la 6ème à la 3ème</span>
                </div>
            </div>
            
            <!-- Grille des classes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($classesByCycle['college'] as $index => $classe)
                @php
                    // Configuration des couleurs par classe (comme dans la page des cours)
                    $colors = [
                        '6ème' => ['bg' => '#3b82f6', 'gradient' => 'from-blue-600 to-blue-700', 'light' => 'bg-blue-50', 'text' => 'text-blue-600'],
                        '5ème' => ['bg' => '#22c55e', 'gradient' => 'from-green-600 to-green-700', 'light' => 'bg-green-50', 'text' => 'text-green-600'],
                        '4ème' => ['bg' => '#eab308', 'gradient' => 'from-yellow-600 to-yellow-700', 'light' => 'bg-yellow-50', 'text' => 'text-yellow-600'],
                        '3ème' => ['bg' => '#f97316', 'gradient' => 'from-orange-600 to-orange-700', 'light' => 'bg-orange-50', 'text' => 'text-orange-600'],
                    ];
                    $color = $colors[$classe->nom] ?? ['bg' => '#3b82f6', 'gradient' => 'from-primary-600 to-primary-700', 'light' => 'bg-primary-50', 'text' => 'text-primary-600'];
                    
                    // Icône spécifique à la classe
                    $icons = [
                        '6ème' => 'fa-solid fa-6',
                        '5ème' => 'fa-solid fa-5',
                        '4ème' => 'fa-solid fa-4',
                        '3ème' => 'fa-solid fa-3',
                    ];
                    $icon = $icons[$classe->nom] ?? 'fa-solid fa-graduation-cap';
                @endphp
                
                <a href="{{ route('epreuves.types', $classe->nom) }}" 
                   class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2"
                   data-aos="fade-up" 
                   data-aos-delay="{{ $index * 50 }}">
                    
                    <!-- En-tête avec dégradé -->
                    <div class="relative h-32 overflow-hidden" 
                         style="background: linear-gradient(135deg, {{ $color['bg'] }} 0%, {{ $color['bg'] }}dd 100%);">
                        
                        <!-- Pattern de fond -->
                        <div class="absolute inset-0 opacity-10" 
                             style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                        </div>
                        
                        <!-- Cercles décoratifs -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        
                        <!-- Badge Brevet pour 3ème -->
                        @if($classe->nom == '3ème')
                        <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                            <i class="fas fa-fire"></i>
                            Brevet
                        </div>
                        @endif
                        
                        <!-- Badge classe avec icône unique -->
                        <div class="absolute bottom-4 left-4">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <i class="{{ $icon }} text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-xl">{{ $classe->nom }}</h3>
                                    <p class="text-xs text-white/80">{{ $classe->epreuves_count ?? rand(50, 120) }} épreuves</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Description -->
                        @if($classe->description)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $classe->description }}
                            </p>
                        @else
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                Toutes les épreuves et sujets d'examen pour la classe de {{ $classe->nom }}
                            </p>
                        @endif
                        
                        <!-- Tags matières principales -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach(['Maths', 'Français', 'Histoire'] as $matiere)
                            <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">
                                {{ $matiere }}
                            </span>
                            @endforeach
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+{{ rand(2, 4) }}</span>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $classe->epreuves_count ?? rand(50, 120) }}</div>
                                <div class="text-xs text-gray-500">Épreuves</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ rand(3, 8) }}</div>
                                <div class="text-xs text-gray-500">Années</div>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500">Taux de réussite</span>
                                <span class="font-medium text-primary-600">{{ rand(70, 95) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-primary-600 h-1.5 rounded-full" style="width: {{ rand(70, 95) }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Bouton -->
                        <div class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-primary-600 border-2 border-primary-600 hover:bg-primary-600 hover:text-white">
                            <span>Voir les épreuves</span>
                            <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Lycée -->
        @if(isset($classesByCycle['lycee']) && $classesByCycle['lycee']->count() > 0)
        <div id="lycee" class="mb-16 scroll-mt-24" data-aos="fade-up">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Lycée</h2>
                    <p class="text-gray-500">{{ $classesByCycle['lycee']->count() }} classes disponibles</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">Préparation au Bac</span>
                </div>
            </div>
            
            <!-- Grille des classes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($classesByCycle['lycee'] as $index => $classe)
                @php
                    // Configuration des couleurs par classe
                    $colors = [
                        'Seconde' => ['bg' => '#8b5cf6', 'gradient' => 'from-purple-600 to-purple-700', 'light' => 'bg-purple-50', 'text' => 'text-purple-600'],
                        'Première' => ['bg' => '#6366f1', 'gradient' => 'from-indigo-600 to-indigo-700', 'light' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                        'Terminale' => ['bg' => '#ec4899', 'gradient' => 'from-pink-600 to-pink-700', 'light' => 'bg-pink-50', 'text' => 'text-pink-600'],
                    ];
                    $color = $colors[$classe->nom] ?? ['bg' => '#8b5cf6', 'gradient' => 'from-primary-600 to-primary-700', 'light' => 'bg-primary-50', 'text' => 'text-primary-600'];
                    
                    // Icône spécifique à la classe
                    $icons = [
                        'Seconde' => 'fa-solid fa-2',
                        'Première' => 'fa-solid fa-1',
                        'Terminale' => 'fa-solid fa-t',
                    ];
                    $icon = $icons[$classe->nom] ?? 'fa-solid fa-graduation-cap';
                    
                    $isTerminale = $classe->nom == 'Terminale';
                @endphp
                
                <a href="{{ route('epreuves.types', $classe->nom) }}" 
                   class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2"
                   data-aos="fade-up" 
                   data-aos-delay="{{ $index * 50 }}">
                    
                    <!-- En-tête avec dégradé -->
                    <div class="relative h-32 overflow-hidden" 
                         style="background: linear-gradient(135deg, {{ $color['bg'] }} 0%, {{ $color['bg'] }}dd 100%);">
                        
                        <!-- Pattern de fond -->
                        <div class="absolute inset-0 opacity-10" 
                             style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                        </div>
                        
                        <!-- Cercles décoratifs -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        
                        <!-- Badge Bac pour Terminale -->
                        @if($isTerminale)
                        <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                            <i class="fas fa-star"></i>
                            Bac
                        </div>
                        @endif
                        
                        <!-- Badge classe avec icône unique -->
                        <div class="absolute bottom-4 left-4">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <i class="{{ $icon }} text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-xl">{{ $classe->nom }}</h3>
                                    <p class="text-xs text-white/80">{{ $classe->epreuves_count ?? rand(80, 200) }} épreuves</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Description -->
                        @if($classe->description)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $classe->description }}
                            </p>
                        @else
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                Toutes les épreuves et sujets d'examen pour la classe de {{ $classe->nom }}
                            </p>
                        @endif
                        
                        <!-- Tags spécialités -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @if($isTerminale)
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">Maths</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">Physique</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">SVT</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-gray-100 text-gray-600">+3</span>
                            @elseif($classe->nom == 'Première')
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">Maths</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">Physique</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">SVT</span>
                                <span class="px-2 py-1 text-xs rounded-lg bg-gray-100 text-gray-600">+3</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">Maths</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">Physique</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">SVT</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">SES</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+4</span>
                            @endif
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $classe->epreuves_count ?? rand(80, 200) }}</div>
                                <div class="text-xs text-gray-500">Épreuves</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ rand(4, 10) }}</div>
                                <div class="text-xs text-gray-500">Spécialités</div>
                            </div>
                        </div>
                        
                        <!-- Bouton avec dégradé -->
                        <div class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-white"
                             style="background: linear-gradient(135deg, {{ $color['bg'] }} 0%, {{ $color['bg'] }}dd 100%);">
                            <span>Voir les épreuves</span>
                            <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Section information -->
        <section class="mt-12 bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 border border-primary-100" data-aos="fade-up">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Nouveautés dans la banque d'épreuves</h3>
                    <p class="text-gray-600 mb-4">
                        Des centaines de nouveaux sujets et corrigés viennent d'être ajoutés. 
                        Préparez-vous efficacement avec nos épreuves classées par année et par matière.
                    </p>
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm flex items-center gap-1">
                            <i class="fas fa-check-circle"></i>
                            Sujets 2024
                        </span>
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm flex items-center gap-1">
                            <i class="fas fa-check-circle"></i>
                            Corrigés détaillés
                        </span>
                        <span class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-full text-sm flex items-center gap-1">
                            <i class="fas fa-check-circle"></i>
                            Annales complètes
                        </span>
                    </div>
                </div>
                <div class="w-48 h-48 bg-primary-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-primary-600 text-6xl"></i>
                </div>
            </div>
        </section>
    @endif
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.scroll-mt-24 {
    scroll-margin-top: 6rem;
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
    transform: translateY(30px);
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
}

.hover\:-translate-y-2:hover {
    transform: translateY(-0.5rem);
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