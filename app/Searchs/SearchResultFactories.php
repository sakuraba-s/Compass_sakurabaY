<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // カテゴリが「名前」
    if($category == 'name'){
      if(is_null($subjects)){
        $searchResults = new SelectNames();
      }else{
      // 科目あり
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    // カテゴリが「id」
    }else if($category == 'id'){
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      }else{
      // 科目あり
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