<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers{
// カテゴリが「名前」科目は未選択

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(empty($gender)){
      // カテゴリ「名前」科目未選択（全て）性別未選択（全て）
      $gender = ['1', '2'];
    }else{
      // カテゴリ「名前」科目未選択（全て）性別絞り込み
      $gender = array($gender);
    }
    if(empty($role)){
      // カテゴリ「名前」科目未選択（全て）権限未選択（全て）
      $role = ['1', '2', '3', '4'];
    }else{
      // カテゴリ「名前」科目未選択（全て）権限絞り込み
      $role = array($role);
    }
    // ユーザ情報と、それにリレーションされている科目を取得
    $users = User::with('subjects')
    ->where(function($q) use ($keyword){
      // 名前がキーワードに合致するもの
      $q->where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
      // ほかの選択条件
    })->whereIn('sex', $gender)
    ->whereIn('role', $role)
    ->orderBy('over_name_kana', $updown)->get();

    return $users;
  }
}