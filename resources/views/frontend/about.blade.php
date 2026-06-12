@extends('layouts.app')

@section('title', 'About')

@section('content')
<!-- Page Header Start -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <title>Kounde Avocats - À Propos</title>
    <style>
        .about-page-body {
            background-color: #f5f5f0;
        }

        /* Hero Section */
        .about-hero-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            padding: 140px 0 80px;

            position: relative;
            overflow: hidden;
        }

        .about-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ff8c00" opacity="0.1"><path d="M500 50Q400 90 300 50T100 50Q200 10 300 50T500 50Q600 90 700 50T900 50Q800 10 700 50T500 50Z"/></svg>');
            background-size: cover;
        }

        .about-hero-content {
            position: relative;
            z-index: 2;
        }

        .about-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff8c00, #ffa94d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-hero-breadcrumb {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        .text-orange {
            color: #ff8c00 !important;
            font-weight: 600;
        }

        /* Main About Section */
        .main-about-section {
            padding: 80px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .about-story-section {
            background: white;
            padding: 60px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 80px;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .section-label i {
            color: #ff8c00;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            line-height: 1.2;
            margin-bottom: 30px;
        }

        .story-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .story-text {
            line-height: 1.7;
            color: #333;
        }

        .story-text p {
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .story-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .story-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Values Section */
        .values-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .value-card {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: #fff0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 2px solid #ff8c00;
        }

        .value-icon i {
            color: #ff8c00;
            font-size: 2rem;
        }

        .value-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 15px;
        }

        .value-description {
            color: #666;
            line-height: 1.6;
        }

        /* Experience Section */
        .experience-section {
            padding: 80px 0;
            background: white;
        }

        .experience-timeline {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .experience-timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ff8c00;
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 50%;
            padding: 0 40px;
        }

        .timeline-item:nth-child(odd) {
            left: 0;
        }

        .timeline-item:nth-child(even) {
            left: 50%;
        }

        .timeline-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            border-left: 4px solid #ff8c00;
        }

        .timeline-year {
            position: absolute;
            top: -15px;
            left: -40px;
            background: #ff8c00;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .timeline-item:nth-child(even) .timeline-year {
            left: auto;
            right: -40px;
        }

        .timeline-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 10px;
        }

        .timeline-description {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            padding: 80px 0;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .stat-item {
            padding: 30px 20px;
        }

        .stat-number {
            display: block;
            font-size: 3rem;
            font-weight: bold;
            color: #ff8c00;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: #f8f9fa;
            text-align: center;
        }

        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            margin-bottom: 20px;
        }

        .cta-description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff8c00, #ffa94d);
            border: none;
            color: white;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .about-hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .story-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .values-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .experience-timeline::before {
                left: 30px;
            }

            .timeline-item {
                width: 100%;
                left: 0 !important;
                padding-left: 70px;
                padding-right: 0;
            }

            .timeline-year {
                left: 0 !important;
                right: auto !important;
            }
        }

        @media (max-width: 576px) {
            .about-hero-section {
                padding: 100px 0 40px;
            }

            .main-about-section,
            .values-section,
            .experience-section,
            .stats-section,
            .cta-section {
                padding: 40px 0;
            }

            .about-hero-title {
                font-size: 2rem;
            }

            .about-story-section {
                padding: 30px;
            }

            .cta-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="about-page-body">

    <section class="about-hero-section">
        <div class="container py-1 text-center about-hero-content">
            <h1 class="about-hero-title mb-3">
                <i class="fas fa-user-tie me-3"></i>À <span class="text-orange">Propos</span>
            </h1>
            <p class="about-hero-breadcrumb">
                <i class="fas fa-home me-2"></i>Accueil / <span class="text-orange">À Propos</span>
            </p>
        </div>
    </section>

    <section class="main-about-section">
        <div class="container">
            <div class="about-story-section">
                <div class="section-label">
                    <i class="fas fa-rocket"></i>
                    Mon Parcours
                </div>
                <h2 class="section-title">
                    Maître Koundé : <span class="text-orange">20 ans d'expertise</span> au service de vos droits
                </h2>

                <div class="story-content">
                    <div class="story-text">
                        <p>
                            <i class="fas fa-gavel text-orange me-2"></i>
                            Fort de plus de 20 années d'expérience dans le domaine juridique, Maître Koundé a développé une expertise reconnue en droit immobilier, bancaire et de la construction. Son parcours témoigne d'un engagement constant en faveur de la défense des droits de ses clients.
                        </p>
                        <p>
                            <i class="fas fa-graduation-cap text-orange me-2"></i>
                            Diplômé de l'École de Formation du Barreau de Paris et titulaire d'un Master en Droit des Affaires, Maître Koundé a débuté sa carrière dans un grand cabinet parisien avant de fonder son propre cabinet à Toulouse, sa ville natale.
                        </p>
                        <p>
                            <i class="fas fa-heart text-orange me-2"></i>
                            Sa philosophie : allier expertise technique et approche humaine. Chaque client est unique et mérite une attention particulière, une écoute attentive et une stratégie juridique sur mesure.
                        </p>
                    </div>
                    <div class="story-image">
                        <img src="{{ asset('studyima.png') }}" alt="Maître Koundé">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <div class="section-label text-center">
                <i class="fas fa-star"></i>
                Mes Valeurs
            </div>
            <h2 class="section-title text-center mb-5">
                Les principes qui <span class="text-orange">guident mon action</span>
            </h2>

            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="value-title">Intégrité</h3>
                    <p class="value-description">
                        Je m'engage à exercer mon métier avec la plus grande éthique professionnelle, en toute transparence et honnêteté.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="value-title">Écoute</h3>
                    <p class="value-description">
                        Chaque situation est unique. Je prends le temps de comprendre vos besoins spécifiques pour vous proposer la meilleure stratégie.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="value-title">Excellence</h3>
                    <p class="value-description">
                        Je m'engage à fournir un service de qualité supérieure, en me tenant constamment informé des évolutions juridiques.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="experience-section">
        <div class="container">
            <div class="section-label text-center">
                <i class="fas fa-briefcase"></i>
                Mon Parcours Professionnel
            </div>
            <h2 class="section-title text-center mb-5">
                20 ans d'<span class="text-orange">expérience</span> et de réussites
            </h2>

            <div class="experience-timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2005</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Diplômé de l'EFB Paris</h3>
                        <p class="timeline-description">
                            Obtention du CAPA et début de carrière dans un cabinet spécialisé en droit immobilier.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2010</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Spécialisation en Droit Bancaire</h3>
                        <p class="timeline-description">
                            Développement d'une expertise pointue dans les litiges bancaires et le surendettement.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2015</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Ouverture du Cabinet à Toulouse</h3>
                        <p class="timeline-description">
                            Création de mon propre cabinet avec une approche pluridisciplinaire centrée sur le client.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Expertise en Droit de la Construction</h3>
                        <p class="timeline-description">
                            Développement d'une spécialisation en contentieux de la construction et responsabilité décennale.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">20+</span>
                    <span class="stat-label">Ans d'Expérience</span>
                </div>

                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Dossiers Traités</span>
                </div>

                <div class="stat-item">
                    <span class="stat-number">1000+</span>
                    <span class="stat-label">Clients Accompagnés</span>
                </div>

                <div class="stat-item">
                    <span class="stat-number">95%</span>
                    <span class="stat-label">Taux de Satisfaction</span>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">
                    Prêt à défendre <span class="text-orange">vos droits</span> ?
                </h2>
                <p class="cta-description">
                    Que vous soyez confronté à un litige immobilier, bancaire ou de construction, je suis à vos côtés pour vous conseiller et vous défendre avec détermination.
                </p>
                <a href="{{url('/contact')}}" class="btn-primary">
                    <i class="fas fa-comments me-2"></i>Prendre Rendez-vous
                </a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au défilement
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observer les éléments à animer
            const animatedElements = document.querySelectorAll('.value-card, .timeline-content, .stat-item');
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
        });
    </script>

</body>
</html>
@endsection
