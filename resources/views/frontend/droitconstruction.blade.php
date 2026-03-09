@extends('layouts.app')

@section('title', 'thank you  for shopping')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>Kounde Avocats - Droit de la Construction</title>
    <style>
        .expertise-page-body {
            background-color: #f5f5f0;
        }

        .expertise-hero-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            padding: 140px 0 80px;
            
            position: relative;
            overflow: hidden;
        }

        .expertise-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ff8c00" opacity="0.1"><path d="M500 50Q400 90 300 50T100 50Q200 10 300 50T500 50Q600 90 700 50T900 50Q800 10 700 50T500 50Z"/></svg>');
            background-size: cover;
        }

        .expertise-hero-content {
            position: relative;
            z-index: 2;
        }

        .expertise-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff8c00, #ffa94d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .expertise-hero-breadcrumb {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        .text-orange {
            color: #ff8c00 !important;
            font-weight: 600;
        }

        .expertise-content-section {
            padding: 80px 0;
        }

        .expertise-sidebar {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
        }

        .sidebar-title {
            color: #1a2942;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .sidebar-expertise-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .sidebar-expertise-link:hover {
            color: #ff8c00;
            transform: translateX(5px);
        }

        .sidebar-expertise-link i {
            color: #ff8c00;
            transition: transform 0.3s ease;
        }

        .sidebar-expertise-link:hover i {
            transform: translateX(3px);
        }

        .sidebar-contact-block {
            background: linear-gradient(135deg, #ff8c00, #ffa94d);
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .contact-block-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .contact-block-subtitle {
            opacity: 0.9;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .contact-block-phone {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .contact-block-phone i {
            font-size: 1.2rem;
        }

        .expertise-main-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .expertise-description {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .expertise-description p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #333;
        }

        .process-expertise-page {
            background: white;
            padding: 80px 0;
        }

        .process-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .process-main-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            line-height: 1.1;
        }

        .highlight-orange {
            color: #ff8c00;
        }

        .process-steps {
            margin-top: 40px;
        }

        .step-item {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: #ff8c00;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 8px;
        }

        .step-description {
            color: #666;
            line-height: 1.6;
        }

        .process-image-expertise-page {
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .process-stats-block-expertise-page {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            gap: 30px;
        }

        .stat-item-expertise {
            text-align: center;
            padding: 0 20px;
        }

        .stat-item-expertise.border-start {
            border-left: 2px solid #f0f0f0;
        }

        .stat-number-expertise {
            display: block;
            font-size: 2rem;
            font-weight: bold;
            color: #ff8c00;
            line-height: 1;
        }

        .stat-label-expertise {
            display: block;
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        .btn-process-contact {
            margin-top: 50px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .why-us-section {
            background: #f5f5f0;
            padding: 80px 0;
        }

        .why-us-image {
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .why-us-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .why-us-main-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            line-height: 1.1;
        }

        .advantage-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .advantage-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .card-icon-wrapper {
            width: 60px;
            height: 60px;
            background: #fff0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 2px solid #ff8c00;
        }

        .card-icon {
            font-size: 1.5rem;
            color: #ff8c00;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 10px;
        }

        .card-description {
            color: #666;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .btn-why-us-contact {
            padding: 12px 30px;
            font-weight: 600;
        }

        .faq-section {
            background: white;
            padding: 80px 0;
        }

        .faq-header {
            max-width: 600px;
            margin: 0 auto;
        }

        .faq-main-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            margin-bottom: 20px;
        }

        .faq-description {
            color: #666;
            line-height: 1.7;
            font-size: 1.1rem;
        }

        .faq-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .faq-question {
            background: white;
            border: none;
            padding: 20px 25px;
            font-weight: 600;
            color: #1a2942;
            font-size: 1rem;
        }

        .faq-question:not(.collapsed) {
            background: #fff0e0;
            color: #ff8c00;
        }

        .faq-answer {
            background: #f8f9fa;
            border: none;
            padding: 20px 25px;
            color: #666;
            line-height: 1.7;
        }

        .faq-answer-active {
            background: #fff0e0;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .expertise-sidebar,
        .expertise-description,
        .advantage-card,
        .faq-item {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .expertise-hero-title {
                font-size: 2.5rem;
            }
            
            .process-main-title,
            .why-us-main-title,
            .faq-main-title {
                font-size: 2rem;
            }
            
            .process-stats-block-expertise-page {
                position: relative;
                bottom: 0;
                margin-top: 30px;
            }
            
            .sidebar-contact-block {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .expertise-hero-section {
                padding: 120px 0 60px;
            }
            
            .expertise-content-section,
            .process-expertise-page,
            .why-us-section,
            .faq-section {
                padding: 60px 0;
            }
            
            .expertise-hero-title {
                font-size: 2rem;
            }
            
            .process-stats-block-expertise-page {
                flex-direction: column;
                gap: 15px;
            }
            
            .stat-item-expertise.border-start {
                border-left: none;
                border-top: 2px solid #f0f0f0;
                padding-top: 15px;
            }
        }
    </style>
</head>
<body class="expertise-page-body">

    <section class="expertise-hero-section">
        <div class="container  text-center expertise-hero-content">
            <h1 class="expertise-hero-title mb-3">
                <i class="fas fa-hard-hat me-3"></i>Droit de la <span class="text-orange">Construction</span>
            </h1>
            <p class="expertise-hero-breadcrumb">
                <i class="fas fa-home me-2"></i>Accueil / <i class="fas fa-gavel me-2"></i>Expertises / <span class="text-orange">Droit de la Construction</span>
            </p>
        </div>
    </section>

    <section class="expertise-content-section py-5">
        <div class="container">
            <div class="row g-5">
                
                <div class="col-lg-4">
                    <div class="expertise-sidebar">
                        
                        <div class="sidebar-block-list mb-4">
                            <h5 class="sidebar-title">
                                <i class="fas fa-scale-balanced me-2"></i>Nous défendons aussi:
                            </h5>
                            <a href="droitimmobilier.html" class="sidebar-expertise-link">
                                <i class="fas fa-building me-2"></i>Droit Immobilier
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="droitbancaire.html" class="sidebar-expertise-link">
                                <i class="fas fa-landmark me-2"></i>Droit Bancaire
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="droitfamille.html" class="sidebar-expertise-link">
                                <i class="fas fa-users me-2"></i>Droit de la famille
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        
                        <div class="sidebar-contact-block">
                            <h6 class="contact-block-title">
                                <i class="fas fa-info-circle me-2"></i>Besoin de plus d'infos?
                            </h6>
                            <p class="contact-block-subtitle">Contactez-nous !</p>
                            <div class="contact-block-phone">
                                <i class="fas fa-phone-volume"></i>
                                <span>(+33) 6 66 69 00 80</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-8">
                    
                    <div class="expertise-main-image mb-4">
                        <img src="img/construction.png" alt="Droit de la Construction" class="img-fluid rounded">
                    </div>

                    <div class="expertise-description">
                        <p>
                            <i class="fas fa-gavel text-orange me-2"></i>
                            Le droit de la construction régit les relations entre maîtres d'ouvrage, maîtres d'œuvre et entreprises du BTP. Notre cabinet vous accompagne dans tous les aspects juridiques de vos projets de construction, de la conception à la réception des travaux.
                        </p>
                        <p>
                            <i class="fas fa-shield-alt text-orange me-2"></i>
                            Nous intervenons pour sécuriser vos contrats de construction, prévenir les litiges et défendre vos droits en cas de désordres, retards ou malfaçons. Notre expertise couvre les responsabilités décennales, les garanties de parfait achèvement, les CCMI et tous les contentieux liés aux travaux.
                        </p>
                        <p>
                            <i class="fas fa-handshake text-orange me-2"></i>
                            Nous privilégions une approche pragmatique et technique, permettant d'anticiper les risques et de résoudre efficacement les différends. Que vous soyez promoteur, constructeur, architecte ou particulier, nous vous accompagnons avec expertise tout au long de votre projet.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="process-section process-expertise-page">
        <div class="container">
            <div class="row align-items-center g-5">
                
                <div class="col-lg-6">
                    <p class="process-label">
                        <i class="fas fa-road text-orange"></i>
                        Notre Méthodologie
                    </p>
                    <h2 class="process-main-title mb-4">
                        Nous vous guidons à chaque <span class="highlight-orange">étape</span> du process
                    </h2>
                    <a href="#" class="btn btn-primary d-inline-block mb-4 d-lg-none">
                        <i class="fas fa-comments me-2"></i>Contactez-nous
                    </a>
                    
                    <div class="process-steps">
                        
                        <div class="step-item">
                            <div class="step-number">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="step-content">
                                <h4 class="step-title">Analyse Technique et Juridique</h4>
                                <p class="step-description">
                                    Nous examinons ensemble votre projet de construction lors d'un premier échange approfondi pour identifier les enjeux techniques et juridiques spécifiques.
                                </p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">
                                <i class="fas fa-chess-board"></i>
                            </div>
                            <div class="step-content">
                                <h4 class="step-title">Élaboration de la Stratégie Contractuelle</h4>
                                <p class="step-description">
                                    Je conçois une approche sur mesure, adaptée à votre projet de construction, qu'il s'agisse de rédaction de contrats, de négociation ou de contentieux.
                                </p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="step-content">
                                <h4 class="step-title">Suivi et Résolution des Litiges</h4>
                                <p class="step-description">
                                    Je reste à vos côtés tout au long du projet, garantissant un suivi rigoureux et intervenant rapidement en cas de désordres ou de contentieux.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center position-relative">
                    <img src="img/reu1.png" alt="Processus juridique construction" class="img-fluid process-image-expertise-page rounded">
                    
                    <div class="process-stats-block-expertise-page">
                        <div class="stat-item-expertise">
                            <span class="stat-number-expertise">20+</span>
                            <span class="stat-label-expertise">Ans d'Expérience</span>
                        </div>
                        <div class="stat-item-expertise border-start">
                            <span class="stat-number-expertise">300+</span>
                            <span class="stat-label-expertise">Projets Accompagnés</span>
                        </div>
                    </div>
                    
                    <a href="#" class="btn btn-primary btn-process-contact d-none d-lg-inline-block">
                        <i class="fas fa-comments me-2"></i>Contactez-nous
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="why-us-section">
        <div class="container">
            <div class="row align-items-center g-5">
                
                <div class="col-lg-5">
                    <div class="why-us-image-wrapper">
                        <img src="img/ima.png" alt="Maître Koundé parlant" class="img-fluid why-us-image rounded">
                    </div>
                </div>

                <div class="col-lg-7">
                    <p class="why-us-label">
                        <i class="fas fa-handshake text-orange"></i>
                        Pourquoi choisir notre cabinet?
                    </p>
                    <h2 class="why-us-main-title mb-4">
                        Sécuriser vos <span class="highlight-orange">projets de construction</span>, notre mission
                    </h2>
                    <a href="#" class="btn btn-primary d-inline-block mb-4 d-lg-none">
                        <i class="fas fa-comments me-2"></i>Contactez-nous
                    </a>

                    <div class="row row-cols-md-2 g-4">
                        
                        <div class="col">
                            <div class="advantage-card">
                                <div class="card-icon-wrapper">
                                    <i class="fas fa-medal card-icon"></i>
                                </div>
                                <h4 class="card-title">Expertise technique et juridique</h4>
                                <p class="card-description">
                                    Plus de 20 ans d'expérience combinant compétences juridiques et connaissance technique des métiers du BTP.
                                </p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="advantage-card">
                                <div class="card-icon-wrapper">
                                    <i class="fas fa-chess-knight card-icon"></i>
                                </div>
                                <h4 class="card-title">Stratégie contractuelle efficace</h4>
                                <p class="card-description">
                                    Je conçois des stratégies personnalisées, adaptées à la complexité technique de votre projet de construction.
                                </p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="advantage-card">
                                <div class="card-icon-wrapper">
                                    <i class="fas fa-heart card-icon"></i>
                                </div>
                                <h4 class="card-title">Approche Pragmatique</h4>
                                <p class="card-description">
                                    Pour chaque client, je privilégie des solutions concrètes et opérationnelles, adaptées aux réalités du chantier.
                                </p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="advantage-card">
                                <div class="card-icon-wrapper">
                                    <i class="fas fa-shield-alt card-icon"></i>
                                </div>
                                <h4 class="card-title">Engagement total</h4>
                                <p class="card-description">
                                    Je m'engage à vos côtés de l'avant-projet à la réception des travaux, avec détermination et professionnalisme.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" class="btn btn-primary btn-why-us-contact d-none d-lg-inline-block mt-4">
                        <i class="fas fa-comments me-2"></i>Contactez-nous
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="faq-section">
        <div class="container">
            <div class="faq-header text-center mb-5">
                <h2 class="faq-main-title">
                    <i class="fas fa-question-circle me-3"></i>Notre <span class="highlight-orange">FAQ</span>
                </h2>
                <p class="faq-description">
                    Nous simplifions les questions juridiques complexes en vous fournissant des réponses claires, précises et adaptées à vos préoccupations les plus courantes. Notre objectif est de vous donner la compréhension nécessaire pour avancer en toute confiance.
                </p>
            </div>

            <div class="accordion" id="faqAccordion">
                
                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="fas fa-file-contract me-3"></i>
                            Quels types de dossiers de construction votre cabinet prend-il en charge ?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer">
                            Notre cabinet est spécialisé dans tous les aspects du droit de la construction : contrats de construction (CCMI, marchés de travaux), responsabilités décennales et biennale, garanties de parfait achèvement, litiges de malfaçons, retards de livraison, contentieux avec les entreprises et les architectes, et conseil en assurance construction.
                        </div>
                    </div>
                </div>

                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fas fa-calendar-check me-3"></i>
                            Comment puis-je planifier une consultation ?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer faq-answer-active">
                            Vous pouvez facilement réserver une première consultation gratuite en appelant notre cabinet au (+33) 6 66 69 00 80 ou via le formulaire de contact disponible sur notre site. Nous vous recevons dans nos bureaux toulousains ou en visioconférence selon vos préférences.
                        </div>
                    </div>
                </div>

                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="fas fa-folder-open me-3"></i>
                            Que dois-je apporter à mon premier rendez-vous ?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer">
                            Veuillez apporter tous les documents pertinents à votre projet de construction : contrats signés, plans, devis, photos des désordres, rapports d'expertise, correspondances avec les entreprises, attestations d'assurance, etc. Cela nous aidera à évaluer votre situation avec la plus grande précision.
                        </div>
                    </div>
                </div>

                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="fas fa-euro-sign me-3"></i>
                            Quel est le coût de vos services juridiques ?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer">
                            Nos honoraires sont fixés en toute transparence, généralement au forfait ou au temps passé, en fonction de la complexité technique et juridique de votre dossier. Une estimation détaillée vous sera fournie dès la première consultation. Nous proposons également des solutions de paiement échelonné pour les particuliers.
                        </div>
                    </div>
                </div>

                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <i class="fas fa-gavel me-3"></i>
                            Mon affaire de construction ira-t-elle devant un tribunal ?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer">
                            Nous privilégions toujours la résolution amiable lorsque cela est possible, notamment par la médiation technique ou la négociation avec les entreprises. Si nécessaire, nous vous représenterons avec détermination devant toutes les juridictions compétentes, y compris les tribunaux spécialisés en matière de construction et les experts judiciaires.
                        </div>
                    </div>
                </div>

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
            const animatedElements = document.querySelectorAll('.expertise-sidebar, .expertise-description, .advantage-card, .faq-item, .step-item');
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
            
            // Animation des boutons de contact
            const contactButtons = document.querySelectorAll('.btn-primary');
            contactButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Effet de pulsation
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                    
                    alert('Merci pour votre intérêt ! Un membre du cabinet vous contactera bientôt.');
                });
            });
        });
    </script>

</body>
</html>

@endsection