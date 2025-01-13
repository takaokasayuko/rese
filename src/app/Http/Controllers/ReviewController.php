<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewPostingRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Review;

class ReviewController extends Controller
{
    public function review($shop_id)
    {
        $user = Auth::user();
        $review = Review::where('user_id', $user->id)
        ->where('shop_id', $shop_id)
        ->exists();
        if ($review) {
            return redirect()->route('shop.detail', ['shop_id' => $shop_id]);
        }

        $shop = Shop::where('id', $shop_id)
        ->with('area', 'genre')
        ->first();

        $favorite = Favorite::where('user_id', $user->id)
        ->where('shop_id', $shop->id)
        ->exists();

        return view('review-posting', compact('shop', 'favorite'));
    }

    public function create(ReviewPostingRequest $request)
    {
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)
        ->where('shop_id', $request->shop_id)
        ->exists();
        if($review) {
            return redirect()->route('shop.detail', ['shop_id' => $request->shop_id]);
        }

        Review::create([
            'user_id' => $user_id,
            'shop_id' => $request->shop_id,
            'stars' => $request->stars,
            'comment' => $request->comment,
            'image' => $request->file('image')->store('public/review')
        ]);
        return redirect()->back();
    }
}
