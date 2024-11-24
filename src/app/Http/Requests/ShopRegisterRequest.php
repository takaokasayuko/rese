<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRegisterRequest extends FormRequest
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
            'name' => 'required',
            'area' => 'required',
            'genre' => 'required',
            'image' => 'required',
            'detail' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名の入力がありません。',
            'area.required' => '地域が選択されていません。',
            'genre.required' => 'ジャンルが選択されていません',
            'image.required' => '画像を選んでください。',
            'detail.required' => '店舗の詳細の入力がありません。',
        ];
    }
}
