<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\QrcodeMail;


class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        $tomorrow = Carbon::tomorrow();
        if ($request['date'] < $tomorrow) {
            return back()->with('message', '日付を明日以降にしてください');
        }

        $user = Auth::user();
        $shop = Shop::where('id', $request['shop_id'])
            ->first();
        $date = $request->date . " " . $request->time . ":00";

        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'date' => $date,
            'person_num' => $request->person_num
        ]);

        $reservation = [
            'user' => $user->name,
            'shop' => $shop->name,
            'date' => Carbon::parse($date)->format('Y-m-d H:i'),
            'person_num' => $request->person_num,
        ];

        $reservation_id = Reservation::where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->latest('updated_at')
            ->first();

        $url = route('confirmation', ['reservation_id' => $reservation_id->id]);

        Mail::to($user->email)->send(new QrcodeMail($reservation, $url));

        return redirect('/done');
    }

    public function confirmation($reservation_id)
    {
        $reservation = Reservation::where('id', $reservation_id)
            ->with('reservationShop')
            ->with('reservationUser')
            ->first();

        return view('confirmation', compact('reservation'));
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

    public function update(ReservationRequest $request)
    {
        $request['date'] = Carbon::parse($request->date . " " . $request->time);
        $tomorrow = Carbon::tomorrow();
        if ($request['date'] < $tomorrow) {
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

    public function review()
    {
        $user = Auth::user();
        $today = Carbon::now();
        $visited_shops = Reservation::where('user_id', $user->id)
            ->whereDate('date', '<', $today)
            ->latest('date')
            ->with('reservationShop')
            ->paginate(6);

        return view('review', compact('visited_shops'));
    }

    public function reviewUpdate(ReviewRequest $request)
    {
        $review = Reservation::find($request->id);
        if ($review['stars']) {
            return view('error');
        }

        if (empty($request['nickname'])) {
            $request['nickname'] = "匿名";
        }
        Reservation::find($request->id)
            ->update($request->only([
                'stars',
                'nickname',
                'comment',
            ]));

        return redirect('/review');
    }

    public function credit()
    {
        $user = Auth::user();
        $user->createOrGetStripeCustomer();
        $setup_intent = $user->createSetupIntent();

        return view('credit-card', compact('setup_intent'));
    }

    public function creditStore(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('paymentMethod');
        $user->addPaymentMethod($paymentMethod);

        return redirect('/credit');
    }
}
