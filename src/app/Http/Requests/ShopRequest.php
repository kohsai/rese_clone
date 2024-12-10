<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'image_url' => 'required|url|',
            'name' => 'required|string|max:191|unique:shops',
            'area' => 'required|string',
            'genre' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'image_url.required' => '画像URLを入力してください',
            'image_url.url' => '正しいURL形式で入力して下さい',
            'name.required' => '店舗名を入力してください',
            'name.max:191' => '191文字以下で入力してください',
            'area.required' => '地域を入力してください',
            'genre.required' => 'ジャンルを入力してください',
            'description.required' => '詳細情報を入力してください'
        ];
    }
}
