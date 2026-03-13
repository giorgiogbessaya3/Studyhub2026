@extends('layouts.app')

@section('title', 'Mon profil - StudyHub')
@section('page-title', 'Mon profil')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-800">Mon profil</h1>
            <p class="text-slate-600">Gérez vos informations personnelles</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne de gauche - Avatar et infos -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <!-- Avatar -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <img src="{{ $user->avatar_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-primary-100 mx-auto object-cover">
                            
                            <!-- Formulaire upload avatar -->
                            <form action="{{ url('/profile/avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="document.getElementById('avatarForm').submit()">
                                <button type="button" 
                                        onclick="document.getElementById('avatarInput').click()" 
                                        class="absolute bottom-0 right-0 w-10 h-10 bg-primary-600 hover:bg-primary-700 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transition-colors">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </form>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800 mt-4">{{ $user->name }}</h2>
                        <p class="text-slate-500">{{ $user->email }}</p>
                        
                        <!-- Badge rôle -->
                        <div class="mt-3">
                            @if($user->isAdmin())
                                <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                    <i class="fas fa-crown mr-2"></i> Administrateur
                                </span>
                            @elseif($user->isEnseignant())
                                <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                    <i class="fas fa-chalkboard-teacher mr-2"></i> Enseignant
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                    <i class="fas fa-user-graduate mr-2"></i> Élève
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="font-semibold text-slate-700 mb-4">Statistiques</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">
                                    <i class="fas fa-calendar-alt text-primary-500 w-5 mr-2"></i>Membre depuis
                                </span>
                                <span class="font-medium text-slate-800">{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">
                                    <i class="fas fa-chart-line text-primary-500 w-5 mr-2"></i>Quiz complétés
                                </span>
                                <span class="font-medium text-slate-800">{{ \App\Models\QuizResultat::where('user_id', $user->id)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">
                                    <i class="fas fa-question-circle text-primary-500 w-5 mr-2"></i>Questions posées
                                </span>
                                <span class="font-medium text-slate-800">{{ \App\Models\Question::where('user_id', $user->id)->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Menu de navigation rapide -->
                    <div class="border-t border-slate-200 mt-6 pt-6">
                        <div class="space-y-2">
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors">
                                <i class="fas fa-chart-line w-5 text-primary-500"></i>
                                <span>Tableau de bord</span>
                            </a>
                            <a href="{{ url('/mes-cours') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors">
                                <i class="fas fa-book w-5 text-primary-500"></i>
                                <span>Mes cours</span>
                            </a>
                            <a href="{{ url('/mes-resultats') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors">
                                <i class="fas fa-chart-bar w-5 text-primary-500"></i>
                                <span>Mes résultats</span>
                            </a>
                            <a href="{{ url('/mes-questions') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors">
                                <i class="fas fa-question w-5 text-primary-500"></i>
                                <span>Mes questions</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Formulaires -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Messages de succès/erreur -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                        <p class="font-medium">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulaire d'informations personnelles -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Informations personnelles</h2>
                    
                    <form action="{{ url('/profile') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-6">
                            <label for="bio" class="block text-sm font-medium text-slate-700 mb-2">
                                Bio <span class="text-slate-400 text-xs">(optionnel)</span>
                            </label>
                            <textarea name="bio" 
                                      id="bio" 
                                      rows="4" 
                                      class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('bio') border-red-500 @enderror"
                                      placeholder="Parlez-nous un peu de vous...">{{ old('bio', $user->bio) }}</textarea>
                            <p class="mt-1 text-xs text-slate-500">Maximum 500 caractères</p>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end gap-3">
                            <button type="reset" 
                                    class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Formulaire de changement de mot de passe -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Changer le mot de passe</h2>
                    
                    <form action="{{ url('/profile/password') }}" method="POST">
                        @csrf
                        
                        <!-- Mot de passe actuel -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">
                                Mot de passe actuel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('current_password') border-red-500 @enderror"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('current_password')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <i class="fas fa-eye" id="toggle_current_password"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="mb-6">
                            <label for="new_password" class="block text-sm font-medium text-slate-700 mb-2">
                                Nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="new_password" 
                                       id="new_password" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('new_password') border-red-500 @enderror"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('new_password')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <i class="fas fa-eye" id="toggle_new_password"></i>
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-slate-500">
                                <p>Le mot de passe doit contenir :</p>
                                <ul class="list-disc list-inside ml-2">
                                    <li class="password-requirement" id="length">Au moins 8 caractères</li>
                                    <li class="password-requirement" id="uppercase">Au moins une majuscule</li>
                                    <li class="password-requirement" id="lowercase">Au moins une minuscule</li>
                                    <li class="password-requirement" id="number">Au moins un chiffre</li>
                                </ul>
                            </div>
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                                Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       id="new_password_confirmation" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('new_password_confirmation')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <i class="fas fa-eye" id="toggle_new_password_confirmation"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-1 text-sm hidden"></div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end gap-3">
                            <button type="reset" 
                                    class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-key mr-2"></i>Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Zone de danger (suppression de compte) -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-red-200">
                    <h2 class="text-xl font-semibold text-red-600 mb-4">Zone de danger</h2>
                    <p class="text-slate-600 mb-4">Une fois votre compte supprimé, toutes vos données seront définitivement effacées. Cette action est irréversible.</p>
                    
                    <button onclick="openDeleteModal()" 
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>Supprimer mon compte
                    </button>
                </div>
            </div>
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
                    Supprimer votre compte ?
                </h3>
                
                <p class="text-sm text-slate-500 text-center mb-6">
                    Cette action est irréversible. Toutes vos données seront définitivement supprimées.
                </p>
                
                <form action="{{ url('/profile/delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-4">
                        <label for="delete_password" class="block text-sm font-medium text-slate-700 mb-2">
                            Entrez votre mot de passe pour confirmer
                        </label>
                        <input type="password" 
                               name="password" 
                               id="delete_password" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               required>
                    </div>
                    
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
    .password-requirement {
        @apply text-slate-500 text-xs;
    }
    .password-requirement.valid {
        @apply text-green-600;
    }
    .password-requirement.valid i {
        @apply text-green-600;
    }
</style>
@endpush

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
            
            // Vérifier la longueur
            if (password.length >= 8) {
                requirements.length.innerHTML = '✓ Au moins 8 caractères';
                requirements.length.classList.add('valid');
            } else {
                requirements.length.innerHTML = '✗ Au moins 8 caractères';
                requirements.length.classList.remove('valid');
            }
            
            // Vérifier la majuscule
            if (/[A-Z]/.test(password)) {
                requirements.uppercase.innerHTML = '✓ Au moins une majuscule';
                requirements.uppercase.classList.add('valid');
            } else {
                requirements.uppercase.innerHTML = '✗ Au moins une majuscule';
                requirements.uppercase.classList.remove('valid');
            }
            
            // Vérifier la minuscule
            if (/[a-z]/.test(password)) {
                requirements.lowercase.innerHTML = '✓ Au moins une minuscule';
                requirements.lowercase.classList.add('valid');
            } else {
                requirements.lowercase.innerHTML = '✗ Au moins une minuscule';
                requirements.lowercase.classList.remove('valid');
            }
            
            // Vérifier le chiffre
            if (/\d/.test(password)) {
                requirements.number.innerHTML = '✓ Au moins un chiffre';
                requirements.number.classList.add('valid');
            } else {
                requirements.number.innerHTML = '✗ Au moins un chiffre';
                requirements.number.classList.remove('valid');
            }
            
            // Vérifier la confirmation
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
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }
</script>
@endpush