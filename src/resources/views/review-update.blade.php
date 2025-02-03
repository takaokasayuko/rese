@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-update.css') }}">
@endsection

@section('content')
<div class="content">
  <div class="shop__review-posting">
    <div class="shop-review">
      <h2 class="shop-review__ttl">今回のご利用はいかがでしたか？</h2>

      <div class="shop-detail">
        <div class="shop-img">
          @if(str_starts_with($shop['image'], 'https://'))
          <img src="{{ $shop['image'] }}" alt="店舗画像">
          @else
          <img src="{{ Storage::url($shop['image']) }}" alt="店舗画像">
          @endif
        </div>

        <div class="shop__container">
          <h3 class="shop-name">{{ $shop['name'] }}</h3>

          <div class="shop__container-tag">
            <p class="shop__container-tag--area">#{{ $shop->area->name }}</p>
            <p class="shop__container-tag--genre">#{{ $shop->genre->name }}</p>
          </div>

          <div class="shop__container-foot">
            <div class="shop__container-foot--detail">
              <a class="shop-detail__link" href="{{ route('shop.detail', ['shop_id' => $shop['id']]) }}">詳しくみる</a>
            </div>

            <div class="shop__container-foot--fav">

              @if(empty($favorite))
              <form class="form__fav" action="/favorite/store" method="post">
                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                @csrf
                <button class="button__submit-un_fav button__submit">&#10084;</button>
              </form>
              @endif

              @if($favorite)
              <form class="form__fav" action="/favorite/delete" method="post">
                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                @csrf
                @method('delete')
                <button class="button__submit-fav button__submit">&#10084;</button>
              </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="review-posting">

      <div class="message">
        <ul class="message__alert">
          @foreach($errors->all() as $error)
          <li class="message__item">{{ $error }}</li>
          @endforeach
        </ul>
      </div>

      <form class="form-review" action="/review/update" method="post" enctype='multipart/form-data'>
        <input type="hidden" name="id" value="{{ $review->id }}">
        @method('patch')
        @csrf
        <div class="form__review-stars">
          <label class="review-label" for="stars">体験を評価してください</label>
          <div class="review-stars__input">
            @for($i = 5; $i >= 1; $i--)
            <input class="review-star__input" id="star-{{ $i }}" type="radio" name="stars" value="{{ $i }}" @if($review['stars']==$i) checked @endif>
            <label for="star-{{ $i }}">&#9733;</label>
            @endfor
          </div>
        </div>

        <div class="form__review-comment">
          <label class="review-label" for="comment">口コミ投稿</label>
          <textarea class="review-comment" name="comment" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ $review['comment'] }}</textarea>
          <p class="review-comment__notes">0/400(最高文字数)</p>
        </div>

        <div class="form__review-image">
          <label class="review-label" for="image">画像の追加</label>

          <div class="review-image">
            <img src="{{ Storage::url($review['image']) }}" alt="口コミ画像">
          </div>
          <div class="review-image__group">
            <label class="review-image__upload" for="image">
              クリックして写真を追加
              <span class="review-image__notes">またはドロッグアンドドロップ</span></label>
            <input class="review-image__input" type="file" name="image" id="image" accept="image/*" value="{{ $review['image'] }}">
          </div>
        </div>

    </div>
  </div>

  <button class="review-posting__button">口コミを投稿</button>
  </form>
</div>

@endsection