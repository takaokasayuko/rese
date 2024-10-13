@extends('mypage')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="{{ asset('css/mypage-update.css') }}">
@endsection

@section('update')

<div class="content__reservation-update">
  <h3 class="reservation__tittle">予約変更</h3>
  <div class="reservation__list">
    <div class="reservation__list-header">
      <p class="header-list__name">予約{{ $reservation_num }}</p>
      <div class="header-list__reservation-update">
        <form class="update-form" action="/reservation/update" method="post">
          <input type="hidden" name="id" value="{{ $reservation_update['id'] }}">
        @csrf
        @method('patch')
    </div>

  </div>

  <div class="reservation__list--detail">
    <table class="reservation__table">
      <tr class="reservation__list-row">
        <th class="reservation__list-data">Shop</th>
        <td class="reservation__list-data">{{ $reservation_update->reservationShop->name}}</td>
      </tr>
      <tr class="reservation__list-row">
        <th class="reservation__list-data">Date</th>
        <td class="td reservation__list-data">
          <input class="reservation__list-data--input" type="date" name="date" value="{{ $reservation_update->reservationDay() }}">
        </td>
      </tr>
      <tr class="reservation__list-row">
        <th class="reservation__list-data">Time</th>
        <td class="reservation__list-data">
          <select class="reservation__list-data--select" name="time">
            @foreach($times as $time)
            <option @if($time==$reservation_update->reservationTime()) selected @endif>{{ $time }}</option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr class="reservation__list-row">
        <th class="reservation__list-data">Number</th>
        <td class="reservation__list-data">
          <select class="reservation__number-select" name="person_num">
            @foreach($people_num as $person_num)
            <option value="{{ $person_num }}" @if($person_num==$reservation_update['person_num']) selected @endif>{{ $person_num }}人</option>
            @endforeach
          </select>
        </td>
      </tr>
    </table>
  </div>
  <div class="save__button">
    <button class="save__button-submit">保存</button>
  </div>
  </form>
</div>

</div>

@endsection