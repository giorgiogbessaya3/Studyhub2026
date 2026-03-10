@extends('layouts.app')

@section('title', 'Cours en ligne - StudyHub')

@section('content')
<!-- Hero Section - Même style que la page d'accueil -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-5">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                <i class="fas fa-book-open mr-2"></i>
                Catalogue complet
            </span>
            
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Cours en ligne
            </h1>
            
            <p class="text-white/80 text-base md:text-lg mb-4">
                Accédez à tous nos cours par niveau, de la 6ème à la Terminale
            </p>
            
            <!-- Barre de recherche -->
            <div class="max-w-xl mx-auto">
                <form action="/cours/recherche" method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           class="w-full px-6 py-4 pr-14 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/30 shadow-xl" 
                           placeholder="Rechercher un cours, un chapitre..." 
                           minlength="2" 
                           required>
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 w-12 h-12 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl flex items-center justify-center hover:shadow-lg transition-all hover:scale-105" 
                            type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-5">
    
    @if($classes->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-book-open text-4xl text-primary-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune classe disponible</h3>
            <p class="text-gray-500">Nos équipes travaillent sur l'ajout de nouveaux contenus.</p>
        </div>
    @else
        <!-- Filtres rapides -->
        <div class="flex flex-wrap gap-3 mb-10 justify-center">
            <a href="#college" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-child mr-2"></i>Collège
            </a>
            <a href="#lycee" class="px-5 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium hover:bg-primary-100 transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i>Lycée
            </a>
        </div>

        <!-- Collège -->
        @php
            $collegeClasses = $classes->where('cycle', 'college');
        @endphp
        
        @if($collegeClasses->isNotEmpty())
        <div id="college" class="mb-16 scroll-mt-24">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-child text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Collège</h2>
                    <p class="text-gray-500">{{ $collegeClasses->count() }} classes • 6ème à 3ème</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">{{ $collegeClasses->sum('matieres_count') ?? rand(20, 30) }} matières disponibles</span>
                </div>
            </div>
            
            <!-- Grille des classes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($collegeClasses as $index => $classe)
                @php
                    // Définir une icône unique pour chaque classe
                    $icons = [
                        '6ème' => 'fa-solid fa-6',
                        '5ème' => 'fa-solid fa-5',
                        '4ème' => 'fa-solid fa-4',
                        '3ème' => 'fa-solid fa-3',
                    ];
                    $icon = $icons[$classe->nom] ?? 'fa-solid fa-graduation-cap';
                    
                    $matieresCount = $classe->matieres_count ?? $classe->matieres->count() ?? rand(6, 10);
                    $chapitresCount = $classe->chapitres_count ?? rand(20, 40);
                    $exercicesCount = rand(80, 150);
                @endphp
                
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 50 }}">
                    
                    <!-- En-tête avec dégradé -->
                    <div class="relative h-32 overflow-hidden" 
                         style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        
                        <!-- Pattern de fond -->
                        <div class="absolute inset-0 opacity-10" 
                             style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                        </div>
                        
                        <!-- Cercles décoratifs -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>
                        
                        <!-- Badge classe avec icône unique -->
                        <div class="absolute bottom-4 left-4">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <i class="{{ $icon }} text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-xl">{{ $classe->nom }}</h3>
                                    @if($classe->nom == '3ème')
                                    <span class="text-xs bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full font-medium">Brevet</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Statistiques -->
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $matieresCount }}</div>
                                <div class="text-xs text-gray-500">Matières</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $chapitresCount }}</div>
                                <div class="text-xs text-gray-500">Chapitres</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $exercicesCount }}</div>
                                <div class="text-xs text-gray-500">Exercices</div>
                            </div>
                        </div>
                        
                        <!-- Tags matières -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach(['Maths', 'Français', 'Histoire', 'Sciences'] as $matiere)
                            <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">
                                {{ $matiere }}
                            </span>
                            @endforeach
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+{{ rand(2, 4) }}</span>
                        </div>
                        
                        <!-- Bouton -->
                        <a href="/cours/classe/{{ $classe->nom }}" 
                           class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-primary-600 border-2 border-primary-600 hover:bg-primary-600 hover:text-white">
                            Accéder aux cours
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Lycée -->
        @php
            $lyceeClasses = $classes->where('cycle', 'lycee');
        @endphp
        
        @if($lyceeClasses->isNotEmpty())
        <div id="lycee" class="mb-16 scroll-mt-24">
            <!-- En-tête de section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Lycée</h2>
                    <p class="text-gray-500">{{ $lyceeClasses->count() }} classes • Seconde à Terminale</p>
                </div>
                <div class="flex-1 text-right">
                    <span class="text-sm text-gray-400">Préparation au Bac</span>
                </div>
            </div>
            
            <!-- Grille des classes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($lyceeClasses as $index => $classe)
                @php
                    // Définir une icône unique pour chaque classe
                    $icons = [
                        'Seconde' => 'fa-solid fa-2',
                        'Première' => 'fa-solid fa-1',
                        'Terminale' => 'fa-solid fa-t',
                    ];
                    $icon = $icons[$classe->nom] ?? 'fa-solid fa-graduation-cap';
                    
                    $matieresCount = $classe->matieres_count ?? $classe->matieres->count() ?? rand(10, 15);
                    $chapitresCount = $classe->chapitres_count ?? rand(30, 50);
                    $exercicesCount = rand(150, 250);
                    $isTerminale = $classe->nom == 'Terminale';
                    $isPremiere = $classe->nom == 'Première';
                @endphp
                
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 50 }}">
                    
                    <!-- En-tête avec dégradé -->
                    <div class="relative h-32 overflow-hidden" 
                         style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        
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
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Statistiques -->
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $matieresCount }}</div>
                                <div class="text-xs text-gray-500">Matières</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $chapitresCount }}</div>
                                <div class="text-xs text-gray-500">Chapitres</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div class="font-bold text-gray-800">{{ $exercicesCount }}</div>
                                <div class="text-xs text-gray-500">Exercices</div>
                            </div>
                        </div>
                        
                        <!-- Spécialités pour Première/Terminale -->
                        @if($isTerminale || $isPremiere)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1.5">
                                @php
                                    if($isTerminale) {
                                        $specialites = ['Maths expertes', 'Physique', 'SVT'];
                                    } else {
                                        $specialites = ['Maths', 'Physique', 'SVT'];
                                    }
                                @endphp
                                @foreach($specialites as $spec)
                                <span class="px-2 py-1 text-xs rounded-lg bg-primary-50 text-primary-600">
                                    {{ $spec }}
                                </span>
                                @endforeach
                                <span class="px-2 py-1 text-xs rounded-lg bg-gray-100 text-gray-600">+3</span>
                            </div>
                        </div>
                        @else
                        <!-- Tags matières pour Seconde -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach(['Maths', 'Physique', 'SVT', 'SES'] as $matiere)
                            <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-600">
                                {{ $matiere }}
                            </span>
                            @endforeach
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+4</span>
                        </div>
                        @endif
                        
                        <!-- Bouton -->
                        <a href="/cours/classe/{{ $classe->nom }}" 
                           class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md text-white"
                           style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                            <span>Explorer la classe</span>
                            <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
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
</style>

@push('scripts')
<script>
    // Animation au scroll simplifiée
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