<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'area' => 'required',
            'category' => 'required',
            'overview' => 'required',
        ];
    }

    public function messages()
    {
    return [
    'category.required' => 'ジャンルは必ず指定してください。',
    'overview.required' => '店舗概要は必ず作成してください。',
    ];
    }
}
