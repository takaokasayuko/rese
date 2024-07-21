@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="content">

  <h2 class="form__heading">Registration</h2>
  <form action="" class="form">

    <div class="form-content">
      <div class="form__group">
        <input type="text" class="form__input" name="name" id="name" placeholder="Username" value="{{ old('name') }}">
      </div>

      <div class="form__group">
        <input type="email" class="form__input" name="email" id="email" placeholder="email" value="{{ old('email') }}">
      </div>

      <div class="form__group">
        <input type="password" class="form__input" name="password" id="password" placeholder="Password">
      </div>
    </div>

    <div class="form__button">
      <button class="form__button-submit">登録</button>
    </div>

  </form>




</div>
@endsection