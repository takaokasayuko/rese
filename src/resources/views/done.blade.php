@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="content">
	<p class="thanks__text">ご予約ありがとうございます</p>
	<div class="return__link">
		<a class="return__link-button" href="/">戻る</a>
	</div>
</div>

@endsection