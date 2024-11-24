@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/owner.css') }}">
@endsection

@section('content')
<div class="content">
	<h2 class="owner-tittle">登録店舗</h2>
	<div class="shop-list">
		<table class="shop__table">
			<tr class="shop__row-label">
				<th class="shop__label">Name</th>
				<th class="shop__label">Reservation</th>
				<th class="shop__label">Update-date</th>
			</tr>
			@foreach($shops as $shop)
			<tr class="shop__row-data">
				<td class="shop__data">{{ $shop['name'] }}</td>
				<td class="shop__data">
					<a class="reservation-link" href="{{ route('owner.reservation', ['shop_id' => $shop['id']]) }}">予約確認</a>
				</td>
				<td class="shop__data">
					@if($shop->shopReservations->isEmpty())
					{{ "-" }}
					@else
					{{ \Carbon\Carbon::parse()->toDateString($shop->shopReservations->first()->updated_at) }}
					@endif
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection