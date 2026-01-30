@extends('layouts.app')


@section('content')
<div class="attendance-detail">

    <h2>勤怠詳細</h2>

    {{-- 名前 --}}
    <p>名前：{{ $user->name }}</p>

    {{-- 日付 --}}
    <p>日付：{{ $attendance->work_date }}</p>

    {{-- 出勤・退勤 --}}
    <form method="POST" action="#">
        @csrf

        <div>
            <label>出勤</label>
            <input type="time" name="clock_in"
                value="{{ $attendance->clock_in }}">
        </div>

        <div>
            <label>退勤</label>
            <input type="time" name="clock_out"
                value="{{ $attendance->clock_out }}">
        </div>

        {{-- 休憩 --}}
        <h3>休憩</h3>

        @foreach($attendance->breaks as $break)
        <div>
            <input type="time"
                value="{{ $break->break_start }}">
            〜
            <input type="time"
                value="{{ $break->break_end }}">
        </div>
        @endforeach

        {{-- 追加用（1行） --}}
        <div>
            <input type="time"> 〜 <input type="time">
        </div>

        {{-- 備考 --}}
        <div>
            <label>備考</label><br>
            <textarea name="remark">{{ $attendance->remark }}</textarea>
        </div>

        <button>修正申請</button>
    </form>

</div>
@endsection
