<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Favorite;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request['date'] = $request->date . " " . $request->time . ":00";
        $request['user_id'] = Auth::user()->id;
        unset($request['_token']);
        $reservation = $request->all();
        Reservation::create($reservation);
        return redirect('/done');
    }

    public function mypage()
    {
        $user = Auth::user();
        $today = Carbon::now();
        $reservations = Reservation::where('user_id', $user->id)
            ->whereDate('date', '>', $today)
            ->oldest('date')
            ->with('reservationShop')
            ->get();

        $favorites = Favorite::where('user_id', $user->id)
            ->latest('created_at')
            ->with('favoriteShop')
            ->get();

        return view('mypage', compact('user', 'reservations', 'favorites'));
    }

    public function destory(Request $request)
    {
        Reservation::where('id', $request->id)
            ->delete();

        return back();
    }

    public function done()
    {
        return view('done');
    }
}
