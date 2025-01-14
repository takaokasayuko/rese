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

    <!-- <div class="review-link">
      <a class="review-link__button" href="{{ route('detail.review', ['shop_id' => $shop['id']]) }}">全ての口コミ情報</a>
    </div> -->

    @if(!$user_review)
    <div class="review-posting">
      <a class="review-posting__link" href="{{ route('review.posting', ['shop_id' => $shop['id']]) }}">口コミを投稿する</a>
    </div>
    @else
    <div class="review">
      <div class="review-button">
        <div class="review-edit">
          <a class="review-edit__link" href="{{ route('review.edit', ['shop_id' => $shop['id']]) }}">口コミを編集</a>
        </div>
        <div class="review-delate">
          <form class="review-delete__form" action="/review/delete" method="post">
            <input type="hidden" name="id" value="{{ $user_review->id }}">
            @method('DELETE')
            @csrf
            <button class="review-delete__button">口コミを削除</button>
          </form>
        </div>
      </div>
      <div class="review__group">
        <div class="review-stars" data-rate="{{ $user_review['stars'] }}"></div>
        <div class="review-comment">
          <p class="review-comment__text">{{ $user_review['comment'] }}</p>
        </div>
      </div>
    </div>
    @endif
  </div>

  <div class="content__review">

    @foreach($reviews as $review)

    <div class="review">
      @if(auth()->user()->admin === 0)
      <div class="review-button">
        <form class="review-delete__form" action="/review/delete" method="post">
          <input type="hidden" name="id" value="{{ $review->id }}">
          @method('DELETE')
          @csrf
          <button class="review-delete__button">口コミを削除</button>
        </form>
      </div>
      @endif
      <div class="review-stars" data-rate="{{ $review['stars'] }}"> </div>

      <p class="review-comment__text">{{ $review['comment'] }}</p>
    </div>

    @endforeach

    @if($reviews)
    {{ $reviews->links('vendor.pagination.bootstrap-4') }}
    @endif
  </div>

</div>

@endsection