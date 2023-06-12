<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    // スクール予約カレンダー表示
    public function show(){
        // カレンダー表示のためのクラスを呼び出す
        // 今月のカレンダーを表示するために現在時刻を渡す
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    // スクール予約
    public function reserve(Request $request){
        DB::beginTransaction();

        // $getPart = $request->getPart;
        // $getDate = $request->getData;
        // ddd($getPart);

        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;

            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // 予約枠を減らす
                $reserve_settings->decrement('limit_users');
                // usersはモデルに記述のリレーションのfunctionの名前
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }



    // スクール予約キャンセル
    public function delete(Request $request){
        DB::beginTransaction();

        $getPart = $request->getPart;
        $getDate = $request->getData;
        ddd($getPart);


        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;

            $deleteDays = array_filter(array_combine($getDate, $getPart));
            foreach($deleteDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->increment('limit_users');
                $reserve_settings->users()->detach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}