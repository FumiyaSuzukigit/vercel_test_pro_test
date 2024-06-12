<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvRequest extends FormRequest
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
            'csvdata' => 'required|file|mimes:csv,txt',
        ];
    }

    public function messages()
    {
    return [
    'csvdata.required' => 'csvファイルを選択してください',
    'csvdata.mimes' => '選択されたファイルはcsv形式である必要があります',
    ];}
}
