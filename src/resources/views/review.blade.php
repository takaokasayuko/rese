@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="content">
  <h3 class="shop-visited__tittle">来店履歴</h3>
  <div class="content__shop-visited">
    @foreach($visited_shops as $visited_shop)
    <div class="shop-visited__list">

      <div class="shop-visited__detail">
        <table class="shop-visited__list-table">
          <tr class="shop-visited__list-row">
            <th class="shop-visited__list-data">Shop</th>
            <td class="shop-visited__list-data">{{ $visited_shop->reservationShop->name }}</td>
          </tr>
          <th class="shop-visited__list-data">Date</th>
          <td class="shop-visited__list-data">{{ $visited_shop->reservationDay() }}</td>
          </tr>
          <tr class="shop-visited__list-row">
            <th class="shop-visited__list-data">Time</th>
            <td class="shop-visited__list-data">{{ $visited_shop->reservationTime() }}</td>
          </tr>
          <tr class="shop-visited__list-row">
            <th class="shop-visited__list-data">Number</th>
            <td class="shop-visited__list-data">{{ $visited_shop['person_num'] }}人</td>
          </tr>
        </table>
      </div>
      <div class="review-list">
        <!-- レビュー結果 -->
        @if($visited_shop['stars'])
        <table class="review__list-table">
          <tr class="review-row">
            <th class="review-data__th">stars</th>
            <td class="review-data review-data__star" data-rate="{{ $visited_shop['stars'] }}"></td>
            <td class="review-data__data-rate">({{ $visited_shop['stars'] }})</td>
          </tr>
          <tr class=" review-row">
            <th class="review-data__th">Nickname</th>
            <td class="review-data">{{ $visited_shop['nickname'] }}</td>
          </tr>
          <tr class="review-row">
            <th class="review-data__th">Comment</th>
            <td class="review-data review-data__text">{{ $visited_shop['comment'] }}</td>
          </tr>
        </table>
        <p class="review-data__date">2024/10/01 更新</p>

        <!-- レビュー入力 -->
        @else
        <ul class="message">
          <li class="message-list">{{ session('message') }}</li>
          @foreach ($errors->all() as $error)
          <li class="message-list">{{ $error }}</li>
          @endforeach
        </ul>

        <table class="review__list-table--form">
          <form class="review-form" action="/review/update" method="post">
            <input type="hidden" name="id" value="{{ $visited_shop['id'] }}">
            @csrf
            @method('patch')
            <tr class="review-row">
              <th class="review-data">Stars</th>
              <td class="review-data">
                <div class="review-star">
                  @for($i = 5; $i >= 1; $i--)
                  <input class="review-star__input" id="star-{{ $i }}" type="radio" name="stars" value="{{ $i }}">
                  <label for="star-{{ $i }}">&#9733;</label>
                  @endfor
                </div>
              </td>
            </tr>
            <tr class="review-row">
              <th class="review-data">Nickname</th>
              <td class="review-data">
                <input class="review-data__input" type="text" name="nickname" placeholder="未入力の場合「匿名」になります">
              </td>
            </tr>
            <tr class="review-row">
              <th class="review-data">Comment</th>
              <td class="review-data">
                <textarea class="review-comment__input" name="comment" cols="30" rows="7" placeholder="レビュー内容を記入してください"></textarea>
              </td>
            </tr>
        </table>

        <div class="review__button">
          <button class="review__button-submit">送信</button>
        </div>
        </form>
        @endif
      </div>

    </div>
    @endforeach
    {{ $visited_shops->links('vendor.pagination.bootstrap-4') }}
  </div>
</div>


@endsection