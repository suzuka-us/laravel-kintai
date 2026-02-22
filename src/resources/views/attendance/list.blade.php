@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')

<div class="attendance-wrapper">

    {{-- タイトル：白枠の上、左寄せ --}}
    <h1 class="attendance-wrapper__title">勤怠一覧</h1>

    {{-- 白枠カード --}}
    <div class="attendance-wrapper__inner">

        {{-- 月ナビゲーション --}}
        <div class="month-nav-wrapper">
            <a class="month-nav__prev" href="{{ route('attendance.list', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}">
                ← 前月
            </a>

            <form class="month-nav__form" method="GET" action="{{ route('attendance.list') }}">
                <div class="month-input-wrapper">
                    <input type="month" name="month" value="{{ $currentMonth->format('Y-m') }}" onchange="this.form.submit()">
                </div>
            </form>

            <a class="month-nav__next" href="{{ route('attendance.list', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}">
                翌月 →
            </a>
        </div>


        {{-- 勤怠テーブル --}}
        <table class="attendance-card">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                @php
                $workMinutes = $attendance->clock_in && $attendance->clock_out
                ? \Carbon\Carbon::parse($attendance->clock_out)->diffInMinutes(\Carbon\Carbon::parse($attendance->clock_in))
                : 0;

                $breakMinutes = 0;
                foreach ($attendance->breaks as $break) {
                if ($break->break_start && $break->break_end) {
                $breakMinutes += \Carbon\Carbon::parse($break->break_end)->diffInMinutes(\Carbon\Carbon::parse($break->break_start));
                }
                }

                $totalMinutes = max($workMinutes - $breakMinutes, 0);
                $hours = floor($totalMinutes / 60);
                $minutes = $totalMinutes % 60;

                $breakHours = floor($breakMinutes / 60);
                $breakRemainMinutes = $breakMinutes % 60;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($attendance->work_date)->format('m/d') }}
                        ({{ \Carbon\Carbon::parse($attendance->work_date)->locale('ja')->isoFormat('ddd') }})
                    </td>
                    <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '' }}</td>
                    <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '' }}</td>
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
                        <a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection