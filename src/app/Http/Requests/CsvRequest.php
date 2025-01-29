<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Validation\Rule;
use SplFileObject;

class CsvRequest extends FormRequest
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
    public function rules(): array
    {
        $area_id = Area::all()->pluck('id')->toArray();
        $genre_id = Genre::all()->pluck('id')->toArray();

        return [
            'csv' => ['required', 'mimes:csv,txt'],
            'csv_array.*.name' => ['required', 'max:50'],
            'csv_array.*.area_id' => ['required', 'integer', Rule::in($area_id)],
            'csv_array.*.genre_id' => ['required', 'integer', Rule::in($genre_id)],
            'csv_array.*.image' => ['required', 'regex:/https?:\/\/.*\.(jpg|jpeg|png)$/i'],
            'csv_array.*.detail' => ['required', 'max:400'],
        ];
    }

    protected function prepareForValidation()
    {
        $file = $this->file('csv');
        if (!$file) {
            return;
        }

        $mime_type = $file->getClientMimeType();
        if ($mime_type !== "text/csv") {
            return;
        }

        $path = $file->getPathname();
        $file_object = new SplFileObject($path);

        $file_object->setFlags(
            \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
        );

        $header = [];
        $csv = [];
        foreach ($file_object as $index => $value) {
            if (empty($header)) {
                $header = $value;
                continue;
            }

            $csv[$index]['name'] = $value[0];
            $csv[$index]['area_id'] = $value[1];
            $csv[$index]['genre_id'] = $value[2];
            $csv[$index]['image'] = $value[3];
            $csv[$index]['detail'] = $value[4];
        }

        $this->merge([
            'csv_array' => $csv,
        ]);
    }

    public function messages()
    {
        return [
            'csv.required' => 'CSVファイルを選択してください。',
            'csv.mimes' => 'CSV形式のファイルを選択してください。',
            'csv_array.*.name.required' => ':attributeが空白です。',
            'csv_array.*.name.max' => ':attributeを50文字以内で入力してください。',
            'csv_array.*.area_id.required' => ':attributeが空白です。',
            'csv_array.*.area_id.integer' => ':attributeを整数で指定してください。',
            'csv_array.*.area_id.in' => ':attributeが無効です。',
            'csv_array.*.genre_id.required' => ':attributeが空白です。',
            'csv_array.*.genre_id.integer' => ':attributeを整数で指定してください。',
            'csv_array.*.genre_id.in' => ':attributeが無効です。',
            'csv_array.*.image.required' => ':attributeが空白です。',
            'csv_array.*.image.regex' => ':attribute形式はjpg、jpeg、pngの画像URLにしてください。',
            'csv_array.*.detail.required' => ':attributeが空白です。',
            'csv_array.*.detail.max' => ':attributeを400文字以内で入力してください。',
        ];
    }

    public function attributes()
    {
        $csv = $this->input('csv_array', []);
        $attributes = [];

        foreach ($csv as $index => $row) {
            $number = $index + 1;
            $attributes["csv_array.{$index}.name"] = "{$number} 行目の名前";
            $attributes["csv_array.{$index}.area_id"] = "{$number} 行目の地域ID";
            $attributes["csv_array.{$index}.genre_id"] = "{$number} 行目のジャンルID";
            $attributes["csv_array.{$index}.image"] = "{$number} 行目の画像";
            $attributes["csv_array.{$index}.detail"] = "{$number} 行目の詳細情報";
        }

        return $attributes;
    }
}
