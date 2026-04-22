<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryRule;
use App\Models\Position;
use App\Models\Department;

class SalaryRuleController extends Controller
{
    public function index()
    {
        $rules = SalaryRule::with(['position','department'])->latest()->get();
        return view('finance.salary.index', compact('rules'));
    }

    public function create()
    {
        $positions = Position::all();
        $departments = Department::all();

        return view('finance.salary.create', compact('positions','departments'));
    }

    public function store(Request $request)
{
    // 1. VALIDASI DASAR
    $request->validate([
        'position_id' => 'required',
        'tipe_gaji' => 'required|in:harian,bulanan',
    ]);

    // 2. VALIDASI BERDASARKAN TIPE
    if ($request->tipe_gaji == 'harian') {

        $request->validate([
            'upah_harian' => 'required|numeric|min:0',
        ]);

    } else {

        $request->validate([
            'gaji_pokok' => 'required|numeric|min:0',
            'potongan_alpha' => 'required|numeric|min:0',
        ]);
    }

    // 3. SIMPAN DATA (ANTI SALAH INPUT)
    $rule = \App\Models\SalaryRule::updateOrCreate(
    [
        'position_id' => $request->position_id,
        'department_id' => $request->department_id,
    ],
    [
        'tipe_gaji' => $request->tipe_gaji,
        'gaji_pokok' => $request->tipe_gaji == 'bulanan' ? $request->gaji_pokok : 0,
        'upah_harian' => $request->tipe_gaji == 'harian' ? $request->upah_harian : 0,
        'potongan_alpha' => $request->tipe_gaji == 'bulanan' ? $request->potongan_alpha : 0,
        'status' => 'pending'
    ]
    );

    return redirect()
        ->route('finance.salary.index')
        ->with('success', 'Setting gaji berhasil disimpan/diperbaharui (menunggu approval)');
    }
}