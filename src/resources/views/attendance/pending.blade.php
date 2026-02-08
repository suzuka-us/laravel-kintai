@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')

<div class="attendance-detail">

    {{-- 承認待ちメッセージ --}}
    <p class="text-danger">
        承認待ちのため修正はできません。
    </p>

    <div class="attendance-detail__inner">
        <h1 class="attendance-detail__title">勤怠詳細（承認待ち）</h1>

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
                    <input type="time"
                        value="{{ $attendance->clock_in }}"
                        readonly>
                    〜
                    <input type="time"
                        value="{{ $attendance->clock_out }}"
                        readonly>
                </div>
            </div>

            {{-- 休憩（1のみ表示） --}}
            <div class="attendance-detail__row">
                <span class="label">休憩</span>
                <div class="value">
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_start ?? '' }}"
                        readonly>
                    〜
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_end ?? '' }}"
                        readonly>
                </div>
            </div>

            {{-- 備考 --}}
            <div class="attendance-detail__row">
                <span class="label">備考</span>
                <textarea class="value" readonly>{{ $attendance->remark }}</textarea>
            </div>

        </div>

       
    </div>
</div>

@endsection