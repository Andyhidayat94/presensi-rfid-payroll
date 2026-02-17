<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        $requests = LeaveRequest::where('employee_id', $employee->id)
            ->latest()
            ->get();

        return view('karyawan.cuti.index', compact('requests'));
    }

    public function create()
    {
        return view('karyawan.cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required|in:cuti,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required',
        ]);

        $employee = Auth::user()->employee;

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('karyawan.cuti.index')
            ->with('success', 'Pengajuan berhasil dikirim dan menunggu persetujuan HRD');
    }
}
