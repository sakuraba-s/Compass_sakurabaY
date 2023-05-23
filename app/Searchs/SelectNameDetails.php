<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{
// カテゴリが「名前」科目絞り込み

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      // カテゴリ「名前」科目選択あり「性別」未選択（全て）
      $gender = ['1', '2'];
    }else{
      // カテゴリ「名前」科目選択あり「性別」絞り込み
      $gender = array($gender);
    }
    if(is_null($role)){
      // カテゴリ「名前」科目選択あり「権限」未選択（全て）
      $role = ['1', '2', '3', '4', '5'];
    }else{
      // カテゴリ「名前」科目選択あり「権限」絞り込み
      $role = array($role);
    }
    // ユーザ情報と、それにリレーションされている科目を取得
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
    ->whereHas('subjects', function($q) use ($subjects){
      $q->where('subjects.id', $subjects);
    })
    ->orderBy('over_name_kana', $updown)->get();
    return $users;
  }

}