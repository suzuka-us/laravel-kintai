<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceCorrectionRequest;
use App\Models\StampCorrectionRequest;


class StampCorrectionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

   
}
