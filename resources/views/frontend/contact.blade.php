@extends('layouts.app')

@section('title', 'Contact - StudyHub')

@section('content')
<!-- Hero Section - Style identique à la page des épreuves -->
<section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 min-h-[300px] flex items-center overflow-hidden">
    <!-- Background dots pattern -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;">
    </div>
    
    <!-- Blobs décoratifs -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10 py-5">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm px-4 py-2 rounded-full mb-4">
                <i class="fas fa-headset mr-2"></i>
                Contactez-nous
            </span>
            
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Une question ? Une suggestion ?
            </h1>
            
            <p class="text-white/80 text-base md:text-lg mb-4">
                Notre équipe est là pour vous aider et vous répondre dans les meilleurs délais
            </p>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="0.1"/>
        </svg>
    </div>
</section>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto px-4 py-5">
    
    <!-- Grille principale -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Informations de contact - Style carte -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 h-full">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Parlons de vous</h2>
                <p class="text-gray-600 mb-8">
                    Que vous soyez élève, parent ou enseignant, nous sommes à votre écoute pour répondre à toutes vos questions.
                </p>
                
                <!-- Coordonnées -->
                <div class="space-y-6">
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-map-marker-alt text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Adresse</h3>
                            <p class="text-gray-600">123 Avenue de l'Éducation<br>75001 Paris, France</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-phone-alt text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Téléphone</h3>
                            <p class="text-gray-600">+33 1 23 45 67 89</p>
                            <p class="text-sm text-gray-500">Lun-Ven, 9h-18h</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600">contact@studyhub.fr</p>
                            <p class="text-sm text-gray-500">Réponse sous 24-48h</p>
                        </div>
                    </div>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h3 class="font-semibold text-gray-800 mb-4">Suivez-nous</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulaire de contact - Style carte -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>
                
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    
                    <!-- Prénom et Nom -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('first_name') border-red-500 @enderror"
                                   placeholder="Jean"
                                   required>
                            @error('first_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('last_name') border-red-500 @enderror"
                                   placeholder="Dupont"
                                   required>
                            @error('last_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                               placeholder="jean.dupont@exemple.fr"
                               required>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Téléphone (optionnel) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span class="text-gray-400 text-xs">(optionnel)</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror"
                               placeholder="+33 6 12 34 56 78">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Sujet -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sujet *</label>
                        <select name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('subject') border-red-500 @enderror" required>
                            <option value="" disabled selected>Choisissez un sujet</option>
                            <option value="Question sur les cours" {{ old('subject') == 'Question sur les cours' ? 'selected' : '' }}>Question sur les cours</option>
                            <option value="Problème technique" {{ old('subject') == 'Problème technique' ? 'selected' : '' }}>Problème technique</option>
                            <option value="Suggestion" {{ old('subject') == 'Suggestion' ? 'selected' : '' }}>Suggestion</option>
                            <option value="Devenir partenaire" {{ old('subject') == 'Devenir partenaire' ? 'selected' : '' }}>Devenir partenaire</option>
                            <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Message -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                        <textarea name="message" rows="5" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('message') border-red-500 @enderror"
                                  placeholder="Bonjour, je souhaiterais en savoir plus sur..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Bouton -->
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium py-3 px-4 rounded-lg transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Carte simple -->
    <div class="mt-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="h-64 relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.991440608209!2d2.292292615674365!3d48.85837360866248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1647876543210!5m2!1sfr!2sfr" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 0.2; }
    50% { opacity: 0.3; }
}
.animate-pulse {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.scroll-mt-24 {
    scroll-margin-top: 6rem;
}
</style>
@endsection