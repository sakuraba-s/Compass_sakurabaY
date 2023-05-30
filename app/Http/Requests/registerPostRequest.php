<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class registerPostRequest extends FormRequest
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
            'over_name_kana' => 'required|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|string|email:dns|max:100|unique:users',
            'sex' => 'required|regex:/[123]/',
            'role' => 'required|regex:/[1234]/',
            'password' => 'required|string|min:8|max:30|confirmed',

            // 日付
//             "・必須項目
// ・2000年1月1日から今日まで
// ・正しい日付かどうか（例:2/31や6/31はNG）"
            'old_year' => 'required',
            'old_month' => 'required',
            'old_day' => 'required',
            'birth_day' => 'required|date|after_or_equal:2000-1-1|before_or_equal:' . today()->format('Y-m-d'),
        ];
    }

// バリデーションメッセージ
    public function messages(){
        return [
            'over_name.max' => '※姓は10文字以下で入力してください。',
            'under_name.max' => '※名は10文字以下で入力してください。',
            'over_name_kana.max' => '※セイは10文字以下で入力してください。',
            'over_name_kana.regex' => '※セイはカタカナで入力してください。',
            'under_name_kana.max' => '※メイは10文字以下で入力してください。',
            'under_name_kana.regex' => '※メイは10文字以下で入力してください。',
            'mail_address.email' => '※メールアドレスの形式で入力してください。',
            'mail_address.max' => '※メールアドレスは100文字以内で入力してください。',
            'mail_address.unique' => '※登録済みのメールアドレスです。',
            'sex.regex' => '※性別が無効です。',
            'role.regex' => '※権限が無効です。',
            'password.min' => '※パスワードは8文字以上で入力してください。',
            'password.max' => '※パスワードは30文字以下で入力してください。',
            'password.confirmed' => '※パスワードが一致しません。',

            'old_year.required' => '※年を選択してください。',
            'old_month.required' => '※月を選択してください。',
            'old_day.required' => '※日を選択してください。',


            'birth_day.before_or_equal' => '※生年月日には過去の日付を入力してください。',
            'birth_day.after_or_equal' => '※生年月日には2000年1月1日以降の日付を入力してください。',
            'birth_day.date' => '※日付が不正です。',

            'old_year.regex' => '年が不正です。',
            'old_year.min' => '2000年以降を選択してください。',
            'old_year.max' => '2023年以前を選択してください。',
            'old_month.regex' => '月が不正です。',
            'old_day.regex' => '日が不正です。',

        ];
    }

    // バリデーション用データを取得
    // バリデーターに流すデータに前処理を施す
    public function validationData()
    {
        $data = parent::validationData();
        // 年月日すべて揃っている場合にbirthdayに値を代入する
        if ($data['old_year'] && $data['old_month'] && $data['old_day']) {
            $data['birth_day'] = $data['old_year'] . '-' . $data['old_month'] . '-' . $data['old_day'];
        }
        return $data;
    }
}
