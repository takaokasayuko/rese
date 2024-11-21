@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/credit-card.css') }}">
@endsection

@section('content')
<div class="content">
  <h2 class="stripe__ttl">クレジットカード情報</h2>
  <script src="https://js.stripe.com/v3/"></script>
  <div class="credit">
    <form id="payment-form" action="/credit/store" method="POST">
      @csrf
      <input id="card-holder-name" type="text" placeholder="カード名義人">

      <!-- ストライプ要素のプレースホルダ -->
      <div id="card-element"></div>

      <div class="credit__button">
        <button class="credit__button-submit">
          登録
        </button>
        <input type="hidden" name="stripeToken" id="stripeToken">
      </div>
    </form>
  </div>

  <script>
    const stripe = Stripe("{{ config('services.stripe.pb_key') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      const cardHolderName = document.getElementById('card-holder-name').value;
      const {
        token,
        error
      } = await stripe.createToken(cardElement, {
        name: cardHolderName,
      });

      if (error) {
        console.error(error);
      } else {
        document.getElementById('stripeToken').value = token.id;
        form.submit();
      }
    });
  </script>
</div>

@endsection