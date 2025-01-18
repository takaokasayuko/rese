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

        // ユーザーと管理者
        if (!$user || $user->admin === 2|| $user->admin === 0) {
            $shops = Shop::with('area', 'genre')
                ->get();
            $areas = Area::all();
            $genres = Genre::all();
            $shop_favorites = $this->getShopStatus($shops)->shuffle();
            return view('index', compact('shop_favorites', 'areas', 'genres'));
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

        $sort = $request->input('sort');

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

        if($sort == 1) {
        $shops = $query->withAvg('reviews', 'stars')
            ->orderByDesc('reviews_avg_stars')->get();
        } elseif($sort == 2) {
            $shops = $query->withAvg('reviews', 'stars')
            ->orderByRaw('case when reviews_avg_stars is null then 1 else 0 end')
            ->orderBy('reviews_avg_stars')->get();
        } else {
            $shops = $query->get()->shuffle();
        }


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
        if (empty($review)) {
            $review = [];
        }

        return view('detail', compact('shop', 'times', 'people_num', 'review'));
    }

    public function detailReview($shop_id)
    {
        $user_id = Auth::id();
        $user_review = Review::where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->first();

        if ($user_review) {
            $reviews = Review::where('shop_id', $shop_id)
                ->whereNotIn('id', [$user_review['id']])
                ->latest('updated_at')
                ->paginate(3);
        } else {
            $reviews = Review::where('shop_id', $shop_id)
                ->latest('updated_at')
                ->paginate(3);
        }

        $shop = Shop::where('id', $shop_id)
            ->with('area', 'genre')
            ->first();

        return view('detail-review', compact('shop', 'reviews', 'user_review'));
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
            $review_avg = Review::where('shop_id', $shop->id)
                ->avg('stars');

            return [
                'shop' => $shop,
                'favorite' => $favorite,
                'average' => $review_avg,
            ];
        });
    }
}
