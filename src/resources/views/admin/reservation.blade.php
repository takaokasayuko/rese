@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/reservation.css') }}">
@endsection

@section('content')
<div class="content">
  <div class="reservation-date">
    <a class="reservation__date-link" href="">&lt</a>
    <h2 class="reservation-date__tittle">2024-10-1</h2>
    <a class="reservation__date-link" href="">&gt</a>
  </div>
  <div class="reservation">
    <table class="reservation__table">
      <tr class="reservation__row">
        <th class="reservation__label">Name</th>
        <th class="reservation__label">Date</th>
        <th class="reservation__label">Time</th>
        <th class="reservation__label">Number</th>
      </tr>

      <tr class="reservation__row">
        <td class="reservation__data"></td>
        <td class="reservation__data"></td>
        <td class="reservation__data"></td>
        <td class="reservation__data"></td>
      </tr>
    </table>
  </div>
</div>

@endsection