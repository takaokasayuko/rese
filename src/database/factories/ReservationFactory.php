<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(3, 12),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'date' => $this->faker->dateTimeBetween('-7 days', '-1 days')->format('Y:m:d 19:00:00'),
            'person_num' => $this->faker->numberBetween(1, 99),
            'nickname' => $this->faker->name(),
            'stars' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->realText(),
        ];
    }
}
