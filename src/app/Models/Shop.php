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
    }


}
