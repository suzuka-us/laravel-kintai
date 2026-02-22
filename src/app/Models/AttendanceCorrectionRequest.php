<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attendance;

class AttendanceCorrectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'user_id',
        'status',
        'remark',
        'apply_clock_in',
        'apply_clock_out',
    ];
    
    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 勤怠とのリレーション
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
