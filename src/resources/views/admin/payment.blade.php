@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/payment.css') }}">
@endsection

@section('content')
<div class="content">
  <a class="reservation__link" href="{{ route('owner.reservation', ['shop_id' => $reservation['shop_id'] ]) }}">&lt</a>
  <h2 class="payment-ttl">カード払い</h2>

  <div class="payment-info">
    @if($reservation->reservationUser->stripe_id)
    <table class="payment-table">
      <tr class="payment__row-label">
        <th class="payment__label">お名前</th>
        <td class="payment__data">{{ $reservation->reservationUser->name }} 様</td>
      </tr>
      <tr class="payment__row-label">
        <th class="payment__label">カード会社</th>
        <td class="payment__data">{{ $reservation->reservationUser->pm_type }}</td>
      </tr>
      <tr class="payment__row-label">
        <th class="payment__label">番号</th>
        <td class="payment__data">**** **** **** {{ $reservation->reservationUser->pm_last_four }}</td>
      </tr>
    </table>
    @else
    <p class="payment-text">カード情報が登録されていません</p>
    @endif
  </div>

  @if (session('message'))
  <p class="message">{{ session('message') }}</p>
  @endif

@if($reservation['payment'] === 1)
<p class="payment-text">支払い済みです</p>
@else
  <form class="form" action="/owner/payment/store" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $reservation->id }}">
    <label for="amount">金額 (円):</label>
    <input class="payment-input" type="number" id="amount" name="amount">
    <button type="submit">支払う</button>
  </form>
  @endif
</div>

@endsection