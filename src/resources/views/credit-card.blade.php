@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/credit-card.css') }}">
@endsection

@section('content')
<div class="content">
  <h2 class="stripe__ttl">クレジットカード情報</h2>

  @if($user->stripe_id)
  <div class="credit-info">
    <h3 class="credit-info__ttl">登録済みカード情報</h3>
    <p class="credit-info">{{ $user->pm_type }}
      <span>**** **** **** {{ $user->pm_last_four }}</span>
    </p>
  </div>
  @endif

  @if (session('message'))
  <p class="message">{{ session('message') }}</p>
  @endif

  <script src="https://js.stripe.com/v3/"></script>
  <div class="credit">
    <form class="form" id="payment-form" action="/credit/store" method="POST">
      @csrf
      <input id="card-holder-name" type="text" placeholder="カード名義人">

      <div id="card-element"></div>

      <div class="credit__button">
        <button class="credit__button-submit" id="card-button" data-secret="{{ $intent->client_secret }}">
          登録
        </button>

      </div>
    </form>
  </div>

  <script>
    const stripe = Stripe("{{ config('services.stripe.pb_key') }}");
    const elements = stripe.elements();

    const cardElement = elements.create("card", {
      hidePostalCode: true,
    });
    cardElement.mount("#card-element");

    const cardHolderName = document.getElementById("card-holder-name");
    const cardButton = document.getElementById("card-button");
    const clientSecret = cardButton.dataset.secret;

    const form = document.getElementById("payment-form");
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const {
        setupIntent,
        error
      } = await stripe.confirmCardSetup(clientSecret, {
        payment_method: {
          card: cardElement,
          billing_details: {
            name: cardHolderName.value,
          },
        },
      });

      if (error) {
        alert("カード登録に失敗しました: " + error.message);
      } else {
        let hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "paymentMethod");
        hiddenInput.setAttribute("value", setupIntent.payment_method);
        form.appendChild(hiddenInput);

        form.submit();
      }
    });
  </script>
</div>

@endsection