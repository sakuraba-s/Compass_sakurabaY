<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // カテゴリが「名前」
    if($category == 'name'){
      // 科目が空
      if(is_null($subjects)){
        $searchResults = new SelectNames();
      }else{
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    // カテゴリが「id」
    }else if($category == 'id'){
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      }else{
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    // カテゴリがそのほか
    }else{
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}