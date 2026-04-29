<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryRule;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class SalaryRuleController extends Controller
{
    public function index()
    {
        $rules = SalaryRule::with(['position','department'])
            ->latest()
            ->get();

        return view('finance.salary.index', compact('rules'));
    }

    public function create()
    {
        $positions = Position::all();
        $departments = Department::orderBy('name')->get();

        return view('finance.salary.create', compact('positions','departments'));
    }

    
    public function store(Request $request)
{
    $request->validate([
        'position_id'   => 'required|exists:positions,id',
        'department_id' => 'nullable|exists:departments,id',
        'tipe_gaji'     => 'required|in:harian,bulanan',
        'uang_harian'   => 'required|numeric|min:1', // ❗ jangan boleh 0
        'gaji_pokok'    => 'nullable|numeric|min:0',
    ]);

    // pastikan angka
    $uangHarian = (int) $request->uang_harian;
    $gajiPokok  = (int) $request->gaji_pokok;

    if ($request->tipe_gaji == 'harian') {
        $gajiPokok = 0;
    }

    SalaryRule::updateOrCreate(
        [
            'position_id'   => $request->position_id,
            'department_id' => $request->department_id,
        ],
        [
            'tipe_gaji'   => $request->tipe_gaji,
            'gaji_pokok'  => $gajiPokok,
            'uang_harian' => $uangHarian, // 🔥 WAJIB MASUK SINI
            'status'      => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]
    );

    return redirect()
        ->route('finance.salary.index')
        ->with('success', 'Setting gaji berhasil disimpan');
}

    /*
    |------------------------------------------------------------------
    | APPROVE (ADMIN ONLY)
    |------------------------------------------------------------------
    */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Tidak punya akses');
        }

        $rule = SalaryRule::findOrFail($id);

        $rule->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Setting gaji berhasil di-approve');
    }

    /*
    |------------------------------------------------------------------
    | REJECT (ADMIN ONLY)
    |------------------------------------------------------------------
    */
    public function reject($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Tidak punya akses');
        }

        $rule = SalaryRule::findOrFail($id);

        $rule->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Setting gaji ditolak');
    }
}