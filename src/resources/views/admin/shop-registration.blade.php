@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop-registration.css') }}">
@endsection

@section('content')
<div class="content">

	<div class="message-content">
		<ul class="message">
			@if(session('message'))
			<li class="message-list">{{ session('message') }}</li>
			@endif
			@foreach ($errors->all() as $error)
			<li class="message-list">{{ $error }}</li>
			@endforeach
		</ul>
	</div>

	<div class="shop-register">
		<h2 class="shop-register__tittle">Shop-registration</h2>
		<div class="shop-register__list">
			<form class="shop-register__form" action="/owner/store" method="post" enctype="multipart/form-data">
				@csrf
				<table class="shop-register__table">
					<tr class="shop-register__row">
						<th class="shop-register__data">ShopName</th>
						<td class="shop-register__data">
							<input type="text" class="shop-register__data-input" name="name" value="{{ old('name') }}" placeholder="店舗名を入力してください">
						</td>
					</tr>
					<tr class="shop-register__row">
						<th class="shop-register__data">Area</th>
						<td class="shop-register__data">

							<select class="search__select" name="area">
								<option value="">地域を選んでください</option>
								@foreach($areas as $area)
								<option value="{{ $area }}" {{ old('area') == $area ? 'selected' : '' }}>
									{{ $area }}
								</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr class="shop-register__row">
						<th class="shop-register__data">Genre</th>
						<td class="shop-register__data">
							<select class="search__select" name="genre">
								<option value="">ジャンルを選んでください</option>
								@foreach($genres as $genre)
								<option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr class="shop-register__row">
						<th class="shop-register__data">Image</th>
						<td class="shop-register__data">
							<input type="file" class="shop-register__data-input" name="image">
						</td>
					</tr>
					<tr class="shop-register__row">
						<th class="shop-register__data" valign="top">Detail</th>
						<td class="shop-register__data">
							<textarea class="shop-register__data-input" name="detail" placeholder="店舗の概要を入力してください">{{ old('detail') }}</textarea>
						</td>
					</tr>
				</table>

				<div class="register-button">
					<button class="register-button__submit">登録</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection