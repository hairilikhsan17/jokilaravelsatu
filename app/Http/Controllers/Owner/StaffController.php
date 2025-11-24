<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = User::latest()->paginate(10);
        return view('owner.staff.index', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|in:staff,admin,owner',
                'is_active' => 'nullable',
            ]);

            DB::beginTransaction();

            // Hash password
            $hashedPassword = Hash::make($validated['password']);

            // Handle is_active: jika checkbox dicentang kirim "1", jika tidak kirim "0"
            $isActive = $request->has('is_active') && $request->is_active == '1' ? true : true; // Default true untuk create

            // Buat user di tabel users
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $hashedPassword,
                'role' => $validated['role'],
                'is_active' => $isActive,
            ]);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff berhasil ditambahkan.',
                    'data' => $user
                ]);
            }

            return redirect()->route('owner.staff.index')->with('success', 'Staff berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
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
        $staff = User::findOrFail($id);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($staff);
        }
        
        return view('owner.staff.create_edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:staff,admin,owner',
                'is_active' => 'required|in:0,1',
            ]);

            DB::beginTransaction();

            // Handle is_active dari select dropdown
            $isActive = $request->is_active == '1' ? true : false;

            // Update user
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'is_active' => $isActive,
            ];

            // Jika password diisi, update password
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff berhasil diperbarui.',
                    'data' => $user->fresh()
                ]);
            }

            return redirect()->route('owner.staff.index')->with('success', 'Staff berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
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
            $user = User::findOrFail($id);
            
            // Jangan izinkan owner menghapus dirinya sendiri
            if ($user->role === 'owner' && $user->id === auth()->id()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat menghapus akun owner sendiri.'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun owner sendiri.');
            }

            DB::beginTransaction();

            // Hapus user
            $user->delete();

            DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff berhasil dihapus.'
                ]);
            }

            return redirect()->route('owner.staff.index')->with('success', 'Staff berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
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
     * Update password staff.
     */
    public function updatePassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            DB::beginTransaction();

            $hashedPassword = Hash::make($validated['password']);

            // Update password
            $user->update([
                'password' => $hashedPassword,
            ]);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diubah.'
                ]);
            }

            return redirect()->route('owner.staff.index')->with('success', 'Password berhasil diubah.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
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
     * Toggle status aktif/non-aktif staff.
     */
    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Jangan izinkan owner menonaktifkan dirinya sendiri
            if ($user->role === 'owner' && $user->id === auth()->id()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat menonaktifkan akun owner sendiri.'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Tidak dapat menonaktifkan akun owner sendiri.');
            }

            DB::beginTransaction();

            // Toggle status
            $user->update([
                'is_active' => !$user->is_active,
            ]);

            DB::commit();

            $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff berhasil ' . $statusText . '.',
                    'data' => $user->fresh()
                ]);
            }

            return redirect()->route('owner.staff.index')->with('success', 'Staff berhasil ' . $statusText . '.');
        } catch (\Exception $e) {
            DB::rollBack();
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
