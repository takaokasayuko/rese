@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content">

  <div class="content__reservation">
    @if(session('message'))
    <div class="message">
      {{ session('message') }}
    </div>
    @endif
    @yield('update')
    <div class="content__reservation-detail">
      <h3 class="reservation__tittle">予約状況</h3>
      <div class="reservation__list-all">
        @foreach($reservations as $key=>$reservation)
        <div class="reservation__list">
          <div class="reservation__list-header">
            <p class="header-list__name">予約{{ $key+1 }}</p>

            <div class="header-list__update">
              <a class="update__link" href="{{ route('mypage.update', ['reservation_id' => $reservation['id']]) }}">編集</a>
            </div>

            <div class="header-list__delete">
              <form class="delete-form" action="/reservation/delete" method="post">
                <input type="hidden" name="id" value="{{ $reservation['id'] }}">
                @csrf
                @method('delete')
                <button class="delete-form__button"></button>
              </form>
            </div>

          </div>

          <div class="reservation__list--detail">
            <table class="reservation__list-table">
              <tr class="reservation__list-row">
                <th class="reservation__list-data">Shop</th>
                <td class="reservation__list-data">{{ $reservation->reservationShop->name}}</td>
              </tr>
              <tr class="reservation__list-row">
                <th class="reservation__list-data">Date</th>
                <td class="reservation__list-data" id="reservationDate">{{ $reservation->reservationDay() }}</td>
              </tr>
              <tr class="reservation__list-row">
                <th class="reservation__list-data">Time</th>
                <td class="reservation__list-data" id="reservationTime">{{ $reservation->reservationTime() }}</td>
              </tr>
              <tr class="reservation__list-row">
                <th class="reservation__list-data">Number</th>
                <td class="reservation__list-data" id="personNum">{{ $reservation['person_num'] }}人</td>
              </tr>
            </table>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="shop-visited">
      <a class="shop-visited__link" href="/review">来店履歴</a>
    </div>

    <div class="credit-card">
      <a class="credit-card__link" href="/credit">クレジットカード情報</a>
    </div>

  </div>


  <div class="content__right">
    <h2 class="user__name">{{ $user['name'] }}さん</h2>

    <h3 class="favorite__tittle">お気に入り店舗</h3>
    <div class="content__favorite">
      @foreach($favorites as $favorite)
      <div class="favorite__list">
        <div class="shop__img">
          @if(str_starts_with($favorite->favoriteShop->image, 'https://'))
          <img src="{{ $favorite->favoriteShop->image }}" alt="">
          @else
          <img src="{{ Storage::url($favorite->favoriteShop->image) }}" alt="">
          @endif
        </div>
        <div class="shop__container">
          <h2 class="shop-name">{{ $favorite->favoriteShop->name }}</h2>
          <div class="shop__container-tag">
            <p class="shop__container-tag--area">#{{ $favorite->favoriteShop->area }}</p>
            <p class="shop__container-tag--genre">#{{ $favorite->favoriteShop->genre }}</p>
          </div>
          <div class="shop__container-foot">
            <div class="shop__container-foot--detail">
              <a class="shop-detail__link" href="{{ route('shop.detail', ['shop_id' => $favorite->favoriteShop->id]) }}">詳しくみる</a>
            </div>
            <div class="shop__container-foot--fav">
              <form class="form__fav" action="/favorite/delete" method="post">
                <input type="hidden" name="shop_id" value="{{ $favorite->favoriteShop->id }}">
                @csrf
                @method('delete')
                <button class="button__submit-fav">&#10084;</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>

    @endsection