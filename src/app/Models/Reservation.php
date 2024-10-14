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
    public function reservationUser()
    {
        return $this->belongsTo(User::class, 'user_id');
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


    public function reservationOpeningHours()
    {
        $start_time = Carbon::createFromTimeString('11:00:00');
        $end_time = Carbon::createFromTimeString('21:00:00');
        $times = [];
        while ($start_time <= $end_time) {
            $times[] = $start_time->format('H:i');
            $start_time = $start_time->addMinute(30);
        }
        return $times;
    }

    public function reservationPeopleNum()
    {
        $people_num = [];
        for ($number = 1; $number <= 99; $number++) {
            $people_num[] = $number;
        }
        return $people_num;
    }
}
