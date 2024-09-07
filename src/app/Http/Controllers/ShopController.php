<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function thanks()
    {
        return view('thanks');
    }

    public function index()
    {
        $shops = Shop::all();
        $areas = $shops->unique('area');
        $genres = $shops->unique('genre');

        $shop_favorites = Shop::getFavoriteStatus($shops);

        return view('index', compact('shop_favorites', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $keyword = $request->input('keyword');
        $query = Shop::query();

        if (!empty($area)) {
            $query->where('area', 'LIKE', $area);
        }

        if (!empty($genre)) {
            $query->where('genre', 'LIKE', $genre);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('area', 'like', '%' . $request->keyword . '%')
                    ->orWhere('genre', 'like', '%' . $request->keyword . '%')
                    ->orWhere('detail', 'like', '%' . $request->keyword . '%');
            });
        }

        $shops = $query->get();
        $areas = Shop::all()->unique('genre');
        $genres = Shop::all()->unique('genre');

        $shop_favorites = Shop::getFavoriteStatus($shops);

        return view('index', compact('shop_favorites', 'areas', 'genres'));
    }

    public function store(Request $request)
    {
        $favorite = new Favorite;
        $favorite->shop_id = $request->shop_id;
        $favorite->user_id = Auth::user()->id;
        $favorite->save();

        return back();
    }

    public function destory(Request $request)
    {
        $user_id = Auth::user()->id;
        Favorite::where('shop_id', $request->shop_id)
            ->where('user_id', $user_id)
            ->delete();

        return back();
    }

    public function detail($shop_favorite)
    {
        $shop = Shop::find($shop_favorite);
        $today = Carbon::now();
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)
        ->whereDate('date', '>', $today)
        ->oldest('date')
        ->with('reservationShop')
        ->get();

        //予約可能時間
        $start_time = Carbon::createFromTimeString('11:00:00');
        $end_time = Carbon::createFromTimeString('21:00:00');
        $times = [];
        while($start_time <= $end_time) {
            $times[] = $start_time->format('H:i');
            $start_time = $start_time->addMinute(30);
        }

        //予約可能人数
        $people_num = [];
        for ($number = 1; $number <= 10; $number++) {
            $people_num[] = $number;
        }

        return view('detail', compact('shop', 'times', 'people_num', 'reservations'));
    }
}
