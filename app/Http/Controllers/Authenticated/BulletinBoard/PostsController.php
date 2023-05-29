<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
// ↓これが投稿のバリデーション
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\CommentFormRequest;
use App\Http\Requests\BulletinBoard\EditFormRequest;
use App\Http\Requests\BulletinBoard\MainCategoryFormRequest;
use App\Http\Requests\BulletinBoard\SubCategoryFormRequest;
use Auth;

class PostsController extends Controller
{
    // 掲示板表示
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            // 検索ワード タイトル、投稿内容あいまい検索
            $sub_category = $request->keyword;
            $posts = Post::with('user', 'postComments','subCategories')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')
            ->orwhereHas('subCategories',function($q)use($sub_category){
                $q->where('sub_category', '=', $sub_category);
                } )->get();

        }else if($request->category_word){
            // 検索ワード サブカテゴリ完全一致
            $sub_category = $request->category_word;
            // echo ddd($sub_category);
            // リレーションを定義した3つのクラスとともにポストテーブルを呼び出す
            // リレーションの情報はビューで必要
            $posts = Post::with('user', 'postComments','subCategories')
            ->whereHas('subCategories',function($q)use($sub_category){
            $q->where('sub_category', '=', $sub_category);
            } )->get();

        }else if($request->like_posts){
            // 認証中のユーザがいいねした投稿のIDを取得
            $likes = Auth::user()->likePostId()->get('like_post_id');
            // リレーションを定義した二つのクラスとともにポストテーブルを呼び出す
            $posts = Post::with('user', 'postComments')
            // ポストテーブルの中から認証中のユーザがいいねした投稿のIDに合致するものを取得
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            // 自分の投稿
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    // 詳細画面
    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    // 投稿画面の表示
    public function postInput(){
        // モデルからメインカテゴリを取得
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 新規投稿
    // バリデーションをかませる
    public function postCreate(PostFormRequest $request){
        // サブカテゴリの取得
        $post_category_id=$request->post_category_id;
        // 投稿をテーブルに反映
        $post_get = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        // リレーション
        // 上記で新規登録したポストテーブルのidを取得しつつテーブルを取得
        $post = Post::findOrFail($post_get->id);
        // 投稿とサブカテゴリの紐づけ
        $post->subCategories()->attach($post_category_id);

        return redirect()->route('post.show');
    }

    // 投稿編集
    // バリデーションをかませる
    public function postEdit(EditFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // メインカテゴリの追加
    // バリデーションをかませる
    public function mainCategoryCreate(MainCategoryFormRequest $request){
        MainCategory::create([
            'main_category' => $request->main_category_name
        ]);
        return redirect()->route('post.input');
    }
    // サブカテゴリの追加
    // バリデーションをかませる
    public function subCategoryCreate(SubCategoryFormRequest $request){
        // メインカテゴリの取得
        $main_category_id=$request->main_category_id;
        // サブカテゴリの追加
        $sub_category_get = SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $main_category_id,
        ]);
        return redirect()->route('post.input');
    }

    // コメント投稿
    // バリデーションをかませる
    public function commentCreate(CommentFormRequest $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
