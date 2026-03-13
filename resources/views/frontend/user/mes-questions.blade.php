@extends('layouts.app')

@section('title', 'Mes questions - StudyHub')
@section('page-title', 'Mes questions')

@section('content')
<!-- Hero Section - Compact -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 py-8 overflow-hidden">
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Mes questions</h1>
                <p class="text-white/70 text-sm mt-1">Gérez toutes vos questions posées dans l'assistance</p>
            </div>
            <a href="{{ url('/assistance/poser') }}" 
               class="inline-flex items-center px-4 py-2 bg-white text-primary-700 text-sm font-medium rounded-lg hover:bg-primary-50 transition-colors shadow-md w-fit">
                <i class="fas fa-plus mr-2"></i>Nouvelle question
            </a>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-3 py-5 md:px-4 md:py-6">
    
    <!-- Statistiques - Cartes compactes -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 md:gap-4 mb-5">
        <!-- Total questions -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Total</p>
                    <p class="text-lg md:text-xl font-bold text-gray-800">{{ $questions->total() }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-question text-primary-600 text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Publiées -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Publiées</p>
                    <p class="text-lg md:text-xl font-bold text-green-700">{{ $questions->where('publie', true)->count() }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-700 text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- En attente -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">En attente</p>
                    <p class="text-lg md:text-xl font-bold text-orange-600">{{ $questions->where('publie', false)->count() }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Réponses -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Réponses</p>
                    <p class="text-lg md:text-xl font-bold text-purple-600">
                        {{ $questions->sum(function($q) { return $q->reponses->count(); }) }}
                    </p>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-reply text-purple-600 text-sm md:text-base"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres - Design épuré -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-5 border border-gray-100">
        <form method="GET" action="{{ url('/mes-questions') }}" class="space-y-3">
            <!-- Ligne 1: filtres principaux -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <select name="statut" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white">
                        <option value="">Tous les statuts</option>
                        <option value="publie" {{ request('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <div>
                    <select name="classe_id" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white">
                        <option value="">Toutes les classes</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="matiere_id" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Ligne 2: recherche et boutons -->
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Rechercher une question..." 
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-lg transition-colors">
                    Filtrer
                </button>
                @if(request()->anyFilled(['statut', 'classe_id', 'matiere_id', 'search']))
                    <a href="{{ url('/mes-questions') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-colors">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Liste des questions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($questions->isEmpty())
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-question text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-800 mb-1">Aucune question</h3>
                <p class="text-xs text-gray-500 mb-4">Vous n'avez pas encore posé de question.</p>
                <a href="{{ url('/assistance/poser') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-xs rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Poser une question
                </a>
            </div>
        @else
            <!-- Vue mobile: cartes -->
            <div class="block md:hidden divide-y divide-gray-100">
                @foreach($questions as $question)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <a href="{{ url('/assistance/question/' . $question->id) }}" class="flex-1">
                                <h3 class="font-medium text-gray-800 text-sm line-clamp-2">{{ $question->titre }}</h3>
                            </a>
                            @if($question->publie)
                                <span class="shrink-0 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full">Publié</span>
                            @else
                                <span class="shrink-0 px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] rounded-full">En attente</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-2">
                            <span>{{ $question->classe->nom ?? 'N/A' }}</span>
                            <span>•</span>
                            <span>{{ $question->matiere->nom ?? 'N/A' }}</span>
                            <span>•</span>
                            <span><i class="far fa-comment mr-1"></i>{{ $question->reponses->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-gray-400">{{ $question->created_at->format('d/m/Y H:i') }}</span>
                            
                            <div class="flex items-center gap-1">
                                <a href="{{ url('/assistance/question/' . $question->id) }}" 
                                   class="w-7 h-7 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                @if(!$question->publie)
                                    <a href="{{ url('/assistance/question/' . $question->id . '/edit') }}" 
                                       class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <button onclick="openDeleteModal({{ $question->id }}, '{{ addslashes($question->titre) }}')" 
                                            class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Vue desktop: tableau -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Question</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Classe</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Matière</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Réponses</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($questions as $question)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <a href="{{ url('/assistance/question/' . $question->id) }}" class="font-medium text-gray-800 hover:text-primary-600 text-sm line-clamp-1">
                                        {{ $question->titre }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $question->classe->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $question->matiere->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($question->publie)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-[10px]"></i> Publié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <i class="fas fa-clock mr-1 text-[10px]"></i> En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                        <i class="fas fa-comment text-gray-400 text-xs"></i>
                                        {{ $question->reponses->count() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $question->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ url('/assistance/question/' . $question->id) }}" 
                                           class="w-7 h-7 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors"
                                           title="Voir">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        @if(!$question->publie)
                                            <a href="{{ url('/assistance/question/' . $question->id . '/edit') }}" 
                                               class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <button onclick="openDeleteModal({{ $question->id }}, '{{ addslashes($question->titre) }}')" 
                                                    class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors"
                                                    title="Supprimer">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($questions->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $questions->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal de confirmation - Version mobile friendly -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="min-h-screen px-3 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mx-auto mb-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                
                <h3 class="text-base font-semibold text-gray-900 text-center mb-1">
                    Supprimer la question ?
                </h3>
                
                <p class="text-xs text-gray-500 text-center mb-3" id="deleteQuestionTitle"></p>
                
                <p class="text-xs text-red-500 text-center mb-4">
                    Cette action est irréversible.
                </p>
                
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    
                    <div class="flex gap-2">
                        <button type="button" 
                                onclick="closeDeleteModal()" 
                                class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="flex-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg transition-colors flex items-center justify-center gap-1">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

@push('scripts')
<script>
    let deleteModal = document.getElementById('deleteModal');
    let deleteForm = document.getElementById('deleteForm');
    let deleteQuestionTitle = document.getElementById('deleteQuestionTitle');

    function openDeleteModal(questionId, questionTitle) {
        deleteForm.action = '/assistance/question/' + questionId;
        deleteQuestionTitle.innerHTML = 'Question : <strong>"' + questionTitle + '"</strong>';
        
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }

    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close on outside click
    deleteModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection