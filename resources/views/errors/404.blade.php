<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable — StudyHub</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','sans-serif'], display: ['Poppins','sans-serif'] },
                    colors: { primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' } }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex flex-col">

    <!-- Header minimal -->
    <header class="bg-white border-b border-slate-100 px-6 py-4">
        <a href="{{ url('/') }}" class="flex items-center gap-3 w-fit">
            <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
            <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
        </a>
    </header>

    <!-- Contenu centré -->
    <main class="flex-1 flex items-center justify-center px-6 py-16">
        <div class="text-center max-w-lg">

            <!-- Illustration -->
            <div class="relative mx-auto w-40 h-40 mb-10">
                <div class="absolute inset-0 bg-primary-100 rounded-full"></div>
                <div class="absolute inset-4 bg-primary-200 rounded-full"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="font-display text-6xl font-black text-primary-600 leading-none select-none">404</span>
                </div>
            </div>

            <h1 class="font-display text-3xl font-bold text-slate-900 mb-3">
                Page introuvable
            </h1>
            <p class="text-slate-500 text-base leading-relaxed mb-10">
                La page que vous recherchez n'existe pas ou a été déplacée.<br>
                Vérifiez l'URL ou retournez à l'accueil.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ url('/') }}"
                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/25 transition-all hover:scale-105">
                    <i class="fas fa-home text-sm"></i>
                    Retour à l'accueil
                </a>
                <button onclick="history.back()"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold rounded-xl transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                    Page précédente
                </button>
            </div>

            <!-- Liens rapides -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Liens utiles</p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ url('/cours') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fas fa-book mr-1.5 text-primary-400"></i>Cours
                    </a>
                    <a href="{{ url('/epreuves') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fas fa-file-alt mr-1.5 text-primary-400"></i>Épreuves
                    </a>
                    <a href="{{ url('/quiz') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fas fa-question-circle mr-1.5 text-primary-400"></i>Quiz
                    </a>
                    <a href="{{ url('/assistance') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fas fa-headset mr-1.5 text-primary-400"></i>Assistance
                    </a>
                </div>
            </div>

        </div>
    </main>

    <footer class="text-center py-4 text-xs text-slate-400">
        &copy; {{ date('Y') }} StudyHub. Tous droits réservés.
    </footer>

</body>
</html>
