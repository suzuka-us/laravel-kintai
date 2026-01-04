<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; // ← これ必須

class AttendanceStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'remark' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'remark.required' => '* 承認待ちのため修正はできません。',
        ];
    }
}
