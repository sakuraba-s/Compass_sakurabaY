
$(function(){

   // 予約削除のモーダル
   // 編集ボタン(class="js-modal-open")が押されたら、
   $('.cancel-modal-open').on('click',function(){
       // モーダルの中身(class="js-modal")の表示フェードイン
       $('.js-modal').fadeIn();
       // 押されたボタンからキャンセルしたい日程の情報を取得し変数へ格納
       // ※ビュー側で赤いボタンにdate属性とpart属性を追加し、押下したときにモーダルへデータを送信するようにする
       //  それをここで受け取り、定義する
       // data-属性を取得 ※（）の中がデータ属性の名前
       var date = $(this).attr('data-date');
       var part = $(this).attr('data-part');
       var setting_part = $(this).attr('data-settingpart');

       // 取得したデータをモーダルの中身へ渡す
       // 文字を渡したいのでtextメソッドを使う
      //  一つ目のカッコ→モーダルのどこに渡すか(モーダル側のクラス名)
      // 二つ目のカッコ→渡すデータの情報(上でvar宣言した名前)
       $('.modal_date').text(date);
       $('.modal_date').val(date);
       $('.modal_part').text(part);
       $('.setting_part').val(setting_part);
       return false;
   });
   $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;
    });
});
