<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe - StudyHub</title>
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
        .blob { position:absolute; filter:blur(80px); opacity:0.35; animation:blob-move 20s infinite alternate; }
        @keyframes blob-move { from { transform:translate(0,0) scale(1); } to { transform:translate(40px,-40px) scale(1.1); } }
    </style>
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-900 via-primary-900 to-primary-800 flex items-center justify-center px-4 py-12">

    <div class="blob bg-primary-500 w-96 h-96 rounded-full -top-20 -left-20 fixed"></div>
    <div class="blob bg-purple-600 w-80 h-80 rounded-full bottom-0 right-0 translate-x-1/2 fixed" style="animation-delay:2s"></div>
    <div class="fixed inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,0.07) 1px,transparent 0);background-size:40px 40px"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="flex items-center justify-center gap-3 mb-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur border border-white/20">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="font-display text-2xl font-bold text-white">StudyHub</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-white/10">
            <!-- Icône -->
            <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-2xl mx-auto mb-6">
                <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
            </div>

            <div class="text-center mb-8">
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-2">Nouveau mot de passe</h2>
                <p class="text-slate-500 text-sm">Choisissez un mot de passe fort pour sécuriser votre compte.</p>
            </div>

            <!-- Erreurs -->
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

            <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                        Adresse email
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" id="email" name="email"
                               value="{{ $email ?? old('email') }}"
                               placeholder="votre@email.com"
                               autocomplete="email" required
                               class="w-full px-4 py-3 pl-11 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all {{ $errors->has('email') ? 'border-red-400' : '' }}">
                    </div>
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                        Nouveau mot de passe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Minimum 8 caractères"
                               autocomplete="new-password" required
                               class="w-full px-4 py-3 pl-11 pr-12 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all {{ $errors->has('password') ? 'border-red-400' : '' }}">
                        <button type="button" onclick="togglePassword('password','eye1')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eye1" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                        Confirmer le mot de passe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Répétez le mot de passe"
                               autocomplete="new-password" required
                               class="w-full px-4 py-3 pl-11 pr-12 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <button type="button" onclick="togglePassword('password_confirmation','eye2')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eye2" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    <div id="matchMsg" class="mt-1 text-xs hidden"></div>
                </div>

                <button type="submit" id="submitBtn"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 flex items-center justify-center gap-2 text-sm">
                    <i id="btnIcon" class="fas fa-check-circle"></i>
                    <span id="btnText">Réinitialiser le mot de passe</span>
                </button>
            </form>

            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 mt-5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                <i class="fas fa-arrow-left text-xs"></i>
                Retour à la connexion
            </a>
        </div>

        <p class="text-center text-xs text-white/40 mt-6">
            &copy; {{ date('Y') }} StudyHub — Tous droits réservés
        </p>
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
                msg.className = 'mt-1 text-xs text-green-600';
            } else {
                msg.textContent = '✗ Les mots de passe ne correspondent pas';
                msg.className = 'mt-1 text-xs text-red-500';
            }
        });

        document.getElementById('resetForm').addEventListener('submit', function() {
            const btn  = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            btn.disabled = true;
            btn.classList.add('opacity-75','cursor-not-allowed');
            icon.className = 'fas fa-spinner fa-spin';
            text.textContent = 'Réinitialisation…';
        });
    </script>
</body>
</html>
