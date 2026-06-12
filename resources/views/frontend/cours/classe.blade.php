@extends('layouts.app')

@section('title', 'Cours ' . $classe->nom . ' - StudyHub')

@section('content')
@php
    // Configuration des couleurs et styles par classe
    $classeColors = [
        '6ème' => [
            'gradient' => 'from-blue-600 to-blue-700',
            'light' => 'bg-blue-50',
            'text' => 'text-blue-600',
            'border' => 'border-blue-200',
            'icon' => 'fa-child',
            'badge' => 'bg-blue-400'
        ],
        '5ème' => [
            'gradient' => 'from-green-600 to-green-700',
            'light' => 'bg-green-50',
            'text' => 'text-green-600',
            'border' => 'border-green-200',
            'icon' => 'fa-child',
            'badge' => 'bg-green-400'
        ],
        '4ème' => [
            'gradient' => 'from-yellow-600 to-yellow-700',
            'light' => 'bg-yellow-50',
            'text' => 'text-yellow-600',
            'border' => 'border-yellow-200',
            'icon' => 'fa-child',
            'badge' => 'bg-yellow-400'
        ],
        '3ème' => [
            'gradient' => 'from-orange-600 to-orange-700',
            'light' => 'bg-orange-50',
            'text' => 'text-orange-600',
            'border' => 'border-orange-200',
            'icon' => 'fa-child',
            'badge' => 'bg-orange-400'
        ],
        'Seconde' => [
            'gradient' => 'from-purple-600 to-purple-700',
            'light' => 'bg-purple-50',
            'text' => 'text-purple-600',
            'border' => 'border-purple-200',
            'icon' => 'fa-graduation-cap',
            'badge' => 'bg-purple-400'
        ],
        'Première' => [
            'gradient' => 'from-indigo-600 to-indigo-700',
            'light' => 'bg-indigo-50',
            'text' => 'text-indigo-600',
            'border' => 'border-indigo-200',
            'icon' => 'fa-graduation-cap',
            'badge' => 'bg-indigo-400'
        ],
        'Terminale' => [
            'gradient' => 'from-pink-600 to-pink-700',
            'light' => 'bg-pink-50',
            'text' => 'text-pink-600',
            'border' => 'border-pink-200',
            'icon' => 'fa-graduation-cap',
            'badge' => 'bg-pink-400'
        ],
    ];

    $classeColor = $classeColors[$classe->nom] ?? [
        'gradient' => 'from-primary-600 to-primary-700',
        'light' => 'bg-primary-50',
        'text' => 'text-primary-600',
        'border' => 'border-primary-200',
        'icon' => 'fa-school',
        'badge' => 'bg-primary-400'
    ];

    $cycle = in_array($classe->nom, ['6ème', '5ème', '4ème', '3ème']) ? 'Collège' : 'Lycée';

    // Configuration des icônes par matière (fallback)
    $defaultIcons = [
        'Mathématiques' => 'fas fa-calculator',
        'Maths' => 'fas fa-calculator',
        'Français' => 'fas fa-book',
        'Lettres' => 'fas fa-book',
        'Physique' => 'fas fa-flask',
        'Chimie' => 'fas fa-vial',
        'Physique-Chimie' => 'fas fa-flask',
        'SVT' => 'fas fa-leaf',
        'Histoire' => 'fas fa-landmark',
        'Géographie' => 'fas fa-earth-africa',
        'Histoire-Géo' => 'fas fa-globe',
        'Anglais' => 'fas fa-language',
        'Espagnol' => 'fas fa-language',
        'Allemand' => 'fas fa-language',
        'Philosophie' => 'fas fa-brain',
        'SES' => 'fas fa-chart-line',
        'EMC' => 'fas fa-scale-balanced',
        'Arts' => 'fas fa-paint-brush',
        'Musique' => 'fas fa-music',
        'Sport' => 'fas fa-futbol',
        'EPS' => 'fas fa-futbol',
        'Technologie' => 'fas fa-gears',
        'NSI' => 'fas fa-laptop-code',
        'Numérique' => 'fas fa-laptop',
        'Latin' => 'fas fa-scroll',
        'Grec' => 'fas fa-columns',
    ];

    // Configuration des couleurs par matière (fallback)
    $defaultColors = [
        'Mathématiques' => '#3b82f6',
        'Maths' => '#3b82f6',
        'Français' => '#10b981',
        'Lettres' => '#10b981',
        'Physique' => '#8b5cf6',
        'Chimie' => '#ec4899',
        'Physique-Chimie' => '#8b5cf6',
        'SVT' => '#84cc16',
        'Histoire' => '#f59e0b',
        'Géographie' => '#14b8a6',
        'Histoire-Géo' => '#f59e0b',
        'Anglais' => '#6366f1',
        'Espagnol' => '#f97316',
        'Allemand' => '#eab308',
        'Philosophie' => '#a855f7',
        'SES' => '#ef4444',
        'EMC' => '#06b6d4',
        'Arts' => '#d946ef',
        'Musique' => '#f43f5e',
        'Sport' => '#0ea5e9',
        'EPS' => '#0ea5e9',
        'Technologie' => '#6b7280',
        'NSI' => '#1e40af',
        'Numérique' => '#312e81',
    ];
