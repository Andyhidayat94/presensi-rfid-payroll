<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =============================
        // KPI SUMMARY
        // =============================

        $totalUser = User::count();
        $userAktif = User::where('is_active', 1)->count();

        $pendingLeave = LeaveRequest::where('status', 'pending')->count();

        // IMPORTANT: gunakan status_approval sesuai database kamu
        $pendingPayroll = Payroll::where('status_approval', 'pending')->count();

        // =============================
        // GRAFIK APPROVAL CUTI (30 HARI)
        // =============================

        $last30Days = collect(range(0, 29))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('d M');
        })->reverse();

        $approvalData = [];

        foreach (range(0, 29) as $i) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $approvalData[] = LeaveRequest::whereDate('approved_at', $date)->count();
        }

        $approvalData = array_reverse($approvalData);

        // =============================
        // GRAFIK PAYROLL 12 BULAN
        // =============================

        $payrollLabels = [];
        $payrollData = [];

        foreach (range(0, 11) as $i) {

            $date = Carbon::now()->subMonths($i);

            $year = $date->year;
            $month = $date->month;

            $total = Payroll::where('tahun', $year)
                ->where('bulan', $month)
                ->sum('gaji_bersih');

            $payrollLabels[] = $date->format('M Y');
            $payrollData[] = $total;
        }

        $payrollLabels = array_reverse($payrollLabels);
        $payrollData = array_reverse($payrollData);

        // =============================
        // RECENT LEAVE ACTIVITY
        // =============================

        $recentLeaves = LeaveRequest::with('employee')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'userAktif',
            'pendingLeave',
            'pendingPayroll',
            'approvalData',
            'last30Days',
            'payrollLabels',
            'payrollData',
            'recentLeaves'
        ));
    }
}
