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
    'hari_hadir',
    'gaji_pokok',
    'potongan',
    'gaji_bersih',
    'status_approval',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
