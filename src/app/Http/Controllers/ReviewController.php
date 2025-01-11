<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;

class ReviewController extends Controller
{
    public function review()
    {
        $shop = Shop::find(1);
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
        ->where('shop_id', $shop->id)
        ->exists();

        return view('review-posting', compact('shop', 'favorite'));
    }
}
