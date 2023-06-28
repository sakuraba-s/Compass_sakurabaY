<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  // 予約枠の表示をセットする
  function dayPartCounts($ymd){
    $html = [];
    // reserve_settingsのテーブルと、それに紐づくユーザ情報を取得する
    // setting_reserve＝開講日
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    // その日付が開講日でありかつ第一部である予約テーブルのデータと、それにひもづくユーザのデータ
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    // その日の２部を予約しているユーザを取得
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
    // その日の３部を予約しているユーザを取得

  // 予約可能枠を取得
  // 該当のメソッドを呼び出す
  $one_part_frame=$this->onePartFrame($ymd);
  $two_part_frame=$this->twoPartFrame($ymd);
  $three_part_frame=$this->threePartFrame($ymd);
  // ddd($part_frame);


  // 人数カウント
  $one_part_count = ReserveSettings::withCount('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();


    $html[] = '<div class="text-left">';


  
    if($one_part){
        // 部数の右に予約している人数を表示する
        //   ２つの値をポスト送信する
        // ログインユーザのid 予約日 予約パート
      $html[] = '<p class="day_part m-0 pt-1">1部
      <a href="/calendar/{id}/'.$ymd.'/1">'.$one_part_count.'</a></p>';
    }
    if($two_part){
      $html[] = '<p class="day_part m-0 pt-1">2部
      <a href="/calendar/{id}/'.$ymd.'/1">'.$two_part_frame.'</a></p>';
    }
    if($three_part){
      $html[] = '<p class="day_part m-0 pt-1">3部
      <a href="/calendar/{id}/'.$ymd.'/1">'.$three_part_frame.'</a></p>';
    }
    $html[] = '</div>';

    // 第一引数には要素の間にはさみたい区切り文字を指定
    return implode("", $html);
  }


  // 予約可能枠を取得
  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    // 予約のテーブルにその日で予約枠１があればリミットを取得それ以外はマックスの２０をセット
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;

  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    // 詳細画面にinputで値を送る
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}