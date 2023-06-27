<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarSettingView{
// スクール枠登録(教師のみ)
  private $carbon;

  function __construct($date){
    // newするとき最初に自動で実行されるメソッド
    $this->carbon = new Carbon($date);
  }

  // タイトル取得
  public function getTitle(){
    // メソッドをつなげる事で表記を変更できます
    return $this->carbon->format('Y年n月');
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border adjust-table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    // ※getweeksメソッドはこの下にあるよ
    // ※そのなかでさらに別のファイルにあるクラス、CalendarWeekを呼び出している
    $weeks = $this->getWeeks();

    // 一か月を繰り返すことで一年にする
    foreach($weeks as $week){
      // getClassNameモデルのクラス名を返す
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();
      // ※変数weekが呼び出している別のファイルにあるクラス、CalendarWeek内にあるfunctionの名前
      // 日々の繰り返し、一週間分を取得した結果のこと

      foreach($days as $day){
        $startDay = $this->carbon->format("Y-m-01");
        // 今月の初日を取得
        $toDay = $this->carbon->format("Y-m-d");
        // 本日を取得


        // 過去日をグレーにする
       if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
        // everyDayはCalendarWeekDayクラスにあるメソッド
        // 月初が
        // かつ今日が
        // クラスにpastを追記する(cssでグレーを充てる)
          $html[] = '<td class="past-day border">';
        }else{
          // そのほかはpastなし(グレーアウトにならない)
          $html[] = '<td class="border '.$day->getClassName().'">';
        }


        $html[] = $day->render();
        $html[] = '<div class="adjust-area">';
        if($day->everyDay()){

          // 過去日 disabled無効
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;"
                      name="reserve_day['.$day->everyDay().'][1]"
                      type="text" form="reserveSetting"
                      value="'.$day->onePartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;"name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'" disabled></p>';
          }else{
          // 未来日
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;"
                      name="reserve_day['.$day->everyDay().'][1]"
                      type="text" form="reserveSetting"
                      value="'.$day->onePartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'"></p>';
          }
        }
        $html[] = '</div>';
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="'.route('calendar.admin.update').'" method="post" id="reserveSetting">'.csrf_field().'</form>';
    return implode("", $html);
  }

  // 一週間の繰り返し、ひと月分を取得する
  protected function getWeeks(){
    $weeks = [];

    // 一日目の取得
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 月の初日が始まった瞬間を返す
    $lastDay = $this->carbon->copy()->lastOfMonth();
    // 月の最終日が始まる瞬間（00:00:00）を返す


    // ★「一週間」を準備する
    $week = new CalendarWeek($firstDay->copy());
    // 月の一日目をクラスCalendarWeekに渡す
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    // 月の初日に７を足す
    // その日を含む週のが始まった瞬間を取得する

    // ★繰り返してひと月分にする
    while($tmpDay->lte($lastDay)){
    // 月の初日に7を足してそれがその月の終わりよりも小さい限りは以下を繰り返す
    // つまり月の終わりになるまで７を足す
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}