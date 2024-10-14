<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];


    public function getFavoriteStatus($shops)
    {
        return $shops->map(function ($shop) {
            $user = Auth::user();
            if ($user) {
                $favorite_status = Favorite::where('shop_id', $shop->id)
                    ->Where('user_id', $user->id)
                    ->exists();
            }

            if ($favorite_status) {
                $favorite = 'true'; //お気に入り登録済み
            } else {
                $favorite = 'false'; //お気に入り未登録
            }

            // 星評価の平均
            $review = Reservation::where('shop_id', $shop->id)
                ->avg('stars');
            $review_avg = round($review, 1);
            $review_decimal = $review_avg - floor($review_avg);
            if ($review_decimal < 0.5) {
                $review_decimal = 0;
            } else {
                $review_decimal = 0.5;
            }
            $review_star = floor($review_avg) + $review_decimal;


            return [
                'shop' => $shop,
                'favorite' => $favorite,
                'average' => number_format($review_avg, 1),
                'star' => $review_star,
            ];
        });
    }
}
