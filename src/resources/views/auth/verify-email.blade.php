@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="form__content">
	<h2>メールアドレスをご確認ください</h2>
	<p class="mail-text">ご登録いただいたメールアドレスに確認用のリンクをお送りしました。</br>
		もし確認用メールが送信されていない場合は、下記をクリックしてください。
	</p>

	<form class="form" method="post" action="/email/verification-notification">
		@csrf
		<button class="form__button-submit">確認メールを再送信する</button>
	</form>
</div>

@endsection