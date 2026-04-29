<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
    'employee_id',
    'bulan',
    'tahun',
    'tipe_gaji',
    'hari_hadir',
    'total_alpha',
    'total_cuti',
    'gaji_pokok',
    'upah_harian',
    'potongan',
    'gaji_bersih',
    'status_approval',
    'locked'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
