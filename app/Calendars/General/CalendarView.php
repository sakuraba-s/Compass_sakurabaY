<?php
namespace App\Calendars\General;

// 日時を扱うクラス
// 様々なインスタンス(今日、明日など)を取得できる
use Carbon\Carbon;
use Auth;
use App\Calendars\General\CalendarWeek;


class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // タイトル
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダの出力
  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    // 週カレンダーオブジェクトの配列を取得
    // getweeksは下に記載のメソッド
    // 1から月末までの取得
    $weeks = $this->getWeeks();

    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

    // getDaysは変数weekの中でニューしているCalendarWeekの中にあるメソッド
      $days = $week->getDays();
      foreach($days as $day){
        // 開始日
        $startDay = $this->carbon->copy()->format("Y-m-01");
        // 今日
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="calendar-td">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        // 配列の中に指定した値が存在するかチェックする関数
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px"></p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'">'. $reservePart .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        }else{
          $html[] = $day->selectPart($day->everyDay());
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

    // 1から月末までの取得
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 初日
    $lastDay = $this->carbon->copy()->lastOfMonth();
    // 月末
    // 別のファイルCalendarWeekをニューして使えるようにする
    $week = new CalendarWeek($firstDay->copy());

    $weeks[] = $week;

    // 作業用の日
    // +7日した後、週の開始日に移動する
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    // 月末までループ
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      //次の週=+7日する
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}