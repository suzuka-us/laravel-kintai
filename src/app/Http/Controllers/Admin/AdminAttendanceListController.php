<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AdminAttendanceListController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date')
            ? Carbon::parse($request->query('date'))
            : Carbon::today();

        $users = User::with(['attendances' => function ($query) use ($date) {
            $query->whereDate('clock_in', $date);
        }])->get();

        return view('admin.attendance.admin_list', compact('users', 'date'));
    }
}
