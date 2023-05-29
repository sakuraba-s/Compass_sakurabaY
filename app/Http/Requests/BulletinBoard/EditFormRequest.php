<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class EditFormRequest extends FormRequest
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
            // 登録されているカテゴリかどうか
            'post_category_id' => 'required',
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',

        ];
    }

    public function messages(){
        return [
            'post_category_id.required' => 'カテゴリは必須',
            'post_title.required' => 'タイトルを入力してください',
            'post_title.string' => '文字列で入力してください。',
            'post_title.string' => 'タイトルは100文字以内で入力してください',
            'post_body.string' => '文字列で入力してください。',
            'post_body.string' => '本文は5000文字以内で入力してください',
        ];
    }
}