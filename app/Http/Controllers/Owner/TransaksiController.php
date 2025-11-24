<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Obat;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with('obat')->latest()->paginate(10);
        return view('owner.transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new stock in transaction.
     */
    public function createMasuk()
    {
        $obats = Obat::all();
        return view('owner.transaksi.masuk', compact('obats'));
    }

    /**
     * Store a newly created stock in transaction.
     */
    public function storeMasuk(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($validated['obat_id']);
        
        Transaksi::create([
            'obat_id' => $validated['obat_id'],
            'jenis' => 'masuk',
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'] ?? 'Stok masuk',
            'user_id' => auth()->id(),
        ]);

        $obat->increment('stok', $validated['jumlah']);

        return redirect()->route('owner.transaksi.index')
            ->with('success', 'Stok masuk berhasil dicatat.');
    }

    /**
     * Show the form for creating a new stock out transaction.
     */
    public function createKeluar()
    {
        $obats = Obat::all();
        return view('owner.transaksi.keluar', compact('obats'));
    }

    /**
     * Store a newly created stock out transaction.
     */
    public function storeKeluar(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($validated['obat_id']);

        if ($obat->stok < $validated['jumlah']) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $obat->stok
            ]);
        }
        
        Transaksi::create([
            'obat_id' => $validated['obat_id'],
            'jenis' => 'keluar',
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'] ?? 'Stok keluar',
            'user_id' => auth()->id(),
        ]);

        $obat->decrement('stok', $validated['jumlah']);

        return redirect()->route('owner.transaksi.index')
            ->with('success', 'Stok keluar berhasil dicatat.');
    }
}


