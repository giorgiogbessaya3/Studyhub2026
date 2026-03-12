{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.app')

@section('title', 'StudyHub - Votre plateforme d\'apprentissage')

@section('content')
<!-- HERO SECTION - Version améliorée et responsive -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[400px] md:min-h-[500px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-10 left-10 w-48 h-48 md:w-72 md:h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-64 h-64 md:w-96 md:h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-8 md:py-0">
        <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-8">
            <!-- Texte -->
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-3">
                    Apprenez, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-secondary-300">Révisez</span>,<br class="hidden sm:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-secondary-300">Réussissez</span>
                </h1>
                
                <p class="text-slate-300 text-sm sm:text-base md:text-lg mb-5 md:mb-6 max-w-xl mx-auto lg:mx-0 leading-relaxed px-2 sm:px-0">
                    Accédez à des milliers de cours, exercices et examens corrigés pour exceller dans vos études.
                </p>
                
                <!-- Search bar -->
                <form action="/search" method="GET" 
                      class="flex flex-col sm:flex-row items-stretch sm:items-center bg-white rounded-xl shadow-2xl p-1 max-w-lg mx-auto lg:mx-0 hover:shadow-2xl transition-shadow gap-2 sm:gap-0">
                    <div class="flex items-center flex-1 bg-white rounded-xl sm:rounded-none">
                        <i class="fas fa-search text-primary-400 ml-3"></i>
                        <input type="text" 
                               name="q" 
                               placeholder="Rechercher une matière, un cours..." 
                               class="w-full px-3 py-3 sm:py-2.5 text-slate-700 focus:outline-none text-sm rounded-xl sm:rounded-none"
                               minlength="2"
                               required>
                    </div>
                    <button class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-5 py-3 sm:py-2.5 rounded-xl text-sm font-medium hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 w-full sm:w-auto">
                        Rechercher
                    </button>
                </form>
            </div>
            
            <!-- Image (cachée sur mobile) -->
            <div class="hidden lg:block flex-1">
                <div class="relative">
                    <img src="/img/car1.png" 
                         alt="Student" 
                         class="w-full max-w-md mx-auto animate-float">
                    
                    <!-- Floating cards -->
                    <div class="absolute -top-10 -left-10 bg-white rounded-2xl p-3 shadow-2xl animate-float">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">Exercice réussi !</p>
                                <p class="text-xs text-slate-500">Mathématiques</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-5 -right-5 bg-white rounded-2xl p-3 shadow-2xl animate-float animation-delay-2000">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">Nouveau badge</p>
                                <p class="text-xs text-slate-500">Physique-Chimie</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave separator (optionnel pour une transition plus douce) -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-12 md:h-20">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" fill-opacity="0.1"/>
        </svg>
    </div>
</section>

<!-- SECTION 2 - SERVICES CARDS -->
<section class="py-8 md:py-10 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de section -->
        <div class="text-center mb-6 md:mb-8" data-aos="fade-up">
            <span class="text-primary-600 text-xs md:text-sm uppercase tracking-wider font-semibold bg-primary-50 px-4 py-2 rounded-full inline-block mb-3">
                Nos Services
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 perspective">
            <!-- COURS CARD -->
            <div class="group bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-blue-100 hover:border-blue-300 shadow-lg hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 transform-3d" data-aos="fade-up" data-aos-delay="100">
                <div class="relative mb-4 md:mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-book-open text-white text-xl md:text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 md:w-6 md:h-6 bg-blue-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">Cours en ligne</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 leading-relaxed">Des cours complets et structurés par chapitre avec résumés, illustrations et exercices corrigés.</p>
                <a href="/cours" class="inline-flex items-center text-blue-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Explorer les cours</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- EPREUVES CARD -->
            <div class="group bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-green-100 hover:border-green-300 shadow-lg hover:shadow-2xl hover:shadow-green-500/20 transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 transform-3d" data-aos="fade-up" data-aos-delay="200">
                <div class="relative mb-4 md:mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-file-alt text-white text-xl md:text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 md:w-6 md:h-6 bg-green-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">Banque d'épreuves</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 leading-relaxed">Des milliers de devoirs, interrogations et examens blancs avec leurs corrigés détaillés.</p>
                <a href="/epreuves" class="inline-flex items-center text-green-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Explorer les épreuves</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- ASSISTANCE CARD -->
            <div class="group bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-purple-100 hover:border-purple-300 shadow-lg hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 transform-3d md:col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="300">
                <div class="relative mb-4 md:mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-question-circle text-white text-xl md:text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 md:w-6 md:h-6 bg-purple-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">Assistance</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 leading-relaxed">Bloqué sur un exercice ? Posez vos questions et recevez de l'aide de professeurs et d'autres élèves.</p>
                <a href="/assistance" class="inline-flex items-center text-purple-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Poser une question</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 3 - CLASSES -->
<section class="py-8 md:py-10 bg-white">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 md:mb-8" data-aos="fade-up">
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <span class="text-primary-600 text-xs md:text-sm uppercase tracking-wider font-semibold bg-primary-50 px-4 py-2 rounded-full inline-block mb-2 md:mb-3">
                    Parcours adaptés
                </span>
            </div>
            <a href="/cours" class="group flex items-center gap-2 text-primary-600 font-medium hover:text-primary-700 text-sm md:text-base">
                <span>Voir toutes les classes</span>
                <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @foreach($quickClasses as $index => $classe)
            @php
                $colors = [
                    ['from' => '#3b82f6', 'to' => '#2563eb', 'light' => '#eff6ff'],
                    ['from' => '#10b981', 'to' => '#059669', 'light' => '#ecfdf5'],
                    ['from' => '#8b5cf6', 'to' => '#7c3aed', 'light' => '#f5f3ff'],
                    ['from' => '#f59e0b', 'to' => '#d97706', 'light' => '#fffbeb'],
                    ['from' => '#ef4444', 'to' => '#dc2626', 'light' => '#fef2f2'],
                    ['from' => '#06b6d4', 'to' => '#0891b2', 'light' => '#cffafe'],
                ];
                $color = $colors[$index % count($colors)];
            @endphp
            <div class="group bg-white rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-1 md:hover:-translate-y-2" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ $index * 50 }}">
                <!-- En-tête avec dégradé -->
                <div class="relative h-28 md:h-40 overflow-hidden" 
                     style="background: linear-gradient(135deg, {{ $color['from'] }} 0%, {{ $color['to'] }} 100%);">
                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                    </div>
                    
                    <!-- Cercles décoratifs -->
                    <div class="absolute -right-8 -top-8 w-24 h-24 md:w-32 md:h-32 bg-white/20 rounded-full"></div>
                    <div class="absolute -left-8 -bottom-8 w-24 h-24 md:w-32 md:h-32 bg-white/20 rounded-full"></div>
                    
                    <!-- Icône et titre -->
                    <div class="absolute left-3 md:left-5 bottom-3 md:bottom-5">
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-10 h-10 md:w-14 md:h-14 bg-white/30 backdrop-blur rounded-lg md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <i class="fas fa-graduation-cap text-white text-lg md:text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-lg md:text-2xl">{{ $classe->nom }}</h3>
                                <p class="text-xs text-white/80">{{ $classe->matieres_count ?? rand(8, 12) }} matières</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 md:p-6">
                    <!-- Statistiques détaillées -->
                    <div class="grid grid-cols-2 gap-2 md:gap-4 mb-4 md:mb-6">
                        <div class="text-center p-2 md:p-3 bg-gray-50 rounded-lg md:rounded-xl">
                            <div class="text-base md:text-lg font-bold text-gray-800">{{ rand(40, 80) }}</div>
                            <div class="text-xs text-gray-500">Chapitres</div>
                        </div>
                        <div class="text-center p-2 md:p-3 bg-gray-50 rounded-lg md:rounded-xl">
                            <div class="text-base md:text-lg font-bold text-gray-800">{{ rand(100, 200) }}</div>
                            <div class="text-xs text-gray-500">Exercices</div>
                        </div>
                    </div>
                    
                    <!-- Description (cachée sur très petits écrans) -->
                    <p class="hidden sm:block text-xs md:text-sm text-gray-600 mb-4 md:mb-6 line-clamp-2">
                        Programme complet de {{ $classe->nom }} : cours, exercices, devoirs et examens corrigés.
                    </p>
                    
                    <!-- Tags matières -->
                    <div class="flex flex-wrap gap-1 md:gap-2 mb-4 md:mb-6">
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full" style="background-color: {{ $color['light'] }}; color: {{ $color['from'] }};">Maths</span>
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full" style="background-color: {{ $color['light'] }}; color: {{ $color['from'] }};">Physique</span>
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full" style="background-color: {{ $color['light'] }}; color: {{ $color['from'] }};">Français</span>
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full" style="background-color: {{ $color['light'] }}; color: {{ $color['from'] }};">+{{ rand(3, 6) }}</span>
                    </div>
                    
                    <!-- Bouton d'action -->
                    <a href="/cours/classe/{{ $classe->nom }}" 
                       class="block w-full py-2 md:py-3 text-center rounded-lg md:rounded-xl text-sm md:text-base font-medium transition-all duration-300"
                       style="color: {{ $color['from'] }}; border: 1px solid {{ $color['from'] }};"
                       onmouseover="this.style.backgroundColor='{{ $color['from'] }}'; this.style.color='white';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='{{ $color['from'] }}';">
                        Explorer la classe
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION 4 - STATISTIQUES (optionnelle pour remplir) -->
<section class="py-8 md:py-10 bg-gradient-to-b from-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="text-2xl md:text-3xl font-bold text-primary-600 mb-1 md:mb-2">5000+</div>
                <div class="text-xs md:text-sm text-gray-600">Élèves</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2">1000+</div>
                <div class="text-xs md:text-sm text-gray-600">Cours</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <div class="text-2xl md:text-3xl font-bold text-purple-600 mb-1 md:mb-2">2000+</div>
                <div class="text-xs md:text-sm text-gray-600">Exercices</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="400">
                <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1 md:mb-2">98%</div>
                <div class="text-xs md:text-sm text-gray-600">Satisfaction</div>
            </div>
        </div>
    </div>
</section>

@endsection

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

.perspective {
    perspective: 1000px;
}

.transform-3d {
    transform-style: preserve-3d;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}

.hover\:-translate-y-2:hover {
    transform: translateY(-0.5rem);
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

/* Ajustements responsifs */
@media (max-width: 640px) {
    [data-aos] {
        transition-duration: 0.4s;
    }
    
    [data-aos="fade-up"] {
        transform: translateY(20px);
    }
}

/* Éviter les débordements */
img, svg, video {
    max-width: 100%;
    height: auto;
}
</style>

@push('scripts')
<script>
    // Simple AOS-like animation
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('[data-aos]');
        
        function checkVisibility() {
            animatedElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const threshold = window.innerWidth < 640 ? 0.9 : 0.85; // Plus tolérant sur mobile
                
                if (rect.top < windowHeight * threshold) {
                    element.classList.add('aos-animate');
                }
            });
        }
        
        // Initial check
        checkVisibility();
        
        // Check on scroll avec throttling pour les performances
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    checkVisibility();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Recheck au redimensionnement
        window.addEventListener('resize', function() {
            checkVisibility();
        });
    });
</script>
@endpush