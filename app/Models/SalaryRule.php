<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRule extends Model
{
    protected $fillable = [
    'position_id',
    'department_id',
    'tipe_gaji',
    'gaji_pokok',
    'uang_harian',
    'status',
    'approved_by',
    'approved_at',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
