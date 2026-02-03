<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'clock_in'  => ['required', 'date_format:H:i'],
            'clock_out' => ['required', 'date_format:H:i'],
            'breaks.*.break_start' => ['nullable', 'date_format:H:i'],
            'breaks.*.break_end'   => ['nullable', 'date_format:H:i'],
            'remark' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'remark.required' => '備考を記入してください',
        ];
    }
        public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $clockIn  = $this->clock_in;
            $clockOut = $this->clock_out;

            // 出勤・退勤
            if ($clockIn && $clockOut && $clockIn >= $clockOut) {
                $validator->errors()->add(
                    'clock_in',
                    '出勤時間もしくは退勤時間が不適切な値です'
                );
            }

            // 休憩
            if ($this->breaks) {
                foreach ($this->breaks as $break) {

                    if (!empty($break['break_start'])) {
                        if ($break['break_start'] < $clockIn
                            || $break['break_start'] > $clockOut) {
                            $validator->errors()->add(
                                'breaks',
                                '休憩時間が不適切な値です'
                            );
                        }
                    }

                    if (!empty($break['break_end'])
                        && $break['break_end'] > $clockOut) {
                        $validator->errors()->add(
                            'breaks',
                            '休憩時間もしくは退勤時間が不適切な値です'
                        );
                    }
                }
            }
        });
    }
}


