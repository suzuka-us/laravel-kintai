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

            <div class="{{ session('updated') ? '' : 'attendance-detail__card' }}">

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
                        @if($isEditable)
                        <input type="time" name="clock_in"
                            value="{{ old('clock_in', optional($attendance->clock_in)->format('H:i')) }}">
                        〜
                        <input type="time" name="clock_out"
                            value="{{ old('clock_out', optional($attendance->clock_out)->format('H:i')) }}">
                        @else
                        <span>
                            {{ optional($attendance->clock_in)->format('H:i') }}
                            〜
                            {{ optional($attendance->clock_out)->format('H:i') }}
                        </span>
                        @endif
                    </div>
                </div>


                {{-- 休憩1 --}}
                <div class="attendance-detail__row">
                    <span class="label">休憩</span>
                    <div class="value">
                        @if($isEditable)
                        <input type="time" name="breaks[0][break_start]"
                            value="{{ old('breaks.0.break_start',
                    substr($attendance->breaks[0]->break_start ?? '',0,5)
                ) }}">
                        〜
                        <input type="time" name="breaks[0][break_end]"
                            value="{{ old('breaks.0.break_end',
                    substr($attendance->breaks[0]->break_end ?? '',0,5)
                ) }}">
                        @else
                        <span>
                            {{ substr($attendance->breaks[0]->break_start ?? '',0,5) }}
                            〜
                            {{ substr($attendance->breaks[0]->break_end ?? '',0,5) }}
                        </span>
                        @endif
                    </div>
                </div>



                {{-- 休憩2 --}}
                @if($isEditable)
                <div class="attendance-detail__row">
                    <span class="label">休憩2</span>
                    <div class="value">
                        <input type="time"
                            name="breaks[1][break_start]"
                            value="{{ old('breaks.1.break_start',
                substr($attendance->breaks[1]->break_start ?? '',0,5)
            ) }}">

                        〜

                        <input type="time"
                            name="breaks[1][break_end]"
                            value="{{ old('breaks.1.break_end',
                substr($attendance->breaks[1]->break_end ?? '',0,5)
            ) }}">
                    </div>
                </div>
                @endif



                {{-- 備考 --}}
                <div class="attendance-detail__row">
                    <span class="label">備考</span>
                    <div class="value">
                        @if($isEditable)
                        <textarea name="remark">{{ old('remark', $attendance->remark) }}</textarea>
                        @else
                        <span>{{ $attendance->remark }}</span>
                        @endif
                    </div>
                </div>

          </form>
    </div>
   
   
    {{-- 修正ボタン --}}
    @if(!session('updated') && $isEditable)
    <div class="attendance-detail__action">
        <button type="submit" class="submit-btn">
            修正
        </button>
    </div>
    @endif

    @if(!$isEditable)
    <span class="pending-text">
        *承認待ちのため修正はできません。
    </span>
    @endif

</div>

@endsection