<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification email - StudyHub</title>
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
            <div class="flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-2xl mx-auto mb-6">
                <i class="fas fa-envelope-open-text text-yellow-600 text-2xl"></i>
            </div>

            <div class="text-center mb-8">
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-2">Vérifiez votre email</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Un lien de vérification a été envoyé à votre adresse email.<br>
                    Cliquez dessus pour activer votre compte.
                </p>
            </div>

            <!-- Alerte succès (renvoi) -->
            @if(session('resent'))
                <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                    <span>Un nouveau lien de vérification a été envoyé à votre adresse email.</span>
                </div>
            @endif

            <!-- Étapes -->
            <div class="bg-slate-50 rounded-xl p-5 mb-6 space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-600 text-xs font-bold">1</span>
                    </div>
                    <p class="text-sm text-slate-600">Ouvrez votre boite de réception</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-600 text-xs font-bold">2</span>
                    </div>
                    <p class="text-sm text-slate-600">Cherchez un email de <span class="font-semibold text-slate-700">StudyHub</span></p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-600 text-xs font-bold">3</span>
                    </div>
                    <p class="text-sm text-slate-600">Cliquez sur le lien de vérification</p>
                </div>
            </div>

            <!-- Renvoi -->
            <p class="text-center text-sm text-slate-500 mb-4">Vous n'avez pas reçu l'email ?</p>

            <form method="POST" action="{{ route('verification.resend') }}" id="resendForm">
                @csrf
                <button type="submit" id="resendBtn"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 flex items-center justify-center gap-2 text-sm">
                    <i id="resendIcon" class="fas fa-paper-plane"></i>
                    <span id="resendText">Renvoyer le lien</span>
                </button>
            </form>

            <!-- Déconnexion -->
            <div class="flex items-center gap-4 mt-6">
                <div class="flex-1 h-px bg-slate-100"></div>
                <span class="text-xs text-slate-400">ou</span>
                <div class="flex-1 h-px bg-slate-100"></div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all font-medium">
                    <i class="fas fa-sign-out-alt text-xs text-red-500"></i>
                    Se déconnecter
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-white/40 mt-6">
            &copy; {{ date('Y') }} StudyHub — Tous droits réservés
        </p>
    </div>

    <script>
        document.getElementById('resendForm').addEventListener('submit', function() {
            const btn  = document.getElementById('resendBtn');
            const text = document.getElementById('resendText');
            const icon = document.getElementById('resendIcon');
            btn.disabled = true;
            btn.classList.add('opacity-75','cursor-not-allowed');
            icon.className = 'fas fa-spinner fa-spin';
            text.textContent = 'Envoi en cours…';
        });
    </script>
</body>
</html>
