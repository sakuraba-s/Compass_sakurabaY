<?php
namespace App\Searchs;

use App\Models\Users\User;
use App\Models\Users\Subjects;


class SelectIdDetails implements DisplayUsers{
// カテゴリが「id」科目絞り込み

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // キーワードを設定
    if(is_null($keyword)){
      $keyword = User::get('id')->toArray();
    }else{
      $keyword = array($keyword);
    }
    // 性別を設定
    if(is_null($gender)){
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
    $users = User::with('subjects')
    // idがキーワードに合致
    ->whereIn('id', $keyword)
    // 性別、権限に合致するもの
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    // 科目に合致するもの どれか一つでも合致
    ->whereHas('subjects', function($q) use ($subjects){
      $q->where('subjects.id', $subjects);
    })
    ->orderBy('id', $updown)->get();
    return $users;
  }

}