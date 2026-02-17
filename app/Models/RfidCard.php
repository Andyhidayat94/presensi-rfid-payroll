<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    use HasFactory;

    protected $table = 'rfid_cards';

    protected $fillable = [
        'employee_id',
        'uid_rfid',
        'is_active',
        'registered_at',
        'deactivated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'registered_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
