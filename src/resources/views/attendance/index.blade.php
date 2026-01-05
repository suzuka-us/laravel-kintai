@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance">

    {{-- 勤務外 --}}
    <p class="attendance__status">
        勤務外
    </p>

    {{-- 日付 --}}
    <p class="attendance__date">
        {{ now()->locale('ja')->isoFormat('YYYY年MM月DD日（ddd）') }}
    </p>

    {{-- 時間 --}}
    <p class="attendance__time">
        {{ now()->format('H:i') }}
    </p>

    {{-- 出勤ボタン --}}
    <form method="POST" action="{{ route('attendance.clockIn') }}">
        @csrf
        <button class="attendance__button">
            出勤
        </button>
    </form>

</div>
@endsection