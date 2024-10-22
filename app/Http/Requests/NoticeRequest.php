<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NoticeRequest extends FormRequest
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
            'register_id'    => ['required'],
            'title'          => ['required', 'string', 'max:255'],
            'note'           => ['nullable', 'string', 'max:5000'],
            'started_at'     => ['nullable', 'date'],
            'ended_at'       => ['nullable', 'date'],
            'started_hr_at'  => ['nullable', 'string', 'min:0', 'max:23'],
            'started_min_at' => ['nullable', 'string', 'min:0', 'max:59'],
            'ended_hr_at'    => ['nullable', 'string', 'min:0', 'max:23'],
            'ended_min_at'   => ['nullable', 'string', 'min:0', 'max:59'],
        ];
    }

    public function withValidator($validator)
    {
        $st_date  = $this->input('started_at');
        $st_hr    = $this->input('started_hr_at');
        $st_min   = $this->input('started_min_at');
        $end_date = $this->input('ended_at');
        $end_hr   = $this->input('ended_hr_at');
        $end_min  = $this->input('ended_min_at');

        if(!$this->checkTime($validator, $st_date, $end_date)){
            if(!$this->checkTime($validator, $st_hr, $end_hr)){
                $this->checkTime($validator, $st_min, $end_min);
            }
        }
    }

    public function checkTime($validator, $start, $end)
    {
        $validator->after(function ($validator) use($start, $end) {
            if(isset($start, $end)) {
                if($start > $end) {
                    $validator->errors()->add('', '終了日が開始日よりも早いです');
                    return true;
                }
            }
        });
        return false;
    }
}
