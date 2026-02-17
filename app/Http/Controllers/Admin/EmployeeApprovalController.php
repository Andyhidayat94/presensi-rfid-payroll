<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApprovalController extends Controller
{
   public function index(Request $request)
    {
    $query = Employee::query();

    if($request->search){
        $query->where('nama_lengkap','like','%'.$request->search.'%');
    }

    if($request->status){
        $query->where('status_kerja',$request->status);
    }

    $employees = $query->latest()->get();

    return view('admin.employees.index',compact('employees'));
    }

    public function approve($id)
    {
        $employee = Employee::findOrFail($id);

        // aktifkan akun user
        $employee->user->update([
            'is_active' => 1
        ]);

        // update status kerja
        $employee->update([
            'status_kerja' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil di-approve');

        logActivity(
    'approve',
    'employee',
    'Admin menyetujui karyawan ID: ' . $employee->id
    );

    }
}
