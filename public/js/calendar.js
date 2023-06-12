
$(function(){

   // 予約削除のモーダル
   // 編集ボタン(class="js-modal-open")が押されたら、
   $('.btn-danger').on('click',function(){
       // モーダルの中身(class="js-modal")の表示フェードイン
       $('.modal').fadeIn();
       // 押されたボタンからキャンセルしたい日程の情報を取得し変数へ格納
       // ※編集ボタンにpost属性とpost_id属性を追加し、それぞれの投稿内容と投稿idのデータを持たせてある
       // data-属性を取得
       // varは変数の定義
       //    キャンセルしたい日程を取得
       // 押されたボタンから投稿のidを取得し変数へ格納（どの投稿を編集するか特定するのに必要な為）
       var date = $(this).data('getPart[]');

       // 取得した投稿内容をモーダルの中身(text)へ渡す
       // 文字を渡したいのでtextメソッドを使う
       $('.modal_date').text(date);
       // 取得した投稿のidをモーダルの中身(val)へ渡す
       $('.getPart[]').val(post_id);
       return false;
   });
});   // 全体のfunctionを閉じる

