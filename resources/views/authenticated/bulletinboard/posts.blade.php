@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <!-- <p class="w-75 m-auto">投稿一覧</p> -->
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- 詳細画面へリンク -->
      <p class="bold"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>

      <div class="post_bottom_area d-flex">
        <!-- サブカテゴリ -->
        @foreach($post->subCategories as $subCategory)
          <p><span class="category_btn">{{ $subCategory->sub_category }}</span></p>
        @endforeach
        <div class="d-flex post_status">
          <!-- コメント数 -->
          <div class="mr-5"><i class="fa fa-comment"></i>
            <!-- Postモデルのメソッドを使用 -->
            <span class="">{{ $post->postComments ->count()}}</span>
          </div>
          <!-- いいね数  jsにて実装-->
          <!-- Postモデルのメソッドを使用 -->
          <!-- post_idでポスト送信し、コントローラで受けとる
          ※データベース上でいいねをつける外すの機能
          ※いいね数の増減の機能js で使う -->
          <!-- クラス名はjsから値を受け取る目印 -->
          <div class="mr-6">
            @if(Auth::user()->is_Like($post->id))
            <!-- ログインしているユーザがその投稿をいいねしている場合は赤いハート -->
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span></p>
            @else
            <!-- ログインしているユーザがその投稿をいいねしていない場合はグレーのハート -->
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="post_btn d-flex justify-content-between">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <div class="d-flex justify-content-between">
        <input type="submit" name="like_posts" class="pink" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="yellow" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
      <h5>カテゴリ検索</h5>

        @foreach($categories as $category)
        <li class="main_categories acMenu" category_id="{{ $category->id }}">
          <dt><h5>{{ $category->main_category }}</h5></dt>
          <!-- メインカテゴリ -->
          <dd>
            @foreach($category->subCategories as $subcategory)
              <!-- ここのnameで判別して送る -->
              <input type="submit" name="category_word" class="" value=" {{ $subcategory->sub_category }}" form="postSearchRequest">
            @endforeach
          </dd>
          <!-- サブカテゴリ -->
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection