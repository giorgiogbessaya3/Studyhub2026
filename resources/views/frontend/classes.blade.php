{{-- resources/views/frontend/classes.blade.php --}}
@extends('layouts.app')

@section('title', 'Classes - StudyHub')

@section('content')
<!-- Header Section -->
<section class="relative py-20 bg-gradient-to-br from-primary-600 to-primary-900 overflow-hidden">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="fade-up">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">Choisissez votre classe</h1>
        <p class="text-xl text-primary-100 max-w-2xl mx-auto">Accédez aux ressources pédagogiques adaptées à votre niveau scolaire.</p>
    </div>
</section>

<!-- Classes Grid -->
<section class="py-16 bg-slate-50 -mt-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Collège -->
        <div class="mb-16" data-aos="fade-up">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-school text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-display text-2xl font-bold text-slate-900">Collège</h2>
                    <p class="text-slate-600">Du sixième à la troisième</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($classesByCycle['college'] ?? $classes->filter(fn($c) => in_array($c->nom, ['6ème', '5ème', '4ème', '3ème'])) as $classe)
                <a href="{{ route('classe.detail', $classe->id) }}?type={{ request('type', 'cours') }}" 
                   class="group relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-2xl font-bold text-orange-600 transform group-hover:scale-110 transition-transform">
                                {{ substr($classe->nom, 0, 2) }}e
                            </div>
                            @if($classe->nom == '3ème')
                            <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full font-semibold">Brevet</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-xl text-slate-900 mb-2">{{ $classe->nom }}</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ $classe->description ?? 'Cours et épreuves pour la ' . $classe->nom }}</p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <span class="text-sm text-slate-500">
                                <i class="fas fa-book mr-1 text-orange-500"></i>
                                {{ $classe->matieres_count ?? rand(8, 12) }} matières
                            </span>
                            <i class="fas fa-arrow-right text-slate-300 group-hover:text-orange-500 transform group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Lycée -->
        <div class="mb-16" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-university text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-display text-2xl font-bold text-slate-900">Lycée Général</h2>
                    <p class="text-slate-600">Seconde, Première et Terminale</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($classesByCycle['lycee'] ?? $classes->filter(fn($c) => in_array($c->nom, ['Seconde', 'Première', 'Terminale'])) as $classe)
                <a href="{{ route('classe.detail', $classe->id) }}?type={{ request('type', 'cours') }}" 
                   class="group relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 {{ $classe->nom == 'Terminale' ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600' }} rounded-2xl flex items-center justify-center text-xl font-bold transform group-hover:scale-110 transition-transform">
                                {{ $classe->nom == 'Seconde' ? '2nd' : ($classe->nom == 'Première' ? '1re' : 'Tle') }}
                            </div>
                            @if($classe->nom == 'Terminale')
                            <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full font-semibold">Bac</span>
                            @elseif($classe->nom == 'Première')
                            <span class="bg-indigo-100 text-indigo-600 text-xs px-3 py-1 rounded-full font-semibold">Spécialités</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-xl text-slate-900 mb-2">{{ $classe->nom }}</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ $classe->description ?? 'Préparation complète pour la ' . $classe->nom }}</p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <span class="text-sm text-slate-500">
                                <i class="fas fa-graduation-cap mr-1 text-blue-500"></i>
                                {{ $classe->matieres_count ?? rand(10, 15) }} matières
                            </span>
                            <i class="fas fa-arrow-right text-slate-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Filières Technologiques -->
        <div data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-laptop-code text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-display text-2xl font-bold text-slate-900">Filières Technologiques</h2>
                    <p class="text-slate-600">STI2D, STMG, STL et plus</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(['STI2D', 'STMG', 'STL', 'ST2S'] as $filiere)
                <a href="{{ route('classe.detail', $filiere) }}?type={{ request('type', 'cours') }}" 
                   class="group relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-transform">
                            <span class="text-xl font-bold text-purple-600">{{ $filiere }}</span>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $filiere }}</h3>
                        <p class="text-slate-500 text-sm">Ressources complètes</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endsection