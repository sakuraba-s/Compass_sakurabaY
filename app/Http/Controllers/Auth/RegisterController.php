<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

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
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    // 新規登録バリデーション
    public function validator(array $data){
        $validator=Validator::make($data,[
        'over_name' => 'required|string|max:10',
        'under_name' => 'required|string|max:10',
        'over_name_kana' => 'required|string|max:30|/\A[ァ-ヴー]+\z/u',
        'under_name_kana' => 'required|string|max:30|/\A[ァ-ヴー]+\z/u',
        'mail_address' => ['required','string','email:filter,dns','max:100',Rule::unique('users')->ignore(Auth::id())],
        'sex' => 'required',
        'old_year' => 'required',
        'role' => 'required',
        'password' => 'required|string|min:8|max:30|confirmed',
        ]);
        return $validator;
    }

    // ユーザ新規登録
    public function registerPost(Request $request)
    {
        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            // バリデーション
            $validator=$this->validator($data);
            // バリデーション失敗
                if ($validator->fails()){
                    return redirect()->route('loginView')
                    ->withErrors($validator)
                    // セッションにエラー情報を入れる
                    ->withInput();
                }

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
                    $user = User::findOrFail($user_get->id);
                    $user->subjects()->attach($subjects);
                    DB::commit();
                    return view('auth.login.login');
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->route('loginView');
            }
    }
}