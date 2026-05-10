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

        /* Mobile adjustments */
        @media (max-width: 1023px) {
            main {
                padding-bottom: 80px;
            }
        }

        /* Avatar animations */
        .avatar-hover {
            transition: all 0.3s ease;
        }
        .avatar-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }
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
                            <!-- User Menu Desktop avec Avatar dynamique -->
                            <div class="relative" id="desktopUserMenuContainer">
                                <button onclick="toggleDesktopUserMenu()" class="flex items-center gap-3 pl-2 pr-4 py-2 rounded-full hover:bg-slate-100 transition-colors border-2 border-transparent hover:border-primary-200 avatar-hover">
                                    <img src="{{ Auth::user()->avatar_url }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="w-10 h-10 rounded-full border-2 border-primary-200 object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=40'">
                                    <span class="font-medium text-slate-700 hidden xl:inline">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                    <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                                </button>
                                
                                <!-- Dropdown Desktop amélioré -->
                                <div id="desktopUserMenu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                                    <!-- En-tête avec avatar plus grand -->
                                    <div class="p-6 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ Auth::user()->avatar_url }}" 
                                                 alt="{{ Auth::user()->name }}" 
                                                 class="w-16 h-16 rounded-full border-4 border-white/30 object-cover"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=64'">
                                            <div>
                                                <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-primary-100">{{ Auth::user()->email }}</p>
                                                <div class="mt-2">
                                                    @if(Auth::user()->isAdmin())
                                                        <span class="inline-flex items-center px-3 py-1 bg-purple-500/30 text-white text-xs rounded-full">
                                                            <i class="fas fa-crown mr-1"></i> Administrateur
                                                        </span>
                                                    @elseif(Auth::user()->isEnseignant())
                                                        <span class="inline-flex items-center px-3 py-1 bg-green-500/30 text-white text-xs rounded-full">
                                                            <i class="fas fa-chalkboard-teacher mr-1"></i> Enseignant
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 bg-blue-500/30 text-white text-xs rounded-full">
                                                            <i class="fas fa-user-graduate mr-1"></i> Élève
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Liens du menu -->
                                    <div class="p-2">
                                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-chart-line text-primary-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Tableau de bord</p>
                                                <p class="text-xs text-slate-500">Votre activité</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ url('/profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-user text-primary-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Mon profil</p>
                                                <p class="text-xs text-slate-500">Gérer vos informations</p>
                                            </div>
                                        </a>
                                        <a href="{{ url('/mes-resultats') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-chart-bar text-primary-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Mes résultats</p>
                                                <p class="text-xs text-slate-500">Quiz et évaluations</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ url('/mes-questions') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary-50 text-slate-700 transition-colors group">
                                            <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                                <i class="fas fa-question text-primary-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Mes questions</p>
                                                <p class="text-xs text-slate-500">Assistance</p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <div class="border-t border-slate-100 p-2">
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-600 transition-colors group">
                                                <div class="w-9 h-9 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                                    <i class="fas fa-sign-out-alt text-red-600"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p class="font-medium">Déconnexion</p>
                                                    <p class="text-xs text-red-400">Se déconnecter</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-primary-600 font-medium hover:bg-primary-50 rounded-full transition-colors">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-full shadow-lg shadow-primary-500/30 transition-all hover:scale-105 btn-shine">
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
                <!-- Logo and Name -->
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-slate-900">StudyHub</span>
                </a>

                <!-- Right side icons -->
                <div class="flex items-center gap-2">
                    <!-- Search Icon -->
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors">
                        <i class="fas fa-search text-slate-600 text-lg"></i>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors" id="mobileMenuButton">
                        <i class="fas fa-bars text-slate-600 text-lg" id="menuIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Panel (slide-down) -->
    <div id="mobileMenuPanel" class="lg:hidden fixed top-16 left-0 right-0 bg-white shadow-xl z-40 hidden transform transition-all duration-300 ease-in-out max-h-[80vh] overflow-y-auto">
        <div class="p-4 border-b border-slate-100">
            @auth
                <div class="flex items-center gap-3 mb-4 p-3 bg-primary-50 rounded-xl">
                    <img src="{{ Auth::user()->avatar_url }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="w-14 h-14 rounded-full border-3 border-primary-200 object-cover"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=56'">
                    <div class="flex-1">
                        <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        <div class="mt-1">
                            @if(Auth::user()->isAdmin())
                                <span class="inline-flex items-center px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full">
                                    <i class="fas fa-crown mr-1"></i> Administrateur
                                </span>
                            @elseif(Auth::user()->isEnseignant())
                                <span class="inline-flex items-center px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i> Enseignant
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">
                                    <i class="fas fa-user-graduate mr-1"></i> Élève
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Navigation Links -->
            <div class="space-y-1">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('/') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    <div class="w-8 h-8 {{ request()->is('/') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                        <i class="fas fa-home {{ request()->is('/') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                    </div>
                    <span class="font-medium">Accueil</span>
                </a>
                
                <a href="{{ url('/cours') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('cours*') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    <div class="w-8 h-8 {{ request()->is('cours*') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                        <i class="fas fa-book {{ request()->is('cours*') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                    </div>
                    <span class="font-medium">Cours</span>
                </a>
                
                <a href="{{ url('/epreuves') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('epreuves*') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    <div class="w-8 h-8 {{ request()->is('epreuves*') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt {{ request()->is('epreuves*') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                    </div>
                    <span class="font-medium">Épreuves</span>
                </a>
                
                <a href="{{ url('/quiz') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('quiz*') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    <div class="w-8 h-8 {{ request()->is('quiz*') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                        <i class="fas fa-question-circle {{ request()->is('quiz*') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                    </div>
                    <span class="font-medium">Quiz</span>
                </a>
                
                <a href="{{ url('/assistance') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('assistance*') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    <div class="w-8 h-8 {{ request()->is('assistance*') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                        <i class="fas fa-headset {{ request()->is('assistance*') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                    </div>
                    <span class="font-medium">Assistance</span>
                </a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin*') ? 'bg-purple-50 text-purple-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                            <div class="w-8 h-8 {{ request()->is('admin*') ? 'bg-purple-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                                <i class="fas fa-cog {{ request()->is('admin*') ? 'text-purple-600' : 'text-slate-500' }}"></i>
                            </div>
                            <span class="font-medium">Administration</span>
                        </a>
                    @endif
                    
                    <div class="border-t border-slate-200 my-3"></div>
                    
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-2">Mon espace</p>
                    
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('dashboard') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                        <div class="w-8 h-8 {{ request()->is('dashboard') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line {{ request()->is('dashboard') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                        </div>
                        <span class="font-medium">Tableau de bord</span>
                    </a>
                    
                    <a href="{{ url('/profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('profile') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                        <div class="w-8 h-8 {{ request()->is('profile') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                            <i class="fas fa-user {{ request()->is('profile') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                        </div>
                        <span class="font-medium">Mon profil</span>
                    </a>
                    
                    
                    
                    <a href="{{ url('/mes-resultats') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('mes-resultats') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                        <div class="w-8 h-8 {{ request()->is('mes-resultats') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-bar {{ request()->is('mes-resultats') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                        </div>
                        <span class="font-medium">Mes résultats</span>
                    </a>
                    
                    <a href="{{ url('/mes-questions') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('mes-questions') ? 'bg-primary-50 text-primary-600' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                        <div class="w-8 h-8 {{ request()->is('mes-questions') ? 'bg-primary-100' : 'bg-slate-100' }} rounded-full flex items-center justify-center">
                            <i class="fas fa-question {{ request()->is('mes-questions') ? 'text-primary-600' : 'text-slate-500' }}"></i>
                        </div>
                        <span class="font-medium">Mes questions</span>
                    </a>
                @endauth
            </div>
            
            @auth
                <div class="border-t border-slate-200 mt-4 pt-4">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-sign-out-alt text-red-600"></i>
                            </div>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-slate-200 mt-4 pt-4 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Se connecter</span>
                    </a>
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                        <i class="fas fa-user-plus"></i>
                        <span>S'inscrire</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Bottom Navigation (visible only on mobile) -->
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
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 text-slate-400">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-lg"></i>
                    </div>
                    <span class="text-xs font-medium">Connexion</span>
                </a>
            @endauth
        </div>
    </nav>

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

    <!-- Main Content -->
    <main class="lg:pt-20 pt-16 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
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
            const menu = document.getElementById('desktopUserMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            const panel = document.getElementById('mobileMenuPanel');
            const icon = document.getElementById('menuIcon');
            
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
                document.body.style.overflow = 'hidden';
            } else {
                panel.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        }

        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobileMenuPanel a').forEach(link => {
            link.addEventListener('click', () => {
                const panel = document.getElementById('mobileMenuPanel');
                const icon = document.getElementById('menuIcon');
                panel.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                document.body.style.overflow = '';
            });
        });

        // Close menus when clicking outside
        document.addEventListener('click', (e) => {
            // Desktop user menu
            const desktopMenu = document.getElementById('desktopUserMenu');
            const desktopButton = e.target.closest('[onclick="toggleDesktopUserMenu()"]');
            if (!desktopButton && desktopMenu && !desktopMenu.classList.contains('hidden')) {
                desktopMenu.classList.add('hidden');
            }

            // Mobile menu
            const mobilePanel = document.getElementById('mobileMenuPanel');
            const mobileButton = e.target.closest('#mobileMenuButton');
            const mobileIcon = e.target.closest('#menuIcon');
            
            if (mobilePanel && !mobilePanel.classList.contains('hidden') && 
                !mobileButton && !mobileIcon && 
                !mobilePanel.contains(e.target)) {
                mobilePanel.classList.add('hidden');
                const icon = document.getElementById('menuIcon');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        });

        // Close search on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const overlay = document.getElementById('searchOverlay');
                if (overlay && !overlay.classList.contains('hidden')) {
                    toggleSearch();
                }
                
                const mobilePanel = document.getElementById('mobileMenuPanel');
                if (mobilePanel && !mobilePanel.classList.contains('hidden')) {
                    mobilePanel.classList.add('hidden');
                    const icon = document.getElementById('menuIcon');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                    document.body.style.overflow = '';
                }
                
                const desktopMenu = document.getElementById('desktopUserMenu');
                if (desktopMenu && !desktopMenu.classList.contains('hidden')) {
                    desktopMenu.classList.add('hidden');
                }
            }
        });

        // Handle responsive behavior
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                const mobilePanel = document.getElementById('mobileMenuPanel');
                if (mobilePanel && !mobilePanel.classList.contains('hidden')) {
                    mobilePanel.classList.add('hidden');
                    const icon = document.getElementById('menuIcon');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                    document.body.style.overflow = '';
                }
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