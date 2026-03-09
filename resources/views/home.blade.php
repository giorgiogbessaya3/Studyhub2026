<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Accueil - StudyHub</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --dark: #1a2b4c;
            --light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary) !important;
        }

        .navbar-brand i {
            margin-right: 10px;
            color: var(--primary);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        .user-role {
            font-size: 0.8rem;
            color: #666;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        .search-box {
            max-width: 500px;
            background: white;
            border-radius: 50px;
            padding: 5px;
            display: flex;
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            outline: none;
        }

        .search-box button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
        }

        /* Stats Cards */
        .stats-section {
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            color: white;
            font-size: 1.8rem;
        }

        .stat-content h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .stat-content p {
            color: #666;
            margin: 0;
        }

        /* Section Titre */
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .section-title a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .card-text {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .card-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: #999;
            margin-bottom: 15px;
        }

        .card-meta i {
            margin-right: 5px;
        }

        .badge-classe {
            background: #e9ecef;
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .badge-matiere {
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .quick-actions h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .action-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 10px;
            transition: background 0.3s;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .action-item:hover {
            background: var(--light);
        }

        .action-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .action-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .action-content p {
            font-size: 0.8rem;
            color: #666;
            margin: 0;
        }

        /* Progress */
        .progress-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .progress-item {
            margin-bottom: 20px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .progress-bar-custom {
            height: 8px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 1px solid #e9ecef;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .stat-card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-book-half"></i>
                StudyHub
            </a>
            
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role == 'eleve' ? 'Élève' : 'Enseignant' }}</div>
                </div>
                <div class="user-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Bienvenue sur StudyHub</h1>
                    <p>Préparez vos examens avec plus de 5000 épreuves corrigées, des cours vidéo et des exercices interactifs.</p>
                    <div class="search-box">
                        <input type="text" placeholder="Rechercher une épreuve, un cours...">
                        <button><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Stats Cards -->
        <div class="row stats-section">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="stat-content">
                        <h3>150+</h3>
                        <p>Épreuves</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-play-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>80+</h3>
                        <p>Cours vidéo</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="stat-content">
                        <h3>200+</h3>
                        <p>Exercices</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3>500+</h3>
                        <p>Étudiants</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Dernières épreuves -->
                <div class="section-title">
                    <h2>Dernières épreuves</h2>
                    <a href="#">Voir tout <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">Terminale S</span>
                                    <span class="badge-matiere">Mathématiques</span>
                                </div>
                                <h5 class="card-title">BAC Blanc 2024 - Maths</h5>
                                <p class="card-text">Sujet complet avec correction détaillée.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-calendar"></i> 15/03/2024</span>
                                    <span><i class="bi bi-clock"></i> 4h</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Commencer</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">3ème</span>
                                    <span class="badge-matiere">Physique</span>
                                </div>
                                <h5 class="card-title">Brevet Blanc - Physique</h5>
                                <p class="card-text">Entraînement pour le brevet.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-calendar"></i> 10/03/2024</span>
                                    <span><i class="bi bi-clock"></i> 2h</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Commencer</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">1ère</span>
                                    <span class="badge-matiere">Français</span>
                                </div>
                                <h5 class="card-title">Commentaire composé</h5>
                                <p class="card-text">Sujet type bac français.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-calendar"></i> 05/03/2024</span>
                                    <span><i class="bi bi-clock"></i> 3h</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Commencer</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">Terminale</span>
                                    <span class="badge-matiere">Histoire</span>
                                </div>
                                <h5 class="card-title">La Guerre Froide</h5>
                                <p class="card-text">Composition avec documents.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-calendar"></i> 01/03/2024</span>
                                    <span><i class="bi bi-clock"></i> 2h30</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Commencer</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cours récents -->
                <div class="section-title mt-4">
                    <h2>Cours récents</h2>
                    <a href="#">Voir tout <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">Terminale</span>
                                    <span class="badge-matiere">Maths</span>
                                </div>
                                <h5 class="card-title">Les intégrales</h5>
                                <p class="card-text">Cours complet avec exercices.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-play-circle"></i> 3 vidéos</span>
                                    <span><i class="bi bi-file-text"></i> 5 exercices</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Voir le cours</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-classe">3ème</span>
                                    <span class="badge-matiere">Physique</span>
                                </div>
                                <h5 class="card-title">L'électricité</h5>
                                <p class="card-text">Circuits électriques et lois.</p>
                                <div class="card-meta">
                                    <span><i class="bi bi-play-circle"></i> 2 vidéos</span>
                                    <span><i class="bi bi-file-text"></i> 4 exercices</span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Voir le cours</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions rapides -->
                <div class="quick-actions mb-4">
                    <h3>Actions rapides</h3>
                    
                    <div class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="action-content">
                            <h4>Nouvelle épreuve</h4>
                            <p>Créer une épreuve personnalisée</p>
                        </div>
                    </div>

                    <div class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-journal-plus"></i>
                        </div>
                        <div class="action-content">
                            <h4>Créer un cours</h4>
                            <p>Partager vos connaissances</p>
                        </div>
                    </div>

                    <div class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <div class="action-content">
                            <h4>Poser une question</h4>
                            <p>Obtenir de l'aide</p>
                        </div>
                    </div>
                </div>

                <!-- Progression -->
                <div class="progress-card">
                    <h3 class="mb-3">Ma progression</h3>
                    
                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Mathématiques</span>
                            <span>75%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Physique</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 45%"></div>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Français</span>
                            <span>60%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Histoire</span>
                            <span>30%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 30%"></div>
                        </div>
                    </div>
                </div>

                <!-- Matières populaires -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Matières populaires</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge-classe">Mathématiques</span>
                            <span class="badge-classe">Physique</span>
                            <span class="badge-classe">Français</span>
                            <span class="badge-classe">Histoire</span>
                            <span class="badge-classe">Anglais</span>
                            <span class="badge-classe">SVT</span>
                            <span class="badge-classe">Philosophie</span>
                            <span class="badge-classe">Chimie</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">StudyHub</h5>
                    <p class="text-muted">La plateforme d'apprentissage pour réussir vos examens.</p>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Liens rapides</h6>
                    <ul class="footer-links">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Épreuves</a></li>
                        <li><a href="#">Cours</a></li>
                        <li><a href="#">Quiz</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Aide</h6>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-3">Contact</h6>
                    <p class="text-muted">
                        <i class="bi bi-envelope me-2"></i> contact@studyhub.com<br>
                        <i class="bi bi-telephone me-2"></i> +221 33 123 45 67
                    </p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                &copy; 2024 StudyHub. Tous droits réservés.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>