@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
<div class="attendance-list">

    <h2>
        {{ $currentMonth->format('Y年m月') }}
    </h2>

    <div class="month-nav">
        <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}">
            前月
        </a>
        |
        <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}">
            翌月
        </a>
    </div>

    <table>
        <tr>
            <th>日付</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>休憩</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>

        @foreach($attendances as $attendance)
        @php
        $workMinutes = 0;

        if ($attendance->clock_in && $attendance->clock_out) {
        $start = \Carbon\Carbon::parse($attendance->clock_in);
        $end = \Carbon\Carbon::parse($attendance->clock_out);
        $workMinutes = $end->diffInMinutes($start);
        }

        $breakMinutes = 0;
        foreach ($attendance->breaks as $break) {
        if ($break->break_start && $break->break_end) {
        $start = \Carbon\Carbon::parse($break->break_start);
        $end = \Carbon\Carbon::parse($break->break_end);
        $breakMinutes += $end->diffInMinutes($start);
        }
        }

        $totalMinutes = max($workMinutes - $breakMinutes, 0);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        $breakHours = floor($breakMinutes / 60);
        $breakRemainMinutes = $breakMinutes % 60;
        @endphp

        <tr>
            <td>
                {{ \Carbon\Carbon::parse($attendance->work_date)->format('m/d') }}
                ({{ \Carbon\Carbon::parse($attendance->work_date)->locale('ja')->isoFormat('ddd') }})
            </td>


            <td>
                {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '' }}
            </td>

            <td>
                {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '' }}
            </td>

            <td>
                @if($breakMinutes > 0)
                {{ $breakHours }}時間{{ $breakRemainMinutes }}分
                @else
                —
                @endif
            </td>

            <td>
                @if($attendance->clock_in && $attendance->clock_out)
                {{ $hours }}時間{{ $minutes }}分
                @else
                —
                @endif
            </td>

            <td>
                <a href="{{ route('attendance.detail', $attendance->id) }}">
                    詳細
                </a>
            </td>
        </tr>
        @endforeach

    </table>

</div>
@endsection