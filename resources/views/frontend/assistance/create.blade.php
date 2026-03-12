@extends('layouts.app')

@section('title', 'Poser une question - StudyHub')

@section('content')
<!-- Hero Section simplifiée -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[150px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10 py-8">
        <div class="text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Poser une question</h1>
            <p class="text-white/80 text-sm md:text-base">Décrivez votre problème en détail</p>
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

<!-- Formulaire -->
<section class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <!-- En-tête du formulaire -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-question text-white"></i>
                </div>
                <div>
                    <h2 class="text-white font-semibold">Nouvelle question</h2>
                    <p class="text-white/80 text-xs">Tous les champs marqués d'une * sont obligatoires</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('assistance.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf

            <!-- Titre -->
            <div class="mb-6">
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-heading text-primary-500 mr-1"></i>
                    Titre de la question <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           name="titre" 
                           id="titre" 
                           value="{{ old('titre') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all pl-11"
                           placeholder="ex: Comment résoudre une équation du second degré ?"
                           required>
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-question-circle"></i>
                    </div>
                </div>
                @error('titre')
                    <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Classe -->
                <div>
                    <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-graduation-cap text-primary-500 mr-1"></i>
                        Classe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="classe_id" 
                                id="classe_id" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all appearance-none bg-white pl-11"
                                required>
                            <option value="" class="text-gray-400">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    @error('classe_id')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Matière -->
                <div>
                    <label for="matiere_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book-open text-primary-500 mr-1"></i>
                        Matière <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="matiere_id" 
                                id="matiere_id" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all appearance-none bg-white pl-11"
                                required>
                            <option value="" class="text-gray-400">Sélectionner une matière</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    @error('matiere_id')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Contenu -->
            <div class="mb-6">
                <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left text-primary-500 mr-1"></i>
                    Description détaillée <span class="text-red-500">*</span>
                </label>
                <textarea name="contenu" 
                          id="contenu" 
                          rows="6"
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all"
                          placeholder="Expliquez votre problème en détail... Si c'est un exercice, recopiez l'énoncé."
                          required>{{ old('contenu') }}</textarea>
                @error('contenu')
                    <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-400 flex items-center gap-1">
                    <i class="fas fa-info-circle"></i>
                    Minimum 20 caractères
                </p>
            </div>

            <!-- Image upload amélioré -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-image text-primary-500 mr-1"></i>
                    Image (optionnelle)
                </label>
                <div class="relative">
                    <input type="file" 
                           name="image" 
                           id="image" 
                           class="hidden" 
                           accept="image/*"
                           onchange="previewImage(this)">
                    
                    <div id="uploadArea" 
                         onclick="document.getElementById('image').click()"
                         class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-500 hover:bg-primary-50/30 transition-all cursor-pointer group">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 group-hover:text-primary-600 transition-colors"></i>
                        </div>
                        <p class="text-gray-600 font-medium mb-1 group-hover:text-primary-700 transition-colors">
                            Cliquez pour ajouter une image
                        </p>
                        <p class="text-xs text-gray-400">
                            PNG, JPG, GIF • Max 2 Mo
                        </p>
                    </div>
                </div>

                <!-- Aperçu de l'image -->
                <div id="imagePreviewContainer" class="mt-4 hidden">
                    <div class="relative inline-block">
                        <img src="" alt="Aperçu" id="imagePreview" class="max-h-48 rounded-xl border border-gray-200 shadow-sm">
                        <button type="button" 
                                onclick="removeImage()"
                                class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                
                @error('image')
                    <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-lg shadow-primary-200 flex items-center justify-center gap-2 group">
                    <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                    <span>Publier ma question</span>
                </button>
                
                <a href="{{ route('assistance.index') }}" 
                   class="sm:w-auto px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Annuler</span>
                </a>
            </div>
        </form>
    </div>
    
    <!-- Petit rappel (optionnel mais utile) -->
    <p class="text-center text-xs text-gray-400 mt-6">
        <i class="far fa-clock mr-1"></i>
        Votre question sera visible après modération par nos équipes
    </p>
</section>

<script>
function previewImage(input) {
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    const uploadArea = document.getElementById('uploadArea');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const uploadArea = document.getElementById('uploadArea');
    
    input.value = '';
    previewContainer.classList.add('hidden');
    uploadArea.classList.remove('hidden');
}
</script>

<style>
/* Animation pour les icônes */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

/* Style pour les champs de formulaire */
input, select, textarea {
    transition: all 0.2s ease;
}

input:hover, select:hover, textarea:hover {
    border-color: #3b82f6;
}

/* Responsive */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection