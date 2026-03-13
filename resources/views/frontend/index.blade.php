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
                <form action="{{ route('search') }}" method="GET" 
                      class="flex flex-col sm:flex-row items-stretch sm:items-center bg-white rounded-xl shadow-2xl p-1 max-w-lg mx-auto lg:mx-0 hover:shadow-2xl transition-shadow gap-2 sm:gap-0">
                    <div class="flex items-center flex-1 bg-white rounded-xl sm:rounded-none">
                        <i class="fas fa-search text-primary-400 ml-3"></i>
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Rechercher une matière, un cours..." 
                               class="w-full px-3 py-3 sm:py-2.5 text-slate-700 focus:outline-none text-sm rounded-xl sm:rounded-none"
                               minlength="2"
                               required>
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-5 py-3 sm:py-2.5 rounded-xl text-sm font-medium hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 w-full sm:w-auto">
                        Rechercher
                    </button>
                </form>
            </div>
            
            <!-- Image (cachée sur mobile) -->
            <div class="hidden lg:block flex-1">
                <div class="relative">
                    <img src="{{ asset('img/car1.png') }}" 
                         alt="Student" 
                         class="w-full max-w-md mx-auto animate-float"
                         onerror="this.src='https://placehold.co/600x400/3b82f6/white?text=StudyHub'">
                    
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
    
    <!-- Wave separator -->
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8 perspective">
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
                <a href="{{ url('/cours') }}" class="inline-flex items-center text-blue-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
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
                <a href="{{ url('/epreuves') }}" class="inline-flex items-center text-green-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Explorer les épreuves</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- QUIZ CARD -->
            <div class="group bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-orange-100 hover:border-orange-300 shadow-lg hover:shadow-2xl hover:shadow-orange-500/20 transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 transform-3d" data-aos="fade-up" data-aos-delay="300">
                <div class="relative mb-4 md:mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-question-circle text-white text-xl md:text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 md:w-6 md:h-6 bg-orange-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">Quiz interactifs</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 leading-relaxed">Testez vos connaissances avec des quiz interactifs adaptés à votre niveau et suivez votre progression.</p>
                <a href="{{ url('/quiz') }}" class="inline-flex items-center text-orange-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Commencer les quiz</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- ASSISTANCE CARD -->
            <div class="group bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-purple-100 hover:border-purple-300 shadow-lg hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 transform-3d" data-aos="fade-up" data-aos-delay="400">
                <div class="relative mb-4 md:mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-headset text-white text-xl md:text-3xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 md:w-6 md:h-6 bg-purple-500 rounded-full animate-ping opacity-50"></div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">Assistance</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 leading-relaxed">Bloqué sur un exercice ? Posez vos questions et recevez de l'aide de professeurs et d'autres élèves.</p>
                <a href="{{ url('/assistance') }}" class="inline-flex items-center text-purple-600 font-medium text-sm md:text-base group-hover:gap-3 transition-all">
                    <span>Poser une question</span>
                    <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 3 - CLASSES (4 CLASSES EXACTEMENT) -->
