<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // カテゴリが「名前」
    if($category == 'name'){
      if(is_null($subjects)){
        // カテゴリ「名前」科目未選択（全て）
        $searchResults = new SelectNames();
      }else{
        // カテゴリ「名前」かつ科目絞り込み
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    // カテゴリが「id」
    }else if($category == 'id'){
      // カテゴリ「id」科目未選択（全て）
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      }else{
        // カテゴリ「id」かつ科目絞り込み
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    //なにも絞り込んでいない状態
    }else{
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}