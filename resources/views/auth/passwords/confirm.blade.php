<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer le mot de passe - StudyHub</title>
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
            <div class="flex items-center justify-center w-16 h-16 bg-orange-100 rounded-2xl mx-auto mb-6">
                <i class="fas fa-user-shield text-orange-600 text-2xl"></i>
            </div>

            <div class="text-center mb-8">
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-2">Confirmation requise</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pour votre sécurité, veuillez confirmer votre mot de passe avant de continuer.
                </p>
            </div>

            <!-- Erreur -->
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
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••"
                               autocomplete="current-password" required autofocus
                               class="w-full px-4 py-3 pl-11 pr-12 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all {{ $errors->has('password') ? 'border-red-400' : '' }}">
                        <button type="button" onclick="togglePassword('password','eyeIcon')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 flex items-center justify-center gap-2 text-sm">
                    <i id="btnIcon" class="fas fa-check-circle"></i>
                    <span id="btnText">Confirmer</span>
                </button>
            </form>

            @if(Route::has('password.request'))
            <div class="flex items-center gap-4 mt-6">
                <div class="flex-1 h-px bg-slate-100"></div>
                <span class="text-xs text-slate-400">ou</span>
                <div class="flex-1 h-px bg-slate-100"></div>
            </div>
            <a href="{{ route('password.request') }}"
               class="flex items-center justify-center gap-2 mt-4 px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all font-medium">
                <i class="fas fa-key text-xs"></i>
                Mot de passe oublié ?
            </a>
            @endif
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

        document.getElementById('confirmForm').addEventListener('submit', function() {
            const btn  = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            btn.disabled = true;
            btn.classList.add('opacity-75','cursor-not-allowed');
            icon.className = 'fas fa-spinner fa-spin';
            text.textContent = 'Vérification…';
        });
    </script>
</body>
</html>
