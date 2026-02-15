@extends('layouts.app')

@section('content')

<h2>承認待ち</h2>

<table border="1">
    <tr>
        <th>状態</th>
        <th>名前</th>
        <th>対象日時</th>
        <th>申請理由</th>
        <th>申請日時</th>
        <th>詳細</th>
    </tr>

    @foreach($pendingRequests as $attendance)
    <tr>
        <td>承認待ち</td>
        <td>{{ $attendance->user->name }}</td>
        <td>{{ $attendance->apply_clock_in }}</td>
        <td>{{ $attendance->apply_remark }}</td>
        <td>{{ $attendance->created_at->format('Y-m-d H:i') }}</td>
        <td>
            <a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>

<h2>承認済み</h2>

<table border="1">
    <tr>
        <th>状態</th>
        <th>名前</th>
        <th>対象日時</th>
        <th>申請理由</th>
        <th>申請日時</th>
        <th>詳細</th>
    </tr>

    @foreach($approvedRequests as $attendance)
    <tr>
        <td>承認済み</td>
        <td>{{ $attendance->user->name }}</td>
        <td>{{ $attendance->apply_clock_in }}</td>
        <td>{{ $attendance->apply_remark }}</td>
        <td>{{ $attendance->created_at->format('Y-m-d H:i') }}</td>
        <td>
            <a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>

@endsection