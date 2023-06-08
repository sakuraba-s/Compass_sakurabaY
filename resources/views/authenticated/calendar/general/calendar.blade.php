@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}


            <!-- 予約キャンセルモーダル
            予約日と予約枠を表示させる-->
            <div class="modal js-modal">
                <!-- ここのbgに対して薄い色をcssで引く -->
                <div class="modal__bg"></div>
                <div class="modal__content">
                        <!-- 取得した投稿内容をモーダルのどこへ渡すかの判別のためにクラス名「modal_post」「modal_id」を設定-->
                            <!-- ※ここの空欄部分valueにiQueryで渡した投稿idが入ってくる -->
                            <p>予約日：{{$part}}</p>
                            <p>時間：</p>
                            <p>上記の予約をキャンセルしてもよろしいですか？</p>
                        <input type="hidden" name="id" class="modal_id" value="">

                        <!-- キャンセルせずにカレンダーに戻る -->
                        <button type="submit" class="modal_submit">閉じる</button>
                        <!-- キャンセルを実行 -->
                        <button type="submit" class="modal_submit">キャンセル</button>
                </div>


      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection