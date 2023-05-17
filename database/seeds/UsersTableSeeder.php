<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'over_name' => '櫻庭',
            'under_name' => '結菜',
            'over_name_kana' => 'サクラバ',
            'under_name_kana' => 'ユウナ',
            'mail_address' => 'yunyun.art.19@outlook.jp',
            'sex' => '2',
            'birth_day' => '1995-06-09',
            'role' => '4',
            'password' => 'yunyun0717',
        ]);

    }
}