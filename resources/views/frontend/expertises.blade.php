@extends('layouts.app')

@section('title', 'Expertises')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>Kounde Avocats - Expertises</title>
    <style>
        .expertises-page-body {
            background-color: #f5f5f0;
        }

        /* Hero Section */
        .expertises-hero-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            padding: 140px 0 80px;
            
            position: relative;
            overflow: hidden;
        }

        .expertises-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ff8c00" opacity="0.1"><path d="M500 50Q400 90 300 50T100 50Q200 10 300 50T500 50Q600 90 700 50T900 50Q800 10 700 50T500 50Z"/></svg>');
            background-size: cover;
        }

        .page-hero-content {
            position: relative;
            z-index: 2;
        }

        .page-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .text-orange {
            color: #ff8c00 !important;
            font-weight: 600;
        }

        .text-white {
            color: white !important;
        }

        .page-hero-breadcrumb {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        /* Main Grid Section */
        .main-expertises-grid-section {
            padding: 80px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .expertise-card {
            display: block;
            text-decoration: none;
            color: inherit;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            height: 300px;
        }

        .expertise-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .expertise-card:hover .card-image {
            transform: scale(1.05);
        }

        .card-title-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(26, 41, 66, 0.9));
            color: white;
            padding: 30px 20px 20px;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-hero-title {
                font-size: 2.5rem;
            }

            .expertise-card {
                height: 250px;
            }
        }

        @media (max-width: 576px) {
            .expertises-hero-section {
                padding: 100px 0 40px;
            }
            
            .main-expertises-grid-section {
                padding: 40px 0;
            }
            
            .page-hero-title {
                font-size: 2rem;
            }
            
            .card-title-overlay {
                font-size: 1.3rem;
                padding: 20px 15px 15px;
            }
        }
    </style>
</head>
<body class="expertises-page-body">

    <section class="expertises-hero-section">
        <div class="container py-5 text-center page-hero-content">
            <h1 class="page-hero-title mb-3">
                <i class="fas fa-gavel me-3"></i>Nos <span class="text-orange">Expertises</span>
            </h1>
            <p class="page-hero-breadcrumb">
                <i class="fas fa-home me-2"></i>Accueil / <span class="text-orange">Expertises</span>
            </p>
        </div>
    </section>

    <section class="main-expertises-grid-section py-5">
        <div class="container">
            <div class="row g-4">
                
                <div class="col-lg-4 col-md-6">
                    <a href="droitbancaire.html" class="expertise-card">
                        <img src="img/bancaire.png" alt="Droit Bancaire" class="card-image img-fluid">
                        <div class="card-title-overlay">
                            <i class="fas fa-landmark me-2"></i>Droit Bancaire
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="droitimmobilier.html" class="expertise-card">
                        <img src="img/imobil.png" alt="Droit Immobilier" class="card-image">
                        <div class="card-title-overlay">
                            <i class="fas fa-building me-2"></i>Droit Immobilier
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="droitconstruction.html" class="expertise-card">
                        <img src="img/construction.png" alt="Droit de Construction" class="card-image">
                        <div class="card-title-overlay">
                            <i class="fas fa-hard-hat me-2"></i>Droit de Construction
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="droitfamille.html" class="expertise-card">
                        <img src="img/imobil.png" alt="Droit de la Famille" class="card-image">
                        <div class="card-title-overlay">
                            <i class="fas fa-users me-2"></i>Droit de la Famille
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <a href="droitconsommation.html" class="expertise-card">
                        <img src="img/imobil.png" alt="Droit de la Consommation" class="card-image">
                        <div class="card-title-overlay">
                            <i class="fas fa-shopping-cart me-2"></i>Droit de la Consommation
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="autres-expertises.html" class="expertise-card">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=700&h=400&fit=crop" alt="Autres Expertises" class="card-image">
                        <div class="card-title-overlay">
                            <i class="fas fa-plus-circle me-2"></i>Autres Domaines
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes d'expertises
            const expertiseCards = document.querySelectorAll('.expertise-card');
            expertiseCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });

            // Animation au défilement
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            expertiseCards.forEach(card => observer.observe(card));
        });
    </script>

</body>
</html>

@endsection