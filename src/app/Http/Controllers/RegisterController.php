<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }


    public function store(RegisterRequest $request)
    {
        // ここでは登録処理を書く
        return redirect('/login');
    }
}
