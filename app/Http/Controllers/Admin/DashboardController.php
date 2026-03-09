<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupération des statistiques réelles (sans views pour l'instant)
        $stats = [
            'articles' => Blog::count(),
            'published_articles' => Blog::where('status', 'published')->count(),
            'draft_articles' => Blog::where('status', 'draft')->count(),
            'users' => User::count(),
            'views' => 1248, // Valeur statique en attendant
            'comments' => 18, // À remplacer par Comment::count() si vous avez un modèle Comment
            'messages' => 7, // À remplacer par Contact::where('read', false)->count()
        ];

        // Récupération des 5 derniers articles
        $recentArticles = Blog::latest()->take(5)->get();
        
        // Commentaires récents (à remplacer par votre modèle Comment)
        $recentComments = [];

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentComments'));
    }
}