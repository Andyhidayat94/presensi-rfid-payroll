<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus($id)
{
    $user = \App\Models\User::findOrFail($id);

    // Jangan izinkan admin menonaktifkan dirinya sendiri
    if ($user->id == auth()->id()) {
        return back()->with('error','Tidak bisa menonaktifkan akun sendiri.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return back()->with('success','Status user berhasil diperbarui.');
    }

}
