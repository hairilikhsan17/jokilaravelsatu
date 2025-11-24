<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LaporanStok;
use App\Models\ObatAlkes;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LaporanStok::with(['obatAlkes', 'staff']);

        // Filter berdasarkan tanggal awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan staff
        if ($request->filled('id_staff')) {
            $query->where('id_staff', $request->id_staff);
        }

        // Pencarian berdasarkan nama obat
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('obatAlkes', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $laporanStok = $query->latest('tanggal')->paginate(10)->withQueryString();
        
        // Ambil semua staff untuk filter
        $staffList = User::where('role', 'staff')->orWhere('role', 'admin')->get();
        
        return view('owner.laporan.index', compact('laporanStok', 'staffList'));
    }

    /**
     * Cetak laporan.
     */
    public function cetak(Request $request)
    {
        $query = LaporanStok::with(['obatAlkes', 'staff']);

        // Filter berdasarkan tanggal awal
        if ($request->filled('tanggal_awal')) {
            $tanggalAwal = $request->tanggal_awal;
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        } else {
            $tanggalAwal = now()->startOfMonth()->format('Y-m-d');
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $tanggalAkhir = $request->tanggal_akhir;
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        } else {
            $tanggalAkhir = now()->endOfMonth()->format('Y-m-d');
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        // Filter berdasarkan staff
        if ($request->filled('id_staff')) {
            $query->where('id_staff', $request->id_staff);
        }
        
        $laporanStok = $query->latest('tanggal')->get();
        
        return view('owner.laporan.cetak', compact('laporanStok', 'tanggalAwal', 'tanggalAkhir'));
    }
}

