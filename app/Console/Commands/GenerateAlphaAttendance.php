<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class GenerateAlphaAttendance extends Command
{
    protected $signature = 'attendance:generate-alpha';
    protected $description = 'Generate alpha attendance for employees without attendance or approved leave';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $employees = Employee::whereHas('user', function ($q) {
            $q->where('is_active', 1);
        })->get();

        foreach ($employees as $employee) {

            // Sudah ada presensi hari ini?
            $alreadyAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if ($alreadyAttendance) {
                continue;
            }

            // Ada cuti/sakit disetujui hari ini?
            $approvedLeave = LeaveRequest::where('employee_id', $employee->id)
                ->where('status', 'disetujui')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->exists();

            if ($approvedLeave) {
                continue;
            }

            // Generate Alpha
            Attendance::create([
                'employee_id' => $employee->id,
                'tanggal' => $today,
                'status_hadir' => 'alpha'
            ]);
        }

        $this->info('Alpha attendance generated successfully.');
    }
}
