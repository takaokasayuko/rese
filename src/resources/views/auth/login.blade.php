@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="content">

  <h2 class="form__heading">Login</h2>
  <form action="/login" class="form" method="post">
    @csrf

    <div class="form-content">

      <div class="form__group">
        <input type="email" class="form__input" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
      </div>
      <p class="error-message">
        @error('email')
        {{ $message }}
        @enderror
      </p>

      <div class="form__group">
        <input type="password" class="form__input" name="password" id="password" placeholder="Password">
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