<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\BreakTime;
use Carbon\Carbon;

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
    public function breakStart(Request $request)
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();

        $attendance->update([
            'status' => '休憩中',
        ]);

        $breakTime = BreakTime::create([
            'attendance_id' => $attendance->id,
            'break_start' => now(),
        ]);

        $request->session()->put('breakTimeId', $breakTime->id);

        return back();
    }


    // 休憩戻
    public function breakEnd(Request $request)
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', now())
            ->first();
        $attendance->update([
            'status' => '出勤中',
        ]);

        $breakTimeId = $request->session()->get('breakTimeId');
        $breakTime = BreakTime::find($breakTimeId);
        $breakTime->update([
            'break_end' => now(),
        ]);

        return back();
    }
   
    // 勤怠一覧画面
    public function list(Request $request)
    {
        // 表示する月（指定がなければ今月）
        $currentMonth = $request->input('month')
            ? Carbon::parse($request->input('month'))
            : Carbon::now();

        // 月初・月末
        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth   = $currentMonth->copy()->endOfMonth();

        // 勤怠取得（自分の分だけ）
        $attendances = Attendance::where('user_id', auth()->id())
            ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
            ->orderBy('work_date')
            ->get();

        return view('attendance.list', [
            'attendances'   => $attendances,
            'currentMonth'  => $currentMonth,
        ]);
    }

    // 勤怠詳細画面
    public function detail($id)
    {
        $attendance = Attendance::with('breaks')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('attendance.detail', [
            'attendance' => $attendance,
            'user' => auth()->user(),
        ]);
    }
    
}


