@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail-review.css') }}">
@endsection

@section('content')
<div class="content">
  <div class="content__shop-detail">
    <div class="shop-name">
      <a class="shop-all__link" href="{{ route('shop.detail', ['shop_id' => $shop['id']]) }}">&lt</a>
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

  <div class="content__review">

    @foreach($reviews as $review)
    <div class="review-list">
      <p class="review-nickname">{{ $review['nickname'] }}</p>

      <p class="star-rate">
        <span class="review-star" data-rate="{{ $review['stars'] }}"></span>
        <span class="review-rate">({{ $review['stars'] }})</span>
      </p>
      <p class="post-date">[投稿日]{{ \Carbon\Carbon::parse($review['updated_at'])->toDateString() }}</p>
      <p class="review-comment">{{ $review['comment'] }}</p>
    </div>
    @endforeach
    {{ $reviews->links('vendor.pagination.bootstrap-4') }}
  </div>



</div>

@endsection