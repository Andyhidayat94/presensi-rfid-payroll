<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\SalaryRule;
use App\Models\LeaveRequest;

class PayrollController extends Controller
{

    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->latest()
            ->get();

        return view('finance.payroll.index', compact('payrolls'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $employees = Employee::all();

        foreach ($employees as $emp) {

            // skip jika sudah locked
            $existing = Payroll::where('employee_id', $emp->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            if ($existing && $existing->locked) continue;

            // ambil salary rule
            $rule = SalaryRule::where('position_id', $emp->position_id)
                ->where('department_id', $emp->department_id)
                ->where('status', 'approved')
                ->first();

            if (!$rule) continue;

            // HITUNG HADIR
            $hadir = Attendance::where('employee_id', $emp->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_hadir', 'hadir')
                ->count();

            // HITUNG ALPHA
            $alpha = Attendance::where('employee_id', $emp->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_hadir', 'alpha')
                ->count();

            // HITUNG CUTI APPROVED
            $cuti = LeaveRequest::where('employee_id', $emp->id)
                ->where('status', 'approved')
                ->whereMonth('tanggal_mulai', $bulan)
                ->count();

            $gaji_pokok = 0;
            $upah_harian = 0;
            $potongan = 0;
            $gaji_bersih = 0;

            // =========================
            // LOGIC GAJI
            // =========================
            if ($rule->tipe_gaji == 'harian') {

                $upah_harian = $rule->upah_harian;
                $total_hadir = $hadir + $cuti;

                $gaji_bersih = $total_hadir * $upah_harian;

            } else {

                $gaji_pokok = $rule->gaji_pokok;
                $potongan = $alpha * $rule->potongan_alpha;

                $gaji_bersih = $gaji_pokok - $potongan;
            }

            // SIMPAN
            Payroll::updateOrCreate(
                [
                    'employee_id' => $emp->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'hari_hadir' => $hadir,
                    'total_alpha' => $alpha,
                    'total_cuti' => $cuti,
                    'gaji_pokok' => $gaji_pokok,
                    'upah_harian' => $upah_harian,
                    'potongan' => $potongan,
                    'gaji_bersih' => $gaji_bersih,
                    'status_approval' => 'pending',
                    'locked' => false
                ]
            );
        }

        return back()->with('success', 'Payroll berhasil digenerate (enterprise logic)');
    }


    public function history()
    {
        $data = Payroll::selectRaw('bulan, tahun,
                SUM(gaji_bersih) as total_gaji,
                COUNT(*) as total_karyawan')
            ->groupBy('bulan','tahun')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('finance.payroll.history', compact('data'));
    }

}