<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\SalaryRule;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
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

    $start = Carbon::create($tahun, $bulan, 1);

    // 🚫 CEK GLOBAL LOCK (1 BULAN)
    $lockedExists = Payroll::where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->where('locked', true)
        ->exists();

    if ($lockedExists) {
        return back()->with('error', 'Payroll bulan ini sudah di-approve & dikunci');
    }

    $employees = Employee::all();

    foreach ($employees as $emp) {

        if (!$emp->position_id || !$emp->department_id) continue;

        // =========================
        // CEK EXISTING
        // =========================
        $existing = Payroll::where('employee_id', $emp->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // 🚫 JANGAN SENTUH DATA YANG SUDAH APPROVED / LOCKED
        if ($existing && ($existing->status_approval == 'approved' || $existing->locked)) {
            continue;
        }

        // =========================
        // AMBIL RULE
        // =========================
        $rule = SalaryRule::where('position_id', $emp->position_id)
            ->where('department_id', $emp->department_id)
            ->where('status', 'approved')
            ->first();

        if (!$rule) continue;

        // =========================
        // HADIR
        // =========================
        $hadir = Attendance::where('employee_id', $emp->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereNotNull('jam_masuk')
            ->count();

        // =========================
        // CUTI & SAKIT
        // =========================
        $cuti = 0;
        $sakit = 0;

        $leaves = LeaveRequest::where('employee_id', $emp->id)
            ->where('status', 'disetujui')
            ->get();

        foreach ($leaves as $l) {

            $range = CarbonPeriod::create(
                $l->tanggal_mulai,
                $l->tanggal_selesai
            );

            foreach ($range as $tgl) {

                if ($tgl->month != $bulan) continue;

                if ($l->jenis_izin == 'cuti') {
                    $cuti++;
                } elseif ($l->jenis_izin == 'sakit') {
                    $sakit++;
                }
            }
        }

        // =========================
        // ALPHA
        // =========================
        $totalHari = $start->daysInMonth;
        $alpha = max(0, $totalHari - ($hadir + $cuti + $sakit));

        if (($hadir + $cuti + $sakit + $alpha) == 0) continue;

        // =========================
        // HITUNG GAJI
        // =========================
        $gaji_pokok = 0;
        $uang_harian = $rule->uang_harian;
        $gaji_bersih = 0;

        if ($rule->tipe_gaji == 'harian') {

            $total_dibayar = $hadir + $cuti + $sakit;
            $gaji_bersih = $total_dibayar * $uang_harian;

        } else {

            $gaji_pokok = $rule->gaji_pokok;
            $gaji_bersih = $gaji_pokok + ($hadir * $uang_harian);
        }

        // =========================
        // SIMPAN (SAFE)
        // =========================
        Payroll::updateOrCreate(
            [
                'employee_id' => $emp->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'tipe_gaji' => $rule->tipe_gaji,
                'hari_hadir' => $hadir,
                'total_alpha' => $alpha,
                'total_cuti' => $cuti,
                'total_sakit' => $sakit,
                'gaji_pokok' => $gaji_pokok,
                'upah_harian' => $uang_harian,
                'potongan' => 0,
                'gaji_bersih' => $gaji_bersih,
                'status_approval' => 'pending',
                'locked' => false
            ]
        );
    }

    return back()->with('success', 'Payroll berhasil digenerate (AMAN)');
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

    public function exportPdf(Request $request)
    {
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $payrolls = \App\Models\Payroll::with('employee')
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'finance.payroll.pdf',
        compact('payrolls', 'bulan', 'tahun')
    );

    return $pdf->download("Payroll_{$bulan}_{$tahun}.pdf");
    }

    public function exportExcel(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $data = \App\Models\Payroll::with('employee')
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->get();

    $filename = "Payroll_{$bulan}_{$tahun}.xls";

    $html = "<table border='1'>";
    
    $html .= "<tr>
                <th colspan='9'>DATA PAYROLL BULAN {$bulan}/{$tahun}</th>
              </tr>";

    $html .= "<tr>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Hadir</th>
                <th>Cuti</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Gaji Pokok</th>
                <th>Uang Harian</th>
                <th>Gaji Bersih</th>
              </tr>";

    $total = 0;

    foreach ($data as $p) {

        $total += $p->gaji_bersih;

        $html .= "<tr>
            <td>{$p->employee->nama_lengkap}</td>
            <td>{$p->tipe_gaji}</td>
            <td>{$p->hari_hadir}</td>
            <td>{$p->total_cuti}</td>
            <td>{$p->total_sakit}</td>
            <td>{$p->total_alpha}</td>
            <td>" . number_format($p->gaji_pokok,0,',','.') . "</td>
            <td>" . number_format($p->upah_harian,0,',','.') . "</td>
            <td><b>" . number_format($p->gaji_bersih,0,',','.') . "</b></td>
        </tr>";
    }

    $html .= "<tr>
                <td colspan='8'><b>TOTAL</b></td>
                <td><b>" . number_format($total,0,',','.') . "</b></td>
              </tr>";

    $html .= "</table>";

    return response($html)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    public function destroy($id)
    {
    $payroll = Payroll::findOrFail($id);

    // ❌ BLOCK hanya yang sudah approved / locked
    if ($payroll->status_approval === 'approved' || $payroll->locked) {
        return back()->with('error', 'Payroll sudah disetujui & tidak bisa dihapus');
    }

    $payroll->delete();

    return back()->with('success', 'Payroll berhasil dihapus');
    }
}