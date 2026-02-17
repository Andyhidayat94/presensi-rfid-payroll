<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\RfidCard;
use Illuminate\Http\Request;

class RfidCardController extends Controller
{
    /**
     * Daftar kartu RFID
     */
    public function index()
    {
        $cards = RfidCard::with('employee')
            ->latest()
            ->get();

        return view('hrd.rfid.index', compact('cards'));
    }

    /**
     * Form registrasi kartu RFID
     */
    public function create()
    {
        /**
         * HANYA tampilkan karyawan yang:
         * - status kerja = aktif
         * - BELUM PERNAH punya kartu RFID (aktif atau nonaktif)
         */
        $employees = Employee::where('status_kerja', 'aktif')
            ->whereDoesntHave('rfidCards') // penting!
            ->get();

        return view('hrd.rfid.create', compact('employees'));
    }

    /*Hapus Kartu RFID
    */
    public function destroy($id)
    {
    $rfid = RfidCard::findOrFail($id);

    if ($rfid->is_active) {
        return back()->withErrors('Tidak bisa menghapus RFID yang masih aktif');
    }

    $rfid->delete();

    return back()->with('success', 'RFID berhasil dihapus');
    }

    /**
     * Simpan registrasi kartu RFID
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'uid_rfid'    => 'required|string',
        ]);

        // 1️⃣ UID RFID HARUS UNIK (tidak boleh reuse)
        if (RfidCard::where('uid_rfid', $request->uid_rfid)->exists()) {
            return back()->withErrors([
                'uid_rfid' => 'Kartu RFID ini sudah terdaftar.'
            ])->withInput();
        }

        // 2️⃣ Karyawan TIDAK BOLEH punya kartu RFID apa pun
        if (RfidCard::where('employee_id', $request->employee_id)->exists()) {
            return back()->withErrors([
                'employee_id' => 'Karyawan ini sudah memiliki kartu RFID.'
            ])->withInput();
        }

        // 3️⃣ Simpan kartu RFID
        RfidCard::create([
            'employee_id'  => $request->employee_id,
            'uid_rfid'     => $request->uid_rfid,
            'is_active'    => 1,
            'registered_at' => now(),
        ]);

        return redirect()
            ->route('hrd.rfid.index')
            ->with('success', 'Kartu RFID berhasil diregistrasi.');
    }
}
