@extends('layouts.email-app')

@section('title', 'ご予約の確認について')

@section('content')
<p class="message-content">{{ $message_content['user_name'] }}&emsp;様<br>
  ご予約いただきありがとうございます。<br>
  ご予約いただいた内容をお知らせします。
</p>

<table class="table">
  <tr class="email__row">
    <th class="email__data">予約者氏名</th>
    <td class="email__data">{{ $message_content['user_name'] }}&emsp;様</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">店舗名</th>
    <td class="email__data">{{ $message_content['shop_name'] }}</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">日時</th>
    <td class="email__data">{{ $message_content['date'] }}</td>
  </tr>
  <tr class="email__row">
    <th class="email__data">人数</th>
    <td class="email__data">{{ $message_content['person_num'] }}人</td>
  </tr>
</table>

<p class="message-footer">当日はお送りしたQRコードを店舗にご提示ください。</p>
{!! QrCode::encoding('UTF-8')->generate($qrcode) !!}
@endsection