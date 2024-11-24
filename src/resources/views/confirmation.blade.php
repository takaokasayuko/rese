@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
@endsection
<div class="content">
	<h2 class="reservation_ttl">ご予約情報</h2>

	<table class="table-email">
		<tr class="email__row">
			<th class="email__data">予約氏名</th>
			<td class="email__data">{{ $reservation->reservationUser->name }}&emsp;様</td>
		</tr>
		<tr class="email__row">
			<th class="email__data">店舗名</th>
			<td class="email__data">{{ $reservation->reservationShop->name }}</td>
		</tr>
		<tr class="email__row">
			<th class="email__data">日時</th>
			<td class="email__data">{{ \Carbon\Carbon::parse($reservation['date'])->format('Y-m-d H:i') }}</td>
		</tr>
		<tr class="email__row">
			<th class="email__data">人数</th>
			<td class="email__data">{{ $reservation->person_num }}人</td>
		</tr>
	</table>
</div>

@section('content')

@endsection