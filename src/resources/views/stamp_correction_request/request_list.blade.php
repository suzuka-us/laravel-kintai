<!-- resources/views/stamp_correction_request/request_list.blade.php -->
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-request-list.css') }}">
@endsection

@section('content')

<div class="attendance-wrapper">

    {{-- タイトル：白枠上、左 --}}
    <h1 class="attendance-wrapper__title">申請一覧</h1>

    <div class="month-nav tab-area">
        <span class="tab-text active" onclick="showTab('pending')">承認待ち</span>
        <span class="tab-text" onclick="showTab('approved')">承認済み</span>
    </div>

    {{-- 白枠カード --}}
    <div class="attendance-wrapper__inner">

        <!-- テーブル -->
        <table class="attendance-card">
            <thead>
                <tr>
                    <th>状態</th>
                    <th>名前</th>
                    <th>対象日時</th>
                    <th>申請理由</th>
                    <th>申請日時</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                {{-- 承認待ち --}}
                @foreach($pendingRequests as $request)
                <tr class="pending-row">
                    <td>承認待ち</td>
                    <td>{{ $request->user->name }}</td>
                    <td>
                        {{-- work_date があればそれ、なければ apply_clock_in、どちらもなければ「データなし」 --}}
                        {{ optional($request->attendance)->work_date 
                            ? \Carbon\Carbon::parse($request->attendance->work_date)->format('Y/m/d') 
                            : (optional($request->apply_clock_in) 
                                ? \Carbon\Carbon::parse($request->apply_clock_in)->format('Y/m/d') 
                                : 'データなし') }}
                    </td>
                    <td>{{ $request->remark ?? 'データなし' }}</td>
                    <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('attendance.detail', $request->attendance_id) }}">詳細</a>
                    </td>
                </tr>
                @endforeach

                {{-- 承認済み --}}
                @foreach($approvedRequests as $request)
                <tr class="approved-row" style="display:none;">
                    <td>承認済み</td>
                    <td>{{ $request->user->name }}</td>
                    <td>
                        {{-- まず work_date、それがなければ apply_clock_in、両方なければ「データなし」 --}}
                        {{ optional($request->attendance)->work_date 
                            ? \Carbon\Carbon::parse($request->attendance->work_date)->format('Y/m/d') 
                            : (optional($request->apply_clock_in) 
                                ? \Carbon\Carbon::parse($request->apply_clock_in)->format('Y/m/d') 
                                : 'データなし') }}
                    </td>
                    <td>{{ $request->remark ?? 'データなし' }}</td>
                    <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('attendance.detail', $request->attendance_id) }}">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<script>
    function showTab(type) {
        const pendingRows = document.querySelectorAll('.pending-row');
        const approvedRows = document.querySelectorAll('.approved-row');
        const tabs = document.querySelectorAll('.tab-text');

        tabs.forEach(tab => tab.classList.remove('active'));

        if (type === 'pending') {
            pendingRows.forEach(row => row.style.display = '');
            approvedRows.forEach(row => row.style.display = 'none');
            tabs[0].classList.add('active');
        } else {
            pendingRows.forEach(row => row.style.display = 'none');
            approvedRows.forEach(row => row.style.display = '');
            tabs[1].classList.add('active');
        }
    }
</script>

@endsection