@endphp

<!-- Hero Section avec dégradé -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20"
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>

    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>

    <div class="container mx-auto px-4 relative z-10 py-2">
        <!-- Fil d'Ariane -->


        <!-- En-tête -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <!-- Badge de classe -->
                <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                    <i class="fas {{ $classeColor['icon'] }} mr-2"></i>
                    {{ $cycle }}
                </span>

                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">
                    {{ $classe->nom }}
                </h1>

                @if($classe->description)
                    <p class="text-white/80 text-base md:text-lg max-w-2xl">
                        {{ $classe->description }}
                    </p>
                @else
                    <p class="text-white/80 text-base md:text-lg max-w-2xl">
                        Découvrez toutes les matières et ressources disponibles pour la classe de {{ $classe->nom }}.
                    </p>
                @endif
            </div>

            <!-- Illustration -->
            <div class="hidden lg:block w-80">
                <img src="{{ asset('img/car1.png') }}"
                     alt="Illustration" class="w-full drop-shadow-2xl animate-float">
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-5">

    @if($matieres->isEmpty())
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center {{ $classeColor['light'] }}">
                <i class="fas fa-book-open text-4xl {{ $classeColor['text'] }}"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune matière disponible</h3>
            <p class="text-gray-500">Les matières pour cette classe seront bientôt ajoutées.</p>
        </div>
    @else
        <!-- En-tête de section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas {{ $classeColor['icon'] }} text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Matières disponibles</h2>
                    <p class="text-gray-500 text-sm">{{ $matieres->count() }} matières · {{ $matieres->sum('chapitres_count') }} chapitres · {{ $matieres->sum('contenus_count') }} contenus</p>
                </div>
            </div>

            <!-- Barre de recherche -->
            <div class="relative w-full md:w-64">
                <input type="text"
                       id="searchMatiere"
                       placeholder="Rechercher une matière..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>

        <!-- Grille des matières -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="matieresGrid">
            @foreach($matieres as $index => $matiere)
            @php
                // Déterminer la couleur (base de données ou fallback)
                $couleurMatiere = $matiere->couleur ?? ($defaultColors[$matiere->nom] ?? '#3b82f6');

                // Déterminer l'icône (base de données ou fallback)
                if (!empty($matiere->icone)) {
                    $iconeMatiere = $matiere->icone;
                } else {
                    // Chercher dans le tableau des icônes par défaut
                    $iconeMatiere = $defaultIcons[$matiere->nom] ?? 'fas fa-book';

                    // Si pas trouvé, essayer avec une correspondance partielle
                    if ($iconeMatiere == 'fas fa-book') {
                        foreach ($defaultIcons as $key => $icon) {
                            if (str_contains(strtolower($matiere->nom), strtolower($key)) ||
                                str_contains(strtolower($key), strtolower($matiere->nom))) {
                                $iconeMatiere = $icon;
                                break;
                            }
                        }
                    }
                }

                $chapitresCount = $matiere->chapitres_count ?? 0;
                $contenusCount = $matiere->contenus_count ?? 0;
                $progression = $chapitresCount > 0 ? rand(0, 100) : 0;

                // Déterminer si c'est une spécialité pour le lycée
                $specialites = ['Mathématiques', 'Physique', 'Chimie', 'Physique-Chimie', 'SVT', 'NSI', 'SES', 'HLP', 'LLCE', 'Histoire-Géo', 'Géopolitique', 'Humanités', 'Littérature'];
                $isSpecialite = in_array($classe->nom, ['Première', 'Terminale']) && in_array($matiere->nom, $specialites);

                // Tags dynamiques basés sur la matière
                $tags = ['Cours', 'Exercices', 'Quiz'];
                $nomMatiereLower = strtolower($matiere->nom);

                if(str_contains($nomMatiereLower, 'math')) {
                    $tags = ['Algèbre', 'Géométrie', 'Probabilités'];
                } elseif(str_contains($nomMatiereLower, 'franc') || str_contains($nomMatiereLower, 'lettres')) {
                    $tags = ['Grammaire', 'Littérature', 'Orthographe'];
                } elseif(str_contains($nomMatiereLower, 'phys')) {
                    $tags = ['Mécanique', 'Électricité', 'Optique'];
                } elseif(str_contains($nomMatiereLower, 'chim')) {
                    $tags = ['Organique', 'Minérale', 'Réactions'];
                } elseif(str_contains($nomMatiereLower, 'svt')) {
                    $tags = ['Biologie', 'Géologie', 'Écologie'];
                } elseif(str_contains($nomMatiereLower, 'hist')) {
                    $tags = ['Antiquité', 'Moyen Âge', 'Moderne'];
                } elseif(str_contains($nomMatiereLower, 'geo')) {
                    $tags = ['Physique', 'Humaine', 'Économique'];
                } elseif(str_contains($nomMatiereLower, 'angl')) {
                    $tags = ['Grammaire', 'Vocabulaire', 'Civilisation'];
                } elseif(str_contains($nomMatiereLower, 'esp')) {
                    $tags = ['Grammaire', 'Vocabulaire', 'Civilisation'];
                } elseif(str_contains($nomMatiereLower, 'philo')) {
                    $tags = ['Notions', 'Auteurs', 'Repères'];
                } elseif(str_contains($nomMatiereLower, 'ses')) {
                    $tags = ['Économie', 'Sociologie', 'Science politique'];
                }
            @endphp

            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2"
                 data-aos="fade-up"
                 data-aos-delay="{{ $index * 50 }}"
                 data-matiere="{{ strtolower($matiere->nom) }}">

                <!-- En-tête avec dégradé (couleur de la matière) -->
                <div class="relative h-32 overflow-hidden"
                     style="background: linear-gradient(135deg, {{ $couleurMatiere }} 0%, {{ $couleurMatiere }}dd 100%);">

                    <!-- Pattern de fond -->
                    <div class="absolute inset-0 opacity-10"
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
                    </div>

                    <!-- Cercles décoratifs -->
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
                    <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/20 rounded-full"></div>

                    <!-- Badge spécialité -->
                    @if($isSpecialite)
                    <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                        <i class="fas fa-star"></i>
                        Spécialité
                    </div>
                    @endif

                    <!-- Badge Bac pour Terminale -->
                    @if($classe->nom == 'Terminale' && in_array($matiere->nom, ['Mathématiques', 'Physique', 'Philosophie', 'SVT', 'Histoire-Géo']))
                    <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                        <i class="fas fa-star"></i>
                        Bac
                    </div>
                    @endif

                    <!-- Icône et nom de la matière -->
                    <div class="absolute bottom-4 left-4">
                        <div class="flex items-center gap-3">
                            <!-- Rond blanc avec l'icône de la matière -->
                            <div class="w-14 h-14 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <i class="{{ $iconeMatiere }} text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-xl">{{ $matiere->nom }}</h3>
                                @if(!empty($matiere->code))
                                    <p class="text-xs text-white/80">{{ $matiere->code }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <!-- Description -->
                    @if(!empty($matiere->description))
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $matiere->description }}
                        </p>
                    @endif

                    <!-- Statistiques -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="text-center p-2 bg-gray-50 rounded-lg">
                            <div class="font-bold text-gray-800">{{ $chapitresCount }}</div>
                            <div class="text-xs text-gray-500">Chapitres</div>
                        </div>
                        <div class="text-center p-2 bg-gray-50 rounded-lg">
                            <div class="font-bold text-gray-800">{{ $contenusCount }}</div>
                            <div class="text-xs text-gray-500">Contenus</div>
                        </div>
                        <div class="text-center p-2 bg-gray-50 rounded-lg">
                            <div class="font-bold text-gray-800">{{ $chapitresCount * rand(3, 8) }}</div>
                            <div class="text-xs text-gray-500">Exercices</div>
                        </div>
                    </div>

                    <!-- Tags des matières -->
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach(array_slice($tags, 0, 3) as $tag)
                        <span class="px-2 py-1 text-xs rounded-full"
                              style="background-color: {{ $couleurMatiere }}15; color: {{ $couleurMatiere }};">
                            {{ $tag }}
                        </span>
                        @endforeach
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">+{{ rand(2, 5) }}</span>
                    </div>

                    <!-- Barre de progression -->
                    @if($chapitresCount > 0)
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">Progression</span>
                            <span class="font-medium" style="color: {{ $couleurMatiere }};">{{ $progression }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full transition-all duration-300"
                                 style="width: {{ $progression }}%; background-color: {{ $couleurMatiere }};"></div>
                        </div>
                    </div>
                    @endif

                    <!-- Bouton d'action -->
                    @if($chapitresCount > 0)
                        <a href="/cours/classe/{{ $classe->nom }}/matiere/{{ $matiere->nom }}"
                           class="block w-full py-2.5 text-center rounded-xl font-medium transition-all duration-300 group-hover:shadow-md"
                           style="color: {{ $couleurMatiere }}; border: 2px solid {{ $couleurMatiere }}; background-color: transparent;"
                           onmouseover="this.style.backgroundColor='{{ $couleurMatiere }}'; this.style.color='white';"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='{{ $couleurMatiere }}';">
                            <span>Accéder à la matière</span>
                            <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform inline-block"></i>
                        </a>
                    @else
                        <button disabled
                                class="block w-full py-2.5 text-center bg-gray-100 text-gray-400 rounded-xl font-medium cursor-not-allowed">
                            <i class="fas fa-clock mr-2"></i>
                            Bientôt disponible
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Message aucun résultat pour la recherche -->
        <div id="noResult" class="hidden text-center py-12">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-600">Aucune matière ne correspond à votre recherche</p>
            <button onclick="resetSearch()" class="text-primary-600 font-medium mt-2 hover:underline">
                Réinitialiser la recherche
            </button>
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

/* Animation pour la recherche */
#matieresGrid > div {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Style pour le scroll smooth */
html {
    scroll-behavior: smooth;
}
</style>

@push('scripts')
<script>
    // Fonction de recherche en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchMatiere');
        const matieres = document.querySelectorAll('[data-matiere]');
        const grid = document.getElementById('matieresGrid');
        const noResult = document.getElementById('noResult');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleCount = 0;

                matieres.forEach(matiere => {
                    const matiereName = matiere.dataset.matiere;
                    if (matiereName.includes(searchTerm) || searchTerm === '') {
                        matiere.style.display = 'block';
                        visibleCount++;
                    } else {
                        matiere.style.display = 'none';
                    }
                });

                // Gérer l'affichage du message "aucun résultat"
                if (visibleCount === 0 && searchTerm !== '') {
                    noResult.classList.remove('hidden');
                    grid.classList.add('hidden');
                } else {
                    noResult.classList.add('hidden');
                    grid.classList.remove('hidden');
                }
            });
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

        // Initial check
        checkVisibility();

        // Check on scroll
        window.addEventListener('scroll', checkVisibility);
    });

    // Réinitialiser la recherche
    function resetSearch() {
        const searchInput = document.getElementById('searchMatiere');
        const matieres = document.querySelectorAll('[data-matiere]');
        const grid = document.getElementById('matieresGrid');
        const noResult = document.getElementById('noResult');

        if (searchInput) {
            searchInput.value = '';
            matieres.forEach(matiere => {
                matiere.style.display = 'block';
            });
            noResult.classList.add('hidden');
            grid.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
