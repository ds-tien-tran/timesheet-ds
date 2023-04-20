<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get view dashboard
     */
    public function index()
    {
        return view('dashboard');
    }
}
