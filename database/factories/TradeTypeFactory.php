<?php


namespace Database\Factories;

use App\Models\TradeType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TradeType>
 */
class TradeTypeFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(5),
            'is_increase' => true,
        ];
    }

}
