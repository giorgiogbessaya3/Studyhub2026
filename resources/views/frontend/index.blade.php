{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.app')

@section('title', 'StudyHub - Votre plateforme d\'apprentissage')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 50px 50px;"></div>
        <div class="blob bg-primary-500 w-96 h-96 rounded-full -top-20 -left-20"></div>
        <div class="blob bg-secondary-500 w-80 h-80 rounded-full bottom-0 right-0 translate-y-1/2 translate-x-1/2 animation-delay-2000"></div>
        <div class="blob bg-purple-500 w-64 h-64 rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div data-aos="fade-right">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-primary-100 text-sm font-medium">🚀 Plus de 10,000 élèves nous font confiance</span>
                </div>
                
                <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    Apprenez, Révisez,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-200 to-secondary-400">Réussissez</span>
                </h1>
                
                <p class="text-xl text-primary-100 mb-8 max-w-lg leading-relaxed">
                    Accédez à des milliers de ressources pédagogiques, épreuves corrigées et cours interactifs du collège au lycée.
                </p>

                <!-- Search Bar -->
                <div class="relative max-w-xl mb-8 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <form action="/search" method="GET" class="relative flex items-center bg-white rounded-2xl shadow-2xl p-2">
                        <i class="fas fa-search text-slate-400 text-xl ml-4"></i>
                        <input type="text" name="q" placeholder="Rechercher une matière, un chapitre ou une épreuve..." 
                               class="flex-1 px-4 py-4 text-slate-700 placeholder-slate-400 bg-transparent border-none focus:outline-none focus:ring-0 text-lg">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg btn-shine hidden sm:block">
                            Rechercher
                        </button>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-8 text-white">
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="text-3xl font-bold counter" data-target="{{ $stats['total_epreuves'] ?? 5000 }}">0</div>
                        <div class="text-primary-200 text-sm">Épreuves</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200">
                        <div class="text-3xl font-bold counter" data-target="{{ $stats['total_chapitres'] ?? 1200 }}">0</div>
                        <div class="text-primary-200 text-sm">Chapitres</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300">
                        <div class="text-3xl font-bold counter" data-target="{{ $stats['total_eleves'] ?? 15000 }}">0</div>
                        <div class="text-primary-200 text-sm">Élèves</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <div class="text-3xl font-bold">98%</div>
                        <div class="text-primary-200 text-sm">Réussite</div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Cards -->
            <div class="hidden lg:block relative" data-aos="fade-left">
                <!-- Floating Cards -->
                <div class="absolute -top-10 -left-10 w-64 bg-white rounded-2xl p-4 shadow-2xl animate-float z-20">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Exercice validé !</p>
                            <p class="text-xs text-slate-500">Mathématiques • 3ème</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>

                <div class="absolute top-20 right-0 w-72 bg-white rounded-2xl p-5 shadow-2xl z-10 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Nouveau</span>
                        <i class="fas fa-ellipsis-h text-slate-400"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">DS Mathématiques</h3>
                    <p class="text-sm text-slate-500 mb-4">Suites numériques • Terminale</p>
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name=Marie+L&background=random" class="w-8 h-8 rounded-full">
                        <span class="text-sm text-slate-600">234 téléchargements</span>
                    </div>
                </div>

                <div class="absolute bottom-0 left-10 w-64 bg-white rounded-2xl p-4 shadow-2xl animate-float animation-delay-2000 z-20">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-trophy text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Nouveau badge !</p>
                            <p class="text-xs text-slate-500">Expert Physique-Chimie</p>
                        </div>
                    </div>
                </div>

                <!-- Main Illustration -->
                <div class="relative z-0 transform translate-x-10">
                    <img src="https://illustrations.popsy.co/amber/student-reading.svg" alt="Student" class="w-full max-w-md mx-auto drop-shadow-2xl">
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#features" class="text-white/50 hover:text-white transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Nos Services</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mt-3 mb-4">Tout pour réussir votre année</h2>
            <p class="text-xl text-slate-600">Une plateforme complète avec tous les outils nécessaires pour votre réussite scolaire.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Cours -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="0">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-3xl transform rotate-1 scale-[1.02] opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                <a href="/cours" class="relative block bg-white rounded-3xl p-8 shadow-lg border border-slate-100 card-hover overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30 transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-book-open text-white text-2xl"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Cours en ligne</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Des cours complets et structurés par chapitre avec résumés, illustrations et exercices corrigés.</p>
                        
                        <div class="flex items-center gap-2 text-blue-600 font-semibold group-hover:gap-4 transition-all">
                            <span>Explorer les cours</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Épreuves -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-green-600 rounded-3xl transform -rotate-1 scale-[1.02] opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                <a href="/epreuves" class="relative block bg-white rounded-3xl p-8 shadow-lg border border-slate-100 card-hover overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-500/30 transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Banque d'épreuves</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Des milliers de devoirs, interrogations et examens blancs avec leurs corrigés détaillés à télécharger.</p>
                        
                        <div class="flex items-center gap-2 text-green-600 font-semibold group-hover:gap-4 transition-all">
                            <span>Explorer les épreuves</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Assistance -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-3xl transform rotate-1 scale-[1.02] opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                <a href="/assistance" class="relative block bg-white rounded-3xl p-8 shadow-lg border border-slate-100 card-hover overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30 transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-question-circle text-white text-2xl"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Assistance</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Bloqué sur un exercice ? Posez vos questions et recevez de l'aide de professeurs et d'autres élèves.</p>
                        
                        <div class="flex items-center gap-2 text-purple-600 font-semibold group-hover:gap-4 transition-all">
                            <span>Poser une question</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Classes Section -->
<section class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-primary-50 to-transparent opacity-50"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-12 gap-6" data-aos="fade-up">
            <div>
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Parcours Scolaire</span>
                <h2 class="font-display text-4xl font-bold text-slate-900 mt-2">Choisissez votre niveau</h2>
                <p class="text-slate-600 mt-2 max-w-xl">Des ressources adaptées à chaque classe, du collège à la terminale.</p>
            </div>
            <a href="/cours" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700 transition-colors group">
                Voir toutes les classes
                <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quickClasses as $index => $classe)
            <a href="/cours/classe/{{ $classe->nom }}" 
               class="group relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover overflow-hidden"
               data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="absolute inset-0 bg-gradient-to-br from-{{ ['orange', 'yellow', 'blue'][$index % 3] }}-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="relative flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-bold
                        {{ $index == 0 ? 'bg-orange-100 text-orange-600' : '' }}
                        {{ $index == 1 ? 'bg-red-100 text-red-600' : '' }}
                        {{ $index == 2 ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $index > 2 ? 'bg-slate-100 text-slate-600' : '' }}
                        transform group-hover:scale-110 transition-transform">
                        @php
                            $niveau = preg_replace('/[^0-9]/', '', $classe->nom);
                            echo $niveau ? $niveau . 'e' : substr($classe->nom, 0, 2);
                        @endphp
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-xl text-slate-900 group-hover:text-primary-600 transition-colors">{{ $classe->nom }}</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            {{ $classe->matieres_count ?? $classe->matieres->count() ?? rand(5, 12) }} matières • 
                            {{ $classe->chapitres_count ?? rand(20, 50) }} chapitres
                        </p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary-500 transform group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Recent Content -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4" data-aos="fade-up">
            <div>
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Nouveautés</span>
                <h2 class="font-display text-4xl font-bold text-slate-900 mt-2">Derniers contenus ajoutés</h2>
            </div>
            <div class="flex gap-2">
                <a href="/epreuves" class="px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition">Épreuves</a>
                <a href="/cours" class="px-4 py-2 rounded-full bg-slate-100 text-slate-600 text-sm font-medium hover:bg-slate-200 transition-colors">Cours</a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recentEpreuves as $index => $epreuve)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 card-hover" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="h-48 bg-gradient-to-br from-{{ ['blue', 'purple', 'green'][$index % 3] }}-500 to-{{ ['blue', 'purple', 'green'][$index % 3] }}-600 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-{{ ['blue', 'purple', 'green'][$index % 3] }}-600">
                        {{ $epreuve->matiere->nom ?? 'Mathématiques' }}
                    </div>
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-slate-700">
                        {{ $epreuve->classe->nom ?? 'Terminale' }}
                    </div>
                    <i class="fas fa-file-alt absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white/20 text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                        <span class="bg-{{ ['red', 'blue', 'green'][$index % 3] }}-100 text-{{ ['red', 'blue', 'green'][$index % 3] }}-700 px-2 py-1 rounded-full">
                            {{ $epreuve->typeEpreuve->nom ?? 'Examen blanc' }}
                        </span>
                        <span>•</span>
                        <span>{{ $epreuve->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $epreuve->titre }}</h3>
                    <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($epreuve->description ?? 'Épreuve avec corrigé disponible', 80) }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-4 text-sm text-slate-500">
                            <span><i class="fas fa-clock mr-1"></i>{{ $epreuve->duree ?? '2h' }}</span>
                            <span><i class="fas fa-download mr-1"></i>{{ $epreuve->downloads ?? rand(100, 500) }}</span>
                        </div>
                        <a href="/epreuves/{{ $epreuve->slug ?? $epreuve->id }}" class="text-primary-600 hover:text-primary-700">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
                @php
                    $defaultEpreuves = [
                        ['titre' => 'Devoir commun de Mathématiques', 'matiere' => 'Mathématiques', 'classe' => 'Terminale', 'type' => 'Examen blanc'],
                        ['titre' => 'Composition de Physique-Chimie', 'matiere' => 'Physique-Chimie', 'classe' => 'Première', 'type' => 'Devoir'],
                        ['titre' => 'Dissertation de Français', 'matiere' => 'Français', 'classe' => 'Seconde', 'type' => 'Interrogation']
                    ];
                @endphp
                
                @foreach($defaultEpreuves as $index => $default)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 card-hover" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="h-48 bg-gradient-to-br from-{{ ['blue', 'purple', 'green'][$index % 3] }}-500 to-{{ ['blue', 'purple', 'green'][$index % 3] }}-600 relative overflow-hidden">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-{{ ['blue', 'purple', 'green'][$index % 3] }}-600">
                            {{ $default['matiere'] }}
                        </div>
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-slate-700">
                            {{ $default['classe'] }}
                        </div>
                        <i class="fas fa-file-alt absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white/20 text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                            <span class="bg-{{ ['red', 'blue', 'green'][$index % 3] }}-100 text-{{ ['red', 'blue', 'green'][$index % 3] }}-700 px-2 py-1 rounded-full">
                                {{ $default['type'] }}
                            </span>
                            <span>•</span>
                            <span>Il y a 2 jours</span>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $default['titre'] }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">Épreuve avec corrigé disponible en téléchargement</p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <span><i class="fas fa-clock mr-1"></i>2h</span>
                                <span><i class="fas fa-download mr-1"></i>{{ rand(150, 450) }}</span>
                            </div>
                            <a href="/epreuves" class="text-primary-600 hover:text-primary-700">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-primary-600 to-primary-900 relative overflow-hidden">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="blob bg-white w-96 h-96 rounded-full top-0 right-0 translate-x-1/2 -translate-y-1/2 opacity-10"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">Prêt à améliorer vos résultats ?</h2>
        <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">Rejoignez plus de 15 000 élèves qui utilisent StudyHub pour réussir leur année scolaire. C'est gratuit !</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/register" class="bg-white text-primary-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-primary-50 transition-all transform hover:scale-105 shadow-xl flex items-center justify-center gap-2 btn-shine">
                <i class="fas fa-rocket"></i>
                Commencer gratuitement
            </a>
            <a href="/cours" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-play-circle"></i>
                Explorer les cours
            </a>
        </div>
        
        <p class="mt-6 text-sm text-primary-200">
            <i class="fas fa-check-circle mr-1"></i> Sans engagement 
            <span class="mx-2">•</span> 
            <i class="fas fa-check-circle mr-1"></i> Accès gratuit aux cours
            <span class="mx-2">•</span> 
            <i class="fas fa-check-circle mr-1"></i> Premium pour les épreuves
        </p>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(animateCounters, 20);
            } else {
                counter.innerText = target.toLocaleString();
            }
        });
    };

    // Trigger counter animation when element is in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    });

    counters.forEach(counter => observer.observe(counter));
</script>
@endsection