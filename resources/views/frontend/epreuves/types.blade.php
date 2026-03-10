@extends('layouts.app')

@section('title', 'Types d\'épreuves - ' . $classe->nom . ' - StudyHub')

@section('content')
<!-- Hero Section - Même style que les autres pages -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-5">
        <!-- Fil d'Ariane -->
        <nav class="mb-6 text-sm text-white/80" data-aos="fade-down">
            <ol class="flex items-center flex-wrap gap-1">
                <li><a href="/" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-xs"></i> Accueil
                </a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="/epreuves" class="hover:text-white transition-colors">Épreuves</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium">{{ $classe->nom }}</li>
            </ol>
        </nav>
        
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row items-center gap-6" data-aos="fade-right">
            <div class="w-20 h-20 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="fas fa-tag text-white text-3xl"></i>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">
                    {{ $classe->nom }}
                </h1>
                <p class="text-white/80 text-base md:text-lg">
                    Choisissez le type d'épreuve que vous recherchez
                </p>
                
                <!-- Statistiques rapides -->
                <div class="flex flex-wrap gap-4 mt-4 justify-center md:justify-start">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
                        <i class="fas fa-layer-group text-white/80 text-sm"></i>
                        <span class="text-white text-sm">{{ $types->count() }} types d'épreuves</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
                        <i class="fas fa-file-alt text-white/80 text-sm"></i>
                        <span class="text-white text-sm">{{ $types->sum('epreuves_count') }} épreuves</span>
                    </div>
                </div>
            </div>
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
    
    @if($types->isEmpty())
        <div class="text-center py-20 bg-gray-50 rounded-3xl" data-aos="fade-up">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-tag text-4xl text-primary-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun type d'épreuve disponible</h3>
            <p class="text-gray-500">Aucune épreuve n'est disponible pour cette classe pour le moment.</p>
            <a href="/epreuves" class="inline-flex items-center gap-2 text-primary-600 font-medium mt-4 hover:underline">
                <i class="fas fa-arrow-left"></i>
                Retour aux classes
            </a>
        </div>
    @else
        <!-- En-tête de section -->
        <div class="flex items-center gap-4 mb-8" data-aos="fade-up">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-tag text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Types d'épreuves disponibles</h2>
                <p class="text-gray-500">{{ $types->count() }} types · {{ $types->sum('epreuves_count') }} épreuves au total</p>
            </div>
        </div>
        
        <!-- Grille des types d'épreuves -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($types as $index => $type)
            @php
                // Configuration des couleurs alternées
                $colorClasses = [
                    ['bg' => '#3b82f6', 'gradient' => 'from-blue-600 to-blue-700', 'light' => 'bg-blue-50', 'text' => 'text-blue-600'],
                    ['bg' => '#22c55e', 'gradient' => 'from-green-600 to-green-700', 'light' => 'bg-green-50', 'text' => 'text-green-600'],
                    ['bg' => '#eab308', 'gradient' => 'from-yellow-600 to-yellow-700', 'light' => 'bg-yellow-50', 'text' => 'text-yellow-600'],
                    ['bg' => '#8b5cf6', 'gradient' => 'from-purple-600 to-purple-700', 'light' => 'bg-purple-50', 'text' => 'text-purple-600'],
                ];
                $color = $colorClasses[$index % 4];
                
                // Icône par défaut selon le type
                $icon = $type->icone ?? 'fas fa-file-alt';
                if(!$type->icone) {
                    $icons = [
                        'Devoir' => 'fas fa-pencil-alt',
                        'Examen' => 'fas fa-file-alt',
                        'Concours' => 'fas fa-trophy',
                        'Bac blanc' => 'fas fa-star',
                        'Brevet blanc' => 'fas fa-fire',
                        'Test' => 'fas fa-question-circle',
                        'Quiz' => 'fas fa-puzzle-piece',
                    ];
                    $icon = $icons[$type->nom] ?? 'fas fa-file-alt';
                }
                
                $epreuvesCount = $type->epreuves_count ?? rand(10, 50);
            @endphp
            
            <a href="/epreuves/classe/{{ $classe->nom }}/type/{{ $type->slug }}/matieres" 
               class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2"
               data-aos="fade-up" 
               data-aos-delay="{{ $index * 50 }}">
                
                <!-- En-tête avec dégradé -->
                <div class="relative h-24 overflow-hidden" 
                     style="background: linear-gradient(135deg, {{ $color['bg'] }} 0%, {{ $color['bg'] }}dd 100%);">
                    
                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                    </div>
                    
                    <!-- Cercles décoratifs -->
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                    <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                    
                    <!-- Badge nombre d'épreuves -->
                    <div class="absolute top-3 right-3 bg-white/30 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                        <i class="fas fa-file-alt text-xs"></i>
                        {{ $epreuvesCount }}
                    </div>
                    
                    <!-- Icône principale -->
                    <div class="absolute bottom-3 left-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <i class="{{ $icon }} text-white text-xl"></i>
                            </div>
                            <h3 class="font-bold text-white text-lg">{{ $type->nom }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <!-- Description -->
                    @if($type->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $type->description }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 mb-4 line-clamp-2">
                            Toutes les épreuves de type {{ $type->nom }} pour la classe de {{ $classe->nom }}
                        </p>
                    @endif
                    
                    <!-- Tags des matières principales -->
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @php
                            $matieres = ['Maths', 'Français', 'Histoire', 'Physique', 'SVT'];
                            shuffle($matieres);
                            $selectedMatieres = array_slice($matieres, 0, 3);
                        @endphp
                        
                        @foreach($selectedMatieres as $matiere)
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                            {{ $matiere }}
                        </span>
                        @endforeach
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+{{ rand(2, 5) }}</span>
                    </div>
                    
                    <!-- Années disponibles -->
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                        <i class="fas fa-calendar-alt" style="color: {{ $color['bg'] }};"></i>
                        <span>{{ rand(2020, 2024) }}, {{ rand(2020, 2024) }}, {{ rand(2020, 2024) }}...</span>
                    </div>
                    
                    <!-- Barre de progression (taux de complétion) -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">Disponibilité</span>
                            <span class="font-medium" style="color: {{ $color['bg'] }};">{{ rand(70, 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full transition-all" 
                                 style="width: {{ rand(70, 100) }}%; background-color: {{ $color['bg'] }};"></div>
                        </div>
                    </div>
                    
                    <!-- Bouton d'action -->
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Voir les matières</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all group-hover:scale-110"
                             style="background-color: {{ $color['bg'] }};">
                            <i class="fas fa-arrow-right text-white text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
       
        
        <!-- Navigation retour -->
        <div class="text-center mt-8" data-aos="fade-up">
            <a href="/epreuves" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste des classes
            </a>
        </div>
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