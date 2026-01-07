@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance">

    {{-- ステータス --}}
    <p class="attendance__status">
        {{ $status }}
    </p>

    {{-- 日付 --}}
    <p class="attendance__date">
        {{ now()->locale('ja')->isoFormat('YYYY年MM月DD日（ddd）') }}
    </p>

    {{-- 時間 --}}
    <p class="attendance__time">
        {{ now()->format('H:i') }}
    </p>

    {{-- 出勤（勤務外のみ表示） --}}
    @if($status === '勤務外')
    <form method="POST" action="{{ route('attendance.clockIn') }}">
        @csrf
        <button class="attendance__button">
            出勤
        </button>
    </form>
    @endif

    {{-- 出勤中：退勤 ＋ 休憩入（同じページ） --}}
    @if($status === '出勤中')
    <div class="attendance__actions">

        <form method="POST" action="{{ route('attendance.clockOut') }}">
            @csrf
            <button class="attendance__button">
                退勤
            </button>
        </form>

        <form method="POST" action="{{ route('attendance.breakStart') }}">
            @csrf
            <button class="attendance__button attendance__button--break">
                休憩入
            </button>
        </form>
    </div>
    @endif

    {{-- 休憩中：休憩戻 --}}
    @if($status === '休憩中')
    <form method="POST" action="{{ route('attendance.breakEnd') }}">
        @csrf
        <button class="attendance__button">
            休憩戻
        </button>
    </form>
    @endif

    {{-- 退勤済：メッセージ --}}
    @if($status === '退勤済')
    <p class="attendance__message">
        お疲れ様でした。
    </p>
    @endif

</div>
@endsection