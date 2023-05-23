<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers{
// カテゴリが「id」科目絞り込み

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($keyword)){
      // カテゴリ「id」科目選択あり「キーワード」未選択
      $keyword = User::get('id')->toArray();
    }else{
      // カテゴリ「id」科目選択あり「キーワード」絞り込み
      $keyword = array($keyword);
    }
    if(is_null($gender)){
      // カテゴリ「id」科目選択あり「性別」未選択
      $gender = ['1', '2'];
    }else{
      // カテゴリ「id」科目選択あり「性別」絞り込み
      $gender = array($gender);
    }
    if(is_null($role)){
      // カテゴリ「id」科目選択あり「権限」未選択
      $role = ['1', '2', '3', '4', '5'];
    }else{
      // カテゴリ「id」科目選択あり「権限」絞り込み
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