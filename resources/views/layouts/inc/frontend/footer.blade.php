<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Footer - Kounde Avocats</title>
    <style>
        :root {
            --orange: #ff8c00;
            --orange-light: #ffb347;
            --dark-blue: #1a2942;
            --footer-dark: #2d3748;
            --footer-darker: #1e2531;
            --light-bg: #f5f5f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 2rem;
        }

        .demo-title {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .demo-subtitle {
            color: #666;
            font-size: 1.2rem;
        }

        /* Footer Contact Bar */
        .footer-contact-bar {
            background: linear-gradient(135deg, var(--dark-blue), #243a5e);
            color: white;
            padding: 35px 0;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .footer-contact-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 140, 0, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .contact-bar-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 18px;
            text-align: left;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 15px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .contact-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 140, 0, 0.15);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.2);
        }

        .contact-item-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .contact-item:hover .contact-item-icon {
            transform: rotate(360deg) scale(1.1);
            box-shadow: 0 6px 25px rgba(255, 140, 0, 0.5);
        }

        .contact-details {
            display: flex;
            flex-direction: column;
        }

        .contact-main {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }

        .contact-item:hover .contact-main {
            color: var(--orange-light);
        }

        .contact-label {
            font-size: 0.85rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .address-bubble {
            display: block;
            font-size: 0.85rem;
            opacity: 0.7;
            margin-bottom: 5px;
            font-style: italic;
        }

        /* Main Footer */
        .main-footer {
            background: linear-gradient(to bottom, var(--footer-dark), var(--footer-darker));
            color: white;
            padding: 60px 0 0;
            position: relative;
        }

        .main-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--orange), transparent);
        }

        .main-footer-container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        /* Footer Logo Section */
        .footer-logo-group {
            display: flex;
            flex-direction: column;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .footer-logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.3);
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

        .footer-logo:hover .logo-icon::before {
            left: 100%;
        }

        .footer-logo:hover .logo-icon {
            transform: rotate(-5deg);
            box-shadow: 0 8px 30px rgba(255, 140, 0, 0.5);
        }

        .logo-icon i {
            color: white;
            font-size: 1.5rem;
            z-index: 1;
        }

        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-logo:hover .logo-image {
            transform: rotate(-5deg);
            box-shadow: 0 8px 30px rgba(255, 140, 0, 0.5);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .footer-logo-text-main {
            font-weight: bold;
            font-size: 1.6rem;
            line-height: 1;
            background: linear-gradient(135deg, white, var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
        }

        .footer-logo-text-sub {
            font-size: 0.75rem;
            opacity: 0.8;
            color: white;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .footer-description {
            margin-bottom: 25px;
            opacity: 0.85;
            line-height: 1.8;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.95rem;
        }

        .footer-description i {
            color: var(--orange);
            margin-top: 4px;
            font-size: 1.1rem;
        }

        .footer-social-links {
            display: flex;
            gap: 12px;
        }

        .social-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .social-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--orange);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
        }

        .social-icon:hover::before {
            width: 100%;
            height: 100%;
        }

        .social-icon i {
            position: relative;
            z-index: 1;
        }

        .social-icon:hover {
            transform: translateY(-5px) scale(1.1);
            border-color: var(--orange);
            box-shadow: 0 8px 20px rgba(255, 140, 0, 0.4);
        }

        /* Footer Links Groups */
        .footer-links-group h4 {
            margin-bottom: 25px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-links-group h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--orange), var(--orange-light));
            border-radius: 3px;
        }

        .footer-links-group h4 i {
            color: var(--orange);
            font-size: 1.1rem;
        }

        .footer-links-group a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin-bottom: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            padding: 8px 12px;
            border-radius: 6px;
            position: relative;
        }

        .footer-links-group a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 70%;
            background: linear-gradient(90deg, var(--orange), transparent);
            transition: width 0.3s ease;
            border-radius: 3px;
        }

        .footer-links-group a:hover::before {
            width: 3px;
        }

        .footer-links-group a:hover {
            color: var(--orange-light);
            padding-left: 20px;
            background: rgba(255, 140, 0, 0.05);
        }

        .footer-links-group a i {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .footer-links-group a:hover i {
            transform: translateX(5px);
        }

        /* Newsletter Section */
        .footer-newsletter h4 {
            margin-bottom: 15px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .footer-newsletter h4 i {
            color: var(--orange);
        }

        .newsletter-title-highlight {
            color: var(--orange-light);
            display: block;
            font-size: 1.3rem;
            margin-top: 5px;
        }

        .newsletter-description {
            margin-bottom: 20px;
            opacity: 0.85;
            line-height: 1.7;
            font-size: 0.9rem;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            position: relative;
        }

        .newsletter-input {
            flex: 1;
            padding: 14px 18px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .newsletter-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        .newsletter-button {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border: none;
            color: white;
            padding: 14px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .newsletter-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.5s ease;
        }

        .newsletter-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .newsletter-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.5);
        }

        .newsletter-button i {
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .newsletter-button:hover i {
            transform: translateX(5px);
        }

        /* Footer Copyright */
        .footer-copyright {
            text-align: center;
            padding: 25px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.85rem;
            background: rgba(0, 0, 0, 0.2);
        }

        .footer-copyright i {
            transition: transform 0.3s ease;
        }

        .footer-copyright .fa-heart {
            color: var(--orange);
            animation: heartbeat 1.5s ease-in-out infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-footer-container {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }
            
            .footer-newsletter {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .demo-title {
                font-size: 2rem;
            }

            .contact-bar-container {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .contact-item {
                justify-content: center;
                text-align: center;
                width: 100%;
                max-width: 350px;
            }

            .main-footer-container {
                grid-template-columns: 1fr;
                gap: 35px;
            }
            
            .footer-newsletter {
                grid-column: span 1;
            }
            
            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-button {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 2rem 1rem;
            }

            .footer-contact-bar {
                padding: 25px 0;
            }
            
            .main-footer {
                padding: 40px 0 0;
            }
            
            .main-footer-container {
                padding: 0 15px 30px;
                gap: 30px;
            }
            
            .footer-logo {
                justify-content: center;
                text-align: center;
            }
            
            .footer-description {
                text-align: center;
                justify-content: center;
            }
            
            .footer-social-links {
                justify-content: center;
            }
            
            .footer-links-group {
                text-align: center;
            }
            
            .footer-links-group h4 {
                justify-content: center;
            }

            .footer-links-group h4::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .footer-newsletter {
                text-align: center;
            }

            .footer-newsletter h4 {
                justify-content: center;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Demo Content -->
    
   
    <!-- Footer Contact Bar -->
    <div class="footer-contact-bar">
        <div class="contact-bar-container">
            <div class="contact-item">
                <div class="contact-item-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="contact-details">
                    <span class="contact-main" id="footer-phone">{{ $settings->site_phone ?? '+33 6 66 69 00 80' }}</span>
                    <span class="contact-label">Téléphone direct</span>
                </div>
            </div>
            <div class="contact-item contact-item-address">
                <div class="contact-item-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-details">
                    <span class="address-bubble">Centre-ville Toulouse</span>
                    <span class="contact-main" id="footer-address">{{ $settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse' }}</span>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="contact-details">
                    <span class="contact-main" id="footer-hours">{{ $settings->working_hours ?? 'Lun - Sam: 9h - 18h' }}</span>
                    <span class="contact-label">Sur rendez-vous</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="main-footer-container">
            
            <div class="footer-logo-group">
                <a href="{{ url('/') }}" class="footer-logo">
                    @if(isset($settings) && $settings->site_logo)
                        <img src="{{ asset('storage/' . $settings->site_logo) }}" alt="{{ $settings->site_name ?? 'Kounde Avocats' }}" class="logo-image">
                    @else
                        <div class="logo-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    @endif
                    
                </a>
                <p class="footer-description">
                    <i class="fas fa-map-pin"></i> 
                    <span id="footer-description">{{ $settings->footer_description ?? 'Votre avocat à Toulouse spécialisé en droit Immobilier, Bancaire et de la Construction.' }}</span>
                </p>
                <div class="footer-social-links">
                    @if($settings->facebook_url ?? false)
                    <a href="{{ $settings->facebook_url }}" class="social-icon" title="Facebook" aria-label="Facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($settings->instagram_url ?? false)
                    <a href="{{ $settings->instagram_url }}" class="social-icon" title="Instagram" aria-label="Instagram" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if($settings->linkedin_url ?? false)
                    <a href="{{ $settings->linkedin_url }}" class="social-icon" title="LinkedIn" aria-label="LinkedIn" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if($settings->twitter_url ?? false)
                    <a href="{{ $settings->twitter_url }}" class="social-icon" title="Twitter" aria-label="Twitter" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($settings->youtube_url ?? false)
                    <a href="{{ $settings->youtube_url }}" class="social-icon" title="YouTube" aria-label="YouTube" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div class="footer-links-group">
                <h4><i class="fas fa-link"></i> Liens rapides</h4>
                <a href="{{ url('/') }}">
                    <i class="fas fa-chevron-right"></i> Accueil
                </a>
                <a href="{{ url('/expertises') }}">
                    <i class="fas fa-chevron-right"></i> Expertises
                </a>
                <a href="{{ url('/blog') }}">
                    <i class="fas fa-chevron-right"></i> Blog
                </a>
                <a href="{{ url('/about') }}">
                    <i class="fas fa-chevron-right"></i> À propos
                </a>
                <a href="{{ url('/contact') }}">
                    <i class="fas fa-chevron-right"></i> Contact
                </a>
            </div>

            <div class="footer-links-group">
                <h4><i class="fas fa-gavel"></i> Mentions légales</h4>
                <a href="#">
                    <i class="fas fa-chevron-right"></i> CGU
                </a>
                <a href="#">
                    <i class="fas fa-chevron-right"></i> Mentions légales
                </a>
                <a href="#">
                    <i class="fas fa-chevron-right"></i> Politique confidentialité
                </a>
                <a href="#">
                    <i class="fas fa-chevron-right"></i> Cookies
                </a>
            </div>

            @if($settings->newsletter_enabled ?? true)
            <div class="footer-newsletter">
                <h4>
                    <i class="fas fa-paper-plane"></i> Restez informés
                    <span class="newsletter-title-highlight">Abonnez-vous à notre newsletter</span>
                </h4>
                <p class="newsletter-description">
                    Recevez nos actualités juridiques et conseils directement dans votre boîte mail.
                </p>
                <form class="newsletter-form" id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Votre adresse mail..." class="newsletter-input" required aria-label="Email">
                    <button type="submit" class="newsletter-button" aria-label="S'abonner">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            @endif
        </div>
        
        <div class="footer-copyright">
            <i class="far fa-copyright"></i> 
            <span id="footer-copyright">{{ $settings->footer_copyright ?? '© 2025 Kounde Avocats - Tous droits réservés' }}</span> 
            | Conçu avec <i class="fas fa-heart"></i> pour la justice
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du formulaire de newsletter
            const newsletterForm = document.getElementById('newsletterForm');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const button = this.querySelector('.newsletter-button');
                    const originalHTML = button.innerHTML;
                    
                    // Animation de chargement
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Animation de succès
                            button.innerHTML = '<i class="fas fa-check"></i>';
                            button.style.background = 'linear-gradient(135deg, #4CAF50, #66BB6A)';
                            
                            setTimeout(() => {
                                button.innerHTML = originalHTML;
                                button.style.background = '';
                                button.disabled = false;
                                this.reset();
                                alert(data.message || 'Merci ! Vous êtes maintenant inscrit à notre newsletter.');
                            }, 1500);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        button.innerHTML = originalHTML;
                        button.disabled = false;
                        alert(error.message || 'Une erreur est survenue. Veuillez réessayer.');
                    });
                });
            }

            // Animation des icônes sociales au clic
            const socialIcons = document.querySelectorAll('.social-icon');
            socialIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    this.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                });
            });

            // Smooth scroll pour les liens internes
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Animation d'apparition au scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observer les sections du footer
            document.querySelectorAll('.footer-logo-group, .footer-links-group, .footer-newsletter').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });
        });
    </script>

</body>
</html>