<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'time' => 'required',
            'person_num' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選んでください。',
            'time.required' => '時間を選んでください。',
            'person_num.required' => '人数を選んでください。',
        ];
    }
}
