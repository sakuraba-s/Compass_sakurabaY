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
                    <!-- 取得した投稿内容をモーダルのどこへ渡すかの判別のためにクラス名「modal_date」「modal_part」を設定-->
                        <!-- ※ここの空欄部分valueにiQueryで設定したデータが入ってくる -->
                        <p><span>予約日：</span><span name="gePart" class="modal_date"></span></p>
                        <p><span>時間：</span><span name="getDate" class="modal_part"></span></p>

                        <p>上記の予約をキャンセルしてもよろしいですか？</p>

                        <!-- キャンセルせずにカレンダーに戻る -->
                        <button type="submit" class="modal_submit">閉じる</button>
                        <!-- キャンセルを実行 -->
                        <div class="text-right w-75 m-auto">
                          <input type="submit" class="btn btn-primary modal_submit" value="キャンセル実行" form="deleteParts">
                        </div>
                </div>


      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection