@extends('layouts.sidebar')

@section('content')
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
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
          <div>
            <span>ああ</span>
            @if($user->subjects->id == "1")
            <span>選択科目 : </span><span>国語</span>
            @elseif($user->subject->id == "2")
            <span>選択科目  : </span><span>数学</span>
            @elseif($user->subject->id == "3")
            <span>選択科目  : </span><span>英語</span>
            @endif
          </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25 border">
    <div class="">
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <lavel>カテゴリ</lavel>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="">
        <p class="m-0 search_conditions"><span>検索条件の追加</span></p>
        <div class="search_conditions_inner">
          <div>
            <label>性別</label>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
          </div>
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
              @foreach($subjects as $subject)
                <div class="">
                  <input type="checkbox" name="subjects" value="{{ $subject->id }}"form="userSearchRequest">
                  <label>{{ $subject->subject }}</label>
                </div>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div>
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
    </div>
    <!-- 検索内容をget送信 -->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection