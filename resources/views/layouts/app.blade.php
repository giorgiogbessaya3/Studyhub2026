{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#0642a3">
    <title>@yield('title', 'StudyHub - Plateforme Éducative')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        secondary: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Card Hover Effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(59, 130, 246, 0.3);
        }

        /* Button Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-shine:hover::after {
            left: 100%;
        }

        /* Blob Animation */
        .blob {
            position: absolute;
            filter: blur(80px);
            opacity: 0.4;
            animation: blob-move 20s infinite alternate;
        }
        @keyframes blob-move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, -50px) scale(1.1); }
        }

        /* Hide scrollbar for horizontal scroll */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Mobile Bottom Nav Safe Area */
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 12px);
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Mobile — espace pour la bottom nav fixe */
        @media (max-width: 1023px) {
            main { padding-bottom: 64px; }
        }

        /* Avatar animations */
        .avatar-hover {
            transition: all 0.3s ease;
        }
        .avatar-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }

        /* Animation delay utilities */
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
    
    @yield('styles')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 overflow-x-hidden">

    <!-- Navigation Desktop (visible on lg screens and above) -->
    <nav id="navbar" class="hidden lg:block fixed w-full z-50 transition-all duration-300">
        <div class="glass border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="font-display text-2xl font-bold text-slate-900">StudyHub</span>
                        </div>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="flex items-center space-x-1">
                        <a href="{{ url('/') }}" class="px-4 py-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-primary-50 transition-all {{ request()->is('/') ? 'text-primary-600 bg-primary-50 font-medium' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ url('/cours') }}" class="px-4 py-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-primary-50 transition-all {{ request()->is('cours*') ? 'text-primary-600 bg-primary-50 font-medium' : '' }}">
                            Cours
                        </a>
                        <a href="{{ url('/epreuves') }}" class="px-4 py-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-primary-50 transition-all {{ request()->is('epreuves*') ? 'text-primary-600 bg-primary-50 font-medium' : '' }}">
                            Épreuves
                        </a>
                        <a href="{{ url('/quiz') }}" class="px-4 py-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-primary-50 transition-all {{ request()->is('quiz*') ? 'text-primary-600 bg-primary-50 font-medium' : '' }}">
                            Quiz
                        </a>
                        <a href="{{ url('/assistance') }}" class="px-4 py-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-primary-50 transition-all {{ request()->is('assistance*') ? 'text-primary-600 bg-primary-50 font-medium' : '' }}">
                            Assistance
                        </a>
                        
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 rounded-lg text-purple-600 hover:text-purple-700 hover:bg-purple-50 transition-all {{ request()->is('admin*') ? 'text-purple-600 bg-purple-50 font-medium' : '' }}">
                                    <i class="fas fa-cog mr-1"></i>Admin
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Right Side Desktop -->
                    <div class="flex items-center gap-4">
                        <!-- Search Button -->
                        <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors">
                            <i class="fas fa-search text-slate-600"></i>
                        </button>

                        @auth
                            <!-- User Menu Desktop -->
                            <div class="relative" id="desktopUserMenuContainer">
                                <button onclick="toggleDesktopUserMenu()"
                                        class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-100 border border-slate-200 hover:border-primary-200 transition-all group">
                                    <!-- Avatar -->
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ Auth::user()->avatar_url }}"
                                             alt="{{ Auth::user()->name }}"
                                             class="w-9 h-9 rounded-full border-2 border-primary-200 object-cover"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=36'">
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                                    </div>
                                    <!-- Nom + rôle -->
                                    <div class="text-left hidden xl:block">
                                        <div class="text-sm font-semibold text-slate-800 leading-tight">{{ Str::limit(explode(' ', Auth::user()->name)[0], 14) }}</div>
                                        <div class="text-xs capitalize
                                            @if(Auth::user()->isAdmin()) text-purple-500
                                            @elseif(Auth::user()->isEnseignant()) text-green-600
                                            @else text-primary-500 @endif">
                                            @if(Auth::user()->isAdmin()) Administrateur
                                            @elseif(Auth::user()->isEnseignant()) Enseignant
                                            @else Élève @endif
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200" id="desktopChevron"></i>
                                </button>

                                <!-- Dropdown Desktop -->
                                <div id="desktopUserMenu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">

                                    <!-- En-tête identité -->
                                    <div class="relative px-5 pt-5 pb-4 bg-gradient-to-br from-primary-600 to-primary-800">
                                        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 1px 1px,white 1px,transparent 0);background-size:24px 24px"></div>
                                        <div class="relative flex items-center gap-4">
                                            <div class="relative flex-shrink-0">
                                                <img src="{{ Auth::user()->avatar_url }}"
                                                     alt="{{ Auth::user()->name }}"
                                                     class="w-16 h-16 rounded-2xl border-3 border-white/30 object-cover shadow-lg"
                                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1d4ed8&color=fff&size=64'">
                                                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                                <p class="text-primary-200 text-xs truncate mt-0.5">{{ Auth::user()->email }}</p>
                                                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-1 rounded-full text-xs font-medium
                                                    @if(Auth::user()->isAdmin()) bg-purple-500/30 text-purple-100
                                                    @elseif(Auth::user()->isEnseignant()) bg-green-500/30 text-green-100
                                                    @else bg-white/20 text-white @endif">
                                                    @if(Auth::user()->isAdmin())
                                                        <i class="fas fa-crown text-[10px]"></i> Administrateur
                                                    @elseif(Auth::user()->isEnseignant())
                                                        <i class="fas fa-chalkboard-teacher text-[10px]"></i> Enseignant
                                                    @else
                                                        <i class="fas fa-user-graduate text-[10px]"></i> Élève
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Liens rapides en grille -->
                                    <div class="grid grid-cols-2 gap-1.5 p-3 border-b border-slate-100">
                                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-chart-line text-primary-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Dashboard</p>
                                                <p class="text-[10px] text-slate-400">Activité</p>
                                            </div>
                                        </a>
                                        <a href="{{ url('/profile') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-user-edit text-primary-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Profil</p>
                                                <p class="text-[10px] text-slate-400">Paramètres</p>
                                            </div>
                                        </a>
                                        <a href="{{ url('/mes-resultats') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-chart-bar text-primary-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Résultats</p>
                                                <p class="text-[10px] text-slate-400">Quiz</p>
                                            </div>
                                        </a>
                                        <a href="{{ url('/mes-questions') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-question-circle text-primary-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Questions</p>
                                                <p class="text-[10px] text-slate-400">Assistance</p>
                                            </div>
                                        </a>
                                    </div>

                                    @if(Auth::user()->isAdmin())
                                    <div class="px-3 py-2 border-b border-slate-100">
                                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-purple-50 text-purple-700 transition-colors">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-cog text-purple-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Administration</p>
                                                <p class="text-[10px] text-purple-400">Panneau admin</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif

                                    <div class="p-3">
                                        <button type="button" onclick="openLogoutModal()"
                                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 text-red-600 transition-colors group">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-red-200 transition-colors">
                                                <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                            </div>
                                            <div class="text-left">
                                                <p class="text-xs font-semibold">Déconnexion</p>
                                                <p class="text-[10px] text-red-400">Quitter la session</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 text-primary-600 font-medium hover:bg-primary-50 rounded-xl transition-colors text-sm">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:scale-105 btn-shine text-sm">
                                S'inscrire
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Header (visible only on mobile) -->
    <div class="lg:hidden fixed top-0 left-0 right-0 z-50">
        <div class="glass border-b border-white/20">
            <div class="px-4 h-16 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
                </a>

                <!-- Actions droite -->
                <div class="flex items-center gap-2">
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors" aria-label="Rechercher">
                        <i class="fas fa-search text-slate-600"></i>
                    </button>

                    @auth
                        <!-- Avatar bouton → ouvre le menu mobile -->
                        <button onclick="toggleMobileUserMenu()" id="mobileAvatarBtn"
                                class="relative flex-shrink-0" aria-label="Menu utilisateur">
                            <img src="{{ Auth::user()->avatar_url }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-9 h-9 rounded-full border-2 border-primary-200 object-cover shadow"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=36'">
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Connexion
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Panneau utilisateur mobile (slide-down) --}}
        @auth
        <div id="mobileUserMenu" class="hidden glass border-b border-white/20 shadow-xl">
            <!-- En-tête gradient -->
            <div class="relative px-4 pt-4 pb-3 bg-gradient-to-br from-primary-600 to-primary-800">
                <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 1px 1px,white 1px,transparent 0);background-size:20px 20px"></div>
                <div class="relative flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <img src="{{ Auth::user()->avatar_url }}"
                             alt="{{ Auth::user()->name }}"
                             class="w-14 h-14 rounded-2xl border-2 border-white/30 object-cover shadow-lg"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1d4ed8&color=fff&size=56'">
                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-white text-sm truncate">{{ Auth::user()->name }}</p>
                        <p class="text-primary-200 text-xs truncate">{{ Auth::user()->email }}</p>
                        <span class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium
                            @if(Auth::user()->isAdmin()) bg-purple-500/30 text-purple-100
                            @elseif(Auth::user()->isEnseignant()) bg-green-500/30 text-green-100
                            @else bg-white/20 text-white @endif">
                            @if(Auth::user()->isAdmin()) <i class="fas fa-crown text-[9px]"></i> Administrateur
                            @elseif(Auth::user()->isEnseignant()) <i class="fas fa-chalkboard-teacher text-[9px]"></i> Enseignant
                            @else <i class="fas fa-user-graduate text-[9px]"></i> Élève @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Liens rapides en grille 4 colonnes -->
            <div class="grid grid-cols-4 gap-1 px-3 py-3 bg-white border-b border-slate-100">
                <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-primary-50 transition-colors">
                    <div class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-primary-600 text-sm"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-600">Dashboard</span>
                </a>
                <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-primary-50 transition-colors">
                    <div class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-edit text-primary-600 text-sm"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-600">Profil</span>
                </a>
                <a href="{{ url('/mes-resultats') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-primary-50 transition-colors">
                    <div class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-primary-600 text-sm"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-600">Résultats</span>
                </a>
                <button onclick="closeMobileUserMenu(); openLogoutModal();" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-red-50 transition-colors">
                    <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-red-500 text-sm"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-red-500">Quitter</span>
                </button>
            </div>
        </div>
        @endauth
    </div>

    <!-- Search Overlay -->
    <div id="searchOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="max-w-3xl mx-auto mt-32 px-4">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="searchBox">
                <div class="flex items-center p-4 border-b border-slate-100">
                    <i class="fas fa-search text-slate-400 text-xl mr-3"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un cours, une épreuve, une matière..." class="flex-1 text-lg outline-none text-slate-700 placeholder-slate-400" autofocus>
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 bg-slate-50">
                    <p class="text-sm text-slate-500 mb-3">Suggestions populaires</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ url('/epreuves?classe=terminale') }}" class="px-3 py-1.5 bg-white rounded-full text-sm text-slate-600 hover:text-primary-600 hover:shadow-sm transition-all">Bac 2024</a>
                        <a href="{{ url('/cours/recherche?q=maths') }}" class="px-3 py-1.5 bg-white rounded-full text-sm text-slate-600 hover:text-primary-600 hover:shadow-sm transition-all">Cours de maths</a>
                        <a href="{{ url('/epreuves?type=devoir') }}" class="px-3 py-1.5 bg-white rounded-full text-sm text-slate-600 hover:text-primary-600 hover:shadow-sm transition-all">Devoirs surveillés</a>
                        <a href="{{ url('/quiz') }}" class="px-3 py-1.5 bg-white rounded-full text-sm text-slate-600 hover:text-primary-600 hover:shadow-sm transition-all">Quiz en ligne</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 safe-bottom z-40 shadow-lg">
        <div class="flex justify-around items-center h-16">
            <a href="{{ url('/') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('/') ? 'text-primary-600' : 'text-slate-400' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('/') ? 'bg-primary-100' : '' }}">
                    <i class="fas fa-home text-lg"></i>
                </div>
                <span class="text-xs font-medium">Accueil</span>
            </a>
            <a href="{{ url('/cours') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('cours*') ? 'text-primary-600' : 'text-slate-400' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('cours*') ? 'bg-primary-100' : '' }}">
                    <i class="fas fa-book text-lg"></i>
                </div>
                <span class="text-xs font-medium">Cours</span>
            </a>
            <a href="{{ url('/epreuves') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('epreuves*') ? 'text-primary-600' : 'text-slate-400' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('epreuves*') ? 'bg-primary-100' : '' }}">
                    <i class="fas fa-file-alt text-lg"></i>
                </div>
                <span class="text-xs font-medium">Épreuves</span>
            </a>
            <a href="{{ url('/quiz') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('quiz*') ? 'text-primary-600' : 'text-slate-400' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('quiz*') ? 'bg-primary-100' : '' }}">
                    <i class="fas fa-question-circle text-lg"></i>
                </div>
                <span class="text-xs font-medium">Quiz</span>
            </a>
            @auth
                <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('dashboard') ? 'text-primary-600' : 'text-slate-400' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('dashboard') ? 'bg-primary-100' : '' }}">
                        <i class="fas fa-user text-lg"></i>
                    </div>
                    <span class="text-xs font-medium">Profil</span>
                </a>
            @else
                <a href="{{ url('/assistance') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->is('assistance*') ? 'text-primary-600' : 'text-slate-400' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ request()->is('assistance*') ? 'bg-primary-100' : '' }}">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <span class="text-xs font-medium">Aide</span>
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="lg:pt-20 pt-16 pb-16 lg:pb-0 min-h-screen">
        @yield('content')
    </main>

    <!-- Modal de confirmation déconnexion -->
    @auth
    <div id="logoutModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60] hidden opacity-0 transition-opacity duration-200 flex items-end sm:items-center justify-center px-0 sm:px-4">
        <div id="logoutModalBox" class="bg-white w-full sm:max-w-sm sm:rounded-2xl rounded-t-2xl shadow-2xl p-6 transform translate-y-4 sm:translate-y-0 sm:scale-95 transition-all duration-200">
            <!-- Icône -->
            <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
            </div>
            <!-- Texte -->
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">Déconnexion</h3>
            <p class="text-sm text-slate-500 text-center mb-6">
                Êtes-vous sûr de vouloir vous déconnecter de <span class="font-semibold text-slate-700">StudyHub</span> ?
            </p>
            <!-- Boutons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeLogoutModal()"
                        class="flex-1 px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Annuler
                </button>
                <button type="button" onclick="doLogout()"
                        class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 rounded-xl text-sm font-medium text-white transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Déconnecter
                </button>
            </div>
        </div>
    </div>
    <!-- Formulaire logout centralisé (soumis par le modal) -->
    <form method="POST" action="{{ route('logout') }}" id="logout-form-confirm" class="hidden">
        @csrf
    </form>
    @endauth

    <!-- Footer Desktop uniquement -->
    <footer class="hidden lg:block bg-slate-900 text-slate-300 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <span class="font-display text-2xl font-bold text-white">StudyHub</span>
                    </div>
                    <p class="text-slate-400 mb-6 leading-relaxed">La plateforme éducative complète pour les élèves du collège au lycée. Réussissez vos examens avec nos ressources pédagogiques de qualité.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 transition-colors text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 transition-colors text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 transition-colors text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 transition-colors text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold mb-6">Ressources</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/cours') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Cours par classe</a></li>
                        <li><a href="{{ url('/epreuves') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Banque d'épreuves</a></li>
                        <li><a href="{{ url('/quiz') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Quiz interactifs</a></li>
                        <li><a href="{{ url('/assistance') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Assistance pédagogique</a></li>
                    </ul>
                </div>

                <!-- Classes -->
                <div>
                    <h4 class="text-white font-semibold mb-6">Classes</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/cours/classe/6eme') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Collège (6ème - 3ème)</a></li>
                        <li><a href="{{ url('/cours/classe/seconde') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Seconde</a></li>
                        <li><a href="{{ url('/cours/classe/premiere') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Première</a></li>
                        <li><a href="{{ url('/cours/classe/terminale') }}" class="hover:text-primary-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Terminale (Bac)</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-6">Contact</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope text-primary-500 mt-1"></i>
                            <span>contact@studyhub.fr</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-phone text-primary-500 mt-1"></i>
                            <span>+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-primary-500 mt-1"></i>
                            <span>Paris, France</span>
                        </li>
                    </ul>
                    
                    <!-- Newsletter -->
                    <div class="mt-6">
                        <p class="text-sm text-slate-400 mb-3">Restez informé</p>
                        <form class="flex gap-2">
                            <input type="email" placeholder="Votre email" class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-primary-500">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} StudyHub. Tous droits réservés.</p>
                <div class="flex gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Mentions légales</a>
                    <a href="#" class="hover:text-white transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-white transition-colors">CGU</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize AOS Animation
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // Navbar scroll effect (desktop only)
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-lg');
                } else {
                    navbar.classList.remove('shadow-lg');
                }
            }
        });

        // Toggle search overlay
        function toggleSearch() {
            const overlay = document.getElementById('searchOverlay');
            const box = document.getElementById('searchBox');
            const input = document.getElementById('searchInput');
            
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    box.classList.remove('scale-95');
                    box.classList.add('scale-100');
                    if (input) input.focus();
                }, 10);
            } else {
                overlay.classList.add('opacity-0');
                box.classList.remove('scale-100');
                box.classList.add('scale-95');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        // Toggle desktop user menu
        function toggleDesktopUserMenu() {
            const menu    = document.getElementById('desktopUserMenu');
            const chevron = document.getElementById('desktopChevron');
            if (!menu) return;
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            if (chevron) chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
        }

        // Toggle mobile user menu (slide-down panel)
        function toggleMobileUserMenu() {
            const menu = document.getElementById('mobileUserMenu');
            if (!menu) return;
            menu.classList.toggle('hidden');
        }
        function closeMobileUserMenu() {
            const menu = document.getElementById('mobileUserMenu');
            if (menu) menu.classList.add('hidden');
        }

        // Logout confirmation modal
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const box   = document.getElementById('logoutModalBox');
            if (!modal) return;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                box.classList.remove('translate-y-4', 'sm:scale-95');
                box.classList.add('translate-y-0', 'sm:scale-100');
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const box   = document.getElementById('logoutModalBox');
            if (!modal) return;
            modal.classList.add('opacity-0');
            box.classList.remove('translate-y-0', 'sm:scale-100');
            box.classList.add('translate-y-4', 'sm:scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        function doLogout() {
            document.getElementById('logout-form-confirm').submit();
        }

        // Close menus when clicking outside
        document.addEventListener('click', (e) => {
            // Desktop menu
            const desktopMenu = document.getElementById('desktopUserMenu');
            const chevron = document.getElementById('desktopChevron');
            if (desktopMenu && !desktopMenu.classList.contains('hidden')) {
                const container = document.getElementById('desktopUserMenuContainer');
                if (container && !container.contains(e.target)) {
                    desktopMenu.classList.add('hidden');
                    if (chevron) chevron.style.transform = '';
                }
            }
            // Mobile menu
            const mobileMenu = document.getElementById('mobileUserMenu');
            const mobileBtn  = document.getElementById('mobileAvatarBtn');
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                if (mobileBtn && !mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            }
            // Logout modal backdrop
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal && !logoutModal.classList.contains('hidden') && e.target === logoutModal) {
                closeLogoutModal();
            }
        });

        // Close overlays on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const overlay = document.getElementById('searchOverlay');
                if (overlay && !overlay.classList.contains('hidden')) toggleSearch();
                const desktopMenu = document.getElementById('desktopUserMenu');
                const chevron = document.getElementById('desktopChevron');
                if (desktopMenu && !desktopMenu.classList.contains('hidden')) {
                    desktopMenu.classList.add('hidden');
                    if (chevron) chevron.style.transform = '';
                }
                closeMobileUserMenu();
                const logoutModal = document.getElementById('logoutModal');
                if (logoutModal && !logoutModal.classList.contains('hidden')) closeLogoutModal();
            }
        });
    </script>
    
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/fr.js"></script>
    
    <!-- MathType pour les formules -->
    <script src="https://cdn.jsdelivr.net/npm/@wiris/mathtype-ckeditor5@8.3.0/dist/mathtype-ckeditor5.js"></script>

    @yield('scripts')
</body> 
</html> 