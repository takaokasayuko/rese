<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemindMail;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $today = Carbon::now();
            $start_day = $today->toDateString();
            $start = Carbon::parse($start_day . ' ' . '7:00:00');
            $end_day = $today->addDay()->toDateString();
            $end = Carbon::parse($end_day . ' ' . '7:30:00');

            $reservations = Reservation::where('date', '>', $start)
            ->where('date', '<', $end)
            ->with('reservationUser')
            ->with('reservationShop')
            ->get();

            foreach ($reservations as $reservation) {
                $url = route('confirmation', ['reservation_id' => $reservation->id]);
                Mail::to($reservation->reservationUser->email)->send(new RemindMail($reservation, $url));
            }

        })->dailyAt('7:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
