<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BreakTime;

class BreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 から 20 までの userid = 1 の休憩データを作成 12:00 - 13:00

        for ($i = 1; $i <= 20; $i++) {
            BreakTime::create([
                'attendance_id' => 1,
                'break_start' => '12:00:00',
                'break_end' => '13:00:00',
            ]);
        }
    }
}
