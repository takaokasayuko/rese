<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
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
            'stars' => ['required'],
            'comment' => ['required', 'max:400'],
            'image' => ['mimes:jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            'stars.required' => '星を1～5段階で選んでください。',
            'comment.required' => '感想・コメントの入力がありません。',
            'comment.max:500' => '感想・コメントは500文字以内で入力してください。',
            'image.mimes:jpeg,png' => '画像はjpegまたはpngでアップロードしてください。'
        ];
    }
}
