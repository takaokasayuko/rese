@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="content">

	@if(session('message'))
	<div class="message">
		<p class="message">
			{{ session('message') }}
		</p>
	</div>
	@endif

	<div class="form-list">
		<h2 class="form__heading">ShopOwnerRegistration</h2>
		<form class="form" action="/admin/store" method="post">
			@csrf

			<div class="form-content">
				<div class="form__group">
					<input class="form__input" type="text" name="name" id="name" placeholder="OwnerName" value="{{ old('name') }}">
				</div>
				<p class="error-message">
					@error('name')
					{{ $message }}
					@enderror
				</p>
				<div class="form__group">
					<input class="form__input" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
				</div>
				<p class="error-message">
					@error('email')
					{{ $message }}
					@enderror
				</p>

				<div class="form__group">
					<input class="form__input" type="password" name="password" id="password" placeholder="Password">
				</div>
				<p class="error-message">
					@error('password')
					{{ $message }}
					@enderror
				</p>
			</div>

			<div class="form__button">
				<button class="form__button-submit">登録</button>
			</div>
		</form>
	</div>
</div>
@endsection