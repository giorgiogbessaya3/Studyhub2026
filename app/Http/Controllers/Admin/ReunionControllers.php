<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReunionControllers extends Controller
{
     public function index()
    {
        return view('admin.Reunion.index');
    }
     public function create()
    {
        return view('admin.Reunion.create');
    }
}
