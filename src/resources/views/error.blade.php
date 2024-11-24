@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endsection

@section('content')
<div class="content">
	<p class="error-text">
		エラーが発生しました。<br>
		再度
		<a class="mypage-link" href="/mypage">マイページ</a>
		からお試しください。
	</p>
</div>

@endsection