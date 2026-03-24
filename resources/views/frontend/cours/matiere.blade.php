@extends('layouts.app')

@section('title', $matiere->nom . ' - ' . $classe->nom . ' - StudyHub')

@section('content')
<!-- Hero Section - Exactement comme dans le code exemple -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        
        <!-- En-tête avec stats style code exemple -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <!-- Badge de classe -->
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-4">
                    <i class="{{ $matiere->icone ?? 'fas fa-book' }} text-white text-sm"></i>
                    <span class="text-white/90 text-sm font-medium">{{ $classe->nom }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3">{{ $matiere->nom }}</h1>
                
                @if($matiere->description)
                    <p class="text-white/80 max-w-2xl">{{ $matiere->description }}</p>
                @endif
            </div>
            
            <!-- Stats cards style code exemple -->
            <div class="flex gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4 text-center min-w-[100px]">
                    <div class="text-3xl font-bold text-white">{{ $chapitres->count() }}</div>
                    <div class="text-xs text-white/60">Chapitres</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4 text-center min-w-[100px]">
                    <div class="text-3xl font-bold text-white">{{ $chapitres->sum('contenus_count') }}</div>
                    <div class="text-xs text-white/60">Contenus</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-8">
    
    @if($chapitres->isEmpty())
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
                <i class="fas fa-book-open text-4xl text-primary-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun chapitre disponible</h3>
            <p class="text-gray-500">Les chapitres pour cette matière seront bientôt ajoutés.</p>
        </div>
    @else
        <!-- Liste des chapitres style code exemple -->
        <div class="space-y-4">
            @foreach($chapitres as $index => $chapitre)
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all">
                <!-- En-tête du chapitre (cliquable) -->
                <div class="p-6 cursor-pointer hover:bg-gray-50/50 transition-colors" 
                     onclick="toggleChapitre({{ $chapitre->id }})">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <!-- Numéro de chapitre style code exemple -->
                            <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-lg">
                                {{ $index + 1 }}
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800">{{ $chapitre->titre }}</h3>
                                @if($chapitre->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $chapitre->description }}</p>
                                @endif
                                
                                <!-- Métadonnées style code exemple -->
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="flex items-center gap-1 text-xs text-gray-500">
                                        <i class="fas fa-file-alt"></i>
                                        {{ $chapitre->contenus_count }} contenus
                                    </span>
                                    <span class="flex items-center gap-1 text-xs text-gray-500">
                                        <i class="fas fa-clock"></i>
                                        {{ rand(20, 60) }} min
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chevron style code exemple -->
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" 
                               id="chevron-{{ $chapitre->id }}"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Contenu détaillé du chapitre -->
                <div id="chapitre-{{ $chapitre->id }}" 
                     class="border-t border-gray-100 bg-gray-50/50 p-6 {{ $index === 0 ? '' : 'hidden' }}">
                    
                    @if($chapitre->contenus_count > 0)
                        <!-- Grille des contenus style code exemple -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                                        <i class="fas fa-video text-primary-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-700">Cours vidéo</h4>
                                        <p class="text-xs text-gray-500">{{ rand(2, 5) }} vidéos · {{ rand(30, 90) }} min</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                                        <i class="fas fa-pencil-alt text-primary-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-700">Exercices</h4>
                                        <p class="text-xs text-gray-500">{{ rand(5, 12) }} exercices corrigés</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Barre de progression style code exemple -->
                        @php $progression = rand(0, 100); @endphp
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Progression</span>
                                <span class="font-medium text-primary-600">{{ $progression }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: {{ $progression }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Bouton d'accès style code exemple -->
                        <a href="/cours/chapitre/{{ $chapitre->slug }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition-all group">
                            <span>Accéder au chapitre</span>
                            <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Contenus en cours de préparation</p>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Suggestions de matières avec icônes colorées -->
        @php
            $autresMatieres = $classe->matieres()
                ->where('matieres.id', '!=', $matiere->id)
                ->where('matieres.statut', true)
                ->limit(4)
                ->get();
            
            // Définition des couleurs et icônes par matière
            $matieresConfig = [
                'Mathématiques' => ['icon' => 'fa-solid fa-calculator', 'color' => 'from-blue-500 to-blue-600', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                'Maths' => ['icon' => 'fa-solid fa-calculator', 'color' => 'from-blue-500 to-blue-600', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                'Français' => ['icon' => 'fa-solid fa-book', 'color' => 'from-green-500 to-green-600', 'bg' => 'bg-green-100', 'text' => 'text-green-600'],
                'Histoire' => ['icon' => 'fa-solid fa-landmark', 'color' => 'from-amber-500 to-amber-600', 'bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
                'Géographie' => ['icon' => 'fa-solid fa-earth-africa', 'color' => 'from-emerald-500 to-emerald-600', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                'Physique' => ['icon' => 'fa-solid fa-flask', 'color' => 'from-purple-500 to-purple-600', 'bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                'Chimie' => ['icon' => 'fa-solid fa-vial', 'color' => 'from-pink-500 to-pink-600', 'bg' => 'bg-pink-100', 'text' => 'text-pink-600'],
                'SVT' => ['icon' => 'fa-solid fa-leaf', 'color' => 'from-lime-500 to-lime-600', 'bg' => 'bg-lime-100', 'text' => 'text-lime-600'],
                'Sciences' => ['icon' => 'fa-solid fa-microscope', 'color' => 'from-cyan-500 to-cyan-600', 'bg' => 'bg-cyan-100', 'text' => 'text-cyan-600'],
                'Anglais' => ['icon' => 'fa-solid fa-language', 'color' => 'from-indigo-500 to-indigo-600', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                'Espagnol' => ['icon' => 'fa-solid fa-language', 'color' => 'from-orange-500 to-orange-600', 'bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                'Allemand' => ['icon' => 'fa-solid fa-language', 'color' => 'from-yellow-500 to-yellow-600', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                'Philosophie' => ['icon' => 'fa-solid fa-brain', 'color' => 'from-violet-500 to-violet-600', 'bg' => 'bg-violet-100', 'text' => 'text-violet-600'],
                'SES' => ['icon' => 'fa-solid fa-chart-line', 'color' => 'from-red-500 to-red-600', 'bg' => 'bg-red-100', 'text' => 'text-red-600'],
                'EMC' => ['icon' => 'fa-solid fa-scale-balanced', 'color' => 'from-teal-500 to-teal-600', 'bg' => 'bg-teal-100', 'text' => 'text-teal-600'],
                'Arts' => ['icon' => 'fa-solid fa-paint-brush', 'color' => 'from-fuchsia-500 to-fuchsia-600', 'bg' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-600'],
                'Musique' => ['icon' => 'fa-solid fa-music', 'color' => 'from-rose-500 to-rose-600', 'bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
                'Sport' => ['icon' => 'fa-solid fa-futbol', 'color' => 'from-sky-500 to-sky-600', 'bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                'Technologie' => ['icon' => 'fa-solid fa-gears', 'color' => 'from-gray-500 to-gray-600', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                'NSI' => ['icon' => 'fa-solid fa-laptop-code', 'color' => 'from-blue-800 to-blue-900', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                'Numérique' => ['icon' => 'fa-solid fa-laptop', 'color' => 'from-indigo-800 to-indigo-900', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
            ];
        @endphp
        
        @if($autresMatieres->isNotEmpty())
        <div class="mt-10 pt-8 border-t border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-semibold text-gray-500">AUTRES MATIÈRES DANS {{ $classe->nom }}</h3>
                <a href="/cours/classe/{{ $classe->nom }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    Voir tout
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($autresMatieres as $autre)
                @php
                    $config = $matieresConfig[$autre->nom] ?? [
                        'icon' => 'fa-solid fa-book', 
                        'color' => 'from-primary-500 to-primary-600',
                        'bg' => 'bg-primary-100',
                        'text' => 'text-primary-600'
                    ];
                    $chapitresCount = rand(5, 12);
                    $progression = rand(0, 100);
                @endphp
                <a href="/cours/classe/{{ $classe->nom }}/matiere/{{ $autre->nom }}" 
                   class="group bg-white p-5 rounded-xl border border-gray-200 hover:border-transparent hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    
                    <!-- Dégradé de fond au hover -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br {{ $config['color'] }}"></div>
                    
                    <!-- Contenu -->
                    <div class="relative z-10">
                        <!-- En-tête avec icône et stats -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-12 h-12 rounded-xl {{ $config['bg'] }} group-hover:bg-white/20 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class="{{ $config['icon'] }} text-xl {{ $config['text'] }} group-hover:text-white"></i>
                            </div>
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 group-hover:bg-white/20 text-gray-600 group-hover:text-white/90">
                                {{ $chapitresCount }} chapitres
                            </span>
                        </div>
                        
                        <!-- Nom de la matière -->
                        <h4 class="font-semibold text-gray-800 group-hover:text-white mb-2">{{ $autre->nom }}</h4>
                        
                        <!-- Barre de progression -->
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 group-hover:text-white/80">Progression</span>
                                <span class="font-medium {{ $config['text'] }} group-hover:text-white">{{ $progression }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full {{ $config['bg'] }} group-hover:bg-white/50 rounded-full transition-all" 
                                     style="width: {{ $progression }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Tags des spécialités (optionnel) -->
                        @if(in_array($autre->nom, ['Mathématiques', 'Physique', 'SVT', 'NSI', 'Philosophie']))
                        <div class="mt-3 flex flex-wrap gap-1">
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-100 group-hover:bg-white/20 text-gray-600 group-hover:text-white/80">
                                Spécialité
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Effet de brillance au hover -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-white/0 via-white/10 to-white/0 transform -skew-x-12"></div>
                    </div>
                </a>
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

.hidden {
    display: none;
}

/* Pour le navbar */
nav.fixed {
    position: fixed !important;
}

/* Assurer que le main a assez d'espace pour le footer */
main {
    min-height: calc(100vh - 80px - 400px);
    display: flex;
    flex-direction: column;
}

/* Le contenu principal prend tout l'espace disponible */
main > div:last-child {
    flex: 1;
}

/* Correction pour les écrans larges */
@media (min-width: 1024px) {
    /* S'assurer que le contenu n'est pas caché sous la navbar fixe */
    main {
        padding-top: 80px;
    }
    
    /* S'assurer que le footer est bien visible */
    footer {
        display: block !important;
        margin-top: auto;
    }
    
    /* S'assurer que la navbar desktop est visible */
    nav.hidden.lg\\:block {
        display: block !important;
    }
}

/* Correction pour mobile */
@media (max-width: 1023px) {
    main {
        padding-top: 64px;
        padding-bottom: 80px;
    }
}
</style>

<script>
function toggleChapitre(id) {
    const content = document.getElementById('chapitre-' + id);
    const chevron = document.getElementById('chevron-' + id);
    const isHidden = content.classList.contains('hidden');
    
    content.classList.toggle('hidden');
    chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
}

// Initialiser le premier chapitre ouvert
document.addEventListener('DOMContentLoaded', function() {
    @if($chapitres->isNotEmpty())
        const firstChevron = document.getElementById('chevron-{{ $chapitres->first()->id }}');
        if (firstChevron) {
            firstChevron.style.transform = 'rotate(180deg)';
        }
    @endif
    
    // Vérifier que la navbar et le footer sont visibles sur desktop
    if (window.innerWidth >= 1024) {
        const navbar = document.querySelector('nav.hidden.lg\\:block');
        const footer = document.querySelector('footer.hidden.lg\\:block');
        
        if (navbar) {
            navbar.style.display = 'block';
        }
        
        if (footer) {
            footer.style.display = 'block';
        }
    }
});

// Réagir au redimensionnement de la fenêtre
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
        const navbar = document.querySelector('nav.hidden.lg\\:block');
        const footer = document.querySelector('footer.hidden.lg\\:block');
        
        if (navbar) {
            navbar.style.display = 'block';
        }
        
        if (footer) {
            footer.style.display = 'block';
        }
    }
});
</script>
@endsection