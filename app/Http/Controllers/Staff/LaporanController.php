<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LaporanStok;
use App\Models\ObatAlkes;
use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporanStok = LaporanStok::with(['obatAlkes'])
            ->where('id_staff', Auth::id())
            ->latest('tanggal')
            ->paginate(10);
        
        // Ambil semua obat/alkes untuk dropdown
        $obatAlkes = ObatAlkes::orderBy('nama')->get();
        
        return view('staff.laporan.index', compact('laporanStok', 'obatAlkes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_obat' => 'required|exists:obat_alkes,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $validated['id_staff'] = Auth::id();

            $laporan = LaporanStok::create($validated);

            // Catat riwayat aktivitas
            $obatAlkes = ObatAlkes::find($validated['id_obat']);
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $validated['id_obat'],
                'jenis_aksi' => 'tambah',
                'tanggal' => now(),
                'keterangan' => 'Membuat laporan stok: ' . ($obatAlkes ? $obatAlkes->nama : '') . ' - Jumlah: ' . $validated['jumlah'],
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan stok berhasil dibuat.',
                    'data' => $laporan->load('obatAlkes')
                ]);
            }

            return redirect()->route('staff.laporan.index')->with('success', 'Laporan stok berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laporan = LaporanStok::with(['obatAlkes'])
            ->where('id_staff', Auth::id())
            ->findOrFail($id);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($laporan);
        }
        
        // Ambil semua obat/alkes untuk dropdown
        $obatAlkes = ObatAlkes::orderBy('nama')->get();
        
        return view('staff.laporan.edit', compact('laporan', 'obatAlkes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $laporan = LaporanStok::where('id_staff', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'id_obat' => 'required|exists:obat_alkes,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $laporan->update($validated);

            // Catat riwayat aktivitas
            $obatAlkes = ObatAlkes::find($validated['id_obat']);
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $validated['id_obat'],
                'jenis_aksi' => 'update',
                'tanggal' => now(),
                'keterangan' => 'Memperbarui laporan stok: ' . ($obatAlkes ? $obatAlkes->nama : '') . ' - Jumlah: ' . $validated['jumlah'],
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan stok berhasil diperbarui.',
                    'data' => $laporan->fresh()->load('obatAlkes')
                ]);
            }

            return redirect()->route('staff.laporan.index')->with('success', 'Laporan stok berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $laporan = LaporanStok::where('id_staff', Auth::id())->with('obatAlkes')->findOrFail($id);
            
            // Catat riwayat aktivitas sebelum hapus
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $laporan->id_obat,
                'jenis_aksi' => 'hapus',
                'tanggal' => now(),
                'keterangan' => 'Menghapus laporan stok: ' . ($laporan->obatAlkes ? $laporan->obatAlkes->nama : '') . ' - Jumlah: ' . $laporan->jumlah,
            ]);
            
            $laporan->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan stok berhasil dihapus.'
                ]);
            }

            return redirect()->route('staff.laporan.index')->with('success', 'Laporan stok berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cetak laporan.
     */
    public function cetak(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal', now()->startOfMonth());
        $tanggalAkhir = $request->get('tanggal_akhir', now()->endOfMonth());
        
        $laporanStok = LaporanStok::with(['obatAlkes'])
            ->where('id_staff', Auth::id())
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get();
        
        return view('staff.laporan.cetak', compact('laporanStok', 'tanggalAwal', 'tanggalAkhir'));
    }
}

