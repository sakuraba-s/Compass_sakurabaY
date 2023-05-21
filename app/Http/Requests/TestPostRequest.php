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
            // 完了
            'over_name' => 'required|string|max:10',
            // 完了
            'under_name' => 'required|string|max:10',

            // なぞ
            'over_name_kana' => 'required|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|regex:/\A[ァ-ヴー]+\z/u|max:30',
            // 完了
            'mail_address' => 'required|string|email:dns|max:100|unique:users',
            // 完了
            'sex' => 'required|string|regex:/[123]/',
            'role' => 'required|string|regex:/[1234]/',
            // 完了
            'password' => 'required|string|min:8|max:30|confirmed',

            // なぞ
            // 'old_year' => 'required|regex:/([0-9]{4})/',
            // 'old_month' => 'required|regex:/([0-9]{1})|[11]|[12]/',
            // 'old_day' => 'required|regex:/([0-9]{1})',
        ];
    }
// バリデーションメッセージ
    public function messages(){
        return [
            'over_name.max' => '姓は10文字以下で入力してください。',
            'under_name.max' => '名は10文字以下で入力してください。',
            'over_name_kana.max' => 'セイは10文字以下で入力してください。',
            'over_name_kana.regex' => 'セイはカタカナで入力してください。',
            'under_name_kana.max' => 'メイは10文字以下で入力してください。',
            'under_name_kana.regex' => 'メイは10文字以下で入力してください。',
            'mail_address.email' => 'メールアドレスの形式で入力してください。',
            'mail_address.max' => 'メールアドレスは100文字以内で入力してください。',
            'mail_address.unique' => '登録済みのメールアドレスです。',
            'sex.regex' => '性別を正しく選択して下さい。',
            'role.regex' => '権限を正しく選択して下さい。',
            'password.min' => 'パスワードは8文字以上です。',
            'password.max' => 'パスワードは30文字以下です。',
            'password.confirmed' => 'パスワードが一致しません。',

            'old_year.regex' => '年が不正です。',
            'old_year.min' => '2000年以降を選択してください。',
            'old_year.max' => '2023年以前を選択してください。',
            'old_month.regex' => '月が不正です。',
            'old_day.regex' => '日が不正です。',

        ];
    }
}
