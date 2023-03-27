<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashBoardController extends Controller
{    
    /**
     * Main dashboard
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard', [
            'slide' => 'dashboard'
        ]);
    }
}
