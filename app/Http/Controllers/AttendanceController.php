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

        // Cari kartu RFID aktif
        $card = RfidCard::where('uid_rfid', $request->uid_rfid)
            ->where('is_active', 1)
            ->first();

        if (!$card) {
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

        // ✅ ABSEN MASUK
        if (!$attendance) {
            Attendance::create([
                'employee_id' => $employee->id,
                'tanggal' => $today,
                'jam_masuk' => $now,
                'status_hadir' => 'hadir'
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

        // ❌ Scan ulang < 10 detik
        if ($attendance->updated_at->diffInSeconds($now) < 10) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tunggu 10 detik sebelum scan ulang',
                'employee' => [
                    'nama' => $employee->nama_lengkap,
                    'nik' => $employee->nik,
                    'jabatan' => $employee->jabatan
                ]
            ]);
        }

        // ❌ Jam pulang < 4 jam
        if ($attendance->jam_masuk && !$attendance->jam_pulang) {

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

            // ✅ ABSEN PULANG
            $attendance->update([
                'jam_pulang' => $now,
                'status_hadir' => 'pulang'
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

        // ❌ Sudah lengkap
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
