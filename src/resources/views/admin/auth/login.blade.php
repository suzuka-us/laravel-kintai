@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="form">
    <h1>管理者ログイン</h1>

    <form method="POST" action="{{ url('/admin/login') }}">
        @csrf

        <div class="form__group">
            <label>メールアドレス</label>
            <div class="form__input--text">
                <input type="email" name="email" value="{{ old('email') }}">
            </div>
            @error('email')
            <span class="form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form__group">
            <label>パスワード</label>
            <div class="form__input--text">
                <input type="password" name="password">
            </div>
            @error('password')
            <span class="form__error">{{ $message }}</span>
            @enderror
        </div>

        @if($errors->has('login'))
        <div class="form__error">{{ $errors->first('login') }}</div>
        @endif

        <button type="submit" class="form__button-submit">
            管理者ログインする
        </button>
    </form>
</div>
@endsection