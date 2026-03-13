@extends('layouts.app')

@section('title', 'Mes questions - StudyHub')
@section('page-title', 'Mes questions')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-800">Mes questions</h1>
            <p class="text-slate-600">Gérez toutes vos questions posées dans l'assistance</p>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total questions</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $questions->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-question text-primary-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Questions publiées</p>
                        <p class="text-2xl font-bold text-green-600">{{ $questions->where('publie', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">En attente</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $questions->where('publie', false)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total réponses</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $questions->sum(function($q) { return $q->reponses->count(); }) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-reply text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ url('/mes-questions') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filtre par statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-slate-700 mb-2">Statut</label>
                    <select name="statut" id="statut" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Tous</option>
                        <option value="publie" {{ request('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <!-- Filtre par classe -->
                <div>
                    <label for="classe_id" class="block text-sm font-medium text-slate-700 mb-2">Classe</label>
                    <select name="classe_id" id="classe_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre par matière -->
                <div>
                    <label for="matiere_id" class="block text-sm font-medium text-slate-700 mb-2">Matière</label>
                    <select name="matiere_id" id="matiere_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Recherche et boutons -->
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">Recherche</label>
                    <div class="flex gap-2">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Titre de la question..." 
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request()->anyFilled(['statut', 'classe_id', 'matiere_id', 'search']))
                            <a href="{{ url('/mes-questions') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Liste des questions -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            @if($questions->isEmpty())
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">❓</div>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">Aucune question</h3>
                    <p class="text-slate-500 mb-6">Vous n'avez pas encore posé de question dans l'assistance.</p>
                    <a href="{{ url('/assistance/poser') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Poser une question
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Question</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Classe</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Matière</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Statut</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Réponses</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($questions as $question)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <a href="{{ url('/assistance/question/' . $question->id) }}" class="font-medium text-slate-800 hover:text-primary-600 transition-colors line-clamp-2">
                                            {{ $question->titre }}
                                        </a>
                                        @if(strlen($question->description) > 100)
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ Str::limit($question->description, 100) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $question->classe->nom ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $question->matiere->nom ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        @if($question->publie)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Publié
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <i class="fas fa-clock mr-1"></i> En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-comment text-slate-400"></i>
                                            <span class="font-medium text-slate-700">{{ $question->reponses->count() }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <div>{{ $question->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-slate-400">{{ $question->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ url('/assistance/question/' . $question->id) }}" 
                                               class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors"
                                               title="Voir la question">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            @if(!$question->publie)
                                                <a href="{{ url('/assistance/question/' . $question->id . '/edit') }}" 
                                                   class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
                                                   title="Modifier">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                                <button onclick="openDeleteModal({{ $question->id }}, '{{ $question->titre }}')" 
                                                        class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash text-sm"></i>
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
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                        {{ $questions->appends(request()->query())->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true"></div>
        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all my-8 align-middle max-w-lg w-full">
            <div class="bg-white p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                
                <h3 class="text-lg font-medium text-slate-900 text-center mb-2">
                    Supprimer la question ?
                </h3>
                
                <p class="text-sm text-slate-500 text-center mb-4" id="deleteQuestionTitle"></p>
                
                <p class="text-sm text-red-500 text-center mb-6">
                    Cette action est irréversible.
                </p>
                
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" 
                                onclick="closeDeleteModal()" 
                                class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    /* Style pour la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .pagination .page-item {
        list-style: none;
    }
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.5rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #4a5568;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .pagination .active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: white;
    }
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    let deleteModal = document.getElementById('deleteModal');
    let deleteForm = document.getElementById('deleteForm');
    let deleteQuestionTitle = document.getElementById('deleteQuestionTitle');

    function openDeleteModal(questionId, questionTitle) {
        deleteForm.action = '/assistance/question/' + questionId;
        deleteQuestionTitle.innerHTML = 'Êtes-vous sûr de vouloir supprimer la question : <strong>"' + questionTitle + '"</strong> ?';
        
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
        }, 300);
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    deleteModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>