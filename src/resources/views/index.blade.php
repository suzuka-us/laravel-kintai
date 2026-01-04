@extends('layouts.app')

@section('content')

<div class="attendance__content">

    {{-- メッセージ --}}
    @if(session('message'))
    <div class="attendance__alert">
        {{ session('message') }}
    </div>
    @endif

    <div class="attendance__panel">

        {{-- 勤務外 --}}
        @if($status === '勤務外')
        <form method="POST" action="{{ route('attendance.clockIn') }}">
            @csrf
            <button>出勤</button>
        </form>
        @endif

        {{-- 出勤中 --}}
        @if($status === '出勤中')
        <form method="POST" action="{{ route('attendance.clockOut') }}">
            @csrf
            <button>退勤</button>
        </form>
        @endif

        {{-- 退勤済 --}}
        @if($status === '退勤済')
        <p>本日の勤務は終了しました</p>
        @endif

    </div>

    {{-- 当日の勤怠表示 --}}
    @if($attendance)
    <table>
        <tr>
            <th>出勤</th>
            <th>退勤</th>
        </tr>
        <tr>
            <td>{{ $attendance->clock_in }}</td>
            <td>{{ $attendance->clock_out }}</td>
        </tr>
    </table>
    @endif

</div>
@endsection