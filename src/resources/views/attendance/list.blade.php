@extends('layouts.app')

@section('css') {{-- ★ これを追加 --}}
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
<div class="attendance-list">

    <h2>
        {{ $currentMonth->format('Y年m月') }}
    </h2>

    {{-- 月切り替え --}}
    <div class="month-nav">
        <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}">
            前月
        </a>
        |
        <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}">
            翌月
        </a>
    </div>

    {{-- 一覧 --}}
    <table>
        <tr>
            <th>日付</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>

        @foreach($attendances as $attendance)
        <tr>

            <td>{{ $attendance->work_date }}</td>
            <td>{{ $attendance->clock_in ?? '' }}</td>
            <td>{{ $attendance->clock_out ?? '' }}</td>
            <td>{{ $attendance->status }}</td>
            <td>
                <a href="#">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>

</div>
@endsection