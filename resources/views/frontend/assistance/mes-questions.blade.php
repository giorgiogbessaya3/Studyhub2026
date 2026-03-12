@extends('layouts.app')

@section('title', 'Mes questions - StudyHub')

@section('content')
<!-- Hero Section simplifiée -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[200px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        <div class="text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Mes questions</h1>
            <p class="text-white/80">Gérez toutes vos questions posées sur la plateforme</p>
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
<section class="max-w-7xl mx-auto px-4 py-8">
    <!-- En-tête avec bouton -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-question text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Mes questions</h2>
                <p class="text-gray-500">{{ $questions->total() }} question(s) au total</p>
            </div>
        </div>
        <a href="{{ route('assistance.create') }}" 
           class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all self-start sm:self-auto">
            <i class="fas fa-plus"></i>
            Nouvelle question
        </a>
    </div>

    @if($questions->isNotEmpty())
    <!-- Grille des questions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach($questions as $index => $question)
        @php
            // Couleurs par classe
            $colors = [
                '6ème' => ['bg' => '#3b82f6', 'gradient' => 'from-blue-600 to-blue-700', 'light' => 'bg-blue-50'],
                '5ème' => ['bg' => '#22c55e', 'gradient' => 'from-green-600 to-green-700', 'light' => 'bg-green-50'],
                '4ème' => ['bg' => '#eab308', 'gradient' => 'from-yellow-600 to-yellow-700', 'light' => 'bg-yellow-50'],
                '3ème' => ['bg' => '#f97316', 'gradient' => 'from-orange-600 to-orange-700', 'light' => 'bg-orange-50'],
                'Seconde' => ['bg' => '#8b5cf6', 'gradient' => 'from-purple-600 to-purple-700', 'light' => 'bg-purple-50'],
                'Première' => ['bg' => '#6366f1', 'gradient' => 'from-indigo-600 to-indigo-700', 'light' => 'bg-indigo-50'],
                'Terminale' => ['bg' => '#ec4899', 'gradient' => 'from-pink-600 to-pink-700', 'light' => 'bg-pink-50'],
            ];
            $color = $colors[$question->classe->nom] ?? ['bg' => '#3b82f6', 'gradient' => 'from-primary-600 to-primary-700', 'light' => 'bg-primary-50'];
            
            // Icônes par classe
            $icons = [
                '6ème' => 'fa-solid fa-6',
                '5ème' => 'fa-solid fa-5',
                '4ème' => 'fa-solid fa-4',
                '3ème' => 'fa-solid fa-3',
                'Seconde' => 'fa-solid fa-2',
                'Première' => 'fa-solid fa-1',
                'Terminale' => 'fa-solid fa-t',
            ];
            $icon = $icons[$question->classe->nom] ?? 'fa-solid fa-question';
        @endphp
        
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2" 
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
                
                <!-- Badge statut -->
                @if($question->statut == 'resolue')
                <div class="absolute top-3 right-3 bg-green-400 text-green-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                    <i class="fas fa-check-circle"></i>
                    Résolu
                </div>
                @elseif($question->statut == 'en_attente')
                <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                    <i class="fas fa-clock"></i>
                    Attente
                </div>
                @elseif($question->statut == 'publiee')
                <div class="absolute top-3 right-3 bg-blue-400 text-blue-900 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg z-10">
                    <i class="fas fa-globe"></i>
                    Publiée
                </div>
                @endif
                
                <!-- Badge classe avec icône -->
                <div class="absolute bottom-4 left-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/30 backdrop-blur rounded-xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="{{ $icon }} text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">{{ $question->classe->nom }}</h3>
                            <p class="text-xs text-white/80">{{ $question->matiere->nom }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <!-- Date et stats -->
                <div class="flex justify-between items-center mb-3 text-xs text-gray-500">
                    <span><i class="far fa-calendar mr-1"></i>{{ $question->created_at->format('d/m/Y') }}</span>
                    <div class="flex gap-2">
                        <span><i class="far fa-comment mr-1"></i>{{ $question->reponses_count ?? 0 }}</span>
                        <span><i class="far fa-eye mr-1"></i>{{ $question->views }}</span>
                    </div>
                </div>
                
                <!-- Titre -->
                <a href="{{ route('assistance.show', $question->id) }}" class="block">
                    <h4 class="font-semibold text-gray-800 hover:text-primary-600 mb-2 line-clamp-2 text-sm">
                        {{ $question->titre }}
                    </h4>
                </a>
                
                <!-- Extrait -->
                <p class="text-xs text-gray-600 mb-4 line-clamp-2">
                    {{ Str::limit(strip_tags($question->contenu), 80) }}
                </p>
                
                <!-- Actions -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('assistance.show', $question->id) }}" 
                       class="p-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                       title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    
                    @if($question->statut == 'en_attente')
                        <a href="{{ route('assistance.edit', $question->id) }}" 
                           class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endif
                    
                    <form action="{{ route('assistance.destroy', $question->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Supprimer cette question ?')"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($questions->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $questions->links() }}
    </div>
    @endif

    @else
    <!-- Message vide -->
    <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
        <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-primary-50">
            <i class="fas fa-question text-4xl text-primary-600"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune question</h3>
        <p class="text-gray-500 mb-6">Vous n'avez pas encore posé de question sur la plateforme</p>
        <a href="{{ route('assistance.create') }}" 
           class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium">
            <i class="fas fa-plus"></i>
            Poser ma première question
        </a>
    </div>
    @endif
</section>

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

/* Responsive */
@media (max-width: 640px) {
    .grid {
        gap: 1rem;
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