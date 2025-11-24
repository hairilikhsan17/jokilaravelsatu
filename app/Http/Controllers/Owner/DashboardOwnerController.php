<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardOwnerController extends Controller
{
    /**
     * Display the owner dashboard.
     */
    public function index()
    {
        return view('owner.dashboard');
    }
}


