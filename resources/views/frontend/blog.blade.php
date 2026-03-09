@extends('layouts.app')

@section('title', 'Blog Juridique')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <title>Kounde Avocats - Blog Juridique</title>
    <style>
        .blog-page-body {
            background-color: #f5f5f0;
        }

        .blog-hero-section {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .blog-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ff8c00" opacity="0.1"><path d="M500 50Q400 90 300 50T100 50Q200 10 300 50T500 50Q600 90 700 50T900 50Q800 10 700 50T500 50Z"/></svg>');
            background-size: cover;
        }

        .blog-hero-content {
            position: relative;
            z-index: 2;
        }

        .blog-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff8c00, #ffa94d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blog-hero-breadcrumb {
            font-size: 1.1rem;
            color: #c5d1e0;
        }

        .text-orange {
            color: #ff8c00 !important;
            font-weight: 600;
        }

        .full-blog-grid-section {
            background-color: #f5f5f0;
            padding: 80px 0;
        }

        .blog-post-card {
            display: block;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            height: 380px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: all 0.4s ease;
            background: white;
            cursor: pointer;
        }

        .blog-post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .blog-post-card:hover .post-image {
            transform: scale(1.05);
        }

        .post-content-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0) 100%);
            padding: 25px 20px 20px;
            color: white;
            z-index: 3;
        }

        .post-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .meta-item i {
            color: #ff8c00;
            font-size: 0.9rem;
        }

        .post-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ff8c00;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .video-category {
            background: #ff0000 !important;
        }

        .pagination .page-link {
            border: none;
            color: #1a2942;
            font-weight: 600;
            padding: 10px 18px;
            margin: 0 3px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background-color: #ff8c00;
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background-color: #ff8c00;
            color: white;
            border: none;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #f8f9fa;
        }

        /* Styles pour la vidéo YouTube */
        .video-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
        }

        .youtube-embed {
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .video-play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
            z-index: 2;
        }

        .video-play-overlay:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        .play-button {
            width: 80px;
            height: 80px;
            background: #ff0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            transition: transform 0.3s ease;
        }

        .video-play-overlay:hover .play-button {
            transform: scale(1.1);
        }

        .video-playing .video-thumbnail,
        .video-playing .video-play-overlay {
            display: none;
        }

        /* Image par défaut */
        .default-blog-image {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        /* Animation des cartes */
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

        .blog-post-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .blog-post-card:nth-child(1) { animation-delay: 0.1s; }
        .blog-post-card:nth-child(2) { animation-delay: 0.2s; }
        .blog-post-card:nth-child(3) { animation-delay: 0.3s; }
        .blog-post-card:nth-child(4) { animation-delay: 0.4s; }
        .blog-post-card:nth-child(5) { animation-delay: 0.5s; }
        .blog-post-card:nth-child(6) { animation-delay: 0.6s; }

        /* Styles pour le modal */
        .blog-modal .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .blog-modal .modal-header {
            background: linear-gradient(135deg, #1a2942 0%, #2d4a6b 100%);
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
            padding: 25px 30px;
        }

        .blog-modal .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .blog-modal .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .blog-modal .modal-body {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .blog-modal .blog-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .blog-modal .blog-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .blog-modal .blog-meta-item i {
            color: #ff8c00;
        }

        .blog-modal .blog-description {
            font-size: 1.1rem;
            color: #495057;
            line-height: 1.6;
            margin-bottom: 20px;
            font-style: italic;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ff8c00;
        }

        .blog-modal .blog-content {
            color: #333;
            line-height: 1.8;
            font-size: 1rem;
        }

        .blog-modal .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        .blog-modal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .blog-hero-title {
                font-size: 2.5rem;
            }
            
            .blog-post-card {
                height: 320px;
            }
            
            .post-title {
                font-size: 1rem;
            }
            
            .play-button {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .blog-modal .modal-body {
                padding: 20px;
                max-height: 60vh;
            }

            .blog-modal .modal-header {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .blog-hero-section {
                padding: 120px 0 60px;
            }
            
            .full-blog-grid-section {
                padding: 60px 0;
            }
            
            .blog-hero-title {
                font-size: 2rem;
            }

            .blog-modal .blog-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body class="blog-page-body">

    <section class="blog-hero-section">
        <div class="container text-center blog-hero-content">
            <h1 class="blog-hero-title mb-1">
                <i class="fas fa-newspaper me-3"></i>Blog Juridique
            </h1>
            <p class="blog-hero-breadcrumb">
                <i class="fas fa-home me-2"></i>Accueil / <span class="text-orange">Blog</span>
            </p>
            <p class="lead mt-4 text-light opacity-75">
                Découvrez nos articles sur le droit immobilier, bancaire et de la construction
            </p>
        </div>
    </section>

    <section class="full-blog-grid-section py-5">
        <div class="container">
            @if($blogs->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($blogs as $blog)
                    <div class="col">
                        <div class="blog-post-card" 
                             onclick="handleBlogClick({{ $blog->id }}, {{ $blog->youtube_url ? 'true' : 'false' }})"
                             data-blog-id="{{ $blog->id }}"
                             data-has-video="{{ $blog->youtube_url ? 'true' : 'false' }}">
                            
                            <!-- Catégorie -->
                            <div class="post-category {{ $blog->youtube_url ? 'video-category' : '' }}">
                                <i class="fas {{ $blog->youtube_url ? 'fa-play' : 'fa-newspaper' }}"></i> 
                                {{ $blog->youtube_url ? 'Vidéo' : 'Article' }}
                            </div>
                            
                            <!-- Contenu média : Vidéo YouTube avec lecteur intégré ou Image -->
                            @if($blog->youtube_url)
                                <!-- Lecteur YouTube intégré -->
                                <div class="video-container" id="video-container-{{ $blog->id }}">
                                    <!-- Miniature de la vidéo -->
                                    <img 
                                        src="https://img.youtube.com/vi/{{ $blog->getYouTubeId() }}/hqdefault.jpg" 
                                        alt="{{ $blog->title }}"
                                        class="video-thumbnail"
                                    >
                                    
                                    <!-- Overlay de lecture -->
                                    <div class="video-play-overlay" onclick="event.stopPropagation(); playVideo({{ $blog->id }}, '{{ $blog->getYouTubeId() }}')">
                                        <div class="play-button">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Iframe YouTube (caché au départ) -->
                                    <iframe 
                                        id="youtube-iframe-{{ $blog->id }}"
                                        class="youtube-embed"
                                        src=""
                                        title="{{ $blog->title }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen
                                        style="display: none;"
                                    ></iframe>
                                </div>
                            @else
                                <!-- Image de l'article -->
                                @if($blog->image)
                                    <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="post-image">
                                @else
                                    <div class="post-image default-blog-image">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                            @endif
                            
                            <!-- Overlay avec contenu -->
                            <div class="post-content-overlay">
                                <h3 class="post-title">
                                    {{ $blog->title }}
                                </h3>
                                <div class="post-meta">
                                    <span class="meta-item">
                                        <i class="fa-solid fa-user me-1"></i> {{ $blog->author }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fa-solid fa-calendar-days me-1"></i> {{ $blog->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                <nav class="d-flex justify-content-center mt-5" aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if($blogs->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $blogs->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                            @if($page == $blogs->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if($blogs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $blogs->nextPageUrl() }}" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                @endif

            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Aucun article pour le moment</h3>
                    <p class="text-muted">Revenez bientôt pour découvrir nos publications.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal pour afficher les détails du blog -->
    <div class="modal fade blog-modal" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalTitle">Titre de l'article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="blogModalBody">
                    <!-- Le contenu sera chargé dynamiquement -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Données des blogs (vous pouvez aussi les charger via AJAX)
        const blogsData = {
            @foreach($blogs as $blog)
            {{ $blog->id }}: {
                title: `{{ $blog->title }}`,
                description: `{{ $blog->description }}`,
                content: `{!! $blog->content !!}`,
                author: `{{ $blog->author }}`,
                createdAt: `{{ $blog->created_at->format('d M Y') }}`,
                image: `{{ $blog->image ? Storage::url($blog->image) : '' }}`,
                youtubeUrl: `{{ $blog->youtube_url }}`
            },
            @endforeach
        };

        function handleBlogClick(blogId, hasVideo) {
            if (hasVideo) {
                // Pour les vidéos, on ne fait rien car le clic est géré par playVideo
                return;
            } else {
                // Pour les articles, on affiche le modal
                showBlogModal(blogId);
            }
        }

        function showBlogModal(blogId) {
            const blog = blogsData[blogId];
            if (!blog) return;

            // Mettre à jour le titre du modal
            document.getElementById('blogModalTitle').textContent = blog.title;

            // Construire le contenu du modal
            const modalBody = document.getElementById('blogModalBody');
            modalBody.innerHTML = `
                <div class="blog-meta">
                    <div class="blog-meta-item">
                        <i class="fas fa-user"></i>
                        <span>${blog.author}</span>
                    </div>
                    <div class="blog-meta-item">
                        <i class="fas fa-calendar-days"></i>
                        <span>${blog.createdAt}</span>
                    </div>
                    <div class="blog-meta-item">
                        <i class="fas fa-newspaper"></i>
                        <span>Article</span>
                    </div>
                </div>

                ${blog.image ? `
                <div class="text-center mb-4">
                    <img src="${blog.image}" alt="${blog.title}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                </div>
                ` : ''}

                <div class="blog-description">
                    <strong>Description :</strong> ${blog.description}
                </div>

                <div class="blog-content">
                    ${blog.content}
                </div>
            `;

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('blogModal'));
            modal.show();
        }

        function playVideo(blogId, videoId) {
            const container = document.getElementById(`video-container-${blogId}`);
            const iframe = document.getElementById(`youtube-iframe-${blogId}`);
            
            // Afficher l'iframe et masquer la miniature
            iframe.style.display = 'block';
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
            
            // Marquer comme en cours de lecture
            container.classList.add('video-playing');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes de blog au défilement
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);
            
            // Observer les cartes de blog
            const blogCards = document.querySelectorAll('.blog-post-card');
            blogCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
            
            // Animation de la pagination
            const paginationLinks = document.querySelectorAll('.page-link');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Effet de clic
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });

            // Chargement lazy des miniatures YouTube
            const videoThumbnails = document.querySelectorAll('.video-thumbnail');
            videoThumbnails.forEach(thumbnail => {
                thumbnail.setAttribute('loading', 'lazy');
            });

            // Fermer les vidéos YouTube quand le modal se ferme
            document.getElementById('blogModal').addEventListener('hidden.bs.modal', function() {
                // Réinitialiser les iframes YouTube si nécessaire
                const iframes = document.querySelectorAll('.youtube-embed');
                iframes.forEach(iframe => {
                    iframe.src = '';
                });
            });
        });
    </script>

</body>
</html>
@endsection