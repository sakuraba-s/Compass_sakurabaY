@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
<!-- // スクール予約詳細 -->
  <div class="w-50 m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p>
    <div class="h-75 border">
      <table class="reserve_list">
        <tr class="text-center column">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>

        <div class="data">
          @foreach($reservePersons as $reservePerson)
              <!-- 中間テーブルの繰り返し -->
            @foreach($reservePerson->users as $Person)
              <tr class="text-center data">
                <td class="w-25 data1">{{$Person->id}}</td>
                <td class="w-25 data2">{{$Person->over_name}}{{$Person->under_name}}</td>
                <td class="w-25 data3">リモート</td>
              </tr>
            @endforeach
          @endforeach
          </div>


      </table>
    </div>
  </div>
</div>
@endsection