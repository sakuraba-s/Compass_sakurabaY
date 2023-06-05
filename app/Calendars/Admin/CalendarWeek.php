<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;
  }

  // 日々の繰り返し、一週間分を取得する
  function getDays(){
    $days = [];
    $startDay = $this->carbon->copy()->startOfWeek();
    // 週の初日が始まった瞬間を返す
    $lastDay = $this->carbon->copy()->endOfWeek();
    // 週の最終日が終わる瞬間（23:59:59）を返す

    $tmpDay = $startDay->copy();
    // temporary” （一時的な）

    while($tmpDay->lte($lastDay)){
    // 週の始まりが週の終わりよりも小さい限りは以下を繰り返す
    // 週の終わりまで一日を繰り返し該当月の一週間を作成する
      if($tmpDay->month != $this->carbon->month){
        // 週の初日が属する月が当月ではない場合
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        // ブランク
        $days[] = $day;
        $tmpDay->addDay(1);
        // 週の初日からスタートして、評価が終われば１を足す
        // これを繰り返すことで一週間の取得ができる
        continue;
        // 現在の繰り返しループ の残りの処理をスキップし、
        // 条件式を評価した後に 次の繰り返しの最初から実行を続ける
       }
        // 週の初日が属する月が当月
       $day = new CalendarWeekDay($tmpDay->copy());
      // 予約枠の表示をセットする
       $days[] = $day;
       $tmpDay->addDay(1);
        // 週の初日からスタートして、評価が終われば１を足す
        // これを繰り返すことで一週間の取得ができる
    }
    return $days;
  }
}