<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardStaffController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function index()
    {
        return view('staff.dashboard');
    }
}


