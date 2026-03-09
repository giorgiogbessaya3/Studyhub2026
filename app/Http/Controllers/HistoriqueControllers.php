<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriqueControllers extends Controller
{
    public function index()
    {
        return view('frontend.historique.index');
    }
}
