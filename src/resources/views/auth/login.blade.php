@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="content">

	<h2 class="form__heading">Login</h2>
	<form class="form" action="/login" method="post">
		@csrf

		<div class="form-content">

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
			<button class="form__button-submit">ログイン</button>
		</div>

	</form>

</div>
@endsection