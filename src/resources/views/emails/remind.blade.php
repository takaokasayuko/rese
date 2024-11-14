@extends('layouts.email-app')

@section('content')
<p class="message-content">{{ $reservation->reservationUser->name }}&emsp;様<br>
  ご予約の日が近づいてまいりましたのでお知らせします。<br>
  ご予約いただいた内容をお知らせします。
</p>

<table class="table">
  <tr class="email__row">
    <th class="email__data">予約者氏名</th>
    <td class="email__data">{{ $reservation->reservationUser->name }}&emsp;様</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">店舗名</th>
    <td class="email__data">{{ $reservation->reservationShop->name }}</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">日時</th>
    <td class="email__data">{{ $reservation['date'] }}</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">人数</th>
    <td class="email__data">{{ $reservation['person_num'] }}人</td>
  </tr>
</table>

<p class="message-footer">当日はお送りしたQRコードを店舗にご提示ください。</p>
{!! QrCode::size(200)->generate($url) !!}
@endsection