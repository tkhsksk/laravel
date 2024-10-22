<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShiftRequest extends FormRequest
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
            'preferred_hr_st'   => ['required', 'string', 'min:1', 'max:12'],
            'preferred_min_st'  => ['required', 'string', 'min:1', 'max:12'],
            'preferred_hr_end'  => ['required', 'string', 'min:1', 'max:12'],
            'preferred_min_end' => ['required', 'string', 'min:1', 'max:12'],
            'status'            => ['required', 'string'],
            'charger_id'        => ['required'],
            'preferred_date'    => ['required', 'date'],
            'note'              => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function withValidator($validator)
    {
        $reg_id  = $this->input('register_id');
        $char_id = $this->input('charger_id');

        $validator->after(function ($validator) use($reg_id, $char_id) {
            if(isset($reg_id, $char_id)) {
                if($reg_id == $char_id) {
                    $validator->errors()->add('', '申請者と承認者は別のユーザーにする必要があります');
                }
            }
        });

        $st_hr   = $this->input('preferred_hr_st');
        $st_min  = $this->input('preferred_min_st');
        $end_hr  = $this->input('preferred_hr_end');
        $end_min = $this->input('preferred_min_end');

        $validator->after(function ($validator) use($st_hr, $st_min, $end_hr, $end_min) {
            if(isset($st_hr, $st_min, $end_hr, $end_min)) {
                if($st_hr > $end_hr) {
                    $validator->errors()->add('', '終了時刻が開始時刻よりも早いです');
                }
                if($st_hr == $end_hr && $st_min > $end_min){
                    $validator->errors()->add('', '終了時刻が開始時刻よりも早いです');
                }
            }
        });
    }
}