<section class="py-8 md:py-10 bg-white">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 md:mb-8" data-aos="fade-up">
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <span class="text-primary-600 text-xs md:text-sm uppercase tracking-wider font-semibold bg-primary-50 px-4 py-2 rounded-full inline-block mb-2 md:mb-3">
                    Parcours adaptés
                </span>
            </div>
            <a href="{{ url('/cours') }}" class="group flex items-center gap-2 text-primary-600 font-medium hover:text-primary-700 text-sm md:text-base">
                <span>Voir toutes les classes</span>
                <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        @if(isset($quickClasses) && $quickClasses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($quickClasses as $index => $classe)
            @php
                $colors = [
                    ['from' => '#3b82f6', 'to' => '#2563eb', 'light' => '#eff6ff'], // Bleu
                    ['from' => '#10b981', 'to' => '#059669', 'light' => '#ecfdf5'], // Vert
                    ['from' => '#8b5cf6', 'to' => '#7c3aed', 'light' => '#f5f3ff'], // Violet
                    ['from' => '#f59e0b', 'to' => '#d97706', 'light' => '#fffbeb'], // Orange
                ];
                $color = $colors[$index % count($colors)];
                
                // Statistiques simulées (à remplacer par des vraies données si disponibles)
                $matieresCount = $classe->matieres_count ?? $classe->matieres->count() ?? rand(6, 10);
                $chapitresCount = $classe->chapitres_count ?? rand(20, 40);
                $exercicesCount = rand(80, 150);
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
                                @if(in_array($classe->nom, ['3ème', 'Terminale']))
                                    <span class="text-xs bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full font-medium">
                                        {{ $classe->nom == '3ème' ? 'Brevet' : 'Bac' }}
                                    </span>
                                @else
                                    <p class="text-xs text-white/80">{{ $matieresCount }} matières</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 md:p-6">
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 gap-2 md:gap-4 mb-4 md:mb-6">
                        <div class="text-center p-2 md:p-3 bg-gray-50 rounded-lg md:rounded-xl">
                            <div class="text-base md:text-lg font-bold text-gray-800">{{ $chapitresCount }}</div>
                            <div class="text-xs text-gray-500">Chapitres</div>
                        </div>
                        <div class="text-center p-2 md:p-3 bg-gray-50 rounded-lg md:rounded-xl">
                            <div class="text-base md:text-lg font-bold text-gray-800">{{ $exercicesCount }}</div>
                            <div class="text-xs text-gray-500">Exercices</div>
                        </div>
                    </div>
                    
                    <!-- Tags matières -->
                    <div class="flex flex-wrap gap-1 md:gap-2 mb-4 md:mb-6">
                        @php
                            $matieresList = ['Maths', 'Français', 'Physique', 'Histoire'];
                            if($classe->nom == 'Terminale') {
                                $matieresList = ['Maths', 'Physique', 'SVT', 'Philo'];
                            } elseif($classe->nom == 'Première') {
                                $matieresList = ['Maths', 'Physique', 'SVT', 'SES'];
                            } elseif($classe->nom == 'Seconde') {
                                $matieresList = ['Maths', 'Physique', 'SVT', 'SES'];
                            }
                        @endphp
                        @foreach(array_slice($matieresList, 0, 3) as $matiere)
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full" style="background-color: {{ $color['light'] }}; color: {{ $color['from'] }};">
                            {{ $matiere }}
                        </span>
                        @endforeach
                        <span class="px-2 md:px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+{{ rand(2, 4) }}</span>
                    </div>
                    
                    <!-- Bouton d'action -->
                    <a href="{{ url('/cours/classe/' . $classe->nom) }}" 
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
        @else
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune classe disponible pour le moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- SECTION 4 - STATISTIQUES -->
<section class="py-8 md:py-10 bg-gradient-to-b from-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="text-2xl md:text-3xl font-bold text-primary-600 mb-1 md:mb-2">{{ number_format($stats['total_utilisateurs'] ?? 5000) }}+</div>
                <div class="text-xs md:text-sm text-gray-600">Élèves</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2">{{ number_format($stats['total_cours'] ?? 1000) }}+</div>
                <div class="text-xs md:text-sm text-gray-600">Cours</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1 md:mb-2">{{ number_format($stats['total_quiz'] ?? 500) }}+</div>
                <div class="text-xs md:text-sm text-gray-600">Quiz</div>
            </div>
            <div class="text-center p-4 md:p-6 bg-white rounded-xl md:rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="400">
                <div class="text-2xl md:text-3xl font-bold text-purple-600 mb-1 md:mb-2">98%</div>
                <div class="text-xs md:text-sm text-gray-600">Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 5 - DERNIÈRES ÉPREUVES (optionnel) -->
@if(isset($recentEpreuves) && $recentEpreuves->count() > 0)
<section class="py-8 md:py-10 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 md:mb-8" data-aos="fade-up">
            <div>
                <span class="text-primary-600 text-xs md:text-sm uppercase tracking-wider font-semibold bg-primary-50 px-4 py-2 rounded-full inline-block mb-2">
                    Nouveautés
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dernières épreuves</h2>
            </div>
            <a href="{{ url('/epreuves') }}" class="group flex items-center gap-2 text-primary-600 font-medium hover:text-primary-700 text-sm md:text-base mt-2 sm:mt-0">
                <span>Voir toutes</span>
                <i class="fas fa-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentEpreuves as $epreuve)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="p-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{ $epreuve->classe->nom ?? 'N/A' }}</span>
                        <span>•</span>
                        <span>{{ $epreuve->matiere->nom ?? 'N/A' }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                        <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" class="hover:text-primary-600 transition-colors">
                            {{ $epreuve->titre }}
                        </a>
                    </h3>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-xs text-gray-500">
                            <i class="far fa-calendar mr-1"></i> {{ $epreuve->created_at->format('d/m/Y') }}
                        </span>
                        <a href="{{ url('/epreuve/' . ($epreuve->slug ?? $epreuve->id)) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Voir <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Styles -->
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

/* Animation ping */
@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}
.animate-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
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
                const threshold = window.innerWidth < 640 ? 0.9 : 0.85;
                
                if (rect.top < windowHeight * threshold) {
                    element.classList.add('aos-animate');
                }
            });
        }
        
        checkVisibility();
        
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
        
        window.addEventListener('resize', checkVisibility);
    });
</script>
@endpush
@endsection