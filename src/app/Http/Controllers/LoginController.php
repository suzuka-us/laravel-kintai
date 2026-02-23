<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'login' => 'ログイン情報が登録されていません',
            ]);
        }

        // （これが無いとログイン状態にならない）
        $request->session()->regenerate();

        // ★ 勤怠登録画面へ
        return redirect()->route('attendance.index');
    }

    
}
