<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers{
// カテゴリが「id」科目は未選択

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
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    if(is_null($keyword)){
      // キーワード未入力 選択項目に合致するものを取得
      $users = User::with('subjects')
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }else{
      // キーワード入力あり キーワードに合致かつ選択項目に合致するものを取得
      $users = User::with('subjects')
      ->where('id', $keyword)
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }
    return $users;
  }

}