@extends('layouts.app')

@section('title', 'Épreuves - ' . $matiere->nom . ' - ' . $classe->nom . ' - StudyHub')
@section('meta_description', 'Toutes les épreuves de ' . $matiere->nom . ' pour la classe de ' . $classe->nom . ' - Sujets et corrigés disponibles.')

@section('content')
<!-- Hero Section - Style unifié -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[250px] flex items-center overflow-hidden">
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="hidden sm:block absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="hidden sm:block absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-4 sm:py-5">
        <!-- Fil d'Ariane compact -->
        <nav class="mb-3 sm:mb-4 text-xs sm:text-sm text-white/80 overflow-x-auto whitespace-nowrap pb-1 hide-scrollbar" data-aos="fade-down">
            <ol class="flex items-center">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <i class="fas fa-home text-[10px] sm:text-xs"></i>
                    <span class="hidden sm:inline">Accueil</span>
                </a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('epreuves.index') }}" class="hover:text-white transition-colors whitespace-nowrap">Épreuves</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('epreuves.types', $classe->nom) }}" class="hover:text-white transition-colors whitespace-nowrap">{{ $classe->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('epreuves.matieres', ['classe' => $classe->nom, 'type' => $type->id]) }}" class="hover:text-white transition-colors whitespace-nowrap">{{ $type->nom }}</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-white font-medium truncate max-w-[100px] sm:max-w-xs">{{ $matiere->nom }}</li>
            </ol>
        </nav>
        
        <!-- En-tête compact -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3" data-aos="fade-right">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 backdrop-blur rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-alt text-white text-xl sm:text-3xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-0.5 sm:mb-1 truncate">
                        {{ $matiere->nom }}
                    </h1>
                    <p class="text-white/80 text-xs sm:text-sm truncate">
                        {{ $classe->nom }} • {{ $type->nom }}
                    </p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur rounded-lg sm:rounded-xl px-3 py-1.5 sm:px-4 sm:py-2 self-end sm:self-auto">
                <span class="text-white text-xs sm:text-sm whitespace-nowrap">
                    {{ $epreuves->total() }} épreuve{{ $epreuves->total() > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 h-6 sm:h-12 overflow-hidden">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
        </svg>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 py-4 sm:py-5">

    @if($epreuves->isEmpty())
        <div class="text-center py-12 sm:py-16 bg-gray-50 rounded-2xl sm:rounded-3xl" data-aos="fade-up">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-primary-50 flex items-center justify-center">
                <i class="fas fa-file-excel text-2xl sm:text-3xl text-primary-600"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Aucune épreuve trouvée</h3>
            <p class="text-sm sm:text-base text-gray-500 max-w-md mx-auto px-4">
                Aucune épreuve n'est disponible pour le moment.
            </p>
            <div class="mt-6">
                <a href="{{ route('epreuves.matieres', ['classe' => $classe->nom, 'type' => $type->id]) }}" 
                   class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700">
                    <i class="fas fa-arrow-left"></i>
                    Retour aux matières
                </a>
            </div>
        </div>
    @else
        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6" data-aos="fade-up">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <i class="fas fa-filter text-gray-400"></i>
                    <span class="text-sm font-medium text-gray-700">Filtrer par :</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <form method="GET" action="{{ route('epreuves.liste', ['classe' => $classe->nom, 'type' => $type->id, 'matiere' => $matiere->id]) }}" class="flex flex-wrap gap-2 items-center">
                        <select name="annee" onchange="this.form.submit()" class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Toutes les années</option>
                            @foreach($annees as $annee)
                            <option value="{{ $annee }}" {{ request('annee') == $annee ? 'selected' : '' }}>{{ $annee }}</option>
                            @endforeach
                        </select>
                        
                        <select name="sort" onchange="this.form.submit()" class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="recent" {{ request('sort', 'recent') == 'recent' ? 'selected' : '' }}>Plus récent</option>
                            <option value="ancien" {{ request('sort') == 'ancien' ? 'selected' : '' }}>Plus ancien</option>
                            <option value="titre" {{ request('sort') == 'titre' ? 'selected' : '' }}>Titre (A-Z)</option>
                        </select>
                        
                        @if(request('annee') || request('sort') != 'recent')
                        <a href="{{ route('epreuves.liste', ['classe' => $classe->nom, 'type' => $type->id, 'matiere' => $matiere->id]) }}" 
                           class="px-3 py-1.5 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times mr-1"></i> Réinitialiser
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-6 sm:mb-8" data-aos="fade-up">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-list text-white text-sm sm:text-base"></i>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Liste des épreuves</h2>
                <p class="text-xs sm:text-sm text-gray-500">{{ $epreuves->total() }} épreuve{{ $epreuves->total() > 1 ? 's' : '' }} disponibles</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($epreuves as $index => $epreuve)
            @php
                $colors = [
                    'bg' => ['#3b82f6', '#22c55e', '#eab308', '#8b5cf6', '#ec4899', '#f97316'],
                    'light' => ['bg-blue-50', 'bg-green-50', 'bg-yellow-50', 'bg-purple-50', 'bg-pink-50', 'bg-orange-50'],
                    'text' => ['text-blue-600', 'text-green-600', 'text-yellow-600', 'text-purple-600', 'text-pink-600', 'text-orange-600']
                ];
                $colorIndex = $epreuve->id % count($colors['bg']);
                $mainColor = $colors['bg'][$colorIndex];
                $lightClass = $colors['light'][$colorIndex];
                $textClass = $colors['text'][$colorIndex];
            @endphp
            
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 group"
                 data-aos="fade-up" 
                 data-aos-delay="{{ $index * 50 }}">
                
                <div class="relative h-20 sm:h-24 overflow-hidden" 
                     style="background: linear-gradient(135deg, {{ $mainColor }} 0%, {{ $mainColor }}dd 100%);">
                    
                    <div class="absolute inset-0 opacity-10" 
                         style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 20px 20px;">
                    </div>
                    
                    <div class="absolute -right-8 -top-8 w-24 h-24 bg-white/20 rounded-full"></div>
                    <div class="absolute -left-8 -bottom-8 w-24 h-24 bg-white/20 rounded-full"></div>
                    
                    <div class="absolute bottom-3 left-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/30 backdrop-blur rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-sm"></i>
                            </div>
                            <span class="text-white text-xs sm:text-sm font-medium">{{ $epreuve->typeEpreuve->nom ?? $type->nom }}</span>
                        </div>
                    </div>
                    
                    @if($epreuve->annee)
                    <div class="absolute top-3 right-3 bg-white/30 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs font-medium">
                        {{ $epreuve->annee }}
                    </div>
                    @endif
                </div>
                
                <div class="p-4 sm:p-5">
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">
                        {{ $epreuve->titre }}
                    </h3>
                    
                    @if($epreuve->description)
                        <p class="text-xs sm:text-sm text-gray-500 mb-3 line-clamp-2">{{ $epreuve->description }}</p>
                    @endif
                    
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        @if($epreuve->duree)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="far fa-clock" style="color: {{ $mainColor }};"></i> 
                            {{ $epreuve->duree }} min
                        </span>
                        @endif
                        
                        @if($epreuve->bareme)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="fas fa-star" style="color: {{ $mainColor }};"></i> 
                            {{ $epreuve->bareme }} pts
                        </span>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($epreuve->matieres->take(2) as $matiereItem)
                        <span class="px-2 py-1 text-xs rounded-full {{ $lightClass }} {{ $textClass }}">
                            {{ $matiereItem->nom }}
                        </span>
                        @endforeach
                        @if($epreuve->correction)
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>Corrigé
                        </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('epreuves.show', $epreuve->slug ?? $epreuve->id) }}" 
                           class="flex flex-col items-center justify-center gap-1 px-2 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition-colors group"
                           title="Voir détails">
                            <i class="fas fa-eye text-sm"></i>
                            <span class="text-[10px] sm:text-xs font-medium">Détails</span>
                        </a>
                        
                        <a href="{{ route('epreuves.download', $epreuve->slug ?? $epreuve->id) }}" 
                           class="flex flex-col items-center justify-center gap-1 px-2 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors group"
                           title="Télécharger l'épreuve">
                            <i class="fas fa-download text-sm"></i>
                            <span class="text-[10px] sm:text-xs font-medium">Télécharger</span>
                        </a>
                        
                        @if($epreuve->correction)
                        <a href="{{ route('epreuves.correction', $epreuve->slug ?? $epreuve->id) }}" 
                           class="flex flex-col items-center justify-center gap-1 px-2 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors group"
                           title="Voir le corrigé">
                            <i class="fas fa-check-circle text-sm"></i>
                            <span class="text-[10px] sm:text-xs font-medium">Corrigé</span>
                        </a>
                        @else
                        <button disabled 
                                class="flex flex-col items-center justify-center gap-1 px-2 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed"
                                title="Corrigé non disponible">
                            <i class="fas fa-times-circle text-sm"></i>
                            <span class="text-[10px] sm:text-xs font-medium">Non dispo</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6 sm:mt-8">
            {{ $epreuves->withQueryString()->links() }}
        </div>
        
        <div class="text-center mt-4 text-xs sm:text-sm text-gray-500">
            Affichage de {{ $epreuves->firstItem() ?? 0 }} à {{ $epreuves->lastItem() ?? 0 }} sur {{ $epreuves->total() }} épreuve{{ $epreuves->total() > 1 ? 's' : '' }}
        </div>
    @endif
    
    <div class="text-center mt-6 sm:mt-8" data-aos="fade-up">
        <a href="{{ route('epreuves.matieres', ['classe' => $classe->nom, 'type' => $type->id]) }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-primary-600 transition-colors text-sm sm:text-base">
            <i class="fas fa-arrow-left"></i>
            Retour aux matières
        </a>
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

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

@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .gap-6 {
        gap: 1rem !important;
    }
    
    .p-6 {
        padding: 1rem !important;
    }
}
</style>

@push('scripts')
<script>
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
        
        checkVisibility();
        window.addEventListener('scroll', checkVisibility);
    });
</script>
@endpush
@endsection