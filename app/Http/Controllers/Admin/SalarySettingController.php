<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalarySetting;

class SalarySettingController extends Controller
{
    public function index()
    {
        $settings = SalarySetting::all();
        return view('admin.salary.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required',
            'upah_harian' => 'required|numeric|min:0'
        ]);

        SalarySetting::updateOrCreate(
            ['jabatan' => $request->jabatan],
            ['upah_harian' => $request->upah_harian]
        );

        return back()->with('success','Setting gaji disimpan');
    }
}
