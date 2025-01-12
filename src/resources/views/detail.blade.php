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
      @if(str_starts_with($shop['image'], 'https://'))
      <img src="{{ $shop['image'] }}" alt="">
      @else
      <img src="{{ Storage::url($shop['image']) }}" alt="">
      @endif
    </div>
    <div class="shop-tag">
      <p class="shop-tag__area">#{{ $shop->area->name }}</p>
      <p class="shop-tag__genre">#{{ $shop->genre->name }}</p>
    </div>
    <div class="shop-detail">
      <p class="shop-detail__text">{{ $shop['detail'] }}</p>
    </div>
    <div class="review-posting">
      <a class="review-posting__link" href="{{ route('review.posting', ['shop_id' => $shop['id']]) }}">口コミを投稿する</a>
    </div>

  </div>

  <div class="content__shop-reservation">

    <ul class="message">
      @if(session('message'))
      <li class="message-list">{{ session('message') }}</li>
      @endif
      @foreach ($errors->all() as $error)
      <li class="message-list">{{ $error }}</li>
      @endforeach
    </ul>

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
              <option>{{ $time }}</option>
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
            <th class="reservation__data">Shop</th>
            <td class="reservation__data">{{ $shop['name'] }}</td>
          </tr>
          <tr class="reservation__row">
            <th class="reservation__data">Date</th>
            <td class="reservation__data" id="displayDate"></td>
          </tr>
          <tr class="reservation__row">
            <th class="reservation__data">Time</th>
            <td class="reservation__data" id="displayTime"></td>
          </tr>
          <tr class="reservation__row">
            <th class="reservation__data">Number</th>
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