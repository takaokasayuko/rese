@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
@parent

<div class="search-box">
  <form class="search-form" action="/search" method="get">

    <div class="search-sort">
      <select class="sort__select" name="sort">
        <option value="" disabled selected>並び替え：評価高/低</option>
        <option value="">ランダム</option>
        <option value="0">評価が高い順</option>
        <option value="1">評価が低い順</option>
      </select>
    </div>

    <div class="search-bar">
      <div class="search__area">
        <select class="search__select" name="area">
          <option selected value="">All area</option>
          @foreach($areas as $area)
          <option value="{{ $area['name'] }}" @if( request('area')==$area['name'] ) selected @endif>{{ $area['name'] }}</option>
          @endforeach
        </select>
      </div>

      <div class="search__genre">
        <select class="search__select" name="genre">
          <option selected value="">All genre</option>
          @foreach($genres as $genre)
          <option value="{{ $genre['name'] }}" @if( request('genre')==$genre['name'] ) selected @endif>{{ $genre['name'] }}</option>
          @endforeach
        </select>
      </div>
      <input class="search__button-submit" type="submit" value="">

      <input class="search__keyword-input" type="text" name="keyword" placeholder="Search …" value="{{ request('keyword') }}">
    </div>
  </form>
</div>
@endsection

@section('content')
<div class="content">

  @foreach($shop_favorites as $shop_favorite)
  <div class="shop__list">
    <div class="shop__img">
      @if(str_starts_with($shop_favorite['shop']['image'], 'https://'))
      <img src="{{ $shop_favorite['shop']['image'] }}" alt="店舗画像">
      @else
      <img src="{{ Storage::url($shop_favorite['shop']['image']) }}" alt="店舗画像">
      @endif

    </div>
    <div class="shop__container">
      <div class="shop-tittle__group">
        <h2 class="shop-name">{{ $shop_favorite['shop']['name'] }}</h2>
      </div>

      <div class="shop__container-tag">
        <p class="shop__container-tag--area">#{{ $shop_favorite['shop']->area->name }}</p>
        <p class="shop__container-tag--genre">#{{ $shop_favorite['shop']->genre->name }}</p>
      </div>
      <div class="shop__container-foot">
        <div class="shop__container-foot--detail">
          <a class="shop-detail__link" href="{{ route('shop.detail', ['shop_id' => $shop_favorite['shop']['id']]) }}">詳しくみる</a>
        </div>
        <div class="shop__container-foot--fav">
          @auth()
          @if($shop_favorite['favorite'] === 'false')
          <form class="form__fav" action="/favorite/store" method="post">
            <input type="hidden" name="shop_id" value="{{ $shop_favorite['shop']['id'] }}">
            @csrf
            <button class="button__submit-un_fav">&#10084;</button>
          </form>
          @endif

          @if($shop_favorite['favorite'] === 'true')
          <form class="form__fav" action="/favorite/delete" method="post">
            <input type="hidden" name="shop_id" value="{{ $shop_favorite['shop']['id'] }}">
            @csrf
            @method('delete')
            <button class="button__submit-fav">&#10084;</button>
          </form>
          @endif
          @endauth

          @guest()
          <a class="button__submit-un_fav" href="/login">&#10084;</a>
          @endguest

        </div>
      </div>
    </div>
  </div>
  @endforeach

</div>
@endsection