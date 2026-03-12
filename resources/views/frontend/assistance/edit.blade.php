@extends('layouts.app')

@section('title', 'Modifier ma question - StudyHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- En-tête -->
    <div class="mb-8" data-aos="fade-up">
        <h1 class="text-3xl font-display font-bold text-slate-900 mb-4">Modifier ma question</h1>
        <p class="text-slate-600">
            Vous pouvez modifier votre question tant qu'elle n'a pas encore été publiée.
        </p>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('assistance.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Titre -->
            <div class="mb-6">
                <label for="titre" class="block text-sm font-medium text-slate-700 mb-2">
                    Titre de la question <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="titre" 
                       id="titre" 
                       value="{{ old('titre', $question->titre) }}"
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-colors"
                       required>
                @error('titre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Classe -->
                <div>
                    <label for="classe_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Classe <span class="text-red-500">*</span>
                    </label>
                    <select name="classe_id" 
                            id="classe_id" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-colors"
                            required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id', $question->classe_id) == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Matière -->
                <div>
                    <label for="matiere_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Matière <span class="text-red-500">*</span>
                    </label>
                    <select name="matiere_id" 
                            id="matiere_id" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-colors"
                            required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ old('matiere_id', $question->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('matiere_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contenu -->
            <div class="mb-6">
                <label for="contenu" class="block text-sm font-medium text-slate-700 mb-2">
                    Description détaillée <span class="text-red-500">*</span>
                </label>
                <textarea name="contenu" 
                          id="contenu" 
                          rows="8"
                          class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-colors"
                          required>{{ old('contenu', $question->contenu) }}</textarea>
                @error('contenu')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image actuelle -->
            @if($question->image)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Image actuelle
                    </label>
                    <img src="{{ Storage::url($question->image) }}" alt="Image jointe" class="max-h-48 rounded-lg">
                </div>
            @endif

            <!-- Nouvelle image -->
            <div class="mb-8">
                <label for="image" class="block text-sm font-medium text-slate-700 mb-2">
                    @if($question->image)
                        Changer l'image (optionnel)
                    @else
                        Ajouter une image (optionnelle)
                    @endif
                </label>
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                     onclick="document.getElementById('image').click()">
                    <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-3"></i>
                    <p class="text-slate-600 mb-1">Cliquez pour ajouter une image</p>
                    <p class="text-xs text-slate-400">PNG, JPG, GIF jusqu'à 2 Mo</p>
                </div>
                <input type="file" 
                       name="image" 
                       id="image" 
                       class="hidden" 
                       accept="image/*"
                       onchange="previewImage(this)">
                <div id="imagePreview" class="mt-4 hidden">
                    <img src="" alt="Aperçu" class="max-h-48 rounded-lg">
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex items-center gap-4">
                <button type="submit" 
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('assistance.show', $question->id) }}" 
                   class="px-6 py-3 border border-slate-300 rounded-xl text-slate-700 hover:bg-slate-50 transition-colors">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection