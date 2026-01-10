<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BreakTime;
use Carbon\Carbon;

class BreakTimeSeeder extends Seeder
{
    public function run(): void
    {
        BreakTime::create([
            'attendance_id' => 1, // attendances.id
            'break_start'   => Carbon::today()->setTime(12, 0),
            'break_end'     => Carbon::today()->setTime(13, 0),
        ]);
    }
}
