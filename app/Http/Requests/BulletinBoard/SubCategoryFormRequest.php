<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            // 同じサブカテゴリは登録できない
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
            'main_category_id' => 'required|exists:main_categories,id',

        ];
    }

    public function messages(){
        return [

            'sub_category_name.required' => 'サブカテゴリを入力してください',
            'sub_category_name.string' => '文字列で入力してください。',
            'sub_category_name.max' => '100文字以内で入力してください。',
            'sub_category_name.unique' => 'すでに登録されています。',
            'main_category_id.unique' => 'メインカテゴリを選択してください',
            'main_category_id.exists' => '存在しないメインカテゴリです',

        ];
    }
}