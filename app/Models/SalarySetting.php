<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySetting extends Model
{
    protected $fillable = [
    'jabatan',
    'upah_harian'
];

    use HasFactory;
}
