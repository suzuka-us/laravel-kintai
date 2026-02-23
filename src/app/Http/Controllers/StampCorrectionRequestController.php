<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceCorrectionRequest;
use App\Models\Attendance;
use App\Models\BreakTime;

class StampCorrectionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 申請一覧画面
    public function requestList()
    {
        $userId = Auth::id();

        $pendingRequests = AttendanceCorrectionRequest::with('user', 'attendance')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedRequests = AttendanceCorrectionRequest::with('user', 'attendance')
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'stamp_correction_request.request_list',
            compact('pendingRequests', 'approvedRequests')
        );
    }

    // 修正申請保存
    public function store(Request $request)
    {
        $attendance = Attendance::with('breaks')
            ->where('id', $request->attendance_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // ① 申請テーブル保存
        AttendanceCorrectionRequest::create([
            'attendance_id'   => $attendance->id,
            'user_id'         => Auth::id(),
            'status'          => 'pending',
            'remark'          => $request->remark,
            'apply_clock_in'  => $request->clock_in,
            'apply_clock_out' => $request->clock_out,
        ]);

        // ② 本体も更新（画面表示用）
        $attendance->update([
            'clock_in'        => $request->clock_in,
            'clock_out'       => $request->clock_out,
            'remark'          => $request->remark,
            'apply_clock_in'  => $request->clock_in,
            'apply_clock_out' => $request->clock_out,
            'apply_remark'    => $request->remark,
            'approval_status' => 'pending',
        ]);

        // ③ 休憩も申請値を保存
        if ($request->has('breaks')) {
            foreach ($request->breaks as $index => $breakInput) {

                if (empty($breakInput['break_start']) && empty($breakInput['break_end'])) {
                    continue;
                }

                $break = $attendance->breaks[$index] ?? null;

                if ($break) {
                    $break->update([
                        'apply_break_start' => $breakInput['break_start'],
                        'apply_break_end'   => $breakInput['break_end'],
                    ]);
                } else {
                    BreakTime::create([
                        'attendance_id'     => $attendance->id,
                        'break_start'       => $breakInput['break_start'],
                        'break_end'         => $breakInput['break_end'],
                        'apply_break_start' => $breakInput['break_start'],
                        'apply_break_end'   => $breakInput['break_end'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('attendance.detail', $attendance->id)
            ->with('updated', true);
    }
}
