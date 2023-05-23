<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers{
// カテゴリが「id」科目は未選択

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      // カテゴリ「id」科目未選択（全て）性別未選択（全て）
      $gender = ['1', '2'];
    }else{
      // カテゴリ「id」科目未選択（全て）性別絞り込み
      $gender = array($gender);
    }
    if(is_null($role)){
      // カテゴリ「id」科目未選択（全て）権限未選択（全て）
      $role = ['1', '2', '3', '4'];
    }else{
      // カテゴリ「id」科目未選択（全て）権限絞り込み
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