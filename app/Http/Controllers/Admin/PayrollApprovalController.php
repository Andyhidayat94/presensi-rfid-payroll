<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;

class PayrollApprovalController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->latest()
            ->get();

        return view('admin.payroll.index', compact('payrolls'));
    }

    public function approve($id)
    {
    $payroll = Payroll::findOrFail($id);

    if($payroll->locked){
        return back()->with('error','Payroll sudah dikunci.');
    }

    $payroll->status_approval = 'disetujui';
    $payroll->locked = true; // 🔐 LOCK
    $payroll->save();

    logActivity(
        'approve',
        'payroll',
        'Payroll dikunci ID: '.$payroll->id
    );

    return back()->with('success','Payroll disetujui & dikunci');
    }


    public function reject($id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->status_approval = 'ditolak';
        $payroll->save();

        logActivity(
            'reject',
            'payroll',
            'Admin menolak payroll ID: '.$payroll->id
        );

        return back()->with('success','Payroll ditolak');
    }
}
