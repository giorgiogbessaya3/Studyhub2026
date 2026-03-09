<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Kounde Avocats | Expertise Juridique à Toulouse</title>
    <style>
        :root {
            --orange: #ff8c00;
            --dark-blue: #1a2942;
            --light-bg: #f5f5f0;
            --text-dark: #333;
            --text-light: #fff;
            --text-gray: #666;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background-color: #f5f5f5;
            padding: 15px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background-color: rgba(245, 245, 245, 0.98);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 10px 60px;
            backdrop-filter: blur(10px);
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--orange), #ffb347);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .logo:hover .logo-icon::before {
            left: 100%;
        }

        .logo:hover .logo-icon {
            box-shadow: 0 6px 25px rgba(255, 140, 0, 0.5);
            transform: rotate(-5deg);
        }

        .logo-icon i {
            color: white;
            font-size: 20px;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon i {
            transform: scale(1.1);
        }

        .logo-image {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo:hover .logo-image {
            box-shadow: 0 6px 25px rgba(255, 140, 0, 0.5);
            transform: rotate(-5deg);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text-main {
            background: linear-gradient(135deg, var(--orange), #ffb347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .logo:hover .logo-text-main {
            letter-spacing: 3px;
        }

        .logo-text-sub {
            color: var(--orange);
            font-size: 10px;
            letter-spacing: 4px;
            font-weight: 600;
            text-transform: uppercase;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .logo:hover .logo-text-sub {
            letter-spacing: 5px;
            opacity: 1;
        }

        /* Navigation */
        .nav {
            display: flex;
            gap: 35px;
            align-items: center;
        }

        .nav a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .nav a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--orange), #ffb347);
            transform: translateX(-50%);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav a:hover {
            color: var(--orange);
            background-color: rgba(255, 140, 0, 0.05);
            transform: translateY(-2px);
        }

        .nav a:hover::before {
            width: 80%;
        }

        .nav a:hover i {
            transform: scale(1.2) rotate(5deg);
            transition: transform 0.3s ease;
        }

        .nav a i {
            transition: transform 0.3s ease;
        }

        /* Dropdown */
        .nav-expertises {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            position: relative;
        }

        .dropdown-arrow {
            font-size: 10px;
            color: #666;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 10px 0;
            z-index: 1000;
            display: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--orange);
            transform: scaleY(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(255, 140, 0, 0.1), transparent);
            color: var(--orange);
            padding-left: 25px;
        }

        .dropdown-item:hover::before {
            transform: scaleY(1);
        }

        .dropdown-item:hover i {
            transform: translateX(3px) rotate(5deg);
        }

        .dropdown-item i {
            transition: transform 0.3s ease;
            font-size: 16px;
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-info:hover {
            background-color: rgba(255, 140, 0, 0.05);
            transform: translateY(-2px);
        }

        .phone-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange), #ffb347);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 10px rgba(255, 140, 0, 0.2);
        }

        .contact-info:hover .phone-icon {
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 4px 20px rgba(255, 140, 0, 0.4);
        }

        .phone-icon i {
            animation: ring 2s ease-in-out infinite;
        }

        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
            50% { transform: rotate(0deg); }
        }

        .contact-info:hover .phone-icon i {
            animation: none;
        }

        .contact-text {
            display: flex;
            flex-direction: column;
        }

        .contact-label {
            font-size: 11px;
            color: #666;
            transition: color 0.3s ease;
        }

        .contact-info:hover .contact-label {
            color: var(--orange);
        }

        .contact-number {
            font-size: 15px;
            color: #333;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .contact-info:hover .contact-number {
            color: var(--orange);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            width: 30px;
            height: 24px;
            cursor: pointer;
            position: relative;
            justify-content: space-between;
        }

        .mobile-menu-toggle span {
            display: block;
            height: 3px;
            width: 100%;
            background-color: #333;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .mobile-menu-toggle:hover span {
            background-color: var(--orange);
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .header {
                padding: 15px 30px;
            }

            .nav {
                gap: 20px;
            }

            .nav a {
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }

            .nav {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: white;
                flex-direction: column;
                padding: 30px;
                gap: 20px;
                transition: left 0.3s ease;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            }

            .nav.active {
                left: 0;
            }

            .nav a {
                width: 100%;
                padding: 15px;
                font-size: 16px;
            }

            .dropdown-menu {
                position: static;
                box-shadow: none;
                margin-top: 10px;
                margin-left: 20px;
                border-left: 2px solid var(--orange);
            }

            .contact-info {
                display: none;
            }

            .mobile-contact {
                display: flex !important;
                margin-top: 20px;
                justify-content: center;
            }
        }

        /* Demo Content */
        .demo-content {
            margin-top: 100px;
            padding: 60px 30px;
            text-align: center;
        }

        .demo-content h1 {
            font-size: 48px;
            color: var(--dark-blue);
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--orange), #ffb347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .demo-content p {
            font-size: 18px;
            color: var(--text-gray);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Mobile Contact */
        .mobile-contact {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Logo dynamique -->
        <a href="{{url('/')}}" class="logo">
            @if(isset($settings) && $settings->site_logo)
                <img src="{{ asset('storage/' . $settings->site_logo) }}" alt="{{ $settings->site_name ?? 'Kounde Avocats' }}" class="logo-image">
            @else
                <div class="logo-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
            @endif
            
        </a>

        <nav class="nav">
            <a href="{{url('/')}}" class="nav-link">
                <i class="fas fa-home"></i> Accueil
            </a>
            <div class="nav-expertises dropdown">
                <a href="{{url('/expertises')}}" class="nav-link dropdown-toggle">
                    <i class="fas fa-gavel"></i> Expertises
                </a>
                <span class="dropdown-arrow"></span>
                <div class="dropdown-menu">
                    <a href="{{url('/droitimmobillier')}}" class="dropdown-item">
                        <i class="fas fa-building"></i> Droit Immobilier
                    </a>
                    <a href="{{url('/droitbancaire')}}" class="dropdown-item">
                        <i class="fas fa-landmark"></i> Droit Bancaire
                    </a>
                    <a href="{{url('/droitconstruction')}}" class="dropdown-item">
                        <i class="fas fa-hard-hat"></i> Droit de Construction
                    </a>
                    <a href="{{url('/droitfamille')}}" class="dropdown-item">
                        <i class="fas fa-users"></i> Droit de la Famille
                    </a>
                </div>
            </div>
            <a href="{{url('/about')}}" class="nav-link">
                <i class="fas fa-user-tie"></i> À propos
            </a>
            <a href="{{url('/blog')}}" class="nav-link">
                <i class="fas fa-blog"></i> Blog
            </a>
            <!-- Lien Contact dans le menu -->
            <a href="{{url('/contact')}}" class="nav-link">
                <i class="fas fa-envelope"></i> Contact
            </a>

            <!-- Contact mobile -->
            <div class="mobile-contact">
                <div class="contact-info">
                    <div class="phone-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <span class="contact-label">Contactez-moi</span>
                        <span class="contact-number">{{ $settings->site_phone ?? '+33 6 66 69 00 80' }}</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contact desktop -->
        <div class="contact-info">
            <div class="phone-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="contact-text">
                <span class="contact-label">Contactez-moi</span>
                <span class="contact-number">{{ $settings->site_phone ?? '+33 6 66 69 00 80' }}</span>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div class="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Demo Content -->
    

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Header avec effet de défilement
            const header = document.querySelector('.header');
            let lastScrollY = window.scrollY;
            
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                lastScrollY = window.scrollY;
            });
            
            // Menu déroulant pour Expertises
            const expertisesDropdown = document.querySelector('.nav-expertises');
            if (expertisesDropdown) {
                const dropdownMenu = expertisesDropdown.querySelector('.dropdown-menu');
                
                expertisesDropdown.addEventListener('mouseenter', function() {
                    dropdownMenu.style.display = 'block';
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.transform = 'translateY(0)';
                    }, 10);
                });
                
                expertisesDropdown.addEventListener('mouseleave', function() {
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        dropdownMenu.style.display = 'none';
                    }, 300);
                });
            }
            
            // Menu mobile
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            if (mobileMenuToggle) {
                const nav = document.querySelector('.nav');
                
                mobileMenuToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    nav.classList.toggle('active');
                });

                // Fermer le menu en cliquant sur un lien
                const navLinks = document.querySelectorAll('.nav a');
                navLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        nav.classList.remove('active');
                        mobileMenuToggle.classList.remove('active');
                    });
                });
            }

            // Toggle dropdown sur mobile
            if (window.innerWidth <= 768) {
                const expertisesLink = document.querySelector('.nav-expertises .dropdown-toggle');
                if (expertisesLink) {
                    expertisesLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        const dropdown = this.parentElement.querySelector('.dropdown-menu');
                        const isVisible = dropdown.style.display === 'block';
                        dropdown.style.display = isVisible ? 'none' : 'block';
                    });
                }
            }
        });
    </script>
</body>
</html>