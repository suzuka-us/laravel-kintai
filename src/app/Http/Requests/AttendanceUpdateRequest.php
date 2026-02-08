<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class AttendanceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            // 備考
            'remark.required' => '備考を記入してください',
        ];
    }


    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {

            // 既にエラーがある場合は何もしない
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $clockIn  = Carbon::createFromFormat('H:i', $this->clock_in);
            $clockOut = Carbon::createFromFormat('H:i', $this->clock_out);

            // 出勤・退勤の前後関係
            if ($clockIn->gte($clockOut)) {
                $validator->errors()->add(
                    'clock_in',
                    '出勤時間もしくは退勤時間が不適切な値です'
                );
                return; // ★ここで止める
            }

            // 休憩
            if ($this->breaks) {
                foreach ($this->breaks as $break) {

                    if (!empty($break['break_start'])) {
                        $breakStart = Carbon::createFromFormat('H:i', $break['break_start']);

                        if ($breakStart->lt($clockIn) || $breakStart->gt($clockOut)) {
                            $validator->errors()->add(
                                'breaks',
                                '休憩時間が不適切な値です'
                            );
                            return;
                        }
                    }

                    if (!empty($break['break_end'])) {
                        $breakEnd = Carbon::createFromFormat('H:i', $break['break_end']);

                        if ($breakEnd->gt($clockOut)) {
                            $validator->errors()->add(
                                'breaks',
                                '休憩時間もしくは退勤時間が不適切な値です'
                            );
                            return;
                        }
                    }
                }
            }
        });
    }
}
