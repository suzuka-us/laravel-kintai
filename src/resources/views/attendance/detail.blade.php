@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')

<div class="attendance-detail">

    {{-- 追加①：承認待ちメッセージ --}}
    @if(!$isEditable)
    <p class="text-danger">
        承認待ちのため修正はできません。
    </p>
    @endif

    {{-- 追加 --}}
    @if ($errors->any())
    <div class="error-messages">
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="attendance-detail__inner">
        <h1 class="attendance-detail__title">勤怠詳細</h1>

        {{-- 枠 --}}
        <div class="attendance-detail__card">

            {{-- 名前（変更なし） --}}
            <div class="attendance-detail__row">
                <span class="label">名前</span>
                <span class="value">{{ $user->name }}</span>
            </div>

            {{-- 日付（変更なし） --}}
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
                    {{-- ★変更②：readonly 制御 --}}
                    <input type="time"
                        value="{{ $attendance->clock_in }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                    〜
                    <input type="time"
                        value="{{ $attendance->clock_out }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                </div>
            </div>

            {{-- 休憩 --}}
            <div class="attendance-detail__row">
                <span class="label">休憩</span>
                <div class="value">
                    {{-- ★変更③：readonly 制御 --}}
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_start ?? '' }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                    〜
                    <input type="time"
                        value="{{ $attendance->breaks[0]->break_end ?? '' }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                </div>
            </div>

            <div class="attendance-detail__row">
                <span class="label">休憩2</span>
                <div class="value">
                    {{-- ★変更④：readonly 制御 --}}
                    <input type="time"
                        value="{{ $attendance->breaks[1]->break_start ?? '' }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                    〜
                    <input type="time"
                        value="{{ $attendance->breaks[1]->break_end ?? '' }}"
                        {{ $isEditable ? '' : 'readonly' }}>
                </div>
            </div>

            {{-- 備考 --}}
            <div class="attendance-detail__row">
                <span class="label">備考</span>
                {{-- ★変更⑤：readonly 制御 --}}
                <textarea class="value"
                    {{ $isEditable ? '' : 'readonly' }}>{{ $attendance->remark }}</textarea>
            </div>

        </div>

        {{-- ★追加①：フォーム開始 --}}
        <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
            @csrf
            @method('PUT')

            {{-- 修正ボタン --}}
            <div class="attendance-detail__action">
                {{-- ★変更⑥：承認待ちは押せない ＋ ★変更⑦：submit指定 --}}
                <button type="submit"
                    class="submit-btn"
                    {{ $isEditable ? '' : 'disabled' }}>
                    修正
                </button>
            </div>

            {{-- ★追加②：フォーム終了 --}}
        </form>


        @endsection