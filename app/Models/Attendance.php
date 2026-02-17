<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'employee_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_hadir',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'jam_masuk'  => 'datetime',
        'jam_pulang' => 'datetime',
    ];

    /**
     * Relasi: 1 attendance milik 1 employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Helper: sudah absen masuk?
     */
    public function hasCheckIn(): bool
    {
        return !is_null($this->jam_masuk);
    }

    /**
     * Helper: sudah absen pulang?
     */
    public function hasCheckOut(): bool
    {
        return !is_null($this->jam_pulang);
    }
}
