@extends('layouts.app')

@section('title', $question->titre . ' - StudyHub')
@section('meta_description', Str::limit(strip_tags($question->contenu), 160))

@section('content')
<!-- Hero Section simplifiée -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[200px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        <!-- Fil d'ariane -->
        <div class="flex items-center gap-2 text-sm text-white/70 mb-4">
            <a href="{{ route('assistance.index') }}" class="hover:text-white transition-colors">
                <i class="fas fa-home mr-1"></i>Accueil
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('assistance.mes-questions') }}" class="hover:text-white transition-colors">
                Mes questions
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-white truncate max-w-[200px] md:max-w-xs">{{ $question->titre }}</span>
        </div>
        
        <!-- Titre -->
        <h1 class="text-xl md:text-2xl font-bold text-white max-w-4xl line-clamp-2">
            {{ $question->titre }}
        </h1>
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
<section class="max-w-4xl mx-auto px-4 py-8">
    <!-- Carte de la question -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8 relative">
        <!-- Badge flottant pour le statut -->
        <div class="absolute -top-3 right-6">
            @if($question->statut == 'resolue')
                <span class="px-4 py-1.5 bg-green-500 text-white rounded-full text-xs font-medium shadow-lg flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i>
                    Résolu
                </span>
            @elseif($question->statut == 'en_attente')
                <span class="px-4 py-1.5 bg-yellow-500 text-white rounded-full text-xs font-medium shadow-lg flex items-center gap-1.5">
                    <i class="fas fa-clock"></i>
                    En attente
                </span>
            @elseif($question->statut == 'publiee')
                <span class="px-4 py-1.5 bg-blue-500 text-white rounded-full text-xs font-medium shadow-lg flex items-center gap-1.5">
                    <i class="fas fa-globe"></i>
                    Publiée
                </span>
            @endif
        </div>
        
        <!-- En-tête avec auteur -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($question->user->name) }}&background=3b82f6&color=fff&size=64" 
                         alt="Avatar" 
                         class="w-14 h-14 md:w-16 md:h-16 rounded-xl border-2 border-primary-200 shadow-md">
                    @if($question->user->isAdmin())
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-primary-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-crown text-white text-xs"></i>
                    </div>
                    @elseif($question->user->isEnseignant())
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-white text-xs"></i>
                    </div>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-gray-800 text-lg">{{ $question->user->name }}</p>
                        @if($question->user->isAdmin())
                            <span class="px-2 py-0.5 bg-primary-100 text-primary-700 rounded-full text-xs font-medium">Admin</span>
                        @elseif($question->user->isEnseignant())
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Enseignant</span>
                        @else
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Élève</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500 mt-1">
                        <span class="flex items-center gap-1">
                            <i class="far fa-calendar-alt"></i>
                            {{ $question->created_at->format('d M Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="far fa-clock"></i>
                            {{ $question->created_at->format('H:i') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="far fa-eye"></i>
                            {{ $question->views }} vues
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Menu actions -->
            @auth
                @if(Auth::id() === $question->user_id)
                    <div class="relative">
                        <button onclick="toggleMenu({{ $question->id }})" 
                                class="p-2.5 hover:bg-gray-100 rounded-xl transition-colors">
                            <i class="fas fa-ellipsis-v text-gray-500"></i>
                        </button>
                        <div id="menu-{{ $question->id }}" 
                             class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-20">
                            @if($question->statut == 'en_attente')
                                <a href="{{ route('assistance.edit', $question->id) }}" 
                                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 text-gray-700 text-sm transition-colors">
                                    <i class="fas fa-edit text-blue-500 w-4"></i>
                                    Modifier
                                </a>
                            @endif
                            <form action="{{ route('assistance.destroy', $question->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Supprimer cette question ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 text-red-600 text-sm transition-colors">
                                    <i class="fas fa-trash-alt w-4"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        
        <!-- Badges classe/matière -->
        <div class="flex flex-wrap gap-2 mb-5">
            <span class="px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg text-xs font-medium flex items-center gap-1.5 border border-primary-100">
                <i class="fas fa-graduation-cap"></i>
                {{ $question->classe->nom }}
            </span>
            <span class="px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-medium flex items-center gap-1.5 border border-gray-200">
                <i class="fas fa-book-open"></i>
                {{ $question->matiere->nom }}
            </span>
        </div>

        <!-- Contenu de la question -->
        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 mb-4">
            <div class="prose max-w-none text-gray-700 text-sm md:text-base leading-relaxed">
                {!! nl2br(e($question->contenu)) !!}
            </div>
        </div>

        <!-- Image si présente -->
        @if($question->image)
            <div class="mt-4">
                <div class="relative group">
                    <img src="{{ Storage::url($question->image) }}" 
                         alt="Image jointe" 
                         class="max-h-64 rounded-xl border border-gray-200 shadow-sm">
                    <a href="{{ Storage::url($question->image) }}" target="_blank" 
                       class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                        <span class="bg-white/90 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-search-plus"></i>
                            Agrandir
                        </span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Section Réponses - Style dialogue -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <!-- En-tête des réponses -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-comments text-primary-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Conversation</h2>
                    <p class="text-xs text-gray-500">{{ $question->reponses->count() }} réponse(s)</p>
                </div>
            </div>
            
            @if($question->reponses->count() > 0)
            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-200 bg-gray-50">
                <option value="recentes">Plus récentes</option>
                <option value="anciennes">Plus anciennes</option>
            </select>
            @endif
        </div>

        <!-- Timeline des réponses -->
        <div class="space-y-4 relative">
            <!-- Ligne verticale décorative -->
            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200 md:left-7"></div>
            
            @forelse($question->reponses as $index => $reponse)
            <div class="relative flex items-start gap-4 {{ $loop->first ? '' : 'mt-6' }}" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <!-- Avatar avec indicateur de rôle -->
                <div class="relative z-10">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reponse->user->name) }}&background={{ $reponse->est_solution ? '10b981' : ($reponse->user->isAdmin() ? '3b82f6' : '6b7280') }}&color=fff&size=48" 
                         alt="Avatar" 
                         class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-white shadow-md">
                    @if($reponse->est_solution)
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                    @elseif($reponse->user->isAdmin())
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-primary-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-crown text-white text-xs"></i>
                    </div>
                    @endif
                </div>
                
                <!-- Bulle de dialogue -->
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="font-semibold text-gray-800 text-sm md:text-base">
                            {{ $reponse->user->name }}
                        </span>
                        @if($reponse->est_solution)
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium flex items-center gap-1">
                                <i class="fas fa-check-circle"></i>
                                Solution
                            </span>
                        @endif
                        <span class="text-xs text-gray-400 ml-auto">
                            <i class="far fa-clock mr-1"></i>{{ $reponse->created_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    <!-- Bulle de message -->
                    <div class="relative bg-gray-50 rounded-2xl p-4 border border-gray-100 {{ $reponse->est_solution ? 'border-l-4 border-l-green-400' : '' }}">
                        <!-- Triangle de la bulle -->
                        <div class="absolute left-0 top-4 -ml-2 w-3 h-3 bg-gray-50 transform rotate-45 border-l border-t border-gray-100"></div>
                        
                        <div class="text-gray-700 text-sm md:text-base leading-relaxed">
                            {!! nl2br(e($reponse->contenu)) !!}
                        </div>
                        
                        <!-- Action solution -->
                        @auth
                            @if(Auth::id() === $question->user_id && $question->statut != 'resolue' && $reponse->statut == 'approuvee' && !$reponse->est_solution)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <form action="{{ route('assistance.solution', $reponse->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" 
                                                class="text-xs bg-green-50 hover:bg-green-100 text-green-700 px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5 transition-colors"
                                                onclick="return confirm('Marquer cette réponse comme solution ?')">
                                            <i class="fas fa-check-circle"></i>
                                            Marquer comme solution
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <!-- Message vide animé -->
            <div class="text-center py-12" data-aos="fade-up">
                <div class="relative w-32 h-32 mx-auto mb-4">
                    <div class="absolute inset-0 bg-primary-100 rounded-full animate-ping opacity-20"></div>
                    <div class="relative w-32 h-32 bg-gradient-to-br from-primary-50 to-gray-50 rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                        <i class="fas fa-comment-dots text-4xl text-primary-400"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Pas encore de réponses</h3>
                <p class="text-sm text-gray-500 mb-4 max-w-sm mx-auto">Soyez le premier à aider en répondant à cette question !</p>
                <div class="flex items-center justify-center gap-2 text-primary-600 text-sm">
                    <i class="fas fa-arrow-down animate-bounce"></i>
                    <span>Écrivez votre réponse ci-dessous</span>
                    <i class="fas fa-arrow-down animate-bounce"></i>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Formulaire de réponse - Style moderne -->
        @auth
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-reply text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Votre réponse</h3>
            </div>
            
            <form action="{{ route('assistance.reply', $question->id) }}" method="POST">
                @csrf
                <div class="relative mb-3">
                    <textarea name="contenu" 
                              rows="3" 
                              class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-100 transition-all text-sm bg-gray-50 hover:bg-white resize-none"
                              placeholder="Écrivez votre réponse..."></textarea>
                    <div class="absolute right-3 bottom-3 text-xs text-gray-400">
                        <i class="far fa-keyboard"></i>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium py-3 px-8 rounded-xl transition-all text-sm shadow-lg shadow-primary-200 flex items-center gap-2 group">
                        <span>Publier la réponse</span>
                        <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="mt-8 pt-6 border-t border-gray-200 text-center bg-gradient-to-r from-gray-50 to-white rounded-xl p-6">
            <div class="w-16 h-16 mx-auto mb-3 bg-primary-100 rounded-full flex items-center justify-center">
                <i class="fas fa-lock text-primary-600 text-xl"></i>
            </div>
            <p class="text-gray-700 mb-3 font-medium">Connectez-vous pour répondre à cette question</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-md">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </a>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-medium transition-colors border border-gray-300">
                    <i class="fas fa-user-plus"></i>
                    Créer un compte
                </a>
            </div>
        </div>
        @endauth
    </div>
    
    <!-- Bouton retour amélioré -->
    <div class="mt-8 text-center">
        <a href="{{ route('assistance.mes-questions') }}" 
           class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-600 text-sm transition-colors group">
            <span class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-primary-50 transition-colors">
                <i class="fas fa-arrow-left text-xs group-hover:text-primary-600"></i>
            </span>
            <span>Retour à mes questions</span>
        </a>
    </div>
</section>

<script>
function toggleMenu(id) {
    const menu = document.getElementById('menu-' + id);
    const isHidden = menu.classList.contains('hidden');
    
    document.querySelectorAll('[id^="menu-"]').forEach(el => {
        el.classList.add('hidden');
    });
    
    if (isHidden) {
        menu.classList.remove('hidden');
    }
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('[onclick^="toggleMenu"]') && !e.target.closest('[id^="menu-"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    line-height: 1.6;
}

/* Animation pour les bulles */
[data-aos="fade-up"] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[data-aos="fade-up"].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* Amélioration du scroll sur mobile */
@media (max-width: 640px) {
    .prose {
        font-size: 0.9rem;
    }
    
    .absolute.left-6 {
        left: 1.25rem;
    }
}
</style>
@endsection