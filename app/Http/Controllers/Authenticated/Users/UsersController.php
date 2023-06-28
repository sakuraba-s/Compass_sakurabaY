<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    public function showUsers(Request $request){
        // 検索内容を取得
        // 検索ワード
        $keyword = $request->keyword;
        // カテゴリ
        $category = $request->category;
        // 昇順降順
        $updown = $request->updown;
        // 追加の条件
        $gender = $request->sex;
        $role = $request->role;
        // 選択された科目をidで受け取る※複数！！
        $subjects = $request->subjects;

        // ddd($subjects);
        // 検索絞り込み
        $userFactory = new SearchResultFactories();
        // initializeメソッド
        // classがnewされた際に呼び出されるメソッド
        // 検索ワードに合致する結果を取得
        // SearchResultFactoriesのファイル参照
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        // モデルからすべて取得 選択科目プルダウン用
        $subjects = Subjects::all();
        // compact関数で変数をビューに受け渡す
        // 絞り込んだユーザ情報とプルダウン用の選択科目

        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}