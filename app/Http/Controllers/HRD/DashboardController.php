<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\RfidCard;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard HRD
     */
    public function index()
    {
        // Total seluruh karyawan
        $totalEmployees = Employee::count();

        // Karyawan dengan status menunggu approval admin
        $pendingEmployees = Employee::where('status_kerja', 'pending')->count();

        // Jumlah kartu RFID yang aktif
        $activeRfid = RfidCard::where('is_active', 1)->count();

        // Kirim data ke view dashboard HRD
        return view('hrd.dashboard', compact(
            'totalEmployees',
            'pendingEmployees',
            'activeRfid'
        ));
    }
}
