<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required'],
            
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'メールアドレスを入力してください',
            'email.email'       => 'メールアドレスの形式が正しくありません',
            'password.required' => 'パスワードを入力してください',
        ];
    }
    protected function getRedirectUrl()
    {
        return 'verror';
    }
}
