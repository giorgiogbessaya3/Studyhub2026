<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - StudyHub</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans:['Inter','sans-serif'], display:['Poppins','sans-serif'] },
                    colors: {
                        primary: {
                            50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',
                            400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',
                            800:'#1e40af',900:'#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .blob { position:absolute; filter:blur(80px); opacity:0.3; animation:blob-move 20s infinite alternate; }
        @keyframes blob-move { from{transform:translate(0,0) scale(1);} to{transform:translate(40px,-40px) scale(1.1);} }
        select { appearance:none; -webkit-appearance:none; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex">

    <!-- ═══ Panneau gauche — branding ═══ -->
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background-image:url('{{ asset('img/auth.jpg') }}');background-size:cover;background-position:center;">

        <!-- Overlay dégradé -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/75 via-primary-900/70 to-primary-800/65"></div>
        <!-- Motif de points -->
        <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,0.08) 1px,transparent 0);background-size:40px 40px"></div>

        <div class="relative z-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-14">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="font-display text-2xl font-bold text-white tracking-tight">StudyHub</span>
            </a>

            <h1 class="font-display text-4xl xl:text-5xl font-bold text-white leading-tight mb-5">
                Rejoignez<br>la communauté !
            </h1>
            <p class="text-primary-200 text-base leading-relaxed mb-10 max-w-sm">
                Plus de 15 000 élèves font confiance à StudyHub pour réussir leurs examens. Créez votre compte gratuit en moins d'une minute.
            </p>

            <div class="space-y-4">
                @foreach([
                    ['fas fa-check-circle', 'text-green-400', 'Accès gratuit à tous les cours'],
                    ['fas fa-check-circle', 'text-green-400', 'Quiz et exercices illimités'],
                    ['fas fa-check-circle', 'text-green-400', 'Suivi de progression personnalisé'],
                    ['fas fa-check-circle', 'text-green-400', 'Assistance par des professeurs qualifiés'],
                ] as [$icon, $color, $text])
                <div class="flex items-center gap-4">
                    <i class="{{ $icon }} {{ $color }} text-base flex-shrink-0"></i>
                    <span class="text-primary-100 text-sm">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Social proof -->
        <div class="relative z-10 bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/10">
            <div class="flex items-center gap-3 mb-2">
                <div class="flex -space-x-2">
                    @forelse($derniersEleves as $eleve)
                        <div class="w-8 h-8 rounded-full bg-primary-500 border-2 border-white/80 flex items-center justify-center text-white text-xs font-bold"
                             title="{{ $eleve->name }}">
                            {{ strtoupper(substr($eleve->name, 0, 1)) }}
                        </div>
                    @empty
                        @foreach(['A','B','C','D'] as $l)
                        <div class="w-8 h-8 rounded-full bg-primary-500 border-2 border-white/80 flex items-center justify-center text-white text-xs font-bold">{{ $l }}</div>
                        @endforeach
                    @endforelse
                </div>
                <span class="text-white text-sm font-medium">
                    +{{ $nbEleves >= 1000 ? number_format($nbEleves/1000, 0).' 000' : $nbEleves }} élèves actifs
                </span>
            </div>
            <div class="flex items-center gap-2">
                @for($i=0; $i<5; $i++)
                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                @endfor
                <span class="text-primary-200 text-sm ml-1">5/5 — Excellente plateforme</span>
            </div>
        </div>
    </div>

    <!-- ═══ Panneau droit — formulaire ═══ -->
    <div class="w-full lg:w-7/12 xl:w-1/2 flex flex-col min-h-screen bg-slate-50 overflow-y-auto">
        <div class="flex-1 flex items-center justify-center px-6 sm:px-12 py-10">
            <div class="w-full max-w-md">

                <!-- Logo mobile -->
                <div class="flex lg:hidden items-center gap-3 justify-center mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
                </div>

                <div class="mb-7">
                    <h2 class="font-display text-3xl font-bold text-slate-900 mb-1">Créer un compte</h2>
                    <p class="text-slate-500 text-sm">Rejoignez StudyHub — c'est gratuit !</p>
                </div>

                @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                        <ul class="list-none space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
                    @csrf

                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Jean Dupont"
                                   autocomplete="name" required
                                   class="w-full py-3 pl-11 pr-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('name') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="votre@email.com"
                                   autocomplete="email" required
                                   class="w-full py-3 pl-11 pr-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('email') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    <!-- Rôle -->
                    <div>
                        <label for="role" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Vous êtes <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none z-10"></i>
                            <select id="role" name="role" required
                                    class="w-full py-3 pl-11 pr-10 bg-white border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('role') ? 'border-red-400' : '' }}">
                                <option value="">-- Sélectionnez votre profil --</option>
                                <option value="eleve" {{ old('role')=='eleve'?'selected':'' }}>Élève</option>
                                <option value="enseignant" {{ old('role')=='enseignant'?'selected':'' }}>Enseignant</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="password" id="password" name="password"
                                   placeholder="Minimum 8 caractères"
                                   autocomplete="new-password" required
                                   class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('password') ? 'border-red-400' : '' }}">
                            <button type="button" onclick="togglePassword('password','eye1')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="eye1" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Confirmer le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Répétez votre mot de passe"
                                   autocomplete="new-password" required
                                   class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm">
                            <button type="button" onclick="togglePassword('password_confirmation','eye2')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="eye2" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        <div id="matchMsg" class="mt-1.5 text-xs hidden"></div>
                    </div>

                    <button type="submit" id="submitBtn"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/30 flex items-center justify-center gap-2 text-sm mt-2">
                        <i id="btnIcon" class="fas fa-user-plus"></i>
                        <span id="btnText">Créer mon compte</span>
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-6">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                        Se connecter
                    </a>
                </p>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-1.5">
                        <i class="fas fa-arrow-left text-xs"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center py-4 border-t border-slate-100">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} StudyHub. Tous droits réservés.</p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon  = document.getElementById(iconId);
            field.type  = field.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        const pw  = document.getElementById('password');
        const pw2 = document.getElementById('password_confirmation');
        const msg = document.getElementById('matchMsg');
        pw2.addEventListener('input', () => {
            if (!pw2.value) { msg.classList.add('hidden'); return; }
            if (pw.value === pw2.value) {
                msg.textContent = '✓ Les mots de passe correspondent';
                msg.className = 'mt-1.5 text-xs text-green-600';
            } else {
                msg.textContent = '✗ Les mots de passe ne correspondent pas';
                msg.className = 'mt-1.5 text-xs text-red-500';
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn  = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            btn.disabled = true;
            btn.classList.add('opacity-75','cursor-not-allowed');
            icon.className = 'fas fa-spinner fa-spin';
            text.textContent = 'Création du compte…';
        });
    </script>
</body>
</html>
