<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::create([
            'user_id'   => 1, // usersテーブルに存在するID
            'work_date' => Carbon::today(),
            'clock_in'  => null,
            'clock_out' => null,
            'status'    => '勤務外',
            'remark'    => null,
        ]);
    }
}
