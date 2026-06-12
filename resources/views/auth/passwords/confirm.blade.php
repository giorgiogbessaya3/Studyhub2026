<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer le mot de passe - StudyHub</title>
    <link rel="icon" type="image/png" href="{{ asset('studylogo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans:['Inter','sans-serif'], display:['Poppins','sans-serif'] },
                    colors: { primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' } }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased min-h-screen flex">

    <!-- Panneau gauche -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background-image:url('{{ asset('studyauth.jpg') }}');background-size:cover;background-position:center;">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/75 via-primary-900/70 to-primary-800/65"></div>
        <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,0.08) 1px,transparent 0);background-size:40px 40px"></div>

        <div class="relative z-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-14">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="font-display text-2xl font-bold text-white tracking-tight">StudyHub</span>
            </a>

            <h1 class="font-display text-4xl xl:text-5xl font-bold text-white leading-tight mb-5">
                Zone<br>sécurisée
            </h1>
            <p class="text-primary-200 text-base leading-relaxed mb-10 max-w-sm">
                Pour protéger votre compte, veuillez confirmer votre identité avant d'accéder à cette zone sensible.
            </p>

            <div class="space-y-4">
                @foreach([
                    ['fas fa-user-shield',   'Vérification de votre identité'],
                    ['fas fa-lock',          'Protection des données personnelles'],
                    ['fas fa-history',       'Historique d\'activité sécurisé'],
                    ['fas fa-bell',          'Notifications de connexion activées'],
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

        <div class="relative z-10 bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-400/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-shield text-orange-300 text-sm"></i>
                </div>
                <div>
                    <div class="text-white text-sm font-semibold">Sécurité renforcée</div>
                    <div class="text-primary-300 text-xs mt-0.5">Cette étape protège votre compte contre les accès non autorisés.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panneau droit -->
    <div class="w-full lg:w-1/2 flex flex-col min-h-screen bg-slate-50 overflow-y-auto">
        <div class="flex-1 flex items-center justify-center px-6 sm:px-12 py-12">
            <div class="w-full max-w-md">

                <div class="flex lg:hidden items-center gap-3 justify-center mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
                    <div class="flex items-center justify-center w-16 h-16 bg-orange-100 rounded-2xl mx-auto mb-6">
                        <i class="fas fa-user-shield text-orange-600 text-2xl"></i>
                    </div>

                    <div class="mb-8 text-center">
                        <h2 class="font-display text-2xl font-bold text-slate-900 mb-1">Confirmation requise</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Confirmez votre mot de passe pour continuer vers cette zone sécurisée.
                        </p>
                    </div>

                    @if($errors->has('password'))
                        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                            <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                            <span>{{ $errors->first('password') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm">
                        @csrf
                        <div class="mb-6">
                            <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                                Mot de passe actuel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                                <input type="password" id="password" name="password"
                                       placeholder="••••••••" autocomplete="current-password" required autofocus
                                       class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('password') ? 'border-red-400' : '' }}">
                                <button type="button" onclick="togglePassword('password','eyeIcon')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn"
                                class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 text-sm">
                            <i id="btnIcon" class="fas fa-check-circle"></i>
                            <span id="btnText">Confirmer</span>
                        </button>
                    </form>

                    @if(Route::has('password.request'))
                    <div class="flex items-center gap-4 mt-5">
                        <div class="flex-1 h-px bg-slate-100"></div>
                        <span class="text-xs text-slate-400">ou</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>
                    <a href="{{ route('password.request') }}"
                       class="flex items-center justify-center gap-2 mt-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition-all font-medium">
                        <i class="fas fa-key text-xs"></i>
                        Mot de passe oublié ?
                    </a>
                    @endif
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
        document.getElementById('confirmForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true; btn.classList.add('opacity-75','cursor-not-allowed');
            document.getElementById('btnIcon').className = 'fas fa-spinner fa-spin';
            document.getElementById('btnText').textContent = 'Vérification…';
        });
    </script>
</body>
</html>
