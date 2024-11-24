<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
			'amount' => ['required', 'integer', 'min:1'],
		];
	}

	public function messages()
	{
		return [
			'amount.required' => '金額を入力してください',
			'amount.min:1' => '1以上の数字を入力してください',
			'amount.integer' => '整数で入力してください',
		];
	}
}
