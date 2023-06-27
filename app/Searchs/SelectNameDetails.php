<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{
// カテゴリが「名前」科目絞り込み

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // 性別を設定
    if(is_null($gender)){
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);
    }
    // 権限を設定
    if(is_null($role)){
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }
    // ユーザ情報と、それにリレーションされている科目を取得
    // with リレーション名
    $users = User::with('subjects')
    // 検索ワードに合致するもの
    ->where(function($q) use ($keyword){
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    // 性別、権限に合致するもの
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);

    })
    // 科目に合致するもの どれか一つでも合致
    // whereHasの第一引数にはリレーションメソッド名
    // useメソッド 使いたい変数 ※コントローラにて定義しているよ
    ->whereHas('subjects', function($q) use ($subjects){
      // リレーション先のID（そのユーザと紐づいている科目のId）が検索で選択した科目と一致するケースを抽出
      $q->where('subjects.id', $subjects);
    })
    ->orderBy('over_name_kana', $updown)->get();
    // ddd($subjects);

    return $users;
  }

}