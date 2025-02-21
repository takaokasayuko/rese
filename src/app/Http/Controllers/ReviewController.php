<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewPostingRequest;
use App\Http\Requests\ReviewUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function review($shop_id)
    {
        $user = Auth::user();

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
        if ($review) {
            return redirect()->route('shop.detail', ['shop_id' => $request->shop_id]);
        }

        Review::create([
            'user_id' => $user_id,
            'shop_id' => $request->shop_id,
            'stars' => $request->stars,
            'comment' => $request->comment,
            'image' => $request->file('image')->store('public/review')
        ]);
        return redirect()->route('shop.detail', ['shop_id' => $request->shop_id]);
    }

    public function edit($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::where('id', $shop_id)
            ->with('area', 'genre')
            ->first();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->exists();

        $review = Review::where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->first();

        return view('review-update', compact('shop', 'favorite', 'review'));
    }

    public function update(ReviewUpdateRequest $request)
    {
        $user_id = Auth::id();
        $review = Review::find($request->id);

        if($request->hasFile('image')) {
            $image_path = $request->file('image')->store('public/review');
        } else {
            $image_path = $review['image'];
        }

        if ($review['user_id'] === $user_id) {
            Review::find($request->id)
                ->update([
                    'stars' => $request->stars,
                    'comment' => $request->comment,
                    'image' => $image_path
                ]);
        }

        return redirect()->route('shop.detail', ['shop_id' => $review->shop_id]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $review = Review::find($request->id);

        if ($review['user_id'] === $user->id || $user['admin'] === 0) {
            Review::find($request->id)->delete();
        }

        return redirect()->route('shop.detail', ['shop_id' => $review->shop_id]);
    }
}
