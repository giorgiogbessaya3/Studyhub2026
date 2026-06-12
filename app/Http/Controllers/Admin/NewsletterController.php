<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        return view('admin.newsletter.index');
    }

    public function send(Request $request)
    {
        return back()->with('success', 'Newsletter envoyée.');
    }

    public function subscribers()
    {
        return view('admin.newsletter.subscribers');
    }

    public function destroySubscriber($subscriber)
    {
        return back()->with('success', 'Abonné supprimé.');
    }

    public function toggleSubscriber($subscriber)
    {
        return back()->with('success', 'Statut mis à jour.');
    }

    public function export()
    {
        return back()->with('info', 'Export non disponible.');
    }

    public function import(Request $request)
    {
        return back()->with('info', 'Import non disponible.');
    }
}
