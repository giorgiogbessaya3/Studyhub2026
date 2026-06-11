@extends('layouts.app')

@section('title', $quiz->titre . ' - StudyHub')

@section('content')

@php
    $totalPoints    = $quiz->questions->sum('points');
    $nbTentatives   = $quiz->nombre_tentatives;
    $scoreMoyen     = $quiz->score_moyen;
    $pourcentageDernierScore = ($dernierResultat && $totalPoints > 0)
        ? round(($dernierResultat->score / $totalPoints) * 100)
        : 0;
    $reussi = $pourcentageDernierScore >= $quiz->score_passer;
@endphp

{{-- ═══════════ HERO ═══════════ --}}
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20"
         style="background-image:radial-gradient(circle at 1px 1px,white 1px,transparent 0);background-size:40px 40px"></div>
    <div class="absolute top-10 left-10 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-0 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>

    <div class="container mx-auto px-4 relative z-10 py-10 md:py-14">

        {{-- Fil d'Ariane --}}
        <div class="flex items-center gap-2 text-xs text-white/50 mb-6 flex-wrap">
            <a href="{{ url('/') }}" class="hover:text-white/80 transition-colors">Accueil</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ url('quiz') }}" class="hover:text-white/80 transition-colors">Quiz</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-white/80 truncate max-w-[200px]">{{ $quiz->titre }}</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-end gap-6">
            <div class="flex-1">
                {{-- Badges --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 bg-primary-500/30 backdrop-blur border border-primary-400/30 text-primary-200 text-xs font-medium px-3 py-1 rounded-full">
                        <i class="fas fa-layer-group text-[10px]"></i>
                        {{ $quiz->classe->nom }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur border border-white/10 text-white/80 text-xs font-medium px-3 py-1 rounded-full">
                        <i class="fas fa-book text-[10px]"></i>
                        {{ $quiz->matiere->nom }}
                    </span>
                    @if($quiz->chapitre)
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur border border-white/10 text-white/80 text-xs font-medium px-3 py-1 rounded-full">
                        <i class="fas fa-bookmark text-[10px]"></i>
                        {{ $quiz->chapitre->titre }}
                    </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                    {{ $quiz->titre }}
                </h1>

                @if($quiz->description)
                <p class="text-white/70 text-sm sm:text-base leading-relaxed max-w-2xl">
                    {{ Str::limit($quiz->description, 180) }}
                </p>
                @endif
            </div>

            {{-- Métriques hero --}}
            <div class="flex flex-wrap gap-3 lg:flex-shrink-0">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-xl px-4 py-3 text-center min-w-[80px]">
                    <div class="text-xl font-bold text-white">{{ $quiz->questions->count() }}</div>
                    <div class="text-white/60 text-xs mt-0.5">Questions</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-xl px-4 py-3 text-center min-w-[80px]">
                    <div class="text-xl font-bold text-white">{{ $quiz->duree_formatee }}</div>
                    <div class="text-white/60 text-xs mt-0.5">Durée</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-xl px-4 py-3 text-center min-w-[80px]">
                    <div class="text-xl font-bold text-white">{{ $totalPoints }}</div>
                    <div class="text-white/60 text-xs mt-0.5">Points</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-xl px-4 py-3 text-center min-w-[80px]">
                    <div class="text-xl font-bold text-white">{{ $nbTentatives }}</div>
                    <div class="text-white/60 text-xs mt-0.5">Tentatives</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ CONTENU ═══════════ --}}
<section class="py-8 md:py-12 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 max-w-6xl mx-auto">

            {{-- ── Colonne principale ── --}}
            <div class="flex-1 min-w-0 order-2 lg:order-1">

                {{-- Description complète --}}
                @if($quiz->description)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                    <h2 class="text-base font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-align-left text-primary-600 text-xs"></i>
                        </span>
                        À propos de ce quiz
                    </h2>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $quiz->description }}</p>
                </div>
                @endif

                {{-- Règles du quiz --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                    <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-yellow-600 text-xs"></i>
                        </span>
                        Règles du quiz
                    </h2>
                    <div class="space-y-3">
                        @foreach([
                            ['fas fa-question-circle','blue', 'Le quiz contient <strong>'.$quiz->questions->count().' questions</strong> à choix multiples.'],
                            ['fas fa-clock','orange',          'Vous disposez de <strong>'.$quiz->duree_formatee.'</strong> pour compléter le quiz.'],
                            ['fas fa-star','yellow',           'Chaque bonne réponse rapporte des points. Total : <strong>'.$totalPoints.' pts</strong>.'],
                            ['fas fa-trophy','green',          'Score minimum pour réussir : <strong>'.$quiz->score_passer.'%</strong>.'],
                            ['fas fa-redo','purple',           'Vous pouvez repasser le quiz autant de fois que vous voulez.'],
                        ] as [$icon, $color, $text])
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-{{ $color }}-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="{{ $icon }} text-{{ $color }}-600 text-xs"></i>
                            </span>
                            <p class="text-slate-600 text-sm leading-relaxed">{!! $text !!}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Statistiques globales --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                    <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-indigo-600 text-xs"></i>
                        </span>
                        Statistiques
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-primary-600">{{ $nbTentatives }}</div>
                            <div class="text-xs text-slate-500 mt-1">Tentatives totales</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-primary-600">
                                {{ $nbTentatives > 0 ? $scoreMoyen.'%' : '—' }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">Score moyen</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center col-span-2 sm:col-span-1">
                            <div class="text-2xl font-bold text-primary-600">{{ $quiz->score_passer }}%</div>
                            <div class="text-xs text-slate-500 mt-1">Score requis</div>
                        </div>
                    </div>

                    @if($nbTentatives > 0)
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                            <span>Score moyen</span>
                            <span>{{ $scoreMoyen }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-500
                                {{ $scoreMoyen >= $quiz->score_passer ? 'bg-green-500' : 'bg-orange-400' }}"
                                 style="width:{{ min($scoreMoyen, 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            {{-- ── Carte d'action (sticky) ── --}}
            <div class="w-full lg:w-80 xl:w-96 flex-shrink-0 order-1 lg:order-2">
                <div class="lg:sticky lg:top-24">

                    @auth
                        @if($dejaParticipe)
                        {{-- État : déjà participé --}}
                        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                            <div class="h-1.5 {{ $reussi ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gradient-to-r from-orange-400 to-red-400' }}"></div>
                            <div class="p-6">
                                <div class="text-center mb-6">
                                    {{-- Cercle de score --}}
                                    <div class="relative inline-flex items-center justify-center mb-3">
                                        <svg class="w-28 h-28 -rotate-90" viewBox="0 0 36 36">
                                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f1f5f9" stroke-width="3"/>
                                            <circle cx="18" cy="18" r="15.9" fill="none"
                                                    stroke="{{ $reussi ? '#22c55e' : '#f97316' }}"
                                                    stroke-width="3"
                                                    stroke-dasharray="{{ $pourcentageDernierScore }}, 100"
                                                    stroke-linecap="round"/>
                                        </svg>
                                        <div class="absolute flex flex-col items-center">
                                            <span class="text-2xl font-bold {{ $reussi ? 'text-green-600' : 'text-orange-500' }}">
                                                {{ $pourcentageDernierScore }}%
                                            </span>
                                            <span class="text-[10px] text-slate-400">score</span>
                                        </div>
                                    </div>

                                    <div class="font-bold text-slate-800 text-lg mb-1">
                                        {{ $dernierResultat->score }} / {{ $totalPoints }} pts
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full
                                        {{ $reussi ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        <i class="fas {{ $reussi ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $reussi ? 'Réussi !' : 'Échoué' }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <a href="{{ url('quiz/'.$quiz->id.'/start') }}"
                                       class="flex items-center justify-center gap-2 w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 text-sm">
                                        <i class="fas fa-redo"></i> Refaire le quiz
                                    </a>
                                    <a href="{{ url('quiz/'.$quiz->id.'/result/'.$dernierResultat->id) }}"
                                       class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors text-sm">
                                        <i class="fas fa-chart-bar"></i> Voir mes résultats
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                                    <p class="text-xs text-slate-400">
                                        Score minimum requis : <strong class="text-slate-600">{{ $quiz->score_passer }}%</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @else
                        {{-- État : prêt à commencer --}}
                        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                            <div class="h-1.5 bg-gradient-to-r from-primary-500 to-primary-700"></div>
                            <div class="p-6">
                                <h3 class="font-bold text-slate-800 text-lg mb-1 text-center">Prêt à commencer ?</h3>
                                <p class="text-slate-500 text-xs text-center mb-6">Assurez-vous d'être disponible pendant toute la durée.</p>

                                {{-- Stats résumé --}}
                                <div class="grid grid-cols-3 gap-2 mb-6">
                                    <div class="bg-primary-50 rounded-xl p-3 text-center">
                                        <div class="text-lg font-bold text-primary-700">{{ $quiz->questions->count() }}</div>
                                        <div class="text-[10px] text-primary-500 mt-0.5">Questions</div>
                                    </div>
                                    <div class="bg-orange-50 rounded-xl p-3 text-center">
                                        <div class="text-lg font-bold text-orange-600">{{ $quiz->duree_formatee }}</div>
                                        <div class="text-[10px] text-orange-400 mt-0.5">Durée</div>
                                    </div>
                                    <div class="bg-green-50 rounded-xl p-3 text-center">
                                        <div class="text-lg font-bold text-green-600">{{ $quiz->score_passer }}%</div>
                                        <div class="text-[10px] text-green-500 mt-0.5">Minimum</div>
                                    </div>
                                </div>

                                {{-- Checklist avant de commencer --}}
                                <div class="bg-slate-50 rounded-xl p-4 mb-6 space-y-2">
                                    @foreach([
                                        'Connexion internet stable',
                                        'Environnement calme',
                                        'Cours révisés',
                                    ] as $item)
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class="fas fa-check text-green-500 text-[10px]"></i>
                                        {{ $item }}
                                    </div>
                                    @endforeach
                                </div>

                                <a href="{{ url('quiz/'.$quiz->id.'/start') }}"
                                   class="flex items-center justify-center gap-2 w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 text-sm">
                                    <i class="fas fa-play"></i> Commencer le quiz
                                </a>
                            </div>
                        </div>
                        @endif

                    @else
                    {{-- État : non connecté --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                        <div class="h-1.5 bg-gradient-to-r from-slate-400 to-slate-500"></div>
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-lock text-slate-500 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-2">Connexion requise</h3>
                            <p class="text-slate-500 text-sm mb-6 leading-relaxed">
                                Vous devez être connecté pour participer à ce quiz et sauvegarder vos résultats.
                            </p>
                            <div class="space-y-3">
                                <a href="{{ route('login') }}"
                                   class="flex items-center justify-center gap-2 w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all hover:shadow-lg text-sm">
                                    <i class="fas fa-sign-in-alt"></i> Se connecter
                                </a>
                                <a href="{{ route('register') }}"
                                   class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors text-sm">
                                    <i class="fas fa-user-plus"></i> Créer un compte gratuit
                                </a>
                            </div>
                        </div>
                    </div>
                    @endauth

                    {{-- Lien retour --}}
                    <div class="mt-4 text-center">
                        <a href="{{ url('quiz') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-arrow-left text-xs"></i> Retour aux quiz
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<style>
.animation-delay-2000 { animation-delay: 2s; }
</style>

@endsection
