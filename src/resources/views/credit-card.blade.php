@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
@endsection

@section('content')
<div class="content">
  <h2 class="stripe__ttl">クレジットカード情報</h2>

  <script src="https://js.stripe.com/v3/"></script>

  <form id="payment-form" action="/credit/store" method="POST">
    @csrf
    <div class="credit-container">
      <div class="credit" id="card-element"></div>
      <div class="credit__button">
        <button class="credit__button-submit" type="submit">登録</button>
      </div>
    </div>
  </form>

  <script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
      hidePostalCode: true
    });
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const clientSecret = "{{ $setup_intent->client_secret }}";
      const {
        setupIntent,
        error
      } = await stripe.confirmCardSetup(clientSecret, {
        payment_method: {
          card: cardElement,
        },
      });

      if (error) {
        alert(error.message);
      } else if (paymentMethod) {
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethod');
        hiddenInput.setAttribute('value', paymentMethod.payment_method);
        form.appendChild(hiddenInput);

        form.submit();
      }
    });
  </script>
</div>

@endsection