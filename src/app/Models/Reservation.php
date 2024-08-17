<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function reservationShop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function reservationDay()
    {
        $day = Carbon::parse($this->date)->format('Y-m-d');
        return $day;
    }
    public function reservationTime()
    {
        $time = Carbon::parse($this->date)->format('H:i');
        return $time;
    }
}
