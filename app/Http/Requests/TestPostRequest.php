<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TestPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // アクセスに対してフォームリクエストの利用の是非を定義(真偽値)
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // バリデーションルール
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30',
            'under_name_kana' => 'required|regex:^[ア-ン゛゜ァ-ォャ-ョー]$|max:30',
            'mail_address' => 'required','string','email:filter,dns','max:100','unique:true',
            'sex' => 'required|regex:[1-3]/u',
            'old_year' => 'required|regex:[0-9]{4}/(([13578]|10|12)/([1-9]|[12][0-9]|3[01]))|(([469]|11)/([1-9]|[12][0-9]|30))|(([13578]|10|12)\/([1-9]|[12][0-9]|30))|(([2]\/([1-9]|[12][0-9]))|after:2000/01/01|before:today',
            'role' => 'required|regex:[1-3]',
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
    }
}
