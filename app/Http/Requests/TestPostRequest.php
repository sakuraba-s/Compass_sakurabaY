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
            'under_name_kana' => 'required|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required','string^','email:filter,dns','max:100','unique:true',
            'sex' => 'required|string|regex:/[123]/',
            // 'old_year' => 'required|regex:([0-9]{4})-(([13578]|10|12)-([1-9]|[12][0-9]|3[01]))|(([469]|11)-([1-9]|[12][0-9]|30))|(([13578]|10|12)-([1-9]|[12][0-9]|30))|(([2]-([1-9]|[12][0-9]))|after:2000-01-01|before:today',
            'role' => 'required|string|regex:/[1234]/',
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
    }
// バリデーションメッセージ
    public function messages(){
        return [
            'over_name' => '姓は10文字以下で入力してください。',
            'under_name' => '名は10文字以下で入力してください。',
            'over_name_kana' => 'セイは10文字以下で入力してください。',
            'under_name_kana' => 'メイは10文字以下で入力してください。',
            'mail_address' => 'メールアドレスは100文字以内で入力してください。',
            'sex' => '性別を正しく選択して下さい。',
            'role' => '権限を正しく選択して下さいaaa。',
            'password' => 'パスワードは8文字以上30文字以下です。',
        ];
    }
}
