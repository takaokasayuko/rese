@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/csv-import.css') }}">
@endsection

@section('content')
<div class="content">
  <h1 class="import-ttl">店舗登録</h1>
  <form class="import-form" action="/admin/import/csv" method="post" enctype="multipart/form-data">
    @csrf
    <div class="csv-import">
      <label class="import-label" for="csv">CSVファイルを選択</label>
      <input class="import-input" type="file" name="csv" id="csv">
      <button class="import-button__submit">登録</button>
    </div>
  </form>
  <div class="error-message">
    <ul class="error-message__item">
      @foreach ($errors->all() as $error)
      <li class="error-message__list">{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  <div class="success-message">
    {{ session('message') }}
  </div>
</div>

@endsection