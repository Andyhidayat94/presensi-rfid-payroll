<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryRule;
use Illuminate\Support\Facades\Auth;

class SalarySettingController extends Controller
{
    public function index()
    {
        $rules = SalaryRule::with(['position','department'])
            ->latest()
            ->get();

        return view('admin.salary.index', compact('rules'));
    }

    public function approve($id)
    {
        $rule = SalaryRule::findOrFail($id);

        // 🚫 jika sudah approve → tidak bisa diubah
        if ($rule->status == 'approved') {
            return back()->with('error', 'Data sudah di-approve');
        }

        $rule->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Setting gaji berhasil di-approve');
    }

    public function reject($id)
    {
        $rule = SalaryRule::findOrFail($id);

        if ($rule->status == 'approved') {
            return back()->with('error', 'Data sudah di-approve, tidak bisa ditolak');
        }

        $rule->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Setting gaji ditolak');
    }
}