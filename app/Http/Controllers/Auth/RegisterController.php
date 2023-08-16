<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// トランザクションを張る
use Illuminate\Support\Facades\DB;
// フォームリクエストの読み込み
use Illuminate\Http\Request;
use App\Http\Requests\registerPostRequest;
// use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // 登録画面の表示
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    // ユーザ新規登録
    // バリデーションをかませる
    public function registerPost(registerPostRequest $request)
    {
        DB::beginTransaction();
        try{
            // データの取得
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            // 年月日
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            // 登録
                $user_get = User::create([
                    'over_name' => $request->over_name,
                    'under_name' => $request->under_name,
                    'over_name_kana' => $request->over_name_kana,
                    'under_name_kana' => $request->under_name_kana,
                    'mail_address' => $request->mail_address,
                    'sex' => $request->sex,
                    'birth_day' => $birth_day,
                    'role' => $request->role,
                    'password' => bcrypt($request->password)
                ]);
                // 上記で新規登録したidを取得
                $user = User::findOrFail($user_get->id);
                // ユーザ情報と科目の紐づけ
                $user->subjects()->attach($subjects);
                // commitメソッドでデータベースに反映
                // トランザクション
                DB::commit();
                return view('loginView');
            }catch(\Exception $e){
                // これまでのデータベースの変更をトランザクションの開始時まで戻す
                // トランザクション
                DB::rollback();
                return redirect()->route('loginView');
            }
    }
}