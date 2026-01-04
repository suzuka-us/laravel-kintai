<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrectionRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance_id',
        'user_id',
        'status',
        'remark',
    ];
}
