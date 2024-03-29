@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 vh-100 border d-flex">
  <div class="reserve_users_area ">
    <!-- コントローラから来たユーザ情報を繰り返しに入れる -->

    @foreach($users as $user)
    <div class="border one_person">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @else
        <span>性別 : </span><span>女</span>
        @endif
      </div>
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        <!-- 生徒ならば選択科目を表示 -->
        @if($user->role == 4)
        <span>選択科目 : </span>
          <div class="d-flex">
            @foreach($user->subjects as $subject)
              <div class="d-flex">
                @if($subject->id == "1")
                <span class="mr-2">国語</span>
                @elseif($subject->id == "2")
                <span class="mr-2">数学</span>
                @elseif($subject->id == "3")
                <span class="mr-2">英語</span>
                @endif
              </div>
            @endforeach
          </div>

        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25 border">
    <div class="">
      <div class="">
        <h5>検索</h5>
        <input type="text" class="free_word post_btn btn box" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <label>カテゴリ</label>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class=".mt-0">
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_box">
        
        <p class="m-0 d-flex search_conditions">検索条件の追加</p>
        <div class="search_conditions_inner">
          <div class="inner">
            <label>性別</label>
            <div class="d-flex">
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            </div>
          </div>
          <div class="inner">
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer inner">
            <label>選択科目</label>
            <div class="d-flex">
              @foreach($subjects as $subject)
                <div class="">
                  <label>{{ $subject->subject }}</label>
                  <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"form="userSearchRequest">
                </div>
              @endforeach
              </div>
            </select>
          </div>
        </div>
      </div>
      <div class="search_btn">
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
      <div class="reset">
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <!-- 検索内容をget送信 -->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>

</div>
@endsection