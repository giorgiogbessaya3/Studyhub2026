{{-- resources/views/frontend/chapitre_detail.blade.php --}}
@extends('layouts.app')

@section('title', $chapitre->titre . ' - StudyHub')

@section('content')
{{-- Header Chapitre avec dégradé bleu --}}
<section class="bg-gradient-to-br from-blue-600 to-blue-800 py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-white/70 text-sm mb-4">
            <a href="{{ route('classe.detail', $chapitre->classe->id) }}" class="hover:text-white transition">{{ $chapitre->classe->nom }}</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('matiere.detail', $chapitre->matiere->id) }}?classe={{ $chapitre->classe->id }}" class="hover:text-white transition">{{ $chapitre->matiere->nom }}</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-white">Chapitre {{ $chapitre->ordre }}</span>
        </div>
        
        <h1 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">{{ $chapitre->titre }}</h1>
        <p class="text-blue-100 max-w-3xl">{{ $chapitre->description ?? 'Aucune description disponible' }}</p>
    </div>
</section>

{{-- Navigation Précédent/Suivant --}}
<div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            @if($chapitrePrecedent)
            <a href="{{ route('chapitre.detail', $chapitrePrecedent->id) }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition group">
                <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform"></i>
                <div class="hidden sm:block text-left">
                    <span class="text-xs text-gray-400 block">Précédent</span>
                    <span class="font-medium text-sm truncate max-w-[150px] block">{{ $chapitrePrecedent->titre }}</span>
                </div>
            </a>
            @else
            <div></div>
            @endif
            
            <span class="text-gray-400 text-sm font-medium">Chapitre {{ $chapitre->ordre }}</span>
            
            @if($chapitreSuivant)
            <a href="{{ route('chapitre.detail', $chapitreSuivant->id) }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition group">
                <div class="hidden sm:block text-right">
                    <span class="text-xs text-gray-400 block">Suivant</span>
                    <span class="font-medium text-sm truncate max-w-[150px] block">{{ $chapitreSuivant->titre }}</span>
                </div>
                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
            </a>
            @else
            <div></div>
            @endif
        </div>
    </div>
</div>

