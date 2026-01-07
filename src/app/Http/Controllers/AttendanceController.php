<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        // 全てのメソッドでログイン必須
        $this->middleware('auth');
    }
    /**
     * 勤怠打刻画面表示
     */
    public function index()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();

        if (!$attendance) {
            $status = '勤務外';
        } else {
            $status = $attendance->status;
        }

        return view('attendance.index', [
            'status' => $status,
            'attendance' => $attendance,
        ]);
    }

    /**
     * 出勤
     */
    public function clockIn()
    {
        Attendance::create([
            'user_id'   => auth()->id(),
            'work_date' => now()->toDateString(),
            'clock_in'  => now(),
            'status'    => '出勤中',
        ]);

        return back();
    }

    /**
     * 退勤
     */
    public function clockOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();

        $attendance->update([
            'clock_out' => now(),
            'status'    => '退勤済',
        ]);

        return back()->with('message', 'お疲れ様でした。');
    }

    // 休憩入　追加
    public function breakStart()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();

        $attendance->update([
            'status' => '休憩中',
        ]);

        return back();
    }

    // 休憩戻
    public function breakEnd()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();

        $attendance->update([
            'status' => '出勤中',
        ]);

        return back();
    }
}


