<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan Halaman Profile
    |--------------------------------------------------------------------------
    */
    public function show()
    {
        $user = Auth::user();
        $employee = $user->employee ?? null; // kalau dia punya relasi employee

        return view('profile.show', compact('user','employee'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Informasi Dasar (Nama & Email)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Avatar
    |--------------------------------------------------------------------------
    */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Akun (Opsional)
    |--------------------------------------------------------------------------
    */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password tidak sesuai.'
            ]);
        }

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
