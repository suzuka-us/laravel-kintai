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
        // testuserの勤怠データを作成
        // 2025/12/1 から 2025/12/20 までの勤怠データを作成
        for ($date = Carbon::parse('2025/12/1'); $date->lte(Carbon::parse('2025/12/20')); $date->addDay()) {
            Attendance::create([
                'user_id'   => 1, // usersテーブルに存在するID
                'work_date' => $date,
                'clock_in'  => '08:00:00',
                'clock_out' => '20:00:00',
                'status'    => '退勤済み',
                'remark'    => null,
            ]);
        }
    }
}
