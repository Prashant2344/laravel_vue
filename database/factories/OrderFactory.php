<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private function getRandomDecimal($min, $max, $decimalPlaces = 2) {
        $scale = pow(10, $decimalPlaces);
        $randomNumber = mt_rand($min * $scale, $max * $scale) / $scale;
        return number_format($randomNumber, $decimalPlaces, '.', '');
    }

    public function definition(): array
    {
        $startDate = Carbon::create(2020, 1, 1);
        $endDate = Carbon::create(2024, 12, 31);
        return [
            'price' => $this->getRandomDecimal(1000.00, 99999.99, 2),
            'tax_rate' => 13.00,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'order_date' => Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp)),
        ];
    }
}
