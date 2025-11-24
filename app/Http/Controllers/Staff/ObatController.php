<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ObatAlkes;
use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obatAlkes = ObatAlkes::latest()->paginate(10);
        return view('staff.obat.index', compact('obatAlkes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string|in:Obat,Alkes',
                'stok' => 'required|integer|min:0',
                'kadaluarsa' => 'nullable|date',
                'supplier' => 'nullable|string|max:255',
                'satuan' => 'nullable|string|max:50',
                'lokasi' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $obatAlkes = ObatAlkes::create($validated);

            // Catat riwayat aktivitas
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $obatAlkes->id,
                'jenis_aksi' => 'tambah',
                'tanggal' => now(),
                'keterangan' => 'Menambah data obat/alkes: ' . $obatAlkes->nama,
            ]);

            // Selalu return JSON jika request memiliki header Accept: application/json
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan.',
                    'data' => $obatAlkes->fresh()
                ], 200);
            }

            return redirect()->route('staff.obat.index')->with('success', 'Data berhasil ditambahkan.');
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
        $obatAlkes = ObatAlkes::findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json($obatAlkes);
        }
        
        return view('staff.obat.edit', compact('obatAlkes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $obatAlkes = ObatAlkes::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string|in:Obat,Alkes',
                'stok' => 'required|integer|min:0',
                'kadaluarsa' => 'nullable|date',
                'supplier' => 'nullable|string|max:255',
                'satuan' => 'nullable|string|max:50',
                'lokasi' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $obatAlkes->update($validated);

            // Catat riwayat aktivitas
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $obatAlkes->id,
                'jenis_aksi' => 'update',
                'tanggal' => now(),
                'keterangan' => 'Memperbarui data obat/alkes: ' . $obatAlkes->nama,
            ]);

            // Selalu return JSON jika request memiliki header Accept: application/json
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diperbarui.',
                    'data' => $obatAlkes->fresh()
                ], 200);
            }

            return redirect()->route('staff.obat.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
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
            $obatAlkes = ObatAlkes::findOrFail($id);
            
            // Catat riwayat aktivitas sebelum hapus
            RiwayatAktivitas::create([
                'id_staff' => Auth::id(),
                'id_obat' => $obatAlkes->id,
                'jenis_aksi' => 'hapus',
                'tanggal' => now(),
                'keterangan' => 'Menghapus data obat/alkes: ' . $obatAlkes->nama,
            ]);
            
            $obatAlkes->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus.'
                ]);
            }

            return redirect()->route('staff.obat.index')->with('success', 'Data berhasil dihapus.');
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
}

