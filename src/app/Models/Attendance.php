<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
        'remark',
        'status',
        'apply_clock_in',
        'apply_clock_out',
        'apply_remark',
    ];

    // 休憩（1対多）
    public function breaks()
    {
        return $this->hasMany(BreakTime::class);
    }
}
