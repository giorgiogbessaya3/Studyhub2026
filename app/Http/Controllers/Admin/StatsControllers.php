<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsControllers extends Controller
{
    public function index()
    {
        return view('admin.stats.index');
    }
    public function view()
    {
        return view('admin.stats.view');
    }
    public function reports()
    {
        return view('admin.stats.reports');
    }
    public function logs()
    {
        return view('admin.stats.logs');
    }
}
