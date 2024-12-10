<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'string', 'max:191', 'unique:users,email,'],
            'password' => ['required', 'min:8', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.max:191' => '191文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.max:191' => '191文字以下で入力してください',
            'email.unique' => 'このメールアドレスはすでに登録されています',
            'password.required' => 'パスワードを入力してください',
            'password.min:8' => '9文字以上で入力してください',
            'password.max:191' => '191文字以下で入力してください',
        ];
    }
}