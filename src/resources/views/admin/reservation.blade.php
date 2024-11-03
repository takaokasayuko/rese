@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/reservation.css') }}">
@endsection

@section('content')
<div class="content">
  <div class="reservation-date">
    <a class="reservation__date-link" href="{{ route('owner.reservation', ['shop_id' => $shop_id, 'date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}">&lt</a>
    <h2 class="reservation-date__tittle">{{ $date }}</h2>
    <a class="reservation__date-link" href="{{ route('owner.reservation', ['shop_id' => $shop_id, 'date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}">&gt</a>
  </div>
  <div class="reservation">
    <table class="reservation__table">
      <tr class="reservation__row-label">
        <th class="reservation__label">Name</th>
        <th class="reservation__label">Time</th>
        <th class="reservation__label">Number</th>
      </tr>
      @foreach($reservations as $reservation)
      <tr class="reservation__row-data">
        <td class="reservation__data">{{ $reservation->reservationUser->name }}</td>
        <td class="reservation__data">{{ $reservation->reservationTime() }}</td>
        <td class="reservation__data">{{ $reservation->person_num }}人</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection