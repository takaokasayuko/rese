<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Review;

class ShopController extends Controller
{
    public function thanks()
    {
        return view('thanks');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user && !$user->email_verified_at) {
            return view('auth.verify-email');
        }

        // ユーザー
        if (!$user || $user->admin === 2) {
            $shops = Shop::with('area', 'genre')
                ->get();
            $areas = Area::all();
            $genres = Genre::all();
            $shop_favorites = $this->getShopStatus($shops);
            return view('index', compact('shop_favorites', 'areas', 'genres'));
        }

        // 管理者
        if ($user->admin === 0) {
            return redirect('/admin');
        }

        // 店舗代表者
        if ($user->admin === 1) {
            return redirect('/owner/shop');
        }
    }

    public function search(Request $request)
    {

        $area = Area::where('name', $request->input('area'))->first();
        $genre = Genre::where('name', $request->input('genre'))->first();

        $keyword = $request->input('keyword');
        $query = Shop::query();

        if (!empty($area)) {
            $query->where('area_id', 'LIKE', $area->id);
        }

        if (!empty($genre)) {
            $query->where('genre_id', 'LIKE', $genre->id);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('detail', 'like', '%' . $request->keyword . '%');
            });
        }

        $shops = $query->get();
        $areas = Area::all();
        $genres = Genre::all();

        $shop_favorites = $this->getShopStatus($shops);

        return view('index', compact('shop_favorites', 'areas', 'genres'));
    }

    // お気に入り
    public function store(Request $request)
    {
        $request['user_id'] = Auth::user()->id;
        Favorite::create($request->only([
            'user_id',
            'shop_id'
        ]));

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

    // 詳細ページ
    public function detail($shop_id)
    {
        $shop = Shop::where('id', $shop_id)
            ->with('area', 'genre')
            ->first();
        $reservation = new Reservation();
        $times = $reservation->reservationOpeningHours();
        $people_num = $reservation->reservationPeopleNum();

        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)
        ->where('shop_id', $shop->id)
        ->first();
        if(empty($review)) {
            $review = [];
        }

        return view('detail', compact('shop', 'times', 'people_num', 'review'));
    }

    public function detailReview($shop_id)
    {
        $shop = Shop::where('id', $shop_id)
        ->with('area', 'genre')
        ->first();
        $reviews = Reservation::where('shop_id', $shop_id)
            ->whereNotnull('stars')
            ->latest('updated_at')
            ->paginate(3);

        return view('detail-review', compact('shop', 'reviews'));
    }

    private function getShopStatus($shops)
    {
        return $shops->map(function ($shop) {
            $user = Auth::user();
            $favorite_status = false;
            if ($user) {
                $favorite_status = Favorite::where('shop_id', $shop->id)
                    ->Where('user_id', $user->id)
                    ->exists();
            }
            // trueお気に入り済み、falseお気に入り未登録
            $favorite = $favorite_status ? 'true' : 'false';

            // 星評価の平均
            $review = Reservation::where('shop_id', $shop->id)
                ->avg('stars');
            $review_avg = round($review, 1);
            $review_int = floor($review_avg);
            $review_decimal = $review_avg - $review_int;
            if ($review_decimal < 0.5) {
                $review_decimal = 0;
            } else {
                $review_decimal = 0.5;
            }
            $review_star = $review_int + $review_decimal;

            return [
                'shop' => $shop,
                'favorite' => $favorite,
                'average' => number_format($review_avg, 1),
                'star' => $review_star,
            ];
        });
    }
}
