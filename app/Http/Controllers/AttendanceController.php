<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\RfidCard;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Halaman scan RFID (PUBLIC, tanpa login)
     */
    public function scanPage()
    {
        return view('rfid.scan');
    }

    /**
     * Proses scan RFID
     */
    public function scanProcess(Request $request)
{
    $request->validate([
        'uid_rfid' => 'required|string'
    ]);

    // =========================
    // CARI KARTU RFID AKTIF
    // =========================
    $card = RfidCard::where('uid_rfid', $request->uid_rfid)
        ->where('is_active', 1)
        ->first();

    if (!$card || !$card->employee) {
        return response()->json([
            'status' => 'error',
            'message' => 'Kartu tidak terdaftar atau tidak aktif'
        ]);
    }

    $employee = $card->employee;
    $today = Carbon::today()->toDateString();
    $now = Carbon::now();

    $attendance = Attendance::where('employee_id', $employee->id)
        ->where('tanggal', $today)
        ->first();

    // =========================
    // ABSEN MASUK
    // =========================
    if (!$attendance) {

        Attendance::create([
            'employee_id' => $employee->id,
            'tanggal' => $today,
            'jam_masuk' => $now,
            'status_hadir' => 'hadir' // FIX
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absen masuk berhasil',
            'employee' => [
                'nama' => $employee->nama_lengkap,
                'nik' => $employee->nik,
                'jabatan' => $employee->jabatan
            ],
            'time' => $now->format('H:i:s')
        ]);
    }

    // =========================
    // ANTI SPAM SCAN
    // =========================
    if ($attendance->updated_at && $attendance->updated_at->diffInSeconds($now) < 5) {
        return response()->json([
            'status' => 'error',
            'message' => 'Tunggu sebentar sebelum scan ulang',
            'employee' => [
                'nama' => $employee->nama_lengkap,
                'nik' => $employee->nik,
                'jabatan' => $employee->jabatan
            ]
        ]);
    }

    // =========================
    // ABSEN PULANG
    // =========================
    if ($attendance->jam_masuk && !$attendance->jam_pulang) {

        // OPTIONAL: validasi minimal kerja
        if (Carbon::parse($attendance->jam_masuk)->diffInHours($now) < 4) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal kerja 4 jam sebelum absen pulang',
                'employee' => [
                    'nama' => $employee->nama_lengkap,
                    'nik' => $employee->nik,
                    'jabatan' => $employee->jabatan
                ]
            ]);
        }

        $attendance->update([
            'jam_pulang' => $now
            // ❗ TIDAK ubah status_hadir
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absen pulang berhasil',
            'employee' => [
                'nama' => $employee->nama_lengkap,
                'nik' => $employee->nik,
                'jabatan' => $employee->jabatan
            ],
            'time' => $now->format('H:i:s')
        ]);
    }

    // =========================
    // SUDAH SELESAI
    // =========================
    return response()->json([
        'status' => 'error',
        'message' => 'Presensi hari ini sudah lengkap',
        'employee' => [
            'nama' => $employee->nama_lengkap,
            'nik' => $employee->nik,
            'jabatan' => $employee->jabatan
        ]
    ]);
    }
}
