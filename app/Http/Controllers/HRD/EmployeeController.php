<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('hrd.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('hrd.employees.create');
    }

    public function store(Request $request)
{
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
        'jabatan' => 'required',
        'tanggal_masuk' => 'required|date',
    ]);

    // Buat akun login
    $user = \App\Models\User::create([
        'name' => $request->nama_lengkap, // penting
        'email' => $request->email,
        'password' => bcrypt('password123'),
        'role_id' => 4, // karyawan
        'is_active' => 0,
    ]);

    // Simpan data employee
    \App\Models\Employee::create([
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
        'jabatan' => $request->jabatan,
        'tanggal_masuk' => $request->tanggal_masuk,
        'status_kerja' => 'pending'
    ]);

    return redirect()
        ->route('hrd.employees.index')
        ->with('success', 'Data karyawan berhasil ditambahkan dan menunggu approval admin.');
    }
}
