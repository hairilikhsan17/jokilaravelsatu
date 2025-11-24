<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Display a listing of riwayat aktivitas.
     */
    public function index(Request $request)
    {
        $query = RiwayatAktivitas::with(['obatAlkes'])
            ->where('id_staff', Auth::id());

        // Filter berdasarkan tanggal awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan jenis aksi
        if ($request->filled('jenis_aksi')) {
            $query->where('jenis_aksi', $request->jenis_aksi);
        }

        $riwayatAktivitas = $query->latest('tanggal')->paginate(10)->withQueryString();
        
        return view('staff.riwayat.index', compact('riwayatAktivitas'));
    }
}

