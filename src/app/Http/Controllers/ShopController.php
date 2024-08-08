<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\User;
use App\Models\Favorite;

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

        $shop_favorites = $shops->map(function ($shop) {
            $user = Auth::user();
            if ($user) {
                $favorite_status = Favorite::where('shop_id', $shop->id)
                    ->Where('user_id', $user->id)
                    ->exists();
            } else {
                $favorite_status = null;
            }

            if ($favorite_status) {
                $favorite = 'true'; //お気に入り登録済み
            } else {
                $favorite = 'false'; //お気に入り未登録
            }
            return [
                'shop' => $shop,
                'favorite' => $favorite,
            ];
        });

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

        $shop_favorites = $shops->map(function ($shop) {
            $user = Auth::user();
            if ($user) {
                $favorite_status = Favorite::where('shop_id', $shop->id)
                    ->Where('user_id', $user->id)
                    ->exists();
            } else {
                $favorite_status = null;
            }

            if ($favorite_status) {
                $favorite = 'true'; //お気に入り登録済み
            } else {
                $favorite = 'false'; //お気に入り未登録
            }
            return [
                'shop' => $shop,
                'favorite' => $favorite,
            ];
        });


        return view('index', compact('shop_favorites', 'areas', 'genres'));
    }

    public function store(Request $request)
    {
        $favorite = new Favorite;
        $favorite->shop_id = $request->shop_id;
        $favorite->user_id = Auth::user()->id;
        $favorite->save();

        return redirect('search');
    }

    public function destory(Request $request)
    {
        $user_id = Auth::user()->id;
        Favorite::where('shop_id', $request->shop_id)
            ->where('user_id', $user_id)
            ->delete();

        return redirect('search');
    }
}
