@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="content">

  <div class="content__shop-detail">
    <div class="shop-name">
      <a class="shop-all__link" href="/">&lt</a>
      <h2 class="shop__tittle-name">{{ $shop['name'] }}</h2>
    </div>
    <div class="shop-img">
      <img src="{{ $shop['image'] }}" alt="">
    </div>
    <div class="shop-tag">
      <p class="shop-tag__area">#{{ $shop['area'] }}</p>
      <p class="shop-tag__genre">#{{ $shop['genre'] }}</p>
    </div>
    <div class="shop-detail">
      <p class="shop-detail__text">{{ $shop['detail'] }}</p>
    </div>
  </div>

  <div class="content__shop-reservation">
    <div class="content__shop-reservation--main">
      <h2 class="shop-reservation__tittle">予約</h2>

      <div class="shop-reservation__group">
        <form class="shop-reservation__form" action="/reservation/store" method="post">
          <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
          @csrf
          <input class="reservation__date-input" type="date" name="date" id="reservationDate">

          <div class="reservation__time">
            <select class="reservation__time-select" name="time" id="reservationTime">
              @foreach($times as $time)
              <option value="{{ $time }}">{{ $time }}</option>
              @endforeach
            </select>
          </div>

          <div class="reservation__number">
            <select class="reservation__number-select" name="person_num" id="reservationNumber">
              @foreach($people_num as $person_num)
              <option value="{{ $person_num }}">{{ $person_num }}人</option>
              @endforeach
            </select>
          </div>

      </div>


      <div class="shop-reservation__list">
        <table class="reservation__table">
          <tr class="reservation__row">
            <td class="reservation__data">Shop</td>
            <td class="reservation__data">{{ $shop['name'] }}</td>
          </tr>
          <tr class="reservation__row">
            <td class="reservation__data">Date</td>
            <td class="reservation__data" id="displayDate"></td>
          </tr>
          <tr class="reservation__row">
            <td class="reservation__data">Time</td>
            <td class="reservation__data" id="displayTime"></td>
          </tr>
          <tr class="reservation__row">
            <td class="reservation__data">Number</td>
            <td class="reservation__data" id="displayNumber"></td>
          </tr>
        </table>
      </div>

      <script src="{{ asset('js/detail.js') }}" defer></script>



    </div>
    <div class="reservation__submit">
      <button class="reservation__submit-button">予約する</button>
    </div>
    </form>
  </div>
</div>

@endsection