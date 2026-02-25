<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->path() == 'hello')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric|min:0|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '名前は必須です。',
            'mail.email' => 'メールアドレスを正しく入力してください。',
            'age.numeric' => '年齢を数値で入力してください。',
            'age.min' => '年齢は0以上で入力してください。',
            'age.max' => '年齢は150以下で入力してください。',
        ];
    }
}
