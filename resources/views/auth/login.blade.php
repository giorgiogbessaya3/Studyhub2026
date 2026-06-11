<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - StudyHub</title>
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
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex">

    <!-- ═══ Panneau gauche — branding ═══ -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background-image:url('{{ asset('img/auth.jpg') }}');background-size:cover;background-position:center;">

        <!-- Overlay dégradé -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/75 via-primary-900/70 to-primary-800/65"></div>
        <!-- Motif de points -->
        <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,0.08) 1px,transparent 0);background-size:40px 40px"></div>

        <!-- Logo + tagline -->
        <div class="relative z-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-14">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="font-display text-2xl font-bold text-white tracking-tight">StudyHub</span>
            </a>

            <h1 class="font-display text-4xl xl:text-5xl font-bold text-white leading-tight mb-5">
                Votre réussite<br>commence ici.
            </h1>
            <p class="text-primary-200 text-base leading-relaxed mb-10 max-w-sm">
                Accédez à des milliers de cours, épreuves corrigées et quiz interactifs pour exceller dans vos études.
            </p>

            <!-- Fonctionnalités -->
            <div class="space-y-4">
                @foreach([
                    ['fas fa-book-open',   'Cours structurés par classe et matière'],
                    ['fas fa-file-alt',    'Épreuves corrigées avec corrections détaillées'],
                    ['fas fa-brain',       'Quiz interactifs pour tester vos connaissances'],
                    ['fas fa-headset',     'Assistance pédagogique par des professeurs'],
                ] as [$icon, $text])
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0 border border-white/10">
                        <i class="{{ $icon }} text-white text-sm"></i>
                    </div>
                    <span class="text-primary-100 text-sm">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Stats bas -->
        <div class="relative z-10 flex gap-8 pt-8 border-t border-white/10">
            <div>
                <div class="text-2xl font-bold text-white font-display">
                    {{ $nbEleves >= 1000 ? number_format($nbEleves/1000, 0).' k+' : $nbEleves.'+' }}
                </div>
                <div class="text-primary-300 text-xs mt-0.5">Élèves actifs</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-white font-display">
                    {{ $nbEpreuves >= 1000 ? number_format($nbEpreuves/1000, 0).' k+' : $nbEpreuves.'+' }}
                </div>
                <div class="text-primary-300 text-xs mt-0.5">Épreuves</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-white font-display">{{ $satisfaction }}%</div>
                <div class="text-primary-300 text-xs mt-0.5">Satisfaction</div>
            </div>
        </div>
    </div>

    <!-- ═══ Panneau droit — formulaire ═══ -->
    <div class="w-full lg:w-1/2 flex flex-col min-h-screen bg-slate-50 overflow-y-auto">
        <div class="flex-1 flex items-center justify-center px-6 sm:px-12 py-12">
            <div class="w-full max-w-md">

                <!-- Logo mobile uniquement -->
                <div class="flex lg:hidden items-center gap-3 justify-center mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
                </div>

                <!-- En-tête formulaire -->
                <div class="mb-8">
                    <h2 class="font-display text-3xl font-bold text-slate-900 mb-1">Bon retour !</h2>
                    <p class="text-slate-500 text-sm">Connectez-vous à votre espace d'apprentissage</p>
                </div>

                <!-- Alertes -->
                @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                        <span>Email ou mot de passe incorrect. Veuillez réessayer.</span>
                    </div>
                @endif
                @if(session('status'))
                    <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Formulaire -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="votre@email.com"
                                   autocomplete="email" autofocus required
                                   class="w-full py-3 pl-11 pr-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('email') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Mot de passe
                            </label>
                            <a href="{{ route('password.request') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                Mot de passe oublié ?
                            </a>
                        </div>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input type="password" id="password" name="password"
                                   placeholder="••••••••"
                                   autocomplete="current-password" required
                                   class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('password') ? 'border-red-400' : '' }}">
                            <button type="button" onclick="togglePassword('password','eyeIcon')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Se souvenir -->
                    <div class="flex items-center gap-2.5">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                        <label for="remember" class="text-sm text-slate-600 cursor-pointer select-none">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Bouton -->
                    <button type="submit" id="submitBtn"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/30 flex items-center justify-center gap-2 text-sm mt-2">
                        <i id="btnIcon" class="fas fa-sign-in-alt"></i>
                        <span id="btnText">Se connecter</span>
                    </button>
                </form>

                <!-- Lien inscription -->
                <p class="text-center text-sm text-slate-500 mt-8">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                        S'inscrire gratuitement
                    </a>
                </p>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-1.5">
                        <i class="fas fa-arrow-left text-xs"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
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

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn  = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            btn.disabled = true;
            btn.classList.add('opacity-75','cursor-not-allowed');
            icon.className = 'fas fa-spinner fa-spin';
            text.textContent = 'Connexion en cours…';
        });
    </script>
</body>
</html>
