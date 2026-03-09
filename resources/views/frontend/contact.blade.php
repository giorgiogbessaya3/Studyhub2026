@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <title>{{ $settings->site_name ?? 'Kounde Avocats' }} - Contactez-nous</title>
    <style>
        .contact-page-body {
            background-color: #f5f5f0;
        }

        /* Hero Section */
        .contact-hero-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ff8c00" opacity="0.1"><path d="M500 50Q400 90 300 50T100 50Q200 10 300 50T500 50Q600 90 700 50T900 50Q800 10 700 50T500 50Z"/></svg>');
            background-size: cover;
        }

        .contact-hero-content {
            position: relative;
            z-index: 2;
        }

        .contact-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff8c00, #ffa94d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .contact-hero-breadcrumb {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        .text-orange {
            color: #ff8c00 !important;
            font-weight: 600;
        }

        /* Main Contact Section */
        .main-contact-section {
            padding: 80px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .contact-info-block {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .contact-info-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .label-icon {
            color: #ff8c00;
        }

        .contact-info-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            line-height: 1.2;
            margin-bottom: 30px;
        }

        .contact-details-group {
            margin-bottom: 20px;
        }

        .contact-detail-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            margin-bottom: 15px;
        }

        .contact-detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-icon-wrapper {
            width: 50px;
            height: 50px;
            background: #fff0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ff8c00;
        }

        .detail-icon-wrapper i {
            color: #ff8c00;
            font-size: 1.2rem;
        }

        .detail-text-group {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 600;
            color: #1a2942;
            font-size: 1rem;
        }

        .contact-address-card,
        .contact-hours-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 15px;
        }

        .hours-title {
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 10px;
            display: block;
        }

        .hours-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px;
        }

        .hours-label {
            color: #666;
        }

        .hours-time {
            font-weight: 600;
            color: #1a2942;
        }

        /* Contact Form */
        .contact-form-wrapper {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .form-title {
            font-size: 2rem;
            font-weight: bold;
            color: #1a2942;
            margin-bottom: 10px;
        }

        .form-description {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .contact-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .contact-input:focus {
            border-color: #ff8c00;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25);
            outline: none;
        }

        .contact-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-orange-submit {
            background: linear-gradient(135deg, #ff8c00, #ffa94d);
            border: none;
            color: white;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-orange-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 0, 0.3);
        }

        .btn-orange-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .alert-contact {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }

        /* Geolocalisation Section */
        .geolocalisation-section {
            padding: 80px 0;
            background: white;
        }

        .geolocalisation-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .geolocalisation-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .geolocalisation-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a2942;
            margin-bottom: 15px;
        }

        .geolocalisation-description {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 500px;
            position: relative;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        .map-overlay {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 300px;
        }

        .map-overlay-title {
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .map-overlay-address {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .btn-get-directions {
            background: #ff8c00;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-get-directions:hover {
            background: #e67e00;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .transport-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .transport-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .transport-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .transport-icon {
            width: 60px;
            height: 60px;
            background: #fff0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 2px solid #ff8c00;
        }

        .transport-icon i {
            color: #ff8c00;
            font-size: 1.5rem;
        }

        .transport-title {
            font-weight: 600;
            color: #1a2942;
            margin-bottom: 10px;
        }

        .transport-description {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero-title {
                font-size: 2.5rem;
            }
            
            .contact-info-title {
                font-size: 2rem;
            }
            
            .geolocalisation-title {
                font-size: 2rem;
            }
            
            .map-overlay {
                position: relative;
                top: 0;
                left: 0;
                margin: 20px;
                max-width: none;
            }
        }

        @media (max-width: 576px) {
            .contact-hero-section {
                padding: 100px 0 40px;
            }
            
            .main-contact-section,
            .geolocalisation-section {
                padding: 40px 0;
            }
            
            .contact-hero-title {
                font-size: 2rem;
            }
            
            .contact-info-block,
            .contact-form-wrapper {
                padding: 25px;
            }

            .contact-info-title {
                font-size: 1.8rem;
            }
            
            .geolocalisation-title {
                font-size: 1.8rem;
            }
            
            .transport-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="contact-page-body">

    <section class="contact-hero-section">
        <div class="container text-center contact-hero-content">
            <h1 class="contact-hero-title mb-3">
                Contactez-<span class="text-orange">nous</span>
            </h1>
            <p class="contact-hero-breadcrumb">
                <i class="fas fa-home me-2"></i>Accueil / <span class="text-orange">Contactez-nous</span>
            </p>
        </div>
    </section>

    <section class="main-contact-section py-5">
        <div class="container">
            <!-- Messages d'alerte -->
            @if(session('success'))
                <div class="alert alert-success alert-contact alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-contact alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Veuillez corriger les erreurs dans le formulaire.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-5">
                
                <div class="col-lg-6">
                    <div class="contact-info-block">
                        <p class="contact-info-label">
                            <span class="label-icon"><i class="fa-solid fa-handshake-simple"></i></span>
                            Nos contacts
                        </p>
                        <h2 class="contact-info-title">
                            Des experts juridiques <span class="text-orange">à votre portée</span>
                        </h2>

                        <div class="contact-details-group">
                            <div class="contact-detail-card">
                                <div class="detail-icon-wrapper">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </div>
                                <div class="detail-text-group">
                                    <span class="detail-label">Téléphone</span>
                                    <span class="detail-value">{{ $settings->site_phone ?? '+33 6 66 69 00 80' }}</span>
                                </div>
                            </div>

                            <div class="contact-detail-card">
                                <div class="detail-icon-wrapper">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="detail-text-group">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value">{{ $settings->site_email ?? 'dedji.avocat@gmail.com' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact-address-card">
                            <div class="detail-icon-wrapper">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="detail-text-group">
                                <span class="detail-label">Adresse physique</span>
                                <span class="detail-value">{{ $settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse' }}</span>
                            </div>
                        </div>

                        <div class="contact-hours-card">
                            <span class="hours-title">Horaire d'ouverture</span>
                            <div class="hours-row">
                                <span class="hours-label">Lun - Ven</span>
                                <span class="hours-time">{{ $settings->working_hours ?? '8h - 18h' }}</span>
                            </div>
                            <div class="hours-row">
                                <span class="hours-label">Samedi</span>
                                <span class="hours-time">9h - 12h</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form-wrapper">
                        <h3 class="form-title">Restons en contact</h3>
                        <p class="form-description">
                            Vous avez des questions ou besoin de notre expertise ? Laissez-nous un message et nous vous répondrons dans les plus brefs délais.
                        </p>
                        
                        <form class="contact-form" action="{{ route('contact.store') }}" method="POST" id="contactForm">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" class="form-control contact-input @error('first_name') is-invalid @enderror" 
                                        placeholder="Prénom *" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control contact-input @error('last_name') is-invalid @enderror" 
                                        placeholder="Nom *" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <input type="tel" name="phone" class="form-control contact-input @error('phone') is-invalid @enderror" 
                                        placeholder="Téléphone" value="{{ old('phone') }}"
                                        pattern="[0-9+\-\s()]{10,}" title="Format : 06 12 34 56 78 ou +33612345678">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control contact-input @error('email') is-invalid @enderror" 
                                        placeholder="E-mail *" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <select name="subject" class="form-control contact-input @error('subject') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un sujet *</option>
                                    <option value="Droit Immobilier" {{ old('subject') == 'Droit Immobilier' ? 'selected' : '' }}>Droit Immobilier</option>
                                    <option value="Droit Bancaire" {{ old('subject') == 'Droit Bancaire' ? 'selected' : '' }}>Droit Bancaire</option>
                                    <option value="Droit de la Construction" {{ old('subject') == 'Droit de la Construction' ? 'selected' : '' }}>Droit de la Construction</option>
                                    <option value="Droit de la Famille" {{ old('subject') == 'Droit de la Famille' ? 'selected' : '' }}>Droit de la Famille</option>
                                    <option value="Consultation générale" {{ old('subject') == 'Consultation générale' ? 'selected' : '' }}>Consultation générale</option>
                                    <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <textarea name="message" class="form-control contact-input contact-textarea @error('message') is-invalid @enderror" 
                                    rows="6" placeholder="Votre message *" required maxlength="1000">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-end">
                                    <span id="messageCounter">0</span>/1000 caractères
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('privacy_policy') is-invalid @enderror" 
                                    id="privacy_policy" name="privacy_policy" value="1" {{ old('privacy_policy') ? 'checked' : '' }} required>
                                <label class="form-check-label small" for="privacy_policy">
                                    J'accepte la <a href="#" target="_blank">politique de confidentialité</a> et 
                                    que mes informations soient utilisées pour répondre à ma demande *
                                </label>
                                @error('privacy_policy')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-orange-submit" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Géolocalisation -->
    <section class="geolocalisation-section">
        <div class="container">
            <div class="geolocalisation-header">
                <p class="geolocalisation-label">
                    <i class="fas fa-map-marker-alt text-orange"></i>
                    Notre Localisation
                </p>
                <h2 class="geolocalisation-title">
                    Retrouvez-nous <span class="text-orange">facilement</span>
                </h2>
                <p class="geolocalisation-description">
                    Situé au cœur de Toulouse, notre cabinet est facilement accessible par tous les moyens de transport. Planifiez votre visite en consultant notre localisation précise.
                </p>
            </div>

            <div class="map-container">
                <div id="map"></div>
                <div class="map-overlay">
                    <h4 class="map-overlay-title">
                        <i class="fas fa-balance-scale me-2"></i>{{ $settings->site_name ?? 'Kounde Avocats' }}
                    </h4>
                    <p class="map-overlay-address">
                        <i class="fas fa-map-marker-alt text-orange me-2"></i>
                        {{ $settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse' }}
                    </p>
                    <a href="https://www.google.com/maps/dir//{{ urlencode($settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse') }}" 
                       target="_blank" 
                       class="btn-get-directions">
                        <i class="fas fa-route me-2"></i>
                        Itinéraire
                    </a>
                </div>
            </div>

            <div class="transport-options">
                <div class="transport-card">
                    <div class="transport-icon">
                        <i class="fas fa-subway"></i>
                    </div>
                    <h4 class="transport-title">Métro</h4>
                    <p class="transport-description">
                        Station Capitole<br>
                        Ligne A - 5 min à pied
                    </p>
                </div>

                <div class="transport-card">
                    <div class="transport-icon">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h4 class="transport-title">Bus</h4>
                    <p class="transport-description">
                        Lignes 14, 44, 78<br>
                        Arrêt Place Wilson
                    </p>
                </div>

                <div class="transport-card">
                    <div class="transport-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h4 class="transport-title">Voiture</h4>
                    <p class="transport-description">
                        Parking Indigo<br>
                        Capitole - 2 min à pied
                    </p>
                </div>

                <div class="transport-card">
                    <div class="transport-icon">
                        <i class="fas fa-bicycle"></i>
                    </div>
                    <h4 class="transport-title">VélôToulouse</h4>
                    <p class="transport-description">
                        Station N°57<br>
                        Rue d'Alsace-Lorraine
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes de contact
            const contactCards = document.querySelectorAll('.contact-detail-card, .contact-address-card, .contact-hours-card');
            contactCards.forEach(card => {
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

            contactCards.forEach(card => observer.observe(card));

            // Compteur de caractères pour le message
            const messageTextarea = document.querySelector('textarea[name="message"]');
            const messageCounter = document.getElementById('messageCounter');
            
            if (messageTextarea && messageCounter) {
                messageTextarea.addEventListener('input', function() {
                    const length = this.value.length;
                    messageCounter.textContent = length;
                    
                    if (length > 1000) {
                        messageCounter.style.color = '#dc3545';
                    } else if (length > 800) {
                        messageCounter.style.color = '#ffc107';
                    } else {
                        messageCounter.style.color = '#6c757d';
                    }
                });
                
                // Initialiser le compteur
                messageCounter.textContent = messageTextarea.value.length;
            }

            // Formatage automatique du téléphone
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    
                    if (value.startsWith('33')) {
                        value = value.substring(2);
                    }
                    
                    if (value.length > 0) {
                        if (value.length <= 2) {
                            value = value;
                        } else if (value.length <= 4) {
                            value = value.replace(/(\d{2})/, '$1 ');
                        } else if (value.length <= 6) {
                            value = value.replace(/(\d{2})(\d{2})/, '$1 $2 ');
                        } else if (value.length <= 8) {
                            value = value.replace(/(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 ');
                        } else {
                            value = value.replace(/(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4');
                        }
                    }
                    
                    e.target.value = value;
                });
            }

            // Gestion du formulaire
            const contactForm = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (contactForm && submitBtn) {
                contactForm.addEventListener('submit', function(e) {
                    const message = document.querySelector('textarea[name="message"]').value;
                    
                    // Validation du message
                    if (message.length > 1000) {
                        e.preventDefault();
                        alert('Le message ne peut pas dépasser 1000 caractères.');
                        return;
                    }
                    
                    // Validation de la politique de confidentialité
                    const privacyPolicy = document.getElementById('privacy_policy');
                    if (!privacyPolicy.checked) {
                        e.preventDefault();
                        alert('Veuillez accepter la politique de confidentialité.');
                        return;
                    }
                    
                    // Désactiver le bouton pendant l'envoi
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
                });
            }

            // Initialisation de la carte Leaflet
            function initMap() {
                // Coordonnées de Toulouse (centre-ville)
                const toulouseCoords = [43.6045, 1.4440];
                
                // Création de la carte
                const map = L.map('map').setView(toulouseCoords, 15);

                // Ajout des tuiles OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Icône personnalisée
                const customIcon = L.divIcon({
                    html: '<div style="background: #ff8c00; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-balance-scale" style="color: white; font-size: 12px;"></i></div>',
                    className: 'custom-div-icon',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                // Marqueur pour le cabinet
                const marker = L.marker(toulouseCoords, { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #1a2942;">
                                <i class="fas fa-balance-scale me-2"></i>{{ $settings->site_name ?? 'Kounde Avocats' }}
                            </h4>
                            <p style="margin: 0; color: #666;">
                                {{ $settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse' }}
                            </p>
                            <a href="https://www.google.com/maps/dir//{{ urlencode($settings->site_address ?? '123 Rue de la Loi, 31000 Toulouse') }}" 
                               target="_blank" 
                               style="display: inline-block; margin-top: 10px; padding: 8px 15px; background: #ff8c00; color: white; text-decoration: none; border-radius: 5px; font-size: 0.9rem;">
                                <i class="fas fa-route me-2"></i>Itinéraire
                            </a>
                        </div>
                    `);

                // Animation du marqueur
                setTimeout(() => {
                    marker.openPopup();
                }, 1000);
            }

            // Initialiser la carte une fois la page chargée
            initMap();
        });
    </script>

</body>
</html>

@endsection