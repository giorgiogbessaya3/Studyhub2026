{{-- resources/views/frontend/classe_detail.blade.php --}}
@extends('layouts.app')

@section('title', $classe->nom . ' - StudyHub')

@section('content')
{{-- Header avec Tabs --}}
<section class="bg-gradient-to-br from-primary-600 to-primary-800 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('classes') }}" class="text-blue-200 hover:text-white transition"><i class="fas fa-arrow-left"></i> Retour</a>
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold text-white">{{ $classe->nom }}</h1>
                <p class="text-blue-100 mt-2">Choisissez une matière pour accéder aux cours et épreuves</p>
            </div>
            
            {{-- Toggle Cours/Épreuves --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-full p-1 flex">
                <a href="{{ route('classe.detail', $classe->id) }}?type=cours" class="px-6 py-2 rounded-full text-sm font-medium transition {{ $type == 'cours' ? 'bg-white text-primary-700' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-book mr-2"></i>Cours
                </a>
                <a href="{{ route('classe.detail', $classe->id) }}?type=epreuves" class="px-6 py-2 rounded-full text-sm font-medium transition {{ $type == 'epreuves' ? 'bg-white text-primary-700' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-file-alt mr-2"></i>Épreuves
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Matières Grid --}}
<section class="py-16 bg-gray-50 -mt-8 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($matieres->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($matieres as $matiere)
            <a href="{{ route('matiere.detail', $matiere->id) }}?classe={{ $classe->id }}" class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-{{ $matiere->couleur ?? 'blue' }}-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        @if($matiere->icone)
                        <i class="fas {{ $matiere->icone }} text-{{ $matiere->couleur ?? 'blue' }}-600 text-2xl"></i>
                        @else
                        <span class="font-bold text-{{ $matiere->couleur ?? 'blue' }}-600 text-lg">{{ substr($matiere->nom, 0, 2) }}</span>
                        @endif
                    </div>
                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $type == 'cours' ? ($matiere->chapitres_count ?? '12') . ' chapitres' : '45 épreuves' }}
                    </span>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-primary-600 transition-colors">{{ $matiere->nom }}</h3>
                <p class="text-gray-500 text-sm line-clamp-2">{{ $matiere->description ?? 'Cours et épreuves complets pour cette matière' }}</p>
                <div class="mt-4 flex items-center text-primary-600 font-medium text-sm">
                    <span>Explorer</span>
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-3xl shadow-sm">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-2">Aucune matière disponible</h3>
            <p class="text-gray-500">Les matières seront bientôt ajoutées pour cette classe.</p>
        </div>
        @endif
    </div>
</section>
@endsection