<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StudyHub - Espace Administration')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('admin/css/styles.min.css') }}">
     <link rel="icon" type="image/png" href="{{ asset('study/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('study/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('study/logo.png') }}">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #334155;
            line-height: 1.6;
        }

        /* Header */
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
        }

        .header-brand i {
            color: var(--primary);
            font-size: 1.8rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: #f1f5f9;
            color: var(--secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            position: relative;
        }

        .btn-icon:hover {
            background: #e2e8f0;
            color: var(--dark);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid #f1f5f9;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: #f1f5f9;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .user-info {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--secondary);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: #fff;
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            z-index: 999;
            padding: 20px 0;
        }

        .sidebar-section {
            margin-bottom: 25px;
        }

        .sidebar-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 700;
            padding: 0 20px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-title::before {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .sidebar-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            gap: 12px;
        }

        .nav-link:hover {
            background: #f8fafc;
            color: var(--dark);
            border-left-color: #cbd5e1;
        }

        .nav-item.active > .nav-link {
            background: #eff6ff;
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .nav-item.active > .nav-link .nav-icon {
            color: var(--primary);
        }

        /* Dropdown arrow */
        .has-submenu > .nav-link {
            position: relative;
        }

        .has-submenu > .nav-link::after {
            content: '\ea61';
            font-family: 'tabler-icons';
            margin-left: auto;
            font-size: 0.9rem;
            transition: transform 0.3s;
            color: #94a3b8;
        }

        .has-submenu.open > .nav-link::after {
            transform: rotate(90deg);
            color: var(--primary);
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: #f8fafc;
        }

        .has-submenu.open > .submenu {
            max-height: 500px;
        }

        .submenu .nav-link {
            padding-left: 54px;
            font-size: 0.85rem;
            color: #7c8ba1;
        }

        .submenu .nav-item.active > .nav-link {
            background: #dbeafe;
            color: var(--primary-dark);
            border-left-color: var(--primary);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 25px;
            min-height: calc(100vh - var(--header-height));
        }

        /* Page Header */
        .page-header {
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--secondary);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }
        }

        @media (min-width: 1025px) {
            .mobile-toggle {
                display: none;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="btn-icon mobile-toggle" id="sidebarToggle">
                <i class="ti ti-menu-2"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="header-brand">
                <i class="ti ti-school"></i>
                <span>StudyHub Admin</span>
            </a>
        </div>

        <div class="header-actions">
            <!-- Notifications -->
            <div style="position: relative;">
                <button class="btn-icon" id="notificationBtn">
                    <i class="ti ti-bell"></i>
                    <span class="notification-badge"></span>
                </button>
                <div class="dropdown-menu" id="notificationMenu" style="position: absolute; top: 100%; right: 0; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); min-width: 220px; padding: 8px; z-index: 1001; display: none;">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9;">
                        <h6 style="font-size: 0.9rem; font-weight: 600; color: var(--dark); margin-bottom: 2px;">Notifications</h6>
                        <small style="font-size: 0.8rem; color: var(--secondary);">3 nouvelles</small>
                    </div>
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #475569; font-size: 0.9rem; text-decoration: none;">
                        <i class="ti ti-message-circle text-primary"></i>
                        <div>
                            <div style="font-weight: 500;">Nouvelle question</div>
                            <small style="color: #94a3b8;">Mathématiques - 5ème</small>
                        </div>
                    </a>
                    <div style="height: 1px; background: #f1f5f9; margin: 8px 0;"></div>
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #475569; font-size: 0.9rem; text-decoration: none; justify-content: center; color: var(--primary);">
                        Voir toutes les notifications
                    </a>
                </div>
            </div>

            <!-- User Profile -->
            <div style="position: relative;">
                <div class="user-profile" id="userProfileBtn">
                    <img src="{{ asset('admin/images/profile/user-1.jpg') }}" alt="" class="user-avatar">
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">{{ Auth::user()->name ?? 'Administrateur' }}</div>
                        <div class="user-role">Super Admin</div>
                    </div>
                    <i class="ti ti-chevron-down" style="color: #94a3b8; font-size: 0.9rem;"></i>
                </div>
                <div class="dropdown-menu" id="userProfileMenu" style="position: absolute; top: 100%; right: 0; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); min-width: 220px; padding: 8px; z-index: 1001; display: none;">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9;">
                        <h6 style="font-size: 0.9rem; font-weight: 600; color: var(--dark); margin-bottom: 2px;">{{ Auth::user()->name ?? 'Administrateur' }}</h6>
                        <small style="font-size: 0.8rem; color: var(--secondary);">{{ Auth::user()->email ?? 'admin@studyhub.com' }}</small>
                    </div>
                    <a href="{{ route('admin.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #475569; font-size: 0.9rem; text-decoration: none;">
                        <i class="ti ti-user"></i>
                        Mon profil
                    </a>
                    <a href="{{ route('admin.settings.general') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #475569; font-size: 0.9rem; text-decoration: none;">
                        <i class="ti ti-settings"></i>
                        Paramètres
                    </a>
                    <div style="height: 1px; background: #f1f5f9; margin: 8px 0;"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #ef4444; font-size: 0.9rem; text-decoration: none; width: 100%; border: none; background: none; cursor: pointer;">
                            <i class="ti ti-logout"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">

        <!-- 1. TABLEAU DE BORD -->
        <div class="sidebar-section">
            <div class="sidebar-title">Vue d'ensemble</div>
            <div class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span>Tableau de bord</span>
                </a>
            </div>
        </div>

        <!-- 2. GESTION DES UTILISATEURS -->
        <div class="sidebar-section">
            <div class="sidebar-title">Utilisateurs</div>

            <div class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }} has-submenu {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="ti ti-users"></i></span>
                    <span>Gestion des utilisateurs</span>
                </a>
                <div class="submenu">
                    <div class="nav-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="nav-link">Tous les utilisateurs</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.create') }}" class="nav-link">Ajouter un utilisateur</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.users.eleves') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.eleves') }}" class="nav-link">Élèves</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.users.enseignants') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.enseignants') }}" class="nav-link">Enseignants</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. ORGANISATION -->
        <div class="sidebar-section">
            <div class="sidebar-title">Organisation</div>

            <div class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                <a href="{{ route('admin.classes.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-school"></i></span>
                    <span>Classes</span>
                </a>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.matieres.*') ? 'active' : '' }}">
                <a href="{{ route('admin.matieres.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-book"></i></span>
                    <span>Matières</span>
                </a>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.chapitres.*') ? 'active' : '' }}">
                <a href="{{ route('admin.chapitres.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-book-2"></i></span>
                    <span>Chapitres</span>
                </a>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.contenus.*') ? 'active' : '' }}">
                <a href="{{ route('admin.contenus.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-file-text"></i></span>
                    <span>Contenus (Leçons)</span>
                </a>
            </div>
        </div>

        <!-- 4. BANQUE D'ÉPREUVES -->
        <div class="sidebar-section">
            <div class="sidebar-title">Banque d'épreuves</div>

            <div class="nav-item {{ request()->routeIs('admin.epreuves.*') || request()->routeIs('admin.types-epreuves.*') || request()->routeIs('admin.corrections') ? 'active' : '' }} has-submenu {{ request()->routeIs('admin.epreuves.*') || request()->routeIs('admin.types-epreuves.*') || request()->routeIs('admin.corrections') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="ti ti-file-text"></i></span>
                    <span>Gestion des épreuves</span>
                </a>
                <div class="submenu">
                    <div class="nav-item {{ request()->routeIs('admin.epreuves.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.epreuves.index') }}" class="nav-link">Toutes les épreuves</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.epreuves.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.epreuves.create') }}" class="nav-link">Ajouter une épreuve</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.types-epreuves.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.types-epreuves.index') }}" class="nav-link">Types d'épreuves</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.corrections') ? 'active' : '' }}">
                        <a href="{{ route('admin.corrections') }}" class="nav-link">Corrections</a>
                    </div>
                </div>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.dashboard.epreuves') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.epreuves') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-chart-bar"></i></span>
                    <span>Stats Épreuves</span>
                </a>
            </div>
        </div>

        <!-- 5. ÉVALUATIONS/QUIZ -->
        <div class="sidebar-section">
            <div class="sidebar-title">Évaluations</div>

            <div class="nav-item {{ request()->routeIs('admin.quiz.*') || request()->routeIs('admin.questions.*') || request()->routeIs('admin.resultats') ? 'active' : '' }} has-submenu {{ request()->routeIs('admin.quiz.*') || request()->routeIs('admin.questions.*') || request()->routeIs('admin.resultats') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="ti ti-clipboard-check"></i></span>
                    <span>Gestion des quiz</span>
                </a>
                <div class="submenu">
                    <div class="nav-item {{ request()->routeIs('admin.quiz.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz.index') }}" class="nav-link">Tous les quiz</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.quiz.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz.create') }}" class="nav-link">Ajouter un quiz</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.questions.index') }}" class="nav-link">Questions</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.resultats') ? 'active' : '' }}">
                        <a href="{{ route('admin.resultats') }}" class="nav-link">Résultats</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. ASSISTANCE PÉDAGOGIQUE -->
        <div class="sidebar-section">
            <div class="sidebar-title">Assistance</div>

            <div class="nav-item {{ request()->routeIs('admin.assistance.*') ? 'active' : '' }} has-submenu {{ request()->routeIs('admin.assistance.*') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="ti ti-help-circle"></i></span>
                    <span>Assistance pédagogique</span>
                </a>
                <div class="submenu">
                    <div class="nav-item {{ request()->routeIs('admin.assistance.questions') ? 'active' : '' }}">
                        <a href="{{ route('admin.assistance.questions') }}" class="nav-link">Questions des élèves</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.assistance.reponses') ? 'active' : '' }}">
                        <a href="{{ route('admin.assistance.reponses') }}" class="nav-link">Réponses à modérer</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. COMMUNICATION -->
        <div class="sidebar-section">
            <div class="sidebar-title">Communication</div>

            <div class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-mail"></i></span>
                    <span>Messages de contact</span>
                </a>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <a href="{{ route('admin.newsletter.index') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-send"></i></span>
                    <span>Newsletter</span>
                </a>
            </div>
        </div>

        <!-- 8. PARAMÈTRES -->
        <div class="sidebar-section">
            <div class="sidebar-title">Configuration</div>

            <div class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }} has-submenu {{ request()->routeIs('admin.settings.*') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="ti ti-settings"></i></span>
                    <span>Paramètres système</span>
                </a>
                <div class="submenu">
                    <div class="nav-item {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.general') }}" class="nav-link">Général</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.settings.securite') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.securite') }}" class="nav-link">Sécurité</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.settings.performance') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.performance') }}" class="nav-link">Performance</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.settings.sauvegardes') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.sauvegardes') }}" class="nav-link">Sauvegardes</a>
                    </div>
                    <div class="nav-item {{ request()->routeIs('admin.settings.technique') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.technique') }}" class="nav-link">Technique</a>
                    </div>
                </div>
            </div>

            <div class="nav-item {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                <a href="{{ route('admin.logs') }}" class="nav-link">
                    <span class="nav-icon"><i class="ti ti-file-analytics"></i></span>
                    <span>Journaux d'activité</span>
                </a>
            </div>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Alertes -->
        @if(session('success'))
            <div class="alert alert-success" style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid var(--success); background: #f0fdf4; color: #166534;">
                <i class="ti ti-check-circle" style="font-size: 1.2rem; flex-shrink: 0;"></i>
                <div style="flex: 1;">
                    <strong>Succès!</strong> {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #166534; font-size: 1.2rem;">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid var(--danger); background: #fef2f2; color: #991b1b;">
                <i class="ti ti-alert-circle" style="font-size: 1.2rem; flex-shrink: 0;"></i>
                <div style="flex: 1;">
                    <strong>Erreur!</strong> {{ session('error') }}
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #991b1b; font-size: 1.2rem;">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid var(--danger); background: #fef2f2; color: #991b1b;">
                <i class="ti ti-alert-triangle" style="font-size: 1.2rem; flex-shrink: 0;"></i>
                <div style="flex: 1;">
                    <strong>Attention!</strong>
                    <ul style="margin: 5px 0 0 20px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #991b1b; font-size: 1.2rem;">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif

        <!-- En-tête de page -->
        <div class="page-header">
            <h1 class="page-title">
                @yield('page-title', 'Tableau de bord')
            </h1>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Accueil</a>
                <i class="ti ti-chevron-right" style="font-size: 0.8rem;"></i>
                <span>@yield('breadcrumb', 'Tableau de bord')</span>
            </div>
        </div>

        <!-- Contenu principal -->
        @yield('content')

    </main>

    <!-- Scripts -->
    <script src="{{ asset('admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Toggle submenu
        function toggleSubmenu(element) {
            const navItem = element.closest('.has-submenu');
            const isOpen = navItem.classList.contains('open');

            // Fermer tous les autres sous-menus au même niveau
            const siblings = navItem.parentElement.querySelectorAll('.has-submenu');
            siblings.forEach(sibling => {
                if (sibling !== navItem) {
                    sibling.classList.remove('open');
                }
            });

            // Toggle current
            navItem.classList.toggle('open');
        }

        // Auto-ouvrir les sous-menus actifs au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const activeItems = document.querySelectorAll('.nav-item.active');
            activeItems.forEach(item => {
                let parent = item.closest('.has-submenu');
                while (parent) {
                    parent.classList.add('open');
                    parent = parent.parentElement.closest('.has-submenu');
                }
            });

            // Auto-fermeture des alertes après 5 secondes
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(20px)';
                    alert.style.transition = 'all 0.3s';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 5000);

            // Dropdown notifications
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationMenu = document.getElementById('notificationMenu');

            if (notificationBtn && notificationMenu) {
                notificationBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    notificationMenu.style.display = notificationMenu.style.display === 'block' ? 'none' : 'block';
                    document.getElementById('userProfileMenu').style.display = 'none';
                });
            }

            // Dropdown user profile
            const userProfileBtn = document.getElementById('userProfileBtn');
            const userProfileMenu = document.getElementById('userProfileMenu');

            if (userProfileBtn && userProfileMenu) {
                userProfileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userProfileMenu.style.display = userProfileMenu.style.display === 'block' ? 'none' : 'block';
                    notificationMenu.style.display = 'none';
                });
            }

            // Fermer les dropdowns en cliquant ailleurs
            document.addEventListener('click', () => {
                notificationMenu.style.display = 'none';
                userProfileMenu.style.display = 'none';
            });

            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
