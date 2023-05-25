<?php

namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // 権限に「教師」が含まれるユーザにだけ表示させるために値を渡す
    // ビューに対応する処理の記述
    // サイドバーテンプレートが読み込まれた際に権限を取得
    public function boot()
    {
        $this->registerPolicies();
        //アクションの認可
        // ルーティングのnamespaceがadmin設定になっているページを開くときに、function以下を実行する
        // adminは制限を行う際に利用する任意の名前
        Gate::define('admin', function($user){
            return ($user->role == "1" || $user->role == "2" || $user->role == "3");
            // roleが１または２または３の場合はtrue そうでなければfalseを返す
        });
        // 最大長を191バイトに指定
        \Schema::defaultStringLength(191);
    }
}