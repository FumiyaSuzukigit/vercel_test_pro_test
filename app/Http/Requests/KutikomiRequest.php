<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KutikomiRequest extends FormRequest
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
            'score' => 'required|in:1,2,3,4,5',
            'kutikomi' => 'max:400',
            'image' => 'file|mimes:png,jpg,jpeg|max:5120',
        ];
    }

    public function messages()
    {
    return [
    'score.required' => '星評価は必ず設定してください',
    'score.in' => '星評価は必ず設定してください',
    'kutikomi.max' => '口コミは400字以内でお願いします',
    'image.mimes' => '画像ファイルはpng,jpg,jpegを選択してください',
    'image.file' => '画像ファイルはpng,jpg,jpegを選択してください',
    'image.max' => '画像ファイルは5MB以内で選択してください',
    ];}
}
