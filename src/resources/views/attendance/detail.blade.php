@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')

<div class="attendance-detail">
    <div class="attendance-detail__inner">

        {{-- エラーメッセージ --}}
        @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h1 class="attendance-detail__title">勤怠詳細</h1>

        <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
            @csrf
            @method('PUT')

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
                        {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年n月j日') }}
                    </span>
                </div>

                {{-- 出勤・退勤 --}}
                <div class="attendance-detail__row">
                    <span class="label">出勤・退勤</span>
                    <div class="value">
                        <input type="time"
                            name="clock_in"
                            value="{{ old('clock_in',
                                $attendance->status === 'pending'
                                    ? $attendance->apply_clock_in
                                    : optional($attendance->clock_in)->format('H:i')
                            ) }}"
                            {{ $isEditable ? '' : 'readonly' }}>

                        〜

                        <input type="time"
                            name="clock_out"
                            value="{{ old('clock_out',
                                $attendance->status === 'pending'
                                    ? $attendance->apply_clock_out
                                    : optional($attendance->clock_out)->format('H:i')
                            ) }}"
                            {{ $isEditable ? '' : 'readonly' }}>
                    </div>
                </div>

                {{-- 休憩1 --}}
                <div class="attendance-detail__row">
                    <span class="label">休憩</span>
                    <div class="value">
                        <input type="time"
                            name="breaks[0][break_start]"
                            value="{{ optional($attendance->breaks[0]->break_start ?? null)?->format('H:i') }}"
                            {{ $isEditable ? '' : 'readonly' }}>
                        〜
                        <input type="time"
                            name="breaks[0][break_end]"
                            value="{{ optional($attendance->breaks[0]->break_end ?? null)?->format('H:i') }}"
                            {{ $isEditable ? '' : 'readonly' }}>
                    </div>
                </div>

                {{-- 休憩2 --}}
                <div class="attendance-detail__row">
                    <span class="label">休憩2</span>
                    <div class="value">
                        <input type="time"
                            name="breaks[1][break_start]"
                            value="{{ optional($attendance->breaks[1]->break_start ?? null)?->format('H:i') }}"
                            {{ $isEditable ? '' : 'readonly' }}>
                        〜
                        <input type="time"
                            name="breaks[1][break_end]"
                            value="{{ optional($attendance->breaks[1]->break_end ?? null)?->format('H:i') }}"
                            {{ $isEditable ? '' : 'readonly' }}>
                    </div>
                </div>

                {{-- 備考 --}}
                <div class="attendance-detail__row">
                    <span class="label">備考</span>
                    <textarea name="remark"
                        {{ $isEditable ? '' : 'readonly' }}>{{ old('remark',
                            $attendance->status === 'pending'
                                ? $attendance->apply_remark
                                : $attendance->remark
                        ) }}</textarea>
                </div>

            </div>

            {{-- 修正ボタン --}}
            <div class="attendance-detail__action">
                <button type="submit"
                    class="submit-btn"
                    {{ $isEditable ? '' : 'disabled' }}>
                    修正
                </button>
            </div>

            @if(!$isEditable)
            <span class="pending-text">
                承認待ちのため修正はできません。
            </span>
            @endif

        </form>

    </div>
</div>

@endsection