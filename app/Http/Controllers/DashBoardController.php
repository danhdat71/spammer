<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $totalCustomers = Customer::count();
        $wonderCustomers = Customer::whereNotNull('note')->count();
        $zaloSpamedCustomers = Customer::where('is_zalo_spamed', true)->count();
        $smsSpamedCustomers = 0;
        return view('dashboard', [
            'slide' => 'dashboard',
            'totalCustomers' => $totalCustomers,
            'wonderCustomers' => $wonderCustomers,
            'zaloSpamedCustomers' => $zaloSpamedCustomers,
            'smsSpamedCustomers' => $smsSpamedCustomers
        ]);
    }
}