{{-- Contenu du Chapitre --}}
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @forelse($contenus as $index => $contenu)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
            {{-- En-tête du contenu avec numéro --}}
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                <div class="flex items-center gap-3">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        {{ $index + 1 }}
                    </span>
                    <h2 class="font-display text-2xl font-bold text-gray-900">{{ $contenu->titre }}</h2>
                </div>
            </div>
            
            {{-- Images en galerie --}}
            @if($contenu->images && count($contenu->images) > 0)
            <div class="p-6 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-images text-blue-600"></i>
                    <span class="font-medium text-gray-700">Illustrations</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($contenu->images as $image)
                    <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                        <img src="{{ asset('storage/' . $image) }}" alt="Illustration" class="rounded-xl w-full h-64 object-cover shadow-md group-hover:shadow-lg transition-all">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-xl flex items-center justify-center">
                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity text-2xl"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- Résumé/Cours avec mise en forme --}}
            <div class="p-6 prose prose-blue max-w-none">
                @if($contenu->resume)
                    <div class="leading-relaxed text-gray-700">
                        {!! nl2br(e($contenu->resume)) !!}
                    </div>
                @else
                    <p class="text-gray-400 italic">Aucun contenu texte pour cette section.</p>
                @endif
            </div>
            
            {{-- Exercices avec révélation --}}
            @if($contenu->exercices && count($contenu->exercices) > 0)
            <div class="p-6 bg-blue-50 border-t border-blue-100">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-pencil-alt text-blue-600"></i>
                    <h3 class="font-bold text-blue-800">Exercices d'application</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($contenu->exercices as $exIndex => $exercice)
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-blue-100 exercice-card" data-exercice="{{ $exIndex }}">
                        <div class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ $exIndex + 1 }}
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 mb-3">{{ $exercice['question'] }}</p>
                                
                                @if(isset($exercice['reponse']))
                                <button onclick="toggleReponse({{ $exIndex }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 mb-2">
                                    <i class="fas fa-eye" id="icon-{{ $exIndex }}"></i>
                                    <span id="btn-text-{{ $exIndex }}">Voir la réponse</span>
                                </button>
                                
                                <div id="reponse-{{ $exIndex }}" class="hidden mt-3 p-4 bg-green-50 rounded-lg border border-green-200 animate-slideDown">
                                    <p class="text-sm text-green-800">
                                        <span class="font-semibold">Réponse :</span> 
                                        {{ $exercice['reponse'] }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- Boutons d'action pour le contenu --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span><i class="far fa-clock mr-1"></i> {{ $contenu->created_at->format('d/m/Y') }}</span>
                    @if($contenu->exercices && count($contenu->exercices) > 0)
                    <span><i class="fas fa-pencil-alt mr-1"></i> {{ count($contenu->exercices) }} exercice(s)</span>
                    @endif
                </div>
                
                @if($loop->last && $chapitreSuivant)
                <a href="{{ route('chapitre.detail', $chapitreSuivant->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center gap-2">
                    Chapitre suivant
                    <i class="fas fa-arrow-right"></i>
                </a>
                @endif
            </div>
        </div>
        @empty
        {{-- État vide --}}
        <div class="text-center py-16 bg-white rounded-3xl shadow-sm">
            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-alt text-blue-600 text-4xl"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-2">Contenu en cours de rédaction</h3>
            <p class="text-gray-500 mb-6">Ce chapitre n'a pas encore de contenu. Reviens plus tard !</p>
            
            @if($chapitreSuivant)
            <a href="{{ route('chapitre.detail', $chapitreSuivant->id) }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition inline-flex items-center gap-2">
                Passer au chapitre suivant
                <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
        @endforelse
        
        {{-- Navigation en bas de page --}}
        @if($contenus->count() > 0)
        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
            @if($chapitrePrecedent)
            <a href="{{ route('chapitre.detail', $chapitrePrecedent->id) }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Chapitre précédent
            </a>
            @else
            <div></div>
            @endif
            
            <a href="{{ route('matiere.detail', $chapitre->matiere->id) }}?classe={{ $chapitre->classe->id }}" class="bg-blue-50 text-blue-600 px-6 py-3 rounded-xl hover:bg-blue-100 transition">
                Retour à la liste
            </a>
            
            @if($chapitreSuivant)
            <a href="{{ route('chapitre.detail', $chapitreSuivant->id) }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
                Chapitre suivant
                <i class="fas fa-arrow-right"></i>
            </a>
            @else
            <div></div>
            @endif
        </div>
        @endif
    </div>
</section>

{{-- Modal pour agrandir les images --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center" onclick="closeImageModal()">
    <div class="relative max-w-4xl w-full mx-4" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Image agrandie" class="w-full h-auto rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-white bg-opacity-20 text-white w-10 h-10 rounded-full hover:bg-opacity-30 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

@endsection

@push('styles')
<style>
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .prose {
        line-height: 1.8;
    }
    
    .prose p {
        margin-bottom: 1.2rem;
    }
    
    .exercice-card {
        transition: all 0.3s;
    }
    
    .exercice-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }
    
    #imageModal {
        backdrop-filter: blur(5px);
        transition: opacity 0.3s;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction pour afficher/masquer les réponses des exercices
    function toggleReponse(index) {
        const reponseDiv = document.getElementById(`reponse-${index}`);
        const icon = document.getElementById(`icon-${index}`);
        const btnText = document.getElementById(`btn-text-${index}`);
        
        if (reponseDiv.classList.contains('hidden')) {
            reponseDiv.classList.remove('hidden');
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            btnText.textContent = 'Masquer la réponse';
        } else {
            reponseDiv.classList.add('hidden');
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            btnText.textContent = 'Voir la réponse';
        }
    }
    
    // Fonction pour ouvrir le modal d'image
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Empêcher le scroll du body
        document.body.style.overflow = 'hidden';
    }
    
    // Fonction pour fermer le modal d'image
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Réactiver le scroll du body
        document.body.style.overflow = 'auto';
    }
    
    // Fermer le modal avec la touche Echap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    
    // Animation smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Marquer comme lu (optionnel)
    function markAsRead(contentId) {
        // Envoyer une requête AJAX pour marquer le contenu comme lu
        fetch(`/api/contenu/${contentId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
    }
</script>
@endpush