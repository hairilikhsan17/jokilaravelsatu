<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Display owner profile page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('owner.profil.owner', compact('user'));
    }

    /**
     * Update owner profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path('storage/photos/' . $user->photo))) {
                unlink(public_path('storage/photos/' . $user->photo));
            }

            // Store new photo
            $photo = $request->file('photo');
            $photoName = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('storage/photos'), $photoName);
            $validated['photo'] = $photoName;
        }

        $user->update($validated);

        return redirect()->route('owner.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update owner password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('owner.profil.index')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Delete owner photo.
     */
    public function deletePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->photo && file_exists(public_path('storage/photos/' . $user->photo))) {
            unlink(public_path('storage/photos/' . $user->photo));
        }

        $user->update(['photo' => null]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus.'
            ]);
        }

        return redirect()->route('owner.profil.index')
            ->with('success', 'Foto profil berhasil dihapus.');
    }
}

