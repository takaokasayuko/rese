@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin-email.css') }}">
@endsection

@section('content')
@if(session('message'))
<div class="content">
  <div class="message-success">
    {{ session('message') }}
  </div>
  @endif
  <div class="send-email__content">
    <form class="send-email" action="/admin/email/send" method="post">
      @csrf
      <div class="email__group">
        <label for="subject">件名：</label>
        <input class="subject" type="text" id="subject" name="subject" required>
      </div>
      <div class="email__group">
        <label for="message">メッセージ：</label>
        <textarea class="message" id="message" name="message" required></textarea>
      </div>
      <div class="button">
        <button class="button-submit">送信</button>
      </div>
    </form>
  </div>
</div>
@endsection