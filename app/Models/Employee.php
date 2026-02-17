<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// IMPORT SEMUA MODEL YANG DIPAKAI
use App\Models\User;
use App\Models\RfidCard;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Salary;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'user_id',
        'employee_code',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'nik',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'pendidikan_terakhir',
        'jabatan',
        'tanggal_masuk',
        'status_kerja',
    ];

    /**
     * Relasi ke tabel users
     * 1 employee -> 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kartu RFID
     * 1 employee -> bisa punya beberapa kartu (historis)
     */
    public function rfidCards()
    {
        return $this->hasMany(RfidCard::class);
    }

    /**
     * Relasi ke presensi
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relasi ke pengajuan izin
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Relasi ke gaji
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
