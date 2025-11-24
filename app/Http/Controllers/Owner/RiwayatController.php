<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAktivitas;
use App\Models\User;
use App\Models\ObatAlkes;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of riwayat aktivitas.
     */
    public function index(Request $request)
    {
        $query = RiwayatAktivitas::with(['staff', 'obatAlkes']);

        // Filter berdasarkan staff
        if ($request->filled('id_staff')) {
            $query->where('id_staff', $request->id_staff);
        }

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
        
        // Ambil semua staff untuk filter
        $staffList = User::where('role', 'staff')->orWhere('role', 'admin')->get();
        
        // Ambil semua obat/alkes untuk dropdown edit
        $obatAlkes = ObatAlkes::orderBy('nama')->get();
        
        return view('owner.riwayat.index', compact('riwayatAktivitas', 'staffList', 'obatAlkes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $riwayat = RiwayatAktivitas::with(['staff', 'obatAlkes'])->findOrFail($id);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($riwayat);
        }
        
        // Ambil semua staff untuk dropdown
        $staffList = User::where('role', 'staff')->orWhere('role', 'admin')->get();
        $obatAlkes = ObatAlkes::orderBy('nama')->get();
        
        return view('owner.riwayat.edit', compact('riwayat', 'staffList', 'obatAlkes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $riwayat = RiwayatAktivitas::findOrFail($id);

            $validated = $request->validate([
                'id_staff' => 'required|exists:users,id',
                'id_obat' => 'required|exists:obat_alkes,id',
                'jenis_aksi' => 'required|in:tambah,update,hapus',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            // Convert tanggal string to datetime
            $validated['tanggal'] = \Carbon\Carbon::parse($validated['tanggal']);

            $riwayat->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Riwayat aktivitas berhasil diperbarui.',
                    'data' => $riwayat->fresh()->load(['staff', 'obatAlkes'])
                ]);
            }

            return redirect()->route('owner.riwayat.index')->with('success', 'Riwayat aktivitas berhasil diperbarui.');
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
            $riwayat = RiwayatAktivitas::findOrFail($id);
            
            $riwayat->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Riwayat aktivitas berhasil dihapus.'
                ]);
            }

            return redirect()->route('owner.riwayat.index')->with('success', 'Riwayat aktivitas berhasil dihapus.');
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
