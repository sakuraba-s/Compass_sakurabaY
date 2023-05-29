<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\subCategory;


class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    // 投稿対コメント 一対多
    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        // リレーションの定義
        // 投稿とサブカテゴリ―との中間テーブル
        // 投稿＿サブカテゴリ
        return $this->belongsToMany('App\Models\Categories\subCategory', 'post_sub_categories','post_id','sub_category_id')->withPivot('id');
    }

    // コメント数
    // post_commentテーブルのidの数を数える
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}