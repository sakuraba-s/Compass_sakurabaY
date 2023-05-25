<?php
namespace App\Searchs;

use App\Models\Users\User;

// インターフェイスを実装（継承）
//なにも絞り込んでいない状態
class AllUsers implements DisplayUsers{

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    $users = User::all();
    // $users = User::with('subjects')->get();
    return $users;
  }

}