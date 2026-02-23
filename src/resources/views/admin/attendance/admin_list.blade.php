@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">

<div class="admin-attendance">

    <h1>勤怠一覧</h1>

    <div class="admin-attendance__header">

        <form method="get" action="{{ route('admin.attendance.list') }}">
            <input type="hidden" name="date"
                value="{{ $date->copy()->subDay()->toDateString() }}">
            <button class="admin-attendance__button">前日</button>
        </form>

        <div class="admin-attendance__date">
            {{ $date->format('Y年m月d日') }}
        </div>

        <form method="get" action="{{ route('admin.attendance.list') }}">
            <input type="hidden" name="date"
                value="{{ $date->copy()->addDay()->toDateString() }}">
            <button class="admin-attendance__button">翌日</button>
        </form>

    </div>

    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>ステータス</th>
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

                <td>
                    {{ $attendance?->clock_in
                        ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i')
                        : '' }}
                </td>

                <td>
                    {{ $attendance?->clock_out
                        ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i')
                        : '' }}
                </td>

                <td>
                    {{ $attendance?->break_time ?? '' }}
                </td>

                <td>
                    {{ $attendance?->status ?? '' }}
                </td>

                <td>
                    @if($attendance)
                    <a href="{{ route('attendance.detail', $attendance->id) }}">
                        詳細
                    </a>
                    @endif
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>

</div>

@endsection