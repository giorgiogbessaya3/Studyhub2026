<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe - StudyHub</title>
    <link rel="icon" type="image/png" href="{{ asset('study/logo.png') }}">
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
         style="background-image:url('{{ asset('study/auth.jpg') }}');background-size:cover;background-position:center;">
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
                Nouveau<br>départ !
            </h1>
            <p class="text-primary-200 text-base leading-relaxed mb-10 max-w-sm">
                Choisissez un mot de passe fort et unique pour protéger votre compte StudyHub.
            </p>

            <div class="space-y-3 mb-8">
                <p class="text-white/70 text-sm font-semibold uppercase tracking-wider">Conseils pour un bon mot de passe</p>
                @foreach([
                    ['fas fa-check text-green-400', 'Minimum 8 caractères'],
                    ['fas fa-check text-green-400', 'Mélangez lettres et chiffres'],
                    ['fas fa-check text-green-400', 'Ajoutez des caractères spéciaux'],
                    ['fas fa-times text-red-400',   'Évitez votre nom ou date de naissance'],
                ] as [$icon, $text])
                <div class="flex items-center gap-3">
                    <i class="{{ $icon }} text-xs w-4 flex-shrink-0"></i>
                    <span class="text-primary-100 text-sm">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10 bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-400/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-green-300 text-sm"></i>
                </div>
                <div>
                    <div class="text-white text-sm font-semibold">Connexion sécurisée</div>
                    <div class="text-primary-300 text-xs mt-0.5">Vos données sont protégées et chiffrées.</div>
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
                    <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-2xl mx-auto mb-6">
                        <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                    </div>

                    <div class="mb-8 text-center">
                        <h2 class="font-display text-2xl font-bold text-slate-900 mb-1">Nouveau mot de passe</h2>
                        <p class="text-slate-500 text-sm">Choisissez un mot de passe fort pour sécuriser votre compte.</p>
                    </div>

                    @if($errors->any())
                        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                            <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                            <ul class="list-none space-y-0.5">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" id="resetForm" class="space-y-4">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Adresse email</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}"
                                       placeholder="votre@email.com" autocomplete="email" required
                                       class="w-full py-3 pl-11 pr-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Nouveau mot de passe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                                <input type="password" id="password" name="password" placeholder="Minimum 8 caractères"
                                       autocomplete="new-password" required
                                       class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm {{ $errors->has('password') ? 'border-red-400' : '' }}">
                                <button type="button" onclick="togglePassword('password','eye1')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i id="eye1" class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       placeholder="Répétez le mot de passe" autocomplete="new-password" required
                                       class="w-full py-3 pl-11 pr-12 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-sm">
                                <button type="button" onclick="togglePassword('password_confirmation','eye2')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i id="eye2" class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            <div id="matchMsg" class="mt-1.5 text-xs hidden"></div>
                        </div>

                        <button type="submit" id="submitBtn"
                                class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 text-sm mt-2">
                            <i id="btnIcon" class="fas fa-check-circle"></i>
                            <span id="btnText">Réinitialiser le mot de passe</span>
                        </button>
                    </form>

                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center gap-2 mt-5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i> Retour à la connexion
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
        const pw = document.getElementById('password'), pw2 = document.getElementById('password_confirmation'), msg = document.getElementById('matchMsg');
        pw2.addEventListener('input', () => {
            if (!pw2.value) { msg.classList.add('hidden'); return; }
            msg.className = pw.value === pw2.value ? 'mt-1.5 text-xs text-green-600' : 'mt-1.5 text-xs text-red-500';
            msg.textContent = pw.value === pw2.value ? '✓ Les mots de passe correspondent' : '✗ Les mots de passe ne correspondent pas';
        });
        document.getElementById('resetForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true; btn.classList.add('opacity-75','cursor-not-allowed');
            document.getElementById('btnIcon').className = 'fas fa-spinner fa-spin';
            document.getElementById('btnText').textContent = 'Réinitialisation…';
        });
    </script>
</body>
</html>
