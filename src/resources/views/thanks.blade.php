@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="content">

  <p class="text">会員登録ありがとうございます</p>

  <div class="form__button">
    <a href="/" class="form__button-submit">ログインする</a>
  </div>

</div>
@endsection