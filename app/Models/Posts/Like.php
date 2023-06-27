<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    // いいねをカウントする
    // ライクテーブルの中の「いいねした投稿のID」がその投稿のIDに一致する数をカウント
    public function likeCounts($post_id){
        return $this->where('like_post_id', $post_id)->get()->count();
    }

    // いいねと投稿の関係
    public function post()
    {
      return $this->belongsTo(Post::class);
    }

    // いねとユーザの関係
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
