<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $requests = LeaveRequest::with('employee.user')
            ->latest()
            ->get();

        return view('hrd.cuti.index', compact('requests'));
    }

    public function approve($id)
{
    $leave = LeaveRequest::findOrFail($id);

    $leave->update([
        'status' => 'disetujui',
        'approved_by' => Auth::id(),
        'approved_at' => now(),
    ]);

    $employeeId = $leave->employee_id;

    $start = \Carbon\Carbon::parse($leave->tanggal_mulai);
    $end   = \Carbon\Carbon::parse($leave->tanggal_selesai);

    while ($start->lte($end)) {

        \App\Models\Attendance::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'tanggal' => $start->toDateString(),
            ],
            [
                'status_hadir' => $leave->jenis_izin,
                'jam_masuk' => null,
                'jam_pulang' => null,
            ]
        );

        $start->addDay();
    }

    return back()->with('success', 'Pengajuan disetujui dan presensi otomatis dibuat');
    
    logActivity(
    'approve',
    'leave',
    'HRD menyetujui pengajuan ID: ' . $leave->id
        );
    }

    public function reject($id)
    {
    $leave = LeaveRequest::findOrFail($id);

    $leave->update([
        'status' => 'ditolak',
        'approved_by' => Auth::id(),
        'approved_at' => now(),
    ]);

    return back()->with('success', 'Pengajuan ditolak');
    }
}
