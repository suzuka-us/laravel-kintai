<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest; // 
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }

    public function authenticate(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials) || !Auth::user()->is_admin) {
            return back()->withErrors([
                'login' => 'ログイン情報が登録されていません'
            ]);
        }

        return redirect()->intended('/admin/dashboard');
    }
}
