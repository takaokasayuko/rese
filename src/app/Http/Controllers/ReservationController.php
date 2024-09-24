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
        $tomorrow = Carbon::tomorrow();
        if($request['date'] < $tomorrow) {
            return back()->with('message', '日付を明日以降にしてください');
        }

        $request['user_id'] = Auth::user()->id;
        unset($request['_token']);
        Reservation::create($request->all());
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

    public function mypageUpdate($reservation)
    {
        $user = Auth::user();
        $today = Carbon::now();
        $reservation_update = Reservation::where('id', $reservation)
            ->where('user_id', $user->id)
            ->whereDate('date', '>', $today)
            ->with('reservationShop')
            ->first();
        if (empty($reservation_update)) {
            return view('error');
        }

        $today = Carbon::now();
        $reservations = Reservation::where('user_id', $user->id)
            ->whereDate('date', '>', $today)
            ->oldest('date')
            ->with('reservationShop')
            ->get();

        $reservation_num = $reservations->search(function ($item) use ($reservation_update) {
            return $item->id === $reservation_update->id;
        });
        $reservation_num = ++$reservation_num;

        $favorites = Favorite::where('user_id', $user->id)
            ->latest('created_at')
            ->with('favoriteShop')
            ->get();

        $reservation = new Reservation();
        $times = $reservation->reservationOpeningHours();
        $people_num = $reservation->reservationPeopleNum();

        return view('mypage-update', compact('reservation_update', 'user', 'reservations', 'favorites', 'reservation_num', 'times', 'people_num'));
    }

    public function update(Request $request)
    {
        $request['date'] = Carbon::parse($request->date . " " . $request->time);
        $tomorrow = Carbon::tomorrow();
        if($request['date'] < $tomorrow) {
            return back()->with('message', '日付を明日以降にしてください');
        }
        Reservation::find($request->id)
            ->update($request->only([
                'date',
                'person_num'
            ]));


        return redirect('/mypage')->with('message', '変更しました');
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
