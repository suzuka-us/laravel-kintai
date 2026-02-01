@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')

<div class="attendance-detail">

    {{-- タイトル（枠の外・左） --}}
    @if(!$isEditable)
    <p class="text-danger">
        承認待ちのため修正はできません。
    </p>
    @endif

    <div class="attendance-detail__inner">
        <h1 class="attendance-detail__title">勤怠詳細</h1>



        {{-- 枠 --}}
        <div class="attendance-detail__card">

            {{-- 名前 --}}
            <div class="attendance-detail__row">
                <span class="label">名前</span>
                <span class="value">{{ $user->name }}</span>
            </div>

            {{-- 日付 --}}
            <div class="attendance-detail__row">
                <span class="label">日付</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年 n月j日') }}
                </span>
            </div>

            {{-- 出勤・退勤 --}}
            <div class="attendance-detail__row">
                <span class="label">出勤・退勤</span>
                <div class="value">
                    <input type="time" value="{{ $attendance->clock_in }}">
                    〜
                    <input type="time" value="{{ $attendance->clock_out }}">
                </div>
            </div>

            {{-- 休憩 --}}
            <div class="attendance-detail__row">
                <span class="label">休憩</span>
                <div class="value">
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_start ?? '' }}">
                    〜
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_end ?? '' }}">
                </div>
            </div>

            <div class="attendance-detail__row">
                <span class="label">休憩2</span>
                <div class="value">
                    <input type="time"
                        value="{{ $attendance->breaks[1]->break_start ?? '' }}">
                    〜
                    <input type="time"
                        value="{{ $attendance->breaks[1]->break_end ?? '' }}">
                </div>
            </div>


            {{-- 備考 --}}
            <div class="attendance-detail__row">
                <span class="label">備考</span>
                <textarea class="value">{{ $attendance->remark }}</textarea>
            </div>

        </div>

        {{-- 修正ボタン --}}
        <div class="attendance-detail__action">
            <button class="submit-btn">修正</button>
        </div>

        @endsection