<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - StudyHub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Page non trouvée sur StudyHub - Retournez à l'accueil et continuez votre apprentissage">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="icon" type="image/png" href="{{ asset('studylogo.png') }}">
    <link rel="shortcut icon" href="{{ asset('studylogo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('studylogo.png') }}">
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background pattern (comme dans l'index) */
        .bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* Blobs décoratifs (comme dans l'index) */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            pointer-events: none;
        }

        .blob-1 {
            top: 10%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: var(--primary);
            animation: float 8s ease-in-out infinite;
        }

        .blob-2 {
            bottom: 10%;
            right: 10%;
            width: 400px;
            height: 400px;
            background: var(--warning);
            animation: float 10s ease-in-out infinite reverse;
        }

        .blob-3 {
            top: 50%;
            left: 50%;
            width: 250px;
            height: 250px;
            background: var(--success);
            animation: float 12s ease-in-out infinite;
            opacity: 0.2;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-20px) translateX(10px);
            }
        }

        /* Container principal */
        .error-container {
            position: relative;
            z-index: 2;
            max-width: 900px;
            width: 100%;
            animation: fadeInUp 0.6s ease-out;
        }

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

        /* Carte principale (style cards de l'index) */
        .error-card {
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .error-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        /* En-tête avec dégradé (style des cartes de classe) */
        .error-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Pattern dans l'en-tête (comme dans l'index) */
        .error-header::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* Cercles décoratifs (comme dans l'index) */
        .circle-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }

        .circle-1 {
            width: 150px;
            height: 150px;
            top: -50px;
            right: -50px;
        }

        .circle-2 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            left: -30px;
        }

        .error-code {
            font-size: 7rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            letter-spacing: 8px;
            margin-bottom: 15px;
        }

        .error-code span {
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        .error-code span:nth-child(1) { animation-delay: 0s; }
        .error-code span:nth-child(2) { animation-delay: 0.2s; }
        .error-code span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .error-title {
            font-size: 1.8rem;
            color: white;
            position: relative;
            z-index: 1;
            font-weight: 600;
        }

        .error-title i {
            margin-right: 10px;
        }

        /* Corps de la carte */
        .error-body {
            padding: 40px;
            text-align: center;
        }

        .error-message {
            margin-bottom: 35px;
        }

        .error-message i {
            font-size: 3rem;
            color: var(--warning);
            margin-bottom: 15px;
            display: inline-block;
            animation: shake 1s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
        }

        .error-message p {
            font-size: 1.1rem;
            color: var(--secondary);
            line-height: 1.6;
        }

        /* Suggestions (style des cartes de services) */
        .suggestions {
            margin: 30px 0;
        }

        .suggestions-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--light);
            padding: 8px 20px;
            border-radius: 40px;
        }

        .suggestions-title i {
            color: var(--primary);
        }

        .suggestions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        }

        .suggestion-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-align: left;
        }

        .suggestion-item:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.2);
        }

        .suggestion-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .suggestion-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .suggestion-content {
            flex: 1;
        }

        .suggestion-content a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: block;
            margin-bottom: 4px;
        }

        .suggestion-content a:hover {
            color: var(--primary);
        }

        .suggestion-content span {
            font-size: 0.75rem;
            color: var(--secondary);
        }

        /* Boutons d'action (style des boutons de l'index) */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Section de recherche (style de la barre de recherche de l'index) */
        .search-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e2e8f0;
        }

        .search-label {
            font-size: 0.9rem;
            color: var(--secondary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .search-label i {
            color: var(--primary);
        }

        .search-form {
            display: flex;
            gap: 10px;
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 60px;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .search-form:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-input {
            flex: 1;
            padding: 12px 18px;
            border: none;
            border-radius: 60px;
            font-size: 0.95rem;
            outline: none;
            font-family: inherit;
            background: transparent;
        }

        .search-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            padding: 8px 24px;
            border-radius: 60px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        /* Footer (comme dans l'index) */
        .error-footer {
            background: var(--light);
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .error-footer p {
            color: var(--secondary);
            font-size: 0.85rem;
        }

        .error-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .error-footer a:hover {
            text-decoration: underline;
        }

        /* Conseils supplémentaires (style des statistiques) */
        .tips {
            margin-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .tip {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--secondary);
            padding: 6px 12px;
            background: var(--light);
            border-radius: 40px;
        }

        .tip i {
            color: var(--success);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .error-code {
                font-size: 4rem;
                letter-spacing: 4px;
            }

            .error-title {
                font-size: 1.3rem;
            }

            .error-body {
                padding: 25px;
            }

            .suggestions-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }

            .search-form {
                flex-direction: column;
                border-radius: 20px;
                padding: 10px;
            }

            .search-input {
                text-align: center;
            }

            .search-btn {
                justify-content: center;
                padding: 10px;
            }

            .tips {
                gap: 10px;
            }

            .tip {
                font-size: 0.7rem;
            }
        }

        /* Animation pour les éléments */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Background pattern (comme l'index) -->
    <div class="bg-pattern"></div>

    <!-- Blobs décoratifs (comme l'index) -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="error-container">
        <div class="error-card">
            <!-- En-tête avec dégradé (style des cartes de classe) -->
            <div class="error-header">
                <div class="circle-decoration circle-1"></div>
                <div class="circle-decoration circle-2"></div>
                <div class="error-code">
                    <span>4</span>
                    <span>0</span>
                    <span>4</span>
                </div>
                <div class="error-title">
                    <i class="fas fa-compass"></i>
                    Oups ! Page introuvable
                </div>
            </div>

            <!-- Corps -->
            <div class="error-body">
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>La page que vous recherchez semble avoir disparu dans le néant numérique.<br>
                    Mais ne vous inquiétez pas, nous sommes là pour vous guider !</p>
                </div>

                <!-- Suggestions (style des cartes de services) -->
                <div class="suggestions">
                    <div class="suggestions-title">
                        <i class="fas fa-lightbulb"></i>
                        <span>Suggestions pour vous aider</span>
                    </div>
                    <div class="suggestions-grid">
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('home') }}">Accueil StudyHub</a>
                                <span>Retour à la page d'accueil</span>
                            </div>
                        </div>
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('cours.index') }}">Explorer les cours</a>
                                <span>Tous nos cours par classe</span>
                            </div>
                        </div>
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('epreuves.index') }}">Banque d'épreuves</a>
                                <span>Examens et devoirs corrigés</span>
                            </div>
                        </div>
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('quiz.index') }}">Quiz interactifs</a>
                                <span>Testez vos connaissances</span>
                            </div>
                        </div>
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('assistance.index') }}">Assistance pédagogique</a>
                                <span>Posez vos questions</span>
                            </div>
                        </div>
                        <div class="suggestion-item">
                            <div class="suggestion-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="suggestion-content">
                                <a href="{{ route('contact') }}">Nous contacter</a>
                                <span>Une question ? Contactez-nous</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="action-buttons">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>
                        Retour à l'accueil
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline">
                        <i class="fas fa-undo-alt"></i>
                        Page précédente
                    </a>
                </div>

                <!-- Barre de recherche (style de l'index) -->
                <div class="search-section">
                    <div class="search-label">
                        <i class="fas fa-search"></i>
                        <span>Rechercher sur StudyHub</span>
                    </div>
                    <form action="{{ route('search') }}" method="GET" class="search-form">
                        <input type="text"
                               name="q"
                               class="search-input"
                               placeholder="Rechercher un cours, une matière, un chapitre..."
                               autocomplete="off">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                            <span>Rechercher</span>
                        </button>
                    </form>
                </div>

                <!-- Conseils supplémentaires (style des statistiques) -->
                <div class="tips">
                    <div class="tip">
                        <i class="fas fa-check-circle"></i>
                        <span>Vérifiez l'URL saisie</span>
                    </div>
                    <div class="tip">
                        <i class="fas fa-sync-alt"></i>
                        <span>Actualisez la page</span>
                    </div>
                    <div class="tip">
                        <i class="fas fa-link"></i>
                        <span>Le lien est peut-être cassé</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="error-footer">
                <p>
                    <i class="fas fa-info-circle"></i>
                    Vous pensez qu'il s'agit d'une erreur ?
                    <a href="{{ route('contact') }}">Contactez-nous</a>
                    et nous ferons le nécessaire pour améliorer StudyHub !
                </p>
            </div>
        </div>
    </div>

    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Animation de la barre de recherche
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }

            // Validation du formulaire de recherche
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    const input = this.querySelector('.search-input');
                    if (!input.value.trim()) {
                        e.preventDefault();
                        input.placeholder = 'Veuillez saisir un terme de recherche';
                        input.style.border = '2px solid #ef4444';
                        setTimeout(() => {
                            input.placeholder = 'Rechercher un cours, une matière, un chapitre...';
                            input.style.border = 'none';
                        }, 2000);
                    }
                });
            }

            // Animation des suggestions au scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateX(0)';
                    }
                });
            }, observerOptions);

            const items = document.querySelectorAll('.suggestion-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                item.style.transition = `opacity 0.3s ease ${index * 0.05}s, transform 0.3s ease ${index * 0.05}s`;
                observer.observe(item);
            });

            // Message console
            console.log('%c🔍 Page 404 - StudyHub', 'color: #2563eb; font-size: 16px; font-weight: bold;');
            console.log('%cUtilisez la barre de recherche pour trouver ce que vous cherchez !', 'color: #64748b; font-size: 12px;');
        });
    </script>
</body>
</html>
