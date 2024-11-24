<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'nickname' => 'max:20',
            'stars' => 'required',
            'comment' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'nickname.max:20' => 'ニックネームは20文字以内で入力してください。',
            'stars.required' => '星を1～5段階で選んでください。',
            'comment.max:500' => '感想・コメントは500文字以内で入力してください。'
        ];
    }
}
