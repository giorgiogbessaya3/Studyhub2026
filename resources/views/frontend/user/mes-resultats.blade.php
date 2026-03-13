@extends('layouts.app')

@section('title', 'Mes résultats - StudyHub')
@section('page-title', 'Mes résultats')

@section('content')
<!-- Hero Section - Style identique à la page des cours -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[200px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                <i class="fas fa-chart-bar mr-2"></i>
                Historique
            </span>
            
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Mes résultats
            </h1>
            
            <p class="text-white/80 text-base md:text-lg">
                Consultez l'historique de vos participations aux quiz
            </p>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Statistiques rapides - Style cartes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total quiz</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Quiz réussis</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['reussites'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Score moyen</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['score_moyen'] }}%</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Taux de réussite</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $stats['total'] > 0 ? round(($stats['reussites'] / $stats['total']) * 100) : 0 }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-percent text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres - Style épuré -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <form method="GET" action="{{ url('/mes-resultats') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="quiz_id" class="block text-sm font-medium text-gray-700 mb-2">Quiz</label>
                <select name="quiz_id" id="quiz_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous les quiz</option>
                    @foreach($quizs as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ $quiz->titre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select name="statut" id="statut" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous</option>
                    <option value="reussi" {{ request('statut') == 'reussi' ? 'selected' : '' }}>Réussi</option>
                    <option value="echoue" {{ request('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                </select>
            </div>

            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}" 
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>

            <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                <div class="flex gap-2">
                    <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}" 
                           class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <button type="submit" class="px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-filter"></i>
                    </button>
                    @if(request()->anyFilled(['quiz_id', 'statut', 'date_debut', 'date_fin']))
                        <a href="{{ url('/mes-resultats') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des résultats - Style tableau moderne -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($resultats->isEmpty())
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-primary-50 flex items-center justify-center">
                    <i class="fas fa-chart-bar text-3xl text-primary-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun résultat</h3>
                <p class="text-gray-500 mb-6">Vous n'avez pas encore participé à des quiz.</p>
                <a href="{{ url('/quiz') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-play mr-2"></i>
                    Commencer un quiz
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Quiz</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Classe</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Matière</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Score</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Résultat</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Temps</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($resultats as $resultat)
                            @php
                                $totalQuestions = $resultat->quiz->questions->count();
                                $pourcentage = $totalQuestions > 0 ? round(($resultat->score / $totalQuestions) * 100, 1) : 0;
                                $seuilReussite = $resultat->quiz->score_passer ?? 50;
                                $estReussi = $pourcentage >= $seuilReussite;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ url('/quiz/' . $resultat->quiz_id) }}" class="font-medium text-gray-800 hover:text-primary-600 transition-colors">
                                        {{ $resultat->quiz->titre }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $resultat->quiz->classe->nom ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $resultat->quiz->matiere->nom ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-800">{{ $resultat->score }}/{{ $totalQuestions }}</span>
                                        <span class="text-xs text-gray-500">({{ $pourcentage }}%)</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($estReussi)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i> Réussi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1 text-xs"></i> Échoué
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-sm text-gray-600">
                                    @php
                                        $minutes = floor($resultat->temps_ecoule / 60);
                                        $secondes = $resultat->temps_ecoule % 60;
                                    @endphp
                                    {{ $minutes }}:{{ str_pad($secondes, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $resultat->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ url('/mes-resultats/' . $resultat->id) }}" 
                                           class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors"
                                           title="Voir le détail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ url('/quiz/' . $resultat->quiz_id) }}" 
                                           class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 hover:bg-green-700 hover:text-white transition-colors"
                                           title="Refaire le quiz">
                                            <i class="fas fa-redo-alt text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($resultats->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $resultats->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<style>
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
</style>

@push('scripts')
<script>
    // Animation au scroll simplifiée
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
        
        // Initial check
        checkVisibility();
        
        // Check on scroll
        window.addEventListener('scroll', checkVisibility);
    });
</script>
@endpush
@endsection