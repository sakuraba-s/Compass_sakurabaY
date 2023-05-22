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
        $subjects = $request->subjects;
        // $subjects = null;
        // ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        // initializeメソッド
        // classがnewされた際に呼び出されるメソッド
        // SearchResultFactoriesのファイル参照
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        // モデルからすべて取得
        // $subjects = Subjects::all();
        // compact関数で変数をビューに受け渡す
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