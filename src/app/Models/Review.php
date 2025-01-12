<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'stars',
        'comment',
        'image',
    ];

    public function reviewShop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
    public function reviewUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
