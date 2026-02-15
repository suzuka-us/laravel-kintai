<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class StampCorrectionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 申請一覧画面
     */
    public function requestList()
    {
        $userId = Auth::id();

        // 承認待ち：status = pending
        $pendingRequests = Attendance::where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 承認済み：status = approved
        $approvedRequests = Attendance::where('user_id', $userId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stamp_correction_request.request_list', compact('pendingRequests', 'approvedRequests'));
    }
}
