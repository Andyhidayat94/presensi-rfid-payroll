<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $employee = $user->employee;

        return view('karyawan.profile.show', compact('user', 'employee'));
    }

    public function updateAvatar(Request $request)
    {
    $request->validate([
        'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = auth()->user();

    if ($user->avatar) {
        Storage::disk('public')->delete($user->avatar);
    }

    $path = $request->file('avatar')->store('avatars', 'public');

    $user->update([
        'avatar' => $path
    ]);

    return back()->with('success', 'Foto profil berhasil diperbarui');
    }
}
