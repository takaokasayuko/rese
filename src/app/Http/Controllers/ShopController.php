<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Consts\PrefectureConst;

class ShopController extends Controller
{
    public function thanks()
    {
        return view('thanks');
    }

    public function index()
    {
        $shops = Shop::all();
        $prefecture = PrefectureConst::PREFECTURES;
        $shop_areas = Shop::distinct()->pluck('area')->toArray();
        $areas = collect($prefecture)
            ->filter(fn($shop_area) => in_array($shop_area, $shop_areas))
            ->values();

        $genres = $shops->unique('genre');
        $shop_favorites = $this->getShopStatus($shops);

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
        $prefecture = PrefectureConst::PREFECTURES;
        $shop_areas = Shop::distinct()->pluck('area')->toArray();
        $areas = collect($prefecture)
            ->filter(fn($shop_area) => in_array($shop_area, $shop_areas))
            ->values();
        $genres = Shop::all()->unique('genre');

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
        $shop = Shop::find($shop_id);
        $reservation = new Reservation();
        $times = $reservation->reservationOpeningHours();
        $people_num = $reservation->reservationPeopleNum();

        return view('detail', compact('shop', 'times', 'people_num'));
    }

    public function detailReview($shop_id)
    {
        $shop = Shop::find($shop_id);
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
