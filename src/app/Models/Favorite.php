<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function favoriteShop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
