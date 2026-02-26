@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">
@endsection
@section('content')

<div class="admin-attendance attendance-wrapper">

    <h1 class="attendance-wrapper__title">勤怠一覧</h1>

    {{-- 白枠①：日付ナビ --}}
    <div class="attendance-wrapper__inner">

        <div class="month-nav-wrapper">

            <a class="month-nav__prev"
                href="{{ route('admin.attendance.list', ['date' => $date->copy()->subDay()->toDateString()]) }}">
                ← 前日
            </a>

            <div class="month-nav__form">
                <div class="month-input-wrapper">
                    {{ $date->format('Y年m月d日') }}
                </div>
            </div>

            <a class="month-nav__next"
                href="{{ route('admin.attendance.list', ['date' => $date->copy()->addDay()->toDateString()]) }}">
                翌日 →
            </a>

        </div>

    </div>


    {{-- 白枠②：テーブル --}}
    <div class="attendance-wrapper__inner">

        <table class="attendance-card">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                @php
                $attendance = $user->attendances->first();
                @endphp
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $attendance?->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '' }}</td>
                    <td>{{ $attendance?->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '' }}</td>
                    <td>{{ $attendance?->break_time ?? '—' }}</td>
                    <td>{{ $attendance?->status ?? '—' }}</td>
                    <td>
                        @if($attendance)
                        <a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection