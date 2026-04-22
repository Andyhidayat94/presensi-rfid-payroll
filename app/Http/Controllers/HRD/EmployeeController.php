<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        $rules = \App\Models\SalaryRule::all();

        return view('hrd.employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        $departments = Department::all();
        $rules = \App\Models\SalaryRule::all();

        return view('hrd.employees.create', compact('positions', 'departments'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code',
            'email' => 'required|email|unique:users,email',
            'nama_lengkap' => 'required',
            'nik' => 'required|unique:employees,nik',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'position_id' => 'required',
            'department_id' => 'nullable',
            'tanggal_masuk' => 'required|date',
        ]);

        // ✅ AMBIL DATA POSITION (UNTUK ISI JABATAN)
        $position = Position::findOrFail($request->position_id);

        // ✅ BUAT USER LOGIN
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role_id' => 4, // karyawan
            'is_active' => 0,
        ]);

        // ✅ SIMPAN EMPLOYEE
        Employee::create([
            'user_id' => $user->id,
            'employee_code' => $request->employee_code,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,

            // 🔥 FIX UTAMA
            'jabatan' => $position->name,

            'position_id' => $request->position_id,
            'department_id' => $request->department_id,

            'tanggal_masuk' => $request->tanggal_masuk,
            'status_kerja' => 'pending',
        ]);

        return redirect()
            ->route('hrd.employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan dan menunggu approval admin.');
    }
}