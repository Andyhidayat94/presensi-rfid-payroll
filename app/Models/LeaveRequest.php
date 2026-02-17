<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_izin',
        'keterangan',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
