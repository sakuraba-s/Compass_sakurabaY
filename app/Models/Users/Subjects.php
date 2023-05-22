<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

// 教科＿ユーザ
// 中間テーブルを介してデータを取得できる
    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'subject_users', 'subject_id', 'user_id')->withPivot('id');
    }
}