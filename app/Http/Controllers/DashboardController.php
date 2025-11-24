<?php

namespace App\Http\Controllers;

use App\Models\ObatAlkes;
use App\Models\LaporanStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display owner dashboard.
     */
    public function owner()
    {
        $totalObat = ObatAlkes::count();
        $totalStok = ObatAlkes::sum('stok');
        $stokMenipis = ObatAlkes::where('stok', '<', 10)->count();
        $laporanBaru = LaporanStok::whereDate('created_at', today())->count();
        
        return view('owner.dashboard', compact('totalObat', 'totalStok', 'stokMenipis', 'laporanBaru'));
    }

    /**
     * Display staff dashboard.
     */
    public function staff()
    {
        $totalObat = ObatAlkes::count();
        $stokMenipis = ObatAlkes::where('stok', '<', 10)->count();
        $laporanHariIni = LaporanStok::where('id_staff', Auth::id())
            ->whereDate('created_at', today())
            ->count();
        
        return view('staff.dashboard', compact('totalObat', 'stokMenipis', 'laporanHariIni'));
    }
}
