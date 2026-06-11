@extends('layouts.app')

@section('title', 'Mon profil - StudyHub')
@section('page-title', 'Mon profil')

@section('content')
<!-- Hero Section - Style moderne -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 py-8 overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Mon profil</h1>
                <p class="text-white/70 text-sm mt-1">Gérez vos informations personnelles</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal - Espacement optimisé -->
<div class="max-w-7xl mx-auto px-3 py-5 md:px-4 md:py-6">
    
    <!-- Messages de succès/erreur - Plus compacts -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded-lg mb-4 text-sm flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-lg mb-4 text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <p class="font-medium mb-1 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                Veuillez corriger les erreurs :
            </p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Layout responsive -->
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        
        <!-- Colonne de gauche - Carte profil compacte -->
        <div class="lg:w-72">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-16 lg:top-20">
                <!-- En-tête avec dégradé -->
                <div class="h-16 bg-gradient-to-r from-primary-600 to-primary-700 relative">
                    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2">
                        <div class="relative">
                            <img src="{{ $user->avatar_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                            <form action="{{ url('/profile/avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="document.getElementById('avatarForm').submit()">
                                <button type="button" 
                                        onclick="document.getElementById('avatarInput').click()" 
                                        class="absolute bottom-0 right-0 w-7 h-7 bg-primary-600 hover:bg-primary-700 text-white rounded-full flex items-center justify-center shadow-md transition-colors text-xs">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="pt-12 pb-4 px-4 text-center">
                    <h2 class="font-bold text-gray-800 text-lg">{{ $user->name }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                    
                    <!-- Badge rôle -->
                    <div class="mt-3">
                        @if($user->isAdmin())
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                <i class="fas fa-crown mr-1"></i> Administrateur
                            </span>
                        @elseif($user->isEnseignant())
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Enseignant
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                <i class="fas fa-user-graduate mr-1"></i> Élève
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Statistiques compactes -->
                <div class="border-t border-gray-100 px-4 py-3">
                    <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Statistiques</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 flex items-center gap-1.5">
                                <i class="fas fa-calendar-alt text-primary-500 text-xs"></i> Membre depuis
                            </span>
                            <span class="font-medium text-gray-800 text-xs">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 flex items-center gap-1.5">
                                <i class="fas fa-chart-line text-primary-500 text-xs"></i> Quiz complétés
                            </span>
                            <span class="font-medium text-gray-800 text-xs">{{ \App\Models\QuizResultat::where('user_id', $user->id)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 flex items-center gap-1.5">
                                <i class="fas fa-question-circle text-primary-500 text-xs"></i> Questions posées
                            </span>
                            <span class="font-medium text-gray-800 text-xs">{{ \App\Models\Question::where('user_id', $user->id)->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Menu rapide -->
                <div class="border-t border-gray-100 px-4 py-3">
                    <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Navigation</h3>
                    <div class="space-y-1">
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-chart-line w-4 text-primary-500 text-xs"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ url('/mes-cours') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-book w-4 text-primary-500 text-xs"></i>
                            <span>Mes cours</span>
                        </a>
                        <a href="{{ url('/mes-resultats') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-chart-bar w-4 text-primary-500 text-xs"></i>
                            <span>Mes résultats</span>
                        </a>
                        <a href="{{ url('/mes-questions') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-question w-4 text-primary-500 text-xs"></i>
                            <span>Mes questions</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite - Formulaires -->
        <div class="flex-1 space-y-4">
            
            <!-- Formulaire d'informations personnelles -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
                        <i class="fas fa-user-circle text-primary-600"></i>
                        Informations personnelles
                    </h2>
                </div>
                
                <div class="p-4">
                    <form action="{{ url('/profile') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-600 mb-1">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-600 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-4">
                            <label for="bio" class="block text-xs font-medium text-gray-600 mb-1">
                                Bio <span class="text-gray-400">(optionnel)</span>
                            </label>
                            <textarea name="bio" 
                                      id="bio" 
                                      rows="3" 
                                      class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('bio') border-red-500 @enderror"
                                      placeholder="Parlez-nous un peu de vous...">{{ old('bio', $user->bio) }}</textarea>
                            <p class="mt-1 text-xs text-gray-400">Maximum 500 caractères</p>
                            @error('bio')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end gap-2">
                            <button type="reset" 
                                    class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-xs bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulaire de changement de mot de passe -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
                        <i class="fas fa-key text-primary-600"></i>
                        Changer le mot de passe
                    </h2>
                </div>
                
                <div class="p-4">
                    <form action="{{ url('/profile/password') }}" method="POST">
                        @csrf
                        
                        <!-- Mot de passe actuel -->
                        <div class="mb-4">
                            <label for="current_password" class="block text-xs font-medium text-gray-600 mb-1">
                                Mot de passe actuel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password" 
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('current_password') border-red-500 @enderror"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('current_password')" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggle_current_password"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="mb-4">
                            <label for="new_password" class="block text-xs font-medium text-gray-600 mb-1">
                                Nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="new_password" 
                                       id="new_password" 
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('new_password') border-red-500 @enderror"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('new_password')" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggle_new_password"></i>
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <p class="mb-1">Le mot de passe doit contenir :</p>
                                <div class="grid grid-cols-2 gap-1">
                                    <span class="password-requirement text-[10px]" id="length">✗ 8 caractères</span>
                                    <span class="password-requirement text-[10px]" id="uppercase">✗ Majuscule</span>
                                    <span class="password-requirement text-[10px]" id="lowercase">✗ Minuscule</span>
                                    <span class="password-requirement text-[10px]" id="number">✗ Chiffre</span>
                                </div>
                            </div>
                            @error('new_password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="block text-xs font-medium text-gray-600 mb-1">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       id="new_password_confirmation" 
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-primary-500 focus:border-primary-500 pr-10"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('new_password_confirmation')" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggle_new_password_confirmation"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-1 text-xs hidden"></div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end gap-2">
                            <button type="reset" 
                                    class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-xs bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                <i class="fas fa-key"></i> Changer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Zone de danger - Plus discrète mais visible -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="bg-red-50 px-4 py-3 border-b border-red-200">
                    <h2 class="font-semibold text-red-700 text-sm flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Zone de danger
                    </h2>
                </div>
                
                <div class="p-4">
                    <p class="text-xs text-gray-600 mb-3">
                        Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
                    </p>
                    
                    <button onclick="openDeleteModal()" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg transition-colors flex items-center gap-1">
                        <i class="fas fa-trash"></i> Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation - Version mobile friendly -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="min-h-screen px-3 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all">
            <div class="p-5">
                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mx-auto mb-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                
                <h3 class="text-base font-semibold text-gray-900 text-center mb-1">
                    Supprimer votre compte ?
                </h3>
                
                <p class="text-xs text-gray-500 text-center mb-4">
                    Cette action est irréversible. Toutes vos données seront supprimées.
                </p>
                
                <form action="{{ url('/profile/delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <input type="password" 
                               name="password" 
                               id="delete_password" 
                               placeholder="Votre mot de passe"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500"
                               required>
                    </div>
                    
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
.password-requirement {
    @apply text-gray-500;
}
.password-requirement.valid {
    @apply text-green-600;
}
</style>

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(`toggle_${fieldId}`);
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password strength checker
    const passwordInput = document.getElementById('new_password');
    const requirements = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number')
    };

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            // Longueur
            if (password.length >= 8) {
                requirements.length.innerHTML = '✓ 8 caractères';
                requirements.length.classList.add('valid');
            } else {
                requirements.length.innerHTML = '✗ 8 caractères';
                requirements.length.classList.remove('valid');
            }
            
            // Majuscule
            if (/[A-Z]/.test(password)) {
                requirements.uppercase.innerHTML = '✓ Majuscule';
                requirements.uppercase.classList.add('valid');
            } else {
                requirements.uppercase.innerHTML = '✗ Majuscule';
                requirements.uppercase.classList.remove('valid');
            }
            
            // Minuscule
            if (/[a-z]/.test(password)) {
                requirements.lowercase.innerHTML = '✓ Minuscule';
                requirements.lowercase.classList.add('valid');
            } else {
                requirements.lowercase.innerHTML = '✗ Minuscule';
                requirements.lowercase.classList.remove('valid');
            }
            
            // Chiffre
            if (/\d/.test(password)) {
                requirements.number.innerHTML = '✓ Chiffre';
                requirements.number.classList.add('valid');
            } else {
                requirements.number.innerHTML = '✗ Chiffre';
                requirements.number.classList.remove('valid');
            }
            
            checkPasswordMatch();
        });
    }

    // Password match checker
    const confirmInput = document.getElementById('new_password_confirmation');
    const matchDiv = document.getElementById('passwordMatch');

    function checkPasswordMatch() {
        if (!passwordInput || !confirmInput || !matchDiv) return;
        
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (confirm.length > 0) {
            if (password === confirm) {
                matchDiv.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Les mots de passe correspondent';
                matchDiv.classList.remove('text-red-500', 'hidden');
                matchDiv.classList.add('text-green-600');
            } else {
                matchDiv.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Les mots de passe ne correspondent pas';
                matchDiv.classList.remove('text-green-600', 'hidden');
                matchDiv.classList.add('text-red-500');
            }
        } else {
            matchDiv.classList.add('hidden');
        }
    }

    if (confirmInput) {
        confirmInput.addEventListener('input', checkPasswordMatch);
    }

    // Delete modal
    function openDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
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
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection